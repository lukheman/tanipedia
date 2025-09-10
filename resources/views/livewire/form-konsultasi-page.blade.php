<div class="card">
    <div class="card-body">

    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Konsultasi Tanaman Anda</h2>
        <p class="text-muted lead">
            Punya masalah dengan tanaman kesayangan? Ceritakan keluhannya di sini, dan kami akan bantu cari solusinya!
        </p>
    </div>

    <form wire:submit="submit" class="mx-auto" style="max-width: 600px;">
        <div class="mb-4">
            <label for="crop_type" class="form-label">Jenis Tanaman</label>

            <select id="crop_type" wire:model="id_tanaman" class="form-control @error('id_tanaman') is-invalid @enderror">
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
            <label for="problem" class="form-label">Deskripsi Masalah</label>
            <textarea
                id="problem"
                class="form-control @error('isi') is-invalid @enderror"
                wire:model.defer="isi"
                rows="8"
                placeholder="Jelaskan gejala, kondisi lingkungan, atau perubahan yang terjadi pada tanaman Anda..."></textarea>
            @error('isi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

            <button type="submit" class="btn btn-primary">
                Kirim Konsultasi
            </button>
    </form>
    </div>
</div>
