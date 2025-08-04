<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h1 class="section-title mb-3">{{ $video->judul }}</h1>
                    <div class="text-muted mb-3">
                        <small>Diunggah pada {{ $video->created_at->format('d M Y') }} oleh {{ $video->author }}</small>
                    </div>
                    <div class="video-embed mb-4">
                        <iframe width="100%" height="400" src="{{ asset('storage/' . $video->url_video) }}" frameborder="0" allowfullscreen style="border-radius: 10px;"></iframe>
                    </div>
                    <div class="video-description mb-4">
                        {{ $video->deskripsi }}
                    </div>
                    <a href="{{ route('landing') }}" class="btn btn-custom mt-4">Kembali ke Video Edukasi</a>
                </div>
            </div>

            <!-- Comment Section -->
            <div class="card shadow-sm border-0 mt-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 class="section-title mb-4">Komentar</h3>

                    <!-- Comment Form -->
                    @auth
                        <form class="mb-4">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Tulis Komentar Anda</label>
                                <textarea wire:model="new_komentar" class="form-control" id="comment"  rows="4" placeholder="Masukkan komentar Anda" required></textarea>
                            </div>
                            <button wire:click="saveKomentar" type="button" class="btn btn-custom">Kirim Komentar</button>
                        </form>
@else
    <div class="alert alert-info" role="alert">
        <p class="mb-0">Silakan <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="text-decoration-none">masuk</a> untuk menulis komentar.</p>
    </div>
@endauth

                    <!-- Komentar -->
                    @if ($video->komentar->isEmpty())
                        <p class="text-muted">Belum ada komentar untuk video ini.</p>
                    @else

                        @foreach ($video->komentar as $item)
                        <div class="comment mb-3 p-3 border rounded" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $item->user->name }}</strong>
                                 <small class="text-muted">{{ $item->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <p class="mt-2 mb-0">{{ $item->isi }}</p>
                        </div>

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
