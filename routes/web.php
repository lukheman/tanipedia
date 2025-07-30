<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\IndexPage::class)->name('index');

Route::get('/berita', \App\Livewire\BeritaPage::class)->name('berita');
