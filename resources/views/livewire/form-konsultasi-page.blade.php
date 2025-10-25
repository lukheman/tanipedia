<div class="card">
    <div class="card-body">

    <form wire:submit="submit" class="mx-auto" style="max-width: 600px;">

        <div class="mb-4">
            <label for="judul" class="form-label">Judul Konsultasi</label>

            <input wire:model="judul" type="text" class="form-control" id="judul" placeholder="contoh: perkembangan tanaman">
            @error('judul')
                <small class="d-blmck mt-1 text-danger">{{ $message }}</small>
            @enderror

        </div>

        <div class="mb-4">
            <label for="crop_type" class="form-label">Jenis Tanaman</label>

            <select id="crop_type" wire:model.live="id_tanaman" class="form-control @error('id_tanaman') is-invalid @enderror">
                                    <option value="">Pilih Tanaman</option>
                                    @foreach ($tanamanList as $tanaman)
                                        <option value="{{ $tanaman->id_tanaman }}">{{ $tanaman->nama }}</option>
                                    @endforeach
            </select>

            @error('id_tanaman')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>

        <div class="mb-4">
            <label for="nama_penyuluh" class="form-label">Pilih Penyuluh</label>

            <select id="nama_penyuluh" wire:model="id_penyuluh" class="form-control @error('id_penyuluh') is-invalid @enderror">
                                    <option value="">Pilih Penyuluh</option>
                                    @foreach ($penyuluhList as $penyuluh)
                                        <option value="{{ $penyuluh->id_penyuluh}}">{{ $penyuluh->name }}</option>
                                    @endforeach
            </select>

            @error('id_penyuluh')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>

            <button type="submit" class="btn btn-primary float-end">
                Buat Konsultasi
            </button>
    </form>
    </div>
</div>
