@extends('layouts.sidebar')

@section('content')
<link href="DataTables/datatables.min.css" rel="stylesheet">
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">Daftar Transaksi</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <!-- Tombol buka modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle"></i> Tambah Transaksi
                    </button>
                    <a href="{{ route('transaksi.exportPdf', Request::query()) }}" target="_blank"
                        class="btn btn-danger me-2">
                        <i class="bi bi-file-pdf"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Alert success -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Transaksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.index') }}" method="GET" class="mb-4">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-2">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="">-- Semua --</option>
                                    @foreach ($jenisOptions as $jenis)
                                        <option value="{{ $jenis }}" {{ (isset($selectedJenis) && $selectedJenis == $jenis) ? 'selected' : '' }}>
                                            {{ ucfirst($jenis) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select name="kategori" id="kategori" class="form-select">
                                    <option value="">-- Semua --</option>
                                    @foreach ($kategoriOptions as $kategori)
                                        <option value="{{ $kategori }}" {{ (isset($selectedKategori) && $selectedKategori == $kategori) ? 'selected' : '' }}>
                                            {{ ucfirst($kategori) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ $selectedStartDate ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ $selectedEndDate ?? '' }}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info text-white me-2">Terapkan</button>
                                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    <table id="transaksi" class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                                <th width="155">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($transaksi->isEmpty())
                            @else
                                @foreach ($transaksi as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ ucfirst($item->jenis) }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-warning btn-edit"
                                                    data-id="{{ $item->id_transaksi }}" data-tanggal="{{ $item->tanggal }}"
                                                    data-jenis="{{ $item->jenis }}" data-kategori="{{ $item->kategori }}"
                                                    data-nominal="{{ $item->nominal }}"
                                                    data-keterangan="{{ $item->keterangan }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <form action="{{ route('transaksi.destroy', $item->id_transaksi) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ================= Modal Tambah Data ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"></label>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis</label>
                            <select name="jenis" class="form-select" required>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="qris">Qris</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nominal</label>
                            <input type="number" name="nominal" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ================= End Modal ================= -->

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="editJenis" class="form-label">Jenis</label>
                        <select class="form-select" id="editJenis" name="jenis" required>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editKategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="editKategori" name="kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="editNominal" name="nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKeterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="editKeterangan" name="keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        const formEdit = document.getElementById('formEdit');

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;

                formEdit.action = `/transaksi/${id}`;

                document.getElementById('editTanggal').value = this.dataset.tanggal;
                document.getElementById('editJenis').value = this.dataset.jenis;
                document.getElementById('editKategori').value = this.dataset.kategori;
                document.getElementById('editNominal').value = this.dataset.nominal;
                document.getElementById('editKeterangan').value = this.dataset.keterangan;

                modalEdit.show();
            });
        });
    });
</script>
<script src="DataTables/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#transaksi').DataTable({
        });
    });
</script>

@endsection