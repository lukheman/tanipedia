<div class="card">
    <div class="card-body">
        <button wire:click="add" class="btn btn-primary">
            <i class="bi bi-person-plus"></i>
            Tambah Tanaman
        </button>

        <div class="modal fade" id="modal-form-tanaman" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="myModalLabel1">
                            @if ($currentState === \App\Enums\State::CREATE)
                                Tambah Tanaman
                            @elseif ($currentState === \App\Enums\State::UPDATE)
                                Perbarui Tanaman
                            @elseif ($currentState === \App\Enums\State::SHOW)
                                Detail Tanaman
                            @endif
                        </h5>
                        <button type="button" class="close rounded-pill" wire:click="$dispatch('closeModal', {id: 'modal-form-tanaman'})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama</label>
                                <input wire:model="form.nama" type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama tanaman" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                @error('form.nama')
                                    <small class="d-blmck mt-1 text-danger">{{ $message }}</small>
                                @enderror
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
                        <th>Nama Tanaman</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->tanamanList as $item)
                        <tr>
                            <td class="text-bold-500">{{ $item->nama }}</td>
                            <td class="text-end">
                                <button wire:click="detail({{ $item->id_tanaman }})" class="btn btn-sm btn-info">Lihat</button>
                                <button wire:click="edit({{ $item->id_tanaman }})" class="btn btn-sm btn-warning">Edit</button>
                                <button wire:click="delete({{ $item->id_tanaman }})" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-pagination :items="$this->tanamanList" />
        </div>
    </div>
</div>
