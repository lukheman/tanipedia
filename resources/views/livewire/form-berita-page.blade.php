
@push('styles')
<style>
        #editor img {
            max-width: 100%;
            width: 300px;
            height: auto;
        }
    </style>

@endpush
<div class="card">
    <div class="card-body">

    <div class="form-group">
        <label for="judul">Judul</label>
        <input wire:model="judul" type="text" class="form-control" id="judul" placeholder="Masukan judul berita">

                                @error('judul')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
    </div>

    <div wire:ignore.this>
        <div id="editor" style="min-height: 200px;"></div>
    </div>
    <input type="hidden" wire:model="isi" id="isi">

                                @error('isi')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror

    <button class="btn btn-primary float-end mt-3" wire:click="submit">Publikasi</button>
    </div>
</div>

@push('scripts')
<!-- Include Quill and quill-image-uploader via CDN -->
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-image-uploader@1.3.0/dist/quill.imageUploader.min.js"></script>

<script>
// Register the imageUploader module
Quill.register('modules/imageUploader', window.ImageUploader);

const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            ['link', 'image', 'blockquote', 'code-block'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ],
        imageUploader: {
            upload: (file) => {
                return new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('image', file);

                    fetch('/upload-image', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Upload failed with status ' + response.status);
                        }
                        return response.json();
                    })
                    .then(result => {
                        if (result.url) {
                                console.log(result.url);
                            resolve(result.url); // Insert image URL into editor
                        } else {
                            reject(result.error || 'Upload failed');
                        }
                    })
                    .catch(error => reject('Upload failed: ' + error.message));
                });
            }
        }
    }
});

// Sync Quill content with hidden input for Livewire
quill.on('text-change', function() {
    document.getElementById('isi').value = quill.root.innerHTML;
    document.getElementById('isi').dispatchEvent(new Event('input'));
});

// Set initial content
document.addEventListener('DOMContentLoaded', function() {
    const initialContent = @json($isi);
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }
});
</script>
@endpush
