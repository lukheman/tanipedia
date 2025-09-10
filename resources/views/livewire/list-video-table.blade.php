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
            @foreach ($videos as $item)
            <tr>
                <td class="text-bold-500">{{ $item->judul }}</td>
                <td>{{ $item->tanggal_publikasi}}</td>
                <td class="text-end">
                <button wire:click="detail({{ $item }})"class="btn btn-sm btn-info">Lihat</button>
                <button wire:click="edit({{ $item->id_video }})" class="btn btn-warning">Edit</button>
                <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <x-pagination :items="$videos" />
</div>

