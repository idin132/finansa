@extends('layouts.sidebar')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Pembayaran Hutang</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('hutang.index') }}" class="btn btn-secondary"> Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">Ringkasan</div>
                        <div class="card-body">
                            <h5>{{ $item->judul_hutang }}</h5>
                            <hr>
                            <p>Total Hutang: <br><strong>Rp {{ number_format($item->nilai_pokok) }}</strong></p>
                            <p>Sisa Hutang: <br><strong class="text-danger h4">Rp
                                    {{ number_format($item->sisa_hutang) }}</strong></p>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header bg-success text-white">Input Pembayaran</div>
                        <div class="card-body">
                            <form action="{{ route('hutang.bayar', $item->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label>Tanggal Bayar</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label>Nominal Pembayaran</label>
                                    <input type="number" name="nominal" class="form-control"
                                        max="{{ $item->sisa_hutang }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        placeholder="Contoh: Cicilan ke-1">
                                </div>
                                <button type="submit" class="btn btn-success w-100">Simpan Pembayaran</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Riwayat Cicilan</div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->pembayarans as $p)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                                            <td>Rp {{ number_format($p->nominal) }}</td>
                                            <td>{{ $p->keterangan }}</td>
                                            <td>
                                                <button class="btn btn-xs btn-outline-warning btn-edit-bayar"
                                                    data-id="{{ $p->id }}" data-tgl="{{ $p->tanggal }}"
                                                    data-nom="{{ $p->nominal }}" data-ket="{{ $p->keterangan }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('hutang.bayar.destroy', $p->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-outline-danger"><i
                                                            class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada pembayaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modalEditBayar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditBayar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Riwayat Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" id="edit_tgl_bayar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nominal</label>
                        <input type="number" name="nominal" id="edit_nom_bayar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" id="edit_ket_bayar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.querySelectorAll('.btn-edit-bayar').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const form = document.getElementById('formEditBayar');

                form.action = `/hutang/bayar/${id}`;

                document.getElementById('edit_tgl_bayar').value = this.dataset.tgl;
                document.getElementById('edit_nom_bayar').value = this.dataset.nom;
                document.getElementById('edit_ket_bayar').value = this.dataset.ket;

                new bootstrap.Modal(document.getElementById('modalEditBayar')).show();
            });
        });
    </script>
@endpush
@endsection