

@push('styles')
<style>
        .berita-content img {
            max-width: 100%; /* Agar responsif */
            width: 300px; /* Atur lebar tetap, misalnya 300px */
            height: auto; /* Jaga rasio aspek */
        }
    </style>

@endpush
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <!-- <img src="{{ asset($berita->image) }}" class="card-img-top" alt="{{ $berita->title }}" style="width: 100%; height: 400px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;"> -->
                <div class="card-body p-4">
                    <h1 class="section-title mb-3">{{ $berita->judul }}</h1>
                    <div class="text-muted mb-3">
                        <small>Diunggah pada {{ $berita->created_at->format('d M Y') }} oleh {{ $berita->penulis->name }}</small>
                    </div>
                    <div class="berita-content">
                        {!! $berita->isi !!}
                    </div>
                    <a href="{{ $redirect }}" class="btn btn-custom mt-4" wire:navigate>Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
