<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Support\Str;

class BlogContent
{
    /**
     * @return array{html: string, toc: array<int, array{level: int, id: string, text: string}>}
     */
    public static function prepare(?string $body): array
    {
        $html = trim((string) $body);

        if ($html === '') {
            return ['html' => '', 'toc' => []];
        }

        $html = self::decodeEscapedHtml($html);

        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><div id="blog-content-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $root = $dom->getElementById('blog-content-root');
        if (! $root) {
            return ['html' => $html, 'toc' => []];
        }

        self::sanitizeNode($root);
        $toc = self::addHeadingIds($root);

        return [
            'html' => self::innerHtml($root),
            'toc' => $toc,
        ];
    }

    private static function decodeEscapedHtml(string $html): string
    {
        if (preg_match('/&lt;\/?(p|h[1-6]|ul|ol|li|strong|em|blockquote|table|figure|img|a)\b/i', $html)) {
            return html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $html;
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        $allowedTags = [
            'a', 'blockquote', 'br', 'caption', 'code', 'div', 'em', 'figcaption', 'figure',
            'h2', 'h3', 'h4', 'hr', 'img', 'li', 'ol', 'p', 'pre', 'span', 'strong',
            'table', 'tbody', 'td', 'tfoot', 'th', 'thead', 'tr', 'u', 'ul',
        ];

        for ($child = $node->firstChild; $child; $child = $next) {
            $next = $child->nextSibling;

            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, $allowedTags, true)) {
                    $child->parentNode?->removeChild($child);
                    continue;
                }

                self::sanitizeAttributes($child);
            }

            if ($child->hasChildNodes()) {
                self::sanitizeNode($child);
            }
        }
    }

    private static function sanitizeAttributes(DOMElement $element): void
    {
        $allowedAttributes = [
            'a' => ['href', 'title', 'target', 'rel'],
            'img' => ['src', 'alt', 'title', 'width', 'height', 'loading'],
            'td' => ['colspan', 'rowspan'],
            'th' => ['colspan', 'rowspan', 'scope'],
            '*' => ['id'],
        ];

        $tag = strtolower($element->tagName);
        $allowed = array_merge($allowedAttributes['*'], $allowedAttributes[$tag] ?? []);

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->name);
            $value = trim($attribute->value);

            if (! in_array($name, $allowed, true) || str_starts_with($name, 'on')) {
                $element->removeAttribute($attribute->name);
                continue;
            }

            if (in_array($name, ['href', 'src'], true) && ! self::isSafeUrl($value)) {
                $element->removeAttribute($attribute->name);
            }
        }

        if ($tag === 'a' && $element->hasAttribute('target')) {
            $element->setAttribute('rel', 'noopener noreferrer');
        }

        if ($tag === 'img' && ! $element->hasAttribute('loading')) {
            $element->setAttribute('loading', 'lazy');
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        return $url === ''
            || str_starts_with($url, '/')
            || str_starts_with($url, '#')
            || preg_match('/^(https?:|mailto:|tel:|data:image\/(?:png|gif|jpe?g|webp);base64,)/i', $url) === 1;
    }

    /**
     * @return array<int, array{level: int, id: string, text: string}>
     */
    private static function addHeadingIds(DOMElement $root): array
    {
        $toc = [];
        $usedIds = [];

        foreach ($root->getElementsByTagName('*') as $element) {
            $tag = strtolower($element->tagName);

            if (! in_array($tag, ['h2', 'h3'], true)) {
                continue;
            }

            $text = trim($element->textContent);
            if ($text === '') {
                continue;
            }

            $id = $element->getAttribute('id') ?: Str::slug($text);
            $id = $id ?: 'section';
            $baseId = $id;
            $count = 2;

            while (isset($usedIds[$id])) {
                $id = $baseId.'-'.$count;
                $count++;
            }

            $usedIds[$id] = true;
            $element->setAttribute('id', $id);

            $toc[] = [
                'level' => (int) substr($tag, 1),
                'id' => $id,
                'text' => $text,
            ];
        }

        return $toc;
    }

    private static function innerHtml(DOMElement $element): string
    {
        $html = '';

        foreach ($element->childNodes as $child) {
            $html .= $element->ownerDocument->saveHTML($child);
        }

        return $html;
    }
}
