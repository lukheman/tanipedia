<div>
    <!-- Hero Section -->
    <div class="header-section d-flex align-items-center justify-content-center text-center"
         style="background-image: url('{{ asset('img/hero.jpg')}}'); 
                background-size: cover; 
                background-position: center; 
                height: 100vh; 
                position: relative;">

        <!-- Overlay -->
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5);"></div>

        <div class="container position-relative text-white">
            <h1 class="display-4 fw-bold">Selamat Datang di Tani Pedia</h1>
            <p class="lead">Informasi dan Edukasi untuk Petani Modern</p>
        </div>
    </div>

    <!-- Berita Section -->
    <section id="berita" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Berita Terkini</h2>
            <div class="row">
                @forelse ($berita as $item)
                    <div class="col-md-4 mb-4">
                        <livewire:berita.berita-card :berita="$item" :wire:key="$item->id_berita" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada berita yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('berita.index') }}" class="btn btn-custom" wire:navigate>Lihat Semua Berita</a>
            </div>
        </div>
    </section>

    <!-- Video Edukasi Section -->
    <section id="video" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Video Edukasi</h2>
            <div class="row">
                @forelse ($videos as $video)
                    <div class="col-md-4 mb-4">
                        <livewire:video-card :video="$video" :wire:key="$video->id_video" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada video edukasi yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('video.index') }}" class="btn btn-custom" wire:navigate>Lihat Semua Video</a>
            </div>
        </div>
    </section>
</div>
