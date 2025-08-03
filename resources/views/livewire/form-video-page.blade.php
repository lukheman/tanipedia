<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">

        <!-- Video Preview -->
        @if ($currentState === \App\Enums\State::UPDATE)
        <div class="mb-4 text-center">
            <video class="rounded shadow-sm" width="100%" height="auto" controls>
                <source src="{{ asset('storage/' . $url_video) }}" type="video/mp4">
                Browser Anda tidak mendukung video tag.
            </video>
        </div>
        @endif

        <!-- Judul Video -->
        <div class="mb-3">
            <label for="judul" class="form-label fw-semibold">Judul Video</label>
            <input wire:model.defer="judul" type="text" id="judul" class="form-control" placeholder="Masukkan judul video">
            @error('judul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Upload Video -->
        @if ($currentState === \App\Enums\State::CREATE)
        <div class="mb-3">
            <label for="video" class="form-label fw-semibold">Unggah Video</label>
            <input wire:model.defer="video" class="form-control" type="file" id="video" accept="video/*">
            @error('video')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        @endif

        <!-- Deskripsi Video -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
            <textarea id="deskripsi" wire:model="deskripsi" class="form-control" rows="6" placeholder="Tulis deskripsi video..."></textarea>
        </div>

        <button class="btn btn-primary" wire:click="save">Simpan</button>

    </div>
</div>
