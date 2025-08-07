<div class="container py-5">
    <h2 class="section-title text-center">Video Terkini</h2>
    <div class="row mb-4">
        <div class="col-12">
            <form class="d-flex justify-content-center">
                <div class="input-group" style="max-width: 500px;">
                    <input type="text" class="form-control" placeholder="Cari video edukasi..." wire:model.live="search" aria-label="Cari video edukasi">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @forelse ($this->videos as $video)
                    <div class="col-md-4 mb-4">
<livewire:video-card :video="$video" :wire:key="$video->id" />
                    </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada video tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('landing') }}" class="btn btn-custom" wire:navigate>Kembali ke halaman utama</a>
    </div>
</div>
