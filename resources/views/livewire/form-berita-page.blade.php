<div class="card">
    <div class="card-body"> 

    <div class="form-group">
        <label for="judul">Judul</label>
        <input wire:model="judul" type="text" class="form-control" id="judul" placeholder="Masukan judul berita">
    </div>

    <div>
        <div id="editor" style="min-height: 200px;"></div>
    </div>
    <input type="hidden" wire:model="isi" id="isi">

    <button class="btn btn-primary float-end mt-3" wire:click="submit">Publikasi</button>
    </div>
</div>

@push('scripts')
 <script>
        // Initialize Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Sync Quill content with hidden input for Livewire
        quill.on('text-change', function() {
            document.getElementById('isi').value = quill.root.innerHTML;
            document.getElementById('isi').dispatchEvent(new Event('input'));
        });

        // Optional: Set initial content if exists
        document.addEventListener('DOMContentLoaded', function() {
        const initialContent = @json($isi);
        if (initialContent) {
            quill.root.innerHTML = initialContent; // Atur konten awal
        }
        });
    </script>

@endpush
