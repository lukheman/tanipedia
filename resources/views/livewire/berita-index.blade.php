<div class="container py-5">
    <h2 class="section-title text-center">Berita Terkini</h2>
    <div class="row">
        @forelse ($berita as $item)
            <div class="col-12 mt-3">
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
                <p class="text-muted">Belum ada berita tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
