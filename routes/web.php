<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UploadImageController;
use App\Http\Middleware\MultiAuth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', \App\Livewire\LandingPage::class)->name('index');
Route::get('/landing', \App\Livewire\LandingPage::class)->name('landing');

Route::get('/login', \App\Livewire\LoginPage::class)->name('login')->middleware('guest');
Route::get('/petani/login', \App\Livewire\LoginPage::class)->name('petani.login')->middleware('guest');
Route::get('/admin/login', \App\Livewire\LoginPage::class)->name('admin.login')->middleware('guest');
Route::get('/logout', App\Http\Controllers\LogoutController::class)->name('logout');

Route::get('/registrasi', \App\Livewire\RegistrasiPage::class)->name('registrasi')->middleware('guest');

/*
|--------------------------------------------------------------------------
| Konten Publik (Berita & Video)
|--------------------------------------------------------------------------
*/
Route::get('/baca-berita/{id}', \App\Livewire\Berita\BacaBerita::class)->name('berita.baca-berita');
Route::get('/nonton-video/{id}', \App\Livewire\NontonVideo::class)->name('nonton-video');

Route::get('/semua-berita', \App\Livewire\Berita\BeritaIndex::class)->name('berita.index');
Route::get('/semua-video', \App\Livewire\VideoIndex::class)->name('video.index');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(MultiAuth::class . ':admin')->group(function () {
    // Berita
    Route::get('/berita', \App\Livewire\Berita\BeritaPage::class)->name('berita');
    Route::get('/tambah-berita', \App\Livewire\FormBeritaPage::class)->name('berita.add');
    Route::get('/edit-berita/{id}', \App\Livewire\FormBeritaPage::class)->name('berita.edit');

    // Video
    Route::get('/video', \App\Livewire\VideoPage::class)->name('video');
    Route::get('/video/{id}/komentar', \App\Livewire\KomentarPage::class)->name('video.komentar');

    // Data pengguna dan tanaman
    Route::get('/pengguna', \App\Livewire\PenggunaPage::class)->name('pengguna');
    Route::get('/tanaman', \App\Livewire\TanamanTable::class)->name('tanaman');

    // Upload
    Route::post('/upload-image', UploadImageController::class)->name('upload.image');
});

/*
|--------------------------------------------------------------------------
| Dashboard & Profile
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', \App\Livewire\DashboardPage::class)
    ->name('dashboard')
    ->middleware(MultiAuth::class . ':petani,admin,penyuluh,kepala_dinas');

Route::get('/profile', \App\Livewire\Profile::class)
    ->name('profile')
    ->middleware(MultiAuth::class . ':admin,petani,penyuluh,kepala_dinas');

/*
|--------------------------------------------------------------------------
| Petani Routes
|--------------------------------------------------------------------------
*/
Route::middleware(MultiAuth::class . ':petani')->group(function () {
    Route::get('/home', \App\Livewire\PetaniHome::class)->name('petani-home');
});

/*
|--------------------------------------------------------------------------
| Penyuluh Routes
|--------------------------------------------------------------------------
*/
Route::middleware(MultiAuth::class . ':penyuluh,petani')->group(function () {
    Route::get('/permintaan-konsultasi', \App\Livewire\Konsultasi\PermintaanTable::class)
        ->name('permintaan-konsultasi');

    Route::get('/jadwal-penyuluhan', \App\Livewire\JadwalPenyuluhanTable::class)
        ->name('jadwal-penyuluhan');
});

/*
|--------------------------------------------------------------------------
| Halaman Konsultasi (Multi Role)
|--------------------------------------------------------------------------
*/
Route::get('/konsultasi', \App\Livewire\Konsultasi\DiterimaPage::class)
    ->name('konsultasi')
    ->middleware(MultiAuth::class . ':penyuluh,petani,admin');

/*
|--------------------------------------------------------------------------
| Kepala Dinas Routes (Laporan)
|--------------------------------------------------------------------------
*/
Route::middleware(MultiAuth::class . ':kepala_dinas')->group(function () {
    // Halaman laporan
    Route::get('/laporan/pengguna', \App\Livewire\Laporan\LaporanPenggunaPage::class)->name('laporan.pengguna');
    Route::get('/laporan/petani', \App\Livewire\Laporan\LaporanPetaniPage::class)->name('laporan.petani');
    Route::get('/laporan/ahli-pertanian', \App\Livewire\Laporan\LaporanAhliPertanianPage::class)->name('laporan.ahli-pertanian');
    Route::get('/laporan/kegiatan-penyuluhan', \App\Livewire\LaporanJadwalPenyuluhanTable::class)->name('laporan.kegiatan-penyuluhan');
    Route::get('/laporan/konsultasi', \App\Livewire\Laporan\LaporanKonsultasiPage::class)->name('laporan.konsultasi');

    // Cetak laporan
    Route::get('/cetak-laporan/petani/{id}/{tahun}', [LaporanController::class, 'laporanPetani'])
        ->name('print-laporan.petani');
    Route::get('/cetak-laporan/ahli-pertanian/{id}/{tahun}', [LaporanController::class, 'laporanAhliPertanian'])
        ->name('print-laporan.ahli-pertanian');
    Route::post('/cetak-laporan/konsultasi', [LaporanController::class, 'laporanKonsultasi'])
        ->name('print-laporan.konsultasi');
    Route::post('/cetak-laporan/konsultasi-kecamatan', [LaporanController::class, 'laporanKonsultasiKecamatan'])
        ->name('print-laporan.konsultasi-kecamatan');
    Route::post('/cetak-laporan/kegiatan-penyuluhan', [LaporanController::class, 'laporanKegiatanPenyuluhan'])
        ->name('print-laporan.kegiatan-penyuluhan');
});
