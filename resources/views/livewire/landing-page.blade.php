<div>
    <!-- Header -->
    <div class="header-section">
        <div class="container">
            <h1>Selamat Datang di Tani Pedia</h1>
            <p>Informasi dan Edukasi untuk Petani Modern</p>
        </div>
    </div>

    <!-- Berita Section -->
    <section id="berita" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Berita Terkini</h2>
            <div class="row">

                @forelse ($berita as $item)
                    <div class="col-md-4 mb-4">
                        <div class="news-card h-100 d-flex flex-column shadow-sm border rounded overflow-hidden plant-themed">
                            <div class="p-3 d-flex flex-column justify-content-start flex-grow-1">
                                <div>
                                    <h5 class="fw-bold">{{ $item->judul }}</h5>
                                    <p class="text-muted small">{!! $item->excerpt !!}</p>
                                </div>
                                <div class="d-flex justify-content-start mt-3">
                                    <a href="{{ route('baca-berita', ['id' => $item->id])}}" class="btn btn-custom" wire:navigate>
                                        🌿 Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada berita yang tersedia saat ini.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <!-- Video Edukasi Section -->
    <section id="video" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Video Edukasi</h2>
            <div class="row">

                @forelse ($videos as $item)
                    <div class="col-md-4 mb-4">
                        <div class="video-card">
                            <iframe width="100%" height="200" src="{{ asset('storage/' . $item->url_video) }}" frameborder="0" allowfullscreen></iframe>
                            <div class="p-3">
                                <h5>{{ $item->judul }}</h5>
                                <p>{{ $item->label_deskripsi}}</p>
                                <a href="{{ route('nonton-video', ['id' => $item->id])}}" class="btn btn-custom" wire:navigate>Tonton Sekarang</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada video edukasi yang tersedia saat ini.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>
</div>
