@extends('layouts.sidebar')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="bi bi-calendar"></i> Kalender Keuangan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kalender</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- Gunakan class card AdminLTE --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Catatan Pembayaran dan Jadwal</h3>
                </div>
                <div class="card-body">
                    {{-- CONTAINER KALENDER --}}
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- PUSH STYLES FullCalendar ke dalam @stack('styles') di Parent Layout --}}
@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endpush

{{-- PUSH SCRIPTS FullCalendar dan Logika ke dalam @stack('scripts') di Parent Layout --}}
@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (calendarEl) {
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    locale: 'id',
                    events: '{{ route('calendar.get') }}',
                    editable: true, // WAJIB: Untuk bisa drag and drop event

                    // 1. Tambahkan Fungsi Drag and Drop (Update Tanggal)
                    eventDrop: function (info) {
                        const newStart = info.event.startStr;
                        const newEnd = info.event.endStr;

                        if (confirm(`Anda yakin ingin memindahkan event "${info.event.title}" ke tanggal ${newStart}?`)) {
                            axios.put(`{{ url('/calendar/events') }}/${info.event.id}`, {
                                _token: token,
                                _method: 'PUT', // Penting untuk Laravel
                                start: newStart,
                                end: newEnd,
                            })
                                .then(response => {
                                    alert('Event berhasil dipindahkan dan diubah!');
                                })
                                .catch(error => {
                                    alert('Gagal memindahkan event. Silakan coba lagi.');
                                    info.revert(); // Kembalikan event ke posisi semula jika gagal
                                });
                        } else {
                            info.revert(); // Kembalikan jika user batal
                        }
                    },

                    // 2. Tambahkan Fungsi Klik Event (Hapus dan Ubah Detail)
                    eventClick: function (info) {
                        const action = prompt(`Pilih Aksi untuk event "${info.event.title}":\n\n1. Edit Judul\n2. Hapus`);

                        if (action === '2' || action.toLowerCase() === 'hapus') {
                            // HAPUS EVENT
                            if (confirm(`Yakin ingin menghapus event "${info.event.title}"?`)) {
                                axios.delete(`{{ url('/calendar/events') }}/${info.event.id}`, {
                                    data: { _token: token, _method: 'DELETE' } // Kirim token dan method DELETE
                                })
                                    .then(response => {
                                        info.event.remove(); // Hapus event dari tampilan kalender
                                        alert('Event berhasil dihapus!');
                                    })
                                    .catch(error => {
                                        alert('Gagal menghapus event.');
                                    });
                            }
                        } else if (action === '1' || action.toLowerCase() === 'edit judul') {
                            // EDIT JUDUL
                            const newTitle = prompt('Masukkan Judul baru:', info.event.title);
                            if (newTitle && newTitle !== info.event.title) {
                                axios.put(`{{ url('/calendar/events') }}/${info.event.id}`, {
                                    _token: token,
                                    _method: 'PUT',
                                    title: newTitle,
                                })
                                    .then(response => {
                                        info.event.setProp('title', newTitle); // Update tampilan event di kalender
                                        alert('Judul berhasil diubah!');
                                    })
                                    .catch(error => {
                                        alert('Gagal mengubah judul.');
                                    });
                            }
                        }
                    },

                    // ... (lanjutan dateClick function untuk menambahkan event)
                    dateClick: function (info) {
                        const title = prompt('Masukkan Judul Catatan:');
                        if (title) {
                            axios.post('{{ route('calendar.store') }}', {
                                _token: token,
                                title: title,
                                start: info.dateStr
                            })
                                .then(response => {
                                    calendar.addEvent({
                                        id: response.data.id, // Penting: Tambahkan ID agar bisa di-update/hapus
                                        title: response.data.title,
                                        start: response.data.start,
                                        allDay: true
                                    });
                                    alert('Catatan berhasil ditambahkan!');
                                })
                                .catch(error => { console.error('Error:', error); alert('Gagal menyimpan catatan.'); });
                        }
                    }
                    // ...
                });

                calendar.render();
            }
        });
    </script>
@endpush