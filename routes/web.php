<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UploadImageController;
use App\Http\Middleware\MultiAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\LandingPage::class)->name('index');

Route::get('/landing', \App\Livewire\LandingPage::class)->name('landing');

Route::get('/login', \App\Livewire\LoginPage::class)->name('login')->middleware('guest');
Route::get('/petani/login', \App\Livewire\LoginPage::class)->name('petani.login')->middleware('guest');
Route::get('/admin/login', \App\Livewire\LoginPage::class)->name('admin.login')->middleware('guest');

Route::get('/logout', App\Http\Controllers\LogoutController::class)->name('logout');
Route::get('/registrasi', \App\Livewire\RegistrasiPage::class)->name('registrasi')->middleware('guest');

Route::get('/baca-berita/{id}', \App\Livewire\BacaBerita::class)->name('baca-berita');
Route::get('/nonton-video/{id}', \App\Livewire\NontonVideo::class)->name('nonton-video');

Route::get('/semua-berita', \App\Livewire\BeritaIndex::class)->name('berita.index');
Route::get('/semua-video', \App\Livewire\VideoIndex::class)->name('video.index');

Route::get('/edit-berita/{id}', \App\Livewire\FormBeritaPage::class)->name('berita.edit')->middleware(MultiAuth::class.':admin');
Route::get('/tambah-berita', \App\Livewire\FormBeritaPage::class)->name('berita.add')->middleware(MultiAuth::class.':admin');
Route::get('/berita', \App\Livewire\BeritaPage::class)->name('berita')->middleware(MultiAuth::class.':admin');

Route::get('/dashboard', \App\Livewire\DashboardPage::class)
    ->name('dashboard')
    ->middleware(MultiAuth::class.':petani,admin,penyuluh,kepala_dinas');

Route::get('/video', \App\Livewire\VideoPage::class)->name('video')->middleware(MultiAuth::class.':admin');
Route::get('/video/{id}/komentar', \App\Livewire\KomentarPage::class)->name('video.komentar')->middleware(MultiAuth::class.':admin');

Route::get('/pengguna', \App\Livewire\PenggunaPage::class)->name('pengguna')->middleware(MultiAuth::class.':admin');

Route::get('/konsultasi', \App\Livewire\KonsultasiTable::class)->name('konsultasi')->middleware(MultiAuth::class.':admin,penyuluh,petani');

Route::get('/tanaman', \App\Livewire\TanamanTable::class)->name('tanaman')->middleware(MultiAuth::class.':admin');

Route::get('/tambah-konsultasi', \App\Livewire\FormKonsultasiPage::class)
    ->name('tambah-konsultasi')
    ->middleware(MultiAuth::class.':petani');

Route::get('/laporan/petani', \App\Livewire\Laporan\LaporanPetaniPage::class)->name('laporan.petani')->middleware(MultiAuth::class.':kepala_dinas');
Route::get('/laporan/ahli-pertanian', \App\Livewire\Laporan\LaporanAhliPertanianPage::class)->name('laporan.ahli-pertanian')->middleware(MultiAuth::class.':kepala_dinas');
Route::get('/laporan/konsultasi', \App\Livewire\Laporan\LaporanKonsultasiPage::class)->name('laporan.konsultasi')->middleware(MultiAuth::class.':kepala_dinas');

Route::get('/profile', \App\Livewire\Profile::class)->name('profile')->middleware(MultiAuth::class.':admin,petani,penyuluh,kepala_dinas');

Route::get('/cetak-laporan/petani', [LaporanController::class, 'laporanPetani'])->name('print-laporan.petani')->middleware(MultiAuth::class.':kepala_dinas');
Route::get('/cetak-laporan/ahli-pertanian', [LaporanController::class, 'laporanAhliPertanian'])->name('print-laporan.ahli-pertanian')->middleware(MultiAuth::class.':kepala_dinas');
Route::post('/cetak-laporan/konsultasi', [LaporanController::class, 'laporanKonsultasi'])->name('print-laporan.konsultasi')->middleware(MultiAuth::class.':kepala_dinas');
Route::post('/cetak-laporan/konsultasi-kecamatan', [LaporanController::class, 'laporanKonsultasiKecamatan'])->name('print-laporan.konsultasi-kecamatan')->middleware(MultiAuth::class.':kepala_dinas');

Route::post('/upload-image', UploadImageController::class)->name('upload.image')->middleware(MultiAuth::class.':admin');
