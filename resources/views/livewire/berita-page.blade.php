<div>
    <x-slot:heading>
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#default">Tambah Data</button>
        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#default">
            Launch Modal
        </button>
    </x-slot:heading>

    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-full" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Basic Modal</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input wire:model="judul" type="text" class="form-control" id="judul" placeholder="Masukan judul berita">
                    </div>

                    <div wire:ignore>
                        <div id="editor" style="min-height: 200px;"></div>
                    </div>
                    <input type="hidden" wire:model="isi">
                    <button wire:click="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>judul</th>
                    <th>tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($berita as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->judul }}</td>
                    <td>{{ $item->tanggal_publikasi}}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-info">Detail</button>
                        <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :items="$berita" />
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Sync Quill content with Livewire model
        const hiddenInput = document.querySelector('input[wire\\:model="isi"]');
        quill.on('text-change', function() {
            hiddenInput.value = quill.root.innerHTML;
            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        });

        // Initialize editor content from Livewire model
        quill.root.innerHTML = hiddenInput.value || '';
    });
</script>
@endpush
