<div class="card">
    <div class="card-body">

<button wire:click="add" class="btn btn-primary" >
    <i class="bi bi-person-plus"></i>
    Tambah Pengguna
</button>

<div class="modal fade" id="modal-form-pengguna" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="myModalLabel1">
                    @if ($currentState === \App\Enums\State::CREATE)
                            Tambah Pengguna
                    @elseif($currentState === \App\Enums\State::UPDATE)
                            Perbarui Pengguna
                    @elseif($currentState === \App\Enums\State::SHOW)
                            Detail Pengguna
                    @endif
                </h5>
                <button type="button" class="close rounded-pill" wire:click="$dispatch('closeModal', {id: 'modal-form-pengguna'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama</label>
                        <input wire:model="name" type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama">
                        @error('name')
                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input wire:model="email" type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                        @error('email')
                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select wire:model="role" class="form-select" id="role" name="role">
                            @foreach (\App\Enums\Role::values() as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="telepon" class="form-label fw-semibold">Telepon</label>
                                <input wire:model="telepon" type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon">
                                @error('telepon')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                <input wire:model="tanggal_lahir" type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                @error('tanggal_lahir')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                @if ($currentState === \App\Enums\State::CREATE)
                    <button type="button" wire:click="save" class="btn btn-primary">Tambahkan</button>
                @elseif($currentState === \App\Enums\State::UPDATE)
                    <button type="button" wire:click="save" class="btn btn-primary">Perbarui</button>
                @endif
                <!-- <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button> -->
            </div>
        </div>
    </div>
</div>


    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->name }}</td>
                    <td>{{ $item->email}}</td>
                    <td><span class="badge bg-{{\App\Enums\Role::from($item->role)->getColor()}}">{{ $item->role }}</span></td>
                    <td class="text-end">

                        <button wire:click="detail({{ $item }})"class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-form-pengguna">Lihat</button>

                        <button wire:click="edit({{ $item }})" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-form-pengguna">Edit</button>

                        <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :items="$users" />
    </div>
    </div>
</div>
