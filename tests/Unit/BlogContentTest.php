<?php

namespace Tests\Unit;

use App\Support\BlogContent;
use PHPUnit\Framework\TestCase;

class BlogContentTest extends TestCase
{
    public function test_it_renders_saved_html_and_builds_toc(): void
    {
        $content = BlogContent::prepare('<h2>What is branding?</h2><p>Brand strategy content.</p>');

        $this->assertStringContainsString('<h2 id="what-is-branding">What is branding?</h2>', $content['html']);
        $this->assertStringContainsString('<p>Brand strategy content.</p>', $content['html']);
        $this->assertSame([
            [
                'level' => 2,
                'id' => 'what-is-branding',
                'text' => 'What is branding?',
            ],
        ], $content['toc']);
    }

    public function test_it_decodes_escaped_editor_html(): void
    {
        $content = BlogContent::prepare('&lt;p&gt;Formatted paragraph.&lt;/p&gt;');

        $this->assertStringContainsString('<p>Formatted paragraph.</p>', $content['html']);
        $this->assertStringNotContainsString('&lt;p&gt;', $content['html']);
    }

    public function test_it_removes_unsafe_markup(): void
    {
        $content = BlogContent::prepare('<p onclick="alert(1)">Safe</p><script>alert(1)</script><a href="javascript:alert(1)">Bad link</a>');

        $this->assertStringContainsString('<p>Safe</p>', $content['html']);
        $this->assertStringNotContainsString('<script>', $content['html']);
        $this->assertStringNotContainsString('onclick', $content['html']);
        $this->assertStringNotContainsString('javascript:', $content['html']);
    }
}
