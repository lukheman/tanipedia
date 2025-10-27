<div class="row">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                        {{-- Jika upload baru, tampilkan preview sementara --}}
                        @if ($form->photo && is_object($form->photo))
                            <img src="{{ $form->photo->temporaryUrl() }}" alt="Preview Foto">
                        @else
                            <img src="{{ $form->photo ? asset('storage/' . $form->photo) : asset('assets/compiled/jpg/2.jpg') }}" alt="Foto Profil">
                        @endif
                    </div>

                    <div class="mt-2">
                        <label for="profile-photo" class="btn btn-outline-primary btn-sm" style="cursor: pointer;">
                            <i class="bi bi-camera"></i> Ganti Foto
                        </label>
                        <input wire:model="form.photo" type="file" id="profile-photo" class="d-none" accept="image/*">
                        @error('form.photo')
                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <h3 class="mt-3">{{ $form->name }}</h3>
                    <p class="text-small text-muted">Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <form wire:submit="edit">
                    {{-- Nama --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>
                        <input wire:model="form.name" type="text" id="name" class="form-control" placeholder="Nama Lengkap">
                        @error('form.name')
                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input wire:model="form.email" type="email" id="email" class="form-control" placeholder="Alamat Email">
                        @error('form.email')
                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Telepon & Tanggal Lahir --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input wire:model="form.telepon" type="text" id="telepon" class="form-control" placeholder="Nomor Telepon">
                                @error('form.telepon')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
                                <input wire:model="form.tanggal_lahir" type="date" id="tanggal-lahir" class="form-control">
                                @error('form.tanggal_lahir')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input wire:model="form.password" type="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                        @error('form.password')
                            <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
