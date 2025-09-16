<div class="row">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/compiled/jpg/2.jpg') }}" alt="">
                    </div>
                    <div class="mt-2">
                        <label for="profile-photo" class="btn btn-outline-primary btn-sm" style="cursor: pointer;">
                            <i class="bi bi-camera"></i> Ganti Foto
                        </label>
                        <input wire:model="form.photo" type="file" id="profile-photo" class="d-none" accept="image/*">
                    </div>
                    <h3 class="mt-3">{{ $user->name }}</h3>
                    <p class="text-small">{{ class_basename($user) }}</p>
                    {{-- kalau multi table auth, ini akan menampilkan tipe user berdasarkan model --}}
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <form wire:submit="edit">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input wire:model="form.name" type="text" id="name" class="form-control" placeholder="Your Name">
                        @error('form.name')
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input wire:model="form.email" type="text" id="email" class="form-control">
                        @error('form.email')
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- tampilkan kecamatan & desa hanya jika user punya relasi desa --}}
                    @if ($user->desa)
                        <div class="row">
                            <div class="col-6">
                                <!-- Kecamatan -->
                                <div class="form-group">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select wire:model.live="kecamatan" class="form-control" id="kecamatan">
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach ($kecamatanList as $item)
                                            <option value="{{ $item->id_kecamatan }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kecamatan')
                                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Desa -->
                                <div class="form-group">
                                    <label for="desa" class="form-label">Desa</label>
                                    <select wire:model="form.desa" class="form-control" id="desa">
                                        <option value="">Pilih Desa</option>
                                        @foreach ($desaList as $item)
                                            <option value="{{ $item->id_desa }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.desa')
                                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input wire:model="form.telepon" type="text" id="telepon" class="form-control">
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

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input wire:model="form.password" type="password" id="password" class="form-control">
                        @error('form.password')
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
