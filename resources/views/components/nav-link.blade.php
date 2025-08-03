@props(['href', 'active' => false, 'icon' => 'fa-home'])

@php
    $classes = $active ? 'sidebar-item active' : 'sidebar-item';
@endphp

<li {{ $attributes->class([$classes]) }}>
    <a href="{{ $href }}" class="sidebar-link">
        <i class="bi {{ $icon }}"></i>
        <span>{{ $slot }}</span>
    </a>
</li>
