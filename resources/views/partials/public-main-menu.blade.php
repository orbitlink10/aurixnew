@php
    $publicMainMenuItems = $mainMenuItems
        ?? (\Illuminate\Support\Facades\Schema::hasTable('site_settings')
            ? \App\Models\SiteSetting::mainMenuItems()
            : \App\Models\SiteSetting::defaultMainMenuItems());
    $currentUrl = rtrim(url()->current(), '/');
    $currentFullUrl = rtrim(url()->full(), '/');
@endphp

@foreach($publicMainMenuItems as $menuItem)
    @php
        $label = $menuItem['label'] ?? '';
        $rawUrl = $menuItem['url'] ?? '#';
        $href = $rawUrl === '/'
            ? url('/')
            : (\Illuminate\Support\Str::startsWith($rawUrl, ['http://', 'https://', '#'])
            ? $rawUrl
            : url($rawUrl));
        $normalizedHref = rtrim($href, '/');
        $isActive = $href !== '#'
            && (
                $normalizedHref === $currentFullUrl
                || (! str_contains($normalizedHref, '?') && strtok($normalizedHref, '?') === $currentUrl)
            );
    @endphp
    @if($label !== '')
        <a href="{{ $href }}" @class(['is-active' => $isActive])>{{ $label }}</a>
    @endif
@endforeach
