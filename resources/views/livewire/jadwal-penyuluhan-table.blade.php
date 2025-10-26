<div class="card">

    @if (auth('penyuluh')->check())

    <div class="card-header">
<div class="alert alert-light-warning color-warning">
    <i class="bi bi-exclamation-triangle"></i>
    Klik pada <strong>nama kegiatan</strong> di kalender untuk melihat detail dan menambahkan laporan hasil penyuluhan.
</div>

        <button wire:click="add" class="btn btn-primary mb-3">
            <i class="bi bi-calendar-plus"></i> Tambah Jadwal
        </button>

    </div>

    @endif

    <div class="card-body">


<!-- Modal Placeholder: Detail Jadwal Penyuluhan -->
<div class="modal fade" id="modal-show-jadwal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Detail Jadwal Penyuluhan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Tanggal</label>
                    <input type="text" class="form-control " wire:model="form.tanggal" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Deskripsi Kegiatan</label>
                    <textarea wire:model="form.kegiatan" class="form-control " rows="5" disabled></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input value="{{ ucfirst($form->status)}}" type="text" class="form-control text-{{ \App\Enums\StatusJadwal::from($form->status)->getColor() }} fw-semibold" disabled>
                </div>
            </div>

        </div>
    </div>
</div>

        <div class="modal fade" id="modal-form-jadwal-penyuluhan" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="myModalLabel1">
                            @if ($currentState === \App\Enums\State::CREATE)
                                Tambah Jadwal Penyuluhan
                            @elseif ($currentState === \App\Enums\State::UPDATE)
                                Perbarui Jadwal Penyuluhan
                            @elseif ($currentState === \App\Enums\State::SHOW)
                                Detail Jadwal Penyuluhan
                            @endif
                        </h5>
                        <button type="button" class="close rounded-pill"
                            wire:click="$dispatch('closeModal', {id: 'modal-form-jadwal-penyuluhan'})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Desa</label>
                                <select wire:model="form.id_desa" class="form-select"
                                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                    <option value="">-- Pilih Desa --</option>
                                    @foreach ($this->desaList ?? [] as $desa)
                                        <option value="{{ $desa->id_desa }}">{{ $desa->nama }}</option>
                                    @endforeach
                                </select>
                                @error('form.id_desa')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal</label>
                                <input wire:model="form.tanggal" type="date" class="form-control"
                                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                @error('form.tanggal')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kegiatan</label>
                                <textarea wire:model="form.kegiatan" class="form-control" rows="3"
                                    placeholder="Deskripsikan kegiatan..."
                                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif></textarea>
                                @error('form.kegiatan')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if ($currentState === \App\Enums\State::UPDATE)

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Laporan</label>
                                <textarea wire:model="form.laporan" class="form-control" rows="3"
                                    placeholder="Catatan hasil penyuluhan (opsional)"
                                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif></textarea>
                                @error('form.laporan')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select wire:model="form.status" class="form-select"
                                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                    @foreach (\App\Enums\StatusJadwal::cases() as $status)
                                        <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                                @error('form.status')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        @if ($currentState === \App\Enums\State::CREATE)
                            <button type="button" wire:click="save" class="btn btn-primary">Tambahkan</button>
                        @elseif ($currentState === \App\Enums\State::UPDATE)
                            <button type="button" wire:click="save" class="btn btn-primary">Perbarui</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Kalender --}}
        <div wire:ignore>

        <div id="calendar"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: @json($this->getCalendarEvents()),
            eventClick: function (info) {
                Livewire.dispatch('openDetailJadwal', { id: info.event.id });
            }
        });
        calendar.render();
    }

    Livewire.on('refreshCalendar', (events) => {
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                events: events,
                eventClick: function (info) {
                    Livewire.dispatch('openDetailJadwal', { id: info.event.id });
                }
            });
            calendar.render();
        }
    });
});
</script>
@endpush
