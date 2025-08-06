                        <div class="video-card" wire:ignore>
<video width="100%" height="200" controls>
    <source src="{{ asset('storage/' . $video->url_video) }}" type="video/mp4">
    Browser Anda tidak mendukung tag video.
</video>
                            <div class="p-3">
                                <h5>{{ $video->judul }}</h5>
                                <p>{{ $video->label_deskripsi}}</p>
                                <a href="{{ route('nonton-video', ['id' => $video->id])}}" class="btn btn-custom" wire:navigate>Tonton Sekarang</a>
                            </div>
                        </div>
