@php
    use \App\Enums\Role;
    $role = auth()->user()->role;
@endphp

<div>
    <x-flash-message />
    @if ($role === Role::ADMIN->value)
    <livewire:admin-dashboard />
    @elseif($role === Role::PETANI->value)
    <livewire:petani-dashboard />
    @elseif($role === Role::PETANI->value)
    @elseif($role === Role::AHLIPERTANIAN->value)
    <livewire:ahli-pertanian-dashboard />
    @elseif($role === Role::KEPALADINAS->value)
    <livewire:kepala-dinas-dashboard />
    @endif
</div>
