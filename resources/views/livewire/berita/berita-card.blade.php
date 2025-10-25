<div class="news-card h-100 d-flex flex-column shadow-sm border rounded overflow-hidden plant-themed">
    <div class="p-3 d-flex flex-column justify-content-start flex-grow-1">
        <div>
            <h5 class="fw-bold">{{ $berita->judul }}</h5>
                <p class="text-muted small">{!! $berita->excerpt !!}</p>
            </div>
            <div class="d-flex justify-content-start mt-3">
            <a href="{{ route('berita.baca-berita', ['id' => $berita->id_berita])}}?redirect={{ urlencode(url()->full())}}" class="btn btn-custom" wire:navigate>
               Baca Selengkapnya
            </a>
        </div>
    </div>
</div>
