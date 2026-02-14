@extends('layouts.sidebar')

@section('content')
<div class="content-wrapper">
    <main class="app-main">

        <div class="container-fluid mt-3">

            <div class="d-flex justify-content-between mb-3">
                <h3>Daftar Hutang</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahHutang">
                    + Tambah Hutang
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="tableHutang">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pemberi</th>
                                <th>Total</th>
                                <th>Sisa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($hutang as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->judul_hutang }}</td>
                                    <td>{{ $item->pihak_pemberi }}</td>
                                    <td>Rp {{ number_format($item->nilai_pokok) }}</td>
                                    <td class="text-danger">Rp {{ number_format($item->sisa_hutang) }}</td>

                                    <td class="d-flex gap-1">

                                        <button class="btn btn-info btn-sm btn-detail" data-id="{{ $item->id }}">
                                            Bayar
                                        </button>

                                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $item->id }}"
                                            data-judul="{{ $item->judul_hutang }}" data-pemberi="{{ $item->pihak_pemberi }}"
                                            data-pokok="{{ $item->nilai_pokok }}" data-pinjam="{{ $item->tanggal_pinjam }}"
                                            data-tempo="{{ $item->tanggal_tempo }}" data-ket="{{ $item->keterangan }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('hutang.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>

                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahHutang">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('hutang.store') }}">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Hutang</h5>
                </div>
                <div class="modal-body">

                    <input name="judul_hutang" class="form-control mb-2" placeholder="Judul">
                    <input name="pihak_pemberi" class="form-control mb-2" placeholder="Pemberi">
                    <input name="nilai_pokok" type="number" class="form-control mb-2">
                    <input name="tanggal_pinjam" type="date" class="form-control mb-2">
                    <input name="tanggal_tempo" type="date" class="form-control mb-2">
                    <textarea name="keterangan" class="form-control"></textarea>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf @method('PUT')

                <div class="modal-body">

                    <input id="edit_judul" name="judul_hutang" class="form-control mb-2">
                    <input id="edit_pemberi" name="pihak_pemberi" class="form-control mb-2">
                    <input id="edit_pokok" name="nilai_pokok" class="form-control mb-2">
                    <input id="edit_pinjam" name="tanggal_pinjam" type="date" class="form-control mb-2">
                    <input id="edit_tempo" name="tanggal_tempo" type="date" class="form-control mb-2">
                    <textarea id="edit_ket" name="keterangan" class="form-control"></textarea>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- MODAL DETAIL + BAYAR --}}
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Detail Hutang</h5>
            </div>

            <div class="modal-body" id="detailBody">
            </div>

        </div>
    </div>
</div>

@endsection


@push('scripts')
    <script>

        let allHutang = @json($hutang);

        document.querySelectorAll('.btn-detail').forEach(btn => {
            btn.addEventListener('click', function () {

                let id = this.dataset.id;
                let data = allHutang.find(x => x.id == id);

                let html = `
                    <div class="row">

                    <div class="col-md-4">
                    <h4>${data.judul_hutang}</h4>
                    <p>Total: Rp ${Number(data.nilai_pokok).toLocaleString()}</p>
                    <p>Sisa: Rp ${Number(data.sisa_hutang).toLocaleString()}</p>

                    <form method="POST" action="/hutang/${id}/bayar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="date" name="tanggal" class="form-control mb-2" required>
                    <input type="number" name="nominal" class="form-control mb-2" placeholder="Nominal Pembayaran" required>
                    <input name="keterangan" class="form-control mb-2" placeholder="Keterangan">
                    <button class="btn btn-success w-100">Bayar</button>
                    </form>

                    </div>

                    <div class="col-md-8">
                    <table class="table">
                    <tr><th>Tanggal</th><th>Nominal</th><th>Aksi</th></tr>
                    `;

                data.pembayarans.forEach(p => {
                    html += `
                    <tr>
                    <td>${p.tanggal}</td>
                    <td>${Number(p.nominal).toLocaleString()}</td>
                    <td>

                    <button class="btn btn-warning btn-sm"
                    onclick="editBayar(${p.id},'${p.tanggal}',${p.nominal},'${p.keterangan ?? ''}')">
                    Edit
                    </button>

                    <form method="POST" action="/hutang/bayar/${p.id}" style="display:inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>

                    </td>
                    </tr>
                    `;
                });

                html += `</table></div></div>`;

                document.getElementById('detailBody').innerHTML = html;

                new bootstrap.Modal(document.getElementById('modalDetail')).show();

            });
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {

                let id = this.dataset.id;
                document.getElementById('formEdit').action = "/hutang/" + id;

                edit_judul.value = this.dataset.judul;
                edit_pemberi.value = this.dataset.pemberi;
                edit_pokok.value = this.dataset.pokok;
                edit_pinjam.value = this.dataset.pinjam;
                edit_tempo.value = this.dataset.tempo;
                edit_ket.value = this.dataset.ket;

                new bootstrap.Modal(document.getElementById('modalEdit')).show();

            });
        });

        function editBayar(id, tgl, nom, ket) {
            let html = `
                    <form method="POST" action="/hutang/bayar/${id}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">

                    <input type="date" name="tanggal" value="${tgl}" class="form-control mb-2">
                    <input type="number" name="nominal" value="${nom}" class="form-control mb-2">
                    <input name="keterangan" value="${ket}" class="form-control mb-2">

                    <button class="btn btn-primary w-100">Update</button>
                    </form>
                    `;

            document.getElementById('detailBody').innerHTML = html;
        }

    </script>
@endpush