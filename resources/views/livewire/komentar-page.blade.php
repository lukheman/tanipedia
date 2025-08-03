<div>
        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Tanggal Komentar</th>
                        <th>Komentar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($komentar as $item)
                    <tr>
                        <td class="text-bold-500">{{ $item->user->name }}</td>
                        <td>{{ $item->tanggal_komentar}}</td>
                        <td>{{ $item->isi }}</td>
                        <td class="text-end">
                        <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
