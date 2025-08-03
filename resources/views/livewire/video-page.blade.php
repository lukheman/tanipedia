<div class="card">
    <div class="card-body"> 



    <div class="row">
        <div class="col-12">

        @if ($currentState === \App\Enums\State::CREATE)
            <livewire:form-video-page />
        @elseif($currentState === \App\Enums\State::UPDATE)
            <livewire:form-video-page :video="$selectedVideo" />
        @elseif($currentState === \App\Enums\State::KOMENTAR)
            <livewire:komentar-page :video="$selectedVideo" />
        @elseif($currentState === \App\Enums\State::LISTDATA)

        <button class="btn btn-primary" wire:click="setState('{{ \App\Enums\State::CREATE->value}}')">
            <i class="bi bi-pencil"></i>
            Upload Video
        </button>
        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal Publikasi</th>
                        <!-- <th>Deskripsi</th> -->
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $item)
                    <tr>
                        <td class="text-bold-500">{{ $item->label_judul }}</td>
                        <td>{{ $item->tanggal_publikasi}}</td>
                        <!-- <td>{{ $item->label_deskripsi }}</td> -->
                        <td class="text-end">
                        <!-- <button wire:click="detail({{ $item }})"class="btn btn-sm btn-info">Lihat</button> -->
                        <a href="{{ route('komentar', ['id' => $item->id ])}}" class="btn btn-sm btn-primary">Lihat Komentar</a>
                        <button wire:click="edit({{ $item }})" class="btn btn-sm btn-warning">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <x-pagination :items="$videos" />
        </div>
    @endif



        </div>
    </div>


    <script>
        document.addEventListener('livewire:load', function () {
            // Menutup modal setelah sukses
            window.livewire.on('close-modal', () => {
                $('#modal-form-video').modal('hide');
            });
        });
    </script>
    </div>
</div>
