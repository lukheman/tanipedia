<div class="container my-5">
    <h2 class="text-center section-title">Menu Utama</h2>
    <div class="row g-4 justify-content-center">

        <!-- Card Konsultasi -->
        <div class="col-md-4">
            <div class="card consultation-card h-100">
                <!-- <img src="https://source.unsplash.com/400x200/?consultation,farmer" class="card-img-top" alt="Konsultasi"> -->
                <div class="card-body text-center">
                    <h5 class="card-title">Konsultasi</h5>
                    <p class="card-text">Konsultasikan masalah pertanianmu dengan penyuluh secara langsung.</p>
                    @auth
                        <a href="{{ route('konsultasi') }}" class="btn btn-custom">Mulai Konsultasi</a>
                    @else
                        <a href="{{ route('login')}}?redirect={{ urlencode(route('konsultasi'))}}" class="btn btn-custom">Login untuk Konsultasi</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Card Berita -->
        <div class="col-md-4">
            <div class="card news-card h-100">
                <!-- <img src="https://source.unsplash.com/400x200/?news,agriculture" class="card-img-top" alt="Berita Pertanian"> -->
                <div class="card-body text-center">
                    <h5 class="card-title">Berita Pertanian</h5>
                    <p class="card-text">Dapatkan berita terbaru seputar dunia pertanian.</p>
                    <a wire:navigate href="{{ route('berita.index') }}" class="btn btn-custom">Lihat Berita</a>
                </div>
            </div>
        </div>

        <!-- Card Video -->
        <div class="col-md-4">
            <div class="card video-card h-100">
                <!-- <img src="https://source.unsplash.com/400x200/?video,education,farmer" class="card-img-top" alt="Video Edukasi"> -->
                <div class="card-body text-center">
                    <h5 class="card-title">Video Edukasi</h5>
                    <p class="card-text">Tonton video edukasi untuk meningkatkan pengetahuanmu.</p>
                    <a wire:navigate href="{{ route('video.index') }}" class="btn btn-custom">Lihat Video</a>
                </div>
            </div>
        </div>
    </div>
</div>
