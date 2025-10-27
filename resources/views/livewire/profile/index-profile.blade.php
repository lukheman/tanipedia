<div>

@if (auth('admin')->check())

    <livewire:profile.admin-profile />

@elseif(auth('penyuluh')->check())

    <livewire:profile.penyuluh-profile />

@elseif(auth('petani')->check())

    <livewire:profile.petani-profile />

@elseif(auth('kepala_dinas')->check())

    <livewire:profile.kepala-dinas-profile />

@endif

</div>
