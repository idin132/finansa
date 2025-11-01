<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::where('user_id', Auth::id());

        // --- 1. Ambil Semua Filter dari Request ---
        $filterJenis = $request->get('jenis');
        $filterKategori = $request->get('kategori');
        $startDate = $request->get('start_date'); // Filter Tanggal Mulai
        $endDate = $request->get('end_date');     // Filter Tanggal Akhir

        // --- 2. Terapkan Filter Jenis & Kategori (Kode lama) ---
        if ($filterJenis) {
            $query->filterJenis($filterJenis);
        }
        if ($filterKategori) {
            $query->filterKategori($filterKategori);
        }

        // --- 3. Terapkan Filter Tanggal (Baru) ---
        if ($startDate && $endDate) {
            $query->filterTanggal($startDate, $endDate);
        }

        // Tambahkan pengurutan default agar data lebih rapi
        $query->orderBy('tanggal', 'desc');

        $transaksi = $query->get();

        return view('transaksi', [
            'transaksi' => $transaksi,
            'selectedJenis' => $filterJenis,
            'selectedKategori' => $filterKategori,
            'selectedStartDate' => $startDate,
            'selectedEndDate' => $endDate,
            'jenisOptions' => ['pemasukan', 'pengeluaran'],
            'kategoriOptions' => ['cash', 'transfer', 'qris'],
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string',
            'kategori' => 'required|string',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Tambahkan user_id otomatis dari user yang login
        $validated['user_id'] = Auth::id();

        // Simpan data ke tabel transaksi
        Transaksi::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required',
            'kategori' => 'required',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::where('user_id', Auth::id());

        $filterJenis = $request->get('jenis');
        $filterKategori = $request->get('kategori');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($filterJenis) {
            $query->filterJenis($filterJenis);
        }

        if ($filterKategori) {
            $query->filterKategori($filterKategori);
        }

        if ($startDate && $endDate) {
            $query->filterTanggal($startDate, $endDate);
        }

        $query->orderBy('tanggal', 'asc');

        $transaksis = $query->get();

        $judul = 'Laporan Transaksi ';
        if ($startDate && $endDate) {
            $judul .= 'Periode ' . \Carbon\Carbon::parse($startDate)->format('d/m/Y') .
                ' s/d ' . \Carbon\Carbon::parse($endDate)->format('d/m/Y');
        } else {
            $judul .= 'Keseluruhan';
        }

        $pdf = Pdf::loadView('LaporanPDF', compact('transaksis', 'judul', 'startDate', 'endDate'));

        return $pdf->stream('laporan_transaksi.pdf');
        // Atau untuk download langsung: return $pdf->download('laporan_transaksi.pdf');
    }
}
