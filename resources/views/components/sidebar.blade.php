<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="">TaniPedia</a>
                </div>
                <!-- theme toggle, biarin aja -->
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-md">
                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('./assets/compiled/jpg/2.jpg') }}">
                    </div>

                    {{-- tampilkan nama user sesuai guard --}}
                    @if(auth('admin')->check())
                        <p class="font-bold ms-3 mb-0">Admin - {{ auth('admin')->user()->name }}</p>
                    @elseif(auth('petani')->check())
                        <p class="font-bold ms-3 mb-0">Petani - {{ auth('petani')->user()->name }}</p>
                    @elseif(auth('penyuluh')->check())
                        <p class="font-bold ms-3 mb-0">Penyuluh - {{ auth('penyuluh')->user()->name }}</p>
                    @elseif(auth('kepala_dinas')->check())
                        <p class="font-bold ms-3 mb-0">Kepala Dinas - {{ auth('kepala_dinas')->user()->name }}</p>
                    @endif
                </div>
                <hr>

                <li class="sidebar-title">Navigasi Utama</li>

                <x-nav-link icon="bi-speedometer2"
                    href="{{ route('dashboard')}}"
                    :active="request()->routeIs('dashboard')">
                    Beranda
                </x-nav-link>

                {{-- ADMIN --}}
                @if(auth('admin')->check())
                    <x-nav-link icon="bi-people-fill"
                        href="{{ route('pengguna')}}"
                        :active="request()->routeIs('pengguna')">
                        Manajemen Pengguna
                    </x-nav-link>

                    <x-nav-link icon="bi-newspaper"
                        href="{{ route('berita')}}"
                        :active="request()->routeIs('berita*')">
                        Artikel & Berita
                    </x-nav-link>

                    <x-nav-link icon="bi-camera-video-fill"
                        href="{{ route('video')}}"
                        :active="request()->routeIs('video*')">
                        Galeri Video
                    </x-nav-link>

                    <x-nav-link icon="bi-chat-dots-fill"
                        href="{{ route('konsultasi')}}"
                        :active="request()->routeIs('konsultasi')">
                        Daftar Konsultasi
                    </x-nav-link>
                @endif

                {{-- PETANI --}}
                @if(auth('petani')->check())
                    <x-nav-link icon="bi-plus-circle-fill"
                        href="{{ route('tambah-konsultasi')}}"
                        :active="request()->routeIs('tambah-konsultasi')">
                        Buat Konsultasi Baru
                    </x-nav-link>

                    <x-nav-link icon="bi-chat-dots-fill"
                        href="{{ route('konsultasi')}}"
                        :active="request()->routeIs('konsultasi')">
                        Daftar Konsultasi
                    </x-nav-link>

                    <x-nav-link icon="bi-newspaper"
                        href="{{ route('berita.index') }}"
                        :active="request()->routeIs('berita.index')">
                        Berita Terbaru
                    </x-nav-link>

                    <x-nav-link icon="bi-play-circle-fill"
                        href="{{ route('video.index') }}"
                        :active="request()->routeIs('video.index')">
                        Video Terkini
                    </x-nav-link>
                @endif

                {{-- PENYULUH --}}
                @if(auth('penyuluh')->check())
                    <x-nav-link icon="bi-chat-dots-fill"
                        href="{{ route('konsultasi')}}"
                        :active="request()->routeIs('konsultasi')">
                        Daftar Konsultasi
                    </x-nav-link>
                @endif

                {{-- KEPALA DINAS --}}
                @if(auth('kepala_dinas')->check())
                    <x-nav-link icon="bi-clipboard-data"
                        href="{{ route('laporan.petani')}}"
                        :active="request()->routeIs('laporan.petani')">
                        Laporan Petani
                    </x-nav-link>

                    <x-nav-link icon="bi-person-lines-fill"
                        href="{{ route('laporan.ahli-pertanian')}}"
                        :active="request()->routeIs('laporan.ahli-pertanian')">
                        Laporan Penyuluh Pertanian
                    </x-nav-link>

                    <x-nav-link icon="bi-journal-text"
                        href="{{ route('laporan.konsultasi')}}"
                        :active="request()->routeIs('laporan.konsultasi')">
                        Laporan Konsultasi
                    </x-nav-link>
                @endif

                <li class="sidebar-title">Akun</li>

                <x-nav-link icon="bi-person-circle"
                    href="{{ route('profile')}}"
                    :active="request()->routeIs('profile')">
                    Profil
                </x-nav-link>

                <x-nav-link icon="bi-box-arrow-right"
                    href="{{ route('logout')}}">
                    Keluar
                </x-nav-link>
            </ul>
        </div>
    </div>
</div>
