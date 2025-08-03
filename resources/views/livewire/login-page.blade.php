<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h2 class="section-title text-center mb-4">Login ke Tani Pedia</h2>

                    <x-flash-message />

                    <form wire:submit="submit">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="email" placeholder="Masukkan email Anda" required>

                    @error('email')

                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" wire:model="password" placeholder="Masukkan kata sandi" required>

                    @error('password')

                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Masuk</button>
                    </form>
                    <div class="text-center mt-2">
                        <p>Belum punya akun? <a href="{{ route('registrasi')}}" class="text-decoration-none">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
