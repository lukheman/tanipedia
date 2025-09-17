<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">

        <!-- Video Preview -->
        @if ($currentState === \App\Enums\State::UPDATE)
        <div class="mb-4 text-center">
            <video class="rounded shadow-sm" width="100%" height="auto" controls>
                <source src="{{ asset('storage/' . $form->url_video) }}" type="video/mp4">
                Browser Anda tidak mendukung video tag.
            </video>
        </div>
        @endif

        <form wire:submit.prevent="save" enctype="multipart/form-data">

            <div x-data="{ uploading: false, progress: 10}"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                >

        <!-- Judul Video -->
        <div class="mb-3">
            <label for="judul" class="form-label fw-semibold">Judul Video</label>
            <input wire:model="form.judul" type="text" id="judul" class="form-control" placeholder="Masukkan judul video">
            @error('judul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Upload Video -->
        @if ($currentState === \App\Enums\State::CREATE)
<div class="mb-3">
    <label for="video" class="form-label fw-semibold">Unggah Video</label>
    <input
        wire:model.defer="form.video"
        class="form-control"
        type="file"
        id="video"
        accept="video/*"
    >
    @error('form.video')
        <small class="text-danger">{{ $message }}</small>
    @enderror
                    <div x-show="uploading">

<div x-show="uploading">
    <div class="progress w-100">
        <div class="progress-bar progress-bar-striped progress-bar-animated"
             role="progressbar"
             x-bind:style="`width: ${progress}%`"
             x-bind:aria-valuenow="progress"
             aria-valuemin="0"
             aria-valuemax="100">
            <span x-text="progress + '%'"></span>
        </div>
    </div>
</div>
                    </div>
</div>
        @endif

        <!-- Deskripsi Video -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
            <textarea id="deskripsi" wire:model="form.deskripsi" class="form-control" rows="6" placeholder="Tulis deskripsi video..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>
</div>
