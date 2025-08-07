<div class="container py-5">
    <h2 class="section-title text-center">Berita Terkini</h2>
    <div class="row mb-4">
        <div class="col-12">
            <form class="d-flex justify-content-center">
                <div class="input-group" style="max-width: 500px;">
                    <input type="text" class="form-control" placeholder="Cari berita..." wire:model.live="search" aria-label="Cari berita">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @forelse ($this->berita as $item)
            <div class="col-12 mt-3">
                <livewire:berita-card :berita="$item" :wire:key="$item->id" />
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada berita tersedia.</p>
            </div>
        @endforelse
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('landing') }}" class="btn btn-custom" wire:navigate>Kembali ke halaman utama</a>
    </div>
</div>
