@props(['route', 'active', 'icon' => 'fa-home'])

@php
    $href = route($route);
    $active = request()->routeIs($route);
    $classes = $active ? 'sidebar-item active' : 'sidebar-item';
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    <a href="{{ $href }}" class="sidebar-link">
        <i class="bi {{ $icon }}"></i>
        <span>{{ $slot }}</span>
    </a>
</li>
