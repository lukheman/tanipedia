<div class="card">
    <div class="card-header">

    <a href="{{ route('print-laporan.ahli-pertanian')}}" class="btn btn-danger" type="submit">
    <i class="bi bi-printer"></i>
    Cetak Laporan</a>
    </div>
    <div class="card-body">



    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Tanggal Lahir</th>
                    <!-- <th class="text-end">Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->name }}</td>
                    <td>{{ $item->email}}</td>
                    <td>{{ $item->telepon}}</td>
                    <td>{{ $item->tanggal_lahir}}</td>
                    <!-- <td><span class="badge bg-{{\App\Enums\Role::from($item->role)->getColor()}}">{{ $item->role }}</span></td> -->
                    <!-- <td class="text-end"> -->
                    <!--     <button wire:click="detail({{ $item }})"class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-form-pengguna">Lihat</button> -->
                    <!--     <button wire:click="edit({{ $item }})" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-form-pengguna">Edit</button> -->
                    <!--     <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button> -->
                    <!---->
                    <!-- </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :items="$users" />
    </div>

    </div>
</div>
