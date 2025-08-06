<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\LandingPage::class)->name('index');

Route::get('/landing', \App\Livewire\LandingPage::class)->name('landing');
Route::get('/login', \App\Livewire\LoginPage::class)->name('login')->middleware('guest');
Route::get('/logout', App\Http\Controllers\LogoutController::class)->name('logout');
Route::get('/registrasi', \App\Livewire\RegistrasiPage::class)->name('registrasi')->middleware('guest');

Route::get('/baca-berita/{id}', \App\Livewire\BacaBerita::class)->name('baca-berita');
Route::get('/nonton-video/{id}', \App\Livewire\NontonVideo::class)->name('nonton-video');

Route::get('/edit-berita/{id}', \App\Livewire\FormBeritaPage::class)->name('berita.edit')->middleware('auth');
Route::get('/tambah-berita', \App\Livewire\FormBeritaPage::class)->name('berita.add')->middleware('auth');
Route::get('/berita', \App\Livewire\BeritaPage::class)->name('berita')->middleware('auth');

Route::get('/dashboard', \App\Livewire\DashboardPage::class)->name('dashboard')->middleware(['auth']);

Route::get('/video', \App\Livewire\VideoPage::class)->name('video')->middleware('auth');
Route::get('/video/{id}/komentar', \App\Livewire\KomentarPage::class)->name('video.komentar')->middleware('auth');

Route::get('/pengguna', \App\Livewire\PenggunaPage::class)->name('pengguna')->middleware('auth');

Route::get('/konsultasi', \App\Livewire\KonsultasiPage::class)->name('konsultasi')->middleware('auth');
Route::get('/tambah-konsultasi', \App\Livewire\FormKonsultasiPage::class)->name('tambah-konsultasi')->middleware('auth');

Route::get('/laporan/petani', \App\Livewire\Laporan\LaporanPetaniPage::class)->name('laporan.petani')->middleware('auth');
Route::get('/laporan/ahli-pertanian', \App\Livewire\Laporan\LaporanAhliPertanianPage::class)->name('laporan.ahli-pertanian')->middleware('auth');
Route::get('/laporan/konsultasi', \App\Livewire\Laporan\LaporanKonsultasiPage::class)->name('laporan.konsultasi')->middleware('auth');

Route::get('/profile', \App\Livewire\Profile::class)->name('profile')->middleware('auth');

Route::get('/cetak-laporan/petani', [LaporanController::class, 'laporanPetani'])->name('print-laporan.petani')->middleware('auth');
Route::get('/cetak-laporan/ahli-pertanian', [LaporanController::class, 'laporanAhliPertanian'])->name('print-laporan.ahli-pertanian')->middleware('auth');
Route::post('/cetak-laporan/konsultasi', [LaporanController::class, 'laporanKonsultasi'])->name('print-laporan.konsultasi')->middleware('auth');
Route::post('/cetak-laporan/konsultasi-kecamatan', [LaporanController::class, 'laporanKonsultasiKecamatan'])->name('print-laporan.konsultasi-kecamatan')->middleware('auth');

Route::post('/upload-image', [FormBeritaPage::class, 'uploadImage'])->name('upload.image');

Route::post('/upload-image', UploadImageController::class)->name('upload.image');
