<div class="card">
    <div class="card-body">
        <button wire:click="add" class="btn btn-primary">
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
                            @elseif ($currentState === \App\Enums\State::UPDATE)
                                Perbarui Pengguna
                            @elseif ($currentState === \App\Enums\State::SHOW)
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
                                <input wire:model="form.name" type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                @error('form.name')
                                    <small class="d-blmck mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input wire:model="form.email" type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                @error('form.email')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if ($currentState === \App\Enums\State::SHOW)

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                    <input wire:model="selectedKecamatan" type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="desa" class="form-label fw-semibold">Desa</label>
                                    <input wire:model="selectedDesa" type="text" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                            @endif

                            @if ($currentState !== \App\Enums\State::SHOW)

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                        <select wire:model.live="kecamatan" class="form-control" id="kecamatan" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($kecamatanList as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kecamatan')
                                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="desa" class="form-label fw-semibold">Desa</label>
                                        <select wire:model.live="form.id_desa" class="form-control" id="desa" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                            <option value="">Pilih Desa</option>
                                            @foreach ($desaList as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.id_desa')
                                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @endif
                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                <input wire:model="form.alamat" type="text" class="form-control" id="alamat" name="alamat" placeholder="Contoh: Jl. Pemuda" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                @error('form.alamat')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if ($currentState === \App\Enums\State::SHOW)

                                <div class="mb-3">
                                    <label for="role" class="form-label fw-semibold">Role</label>
                                <input wire:model="form.role" type="text" class="form-control" disabled>
                                </div>

                            @else
                            <div class="mb-3">
                                <label for="role" class="form-label fw-semibold">Role</label>
                                <select wire:model="form.role" class="form-select" id="role" name="role" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                    <option value="">Pilih Role</option>
                                    @foreach (\App\Enums\Role::getOptions() as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('form.role')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label fw-semibold">Telepon</label>
                                        <input wire:model="form.telepon" type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                        @error('form.telepon')
                                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                        <input wire:model="form.tanggal_lahir" type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                        @error('form.tanggal_lahir')
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
                        @elseif ($currentState === \App\Enums\State::UPDATE)
                            <button type="button" wire:click="save" class="btn btn-primary">Perbarui</button>
                        @endif
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
                            <td>{{ $item->email }}</td>
                            <td><span class="badge bg-{{ \App\Enums\Role::from($item->role)->getColor() }}">{{ $item->role }}</span></td>
                            <td class="text-end">
                                <button wire:click="detail({{ $item->id }})" class="btn btn-sm btn-info">Lihat</button>
                                <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-warning">Edit</button>
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
