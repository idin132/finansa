<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\HutangBayar;
use Illuminate\Http\Request;
use Auth;

class HutangController extends Controller
{
    public function index()
    {
        // Mengambil data hutang beserta riwayat pembayarans untuk ditampilkan di modal
        $hutang = Hutang::with('pembayarans')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('hutang.index', compact('hutang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_hutang' => 'required',
            'nilai_pokok' => 'required|numeric',
            'tanggal_pinjam' => 'required|date',
        ]);

        Hutang::create([
            'judul_hutang' => $request->judul_hutang,
            'pihak_pemberi' => $request->pihak_pemberi,
            'nilai_pokok' => $request->nilai_pokok,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_tempo' => $request->tanggal_tempo,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Data hutang berhasil ditambahkan');
    }

    public function show($id)
    {
        $item = Hutang::with('pembayarans')->findOrFail($id);
        return view('hutang.show', compact('item'));
    }

    public function storeBayar(Request $request, $id)
    {
        HutangBayar::create([
            'id_hutang' => $id,
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat');
    }

    public function update(Request $request, $id)
    {
        $hutang = Hutang::findOrFail($id);
        $hutang->update($request->all());
        return redirect()->back()->with('success', 'Data hutang berhasil diperbarui');
    }

    public function destroy($id)
    {
        Hutang::findOrFail($id)->delete();
        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil dihapus');
    }

    // --- CRUD PEMBAYARAN (Hutang_Bayar) ---
    public function updateBayar(Request $request, $id)
    {
        $bayar = HutangBayar::findOrFail($id);
        $bayar->update($request->all());
        return redirect()->back()->with('success', 'Riwayat pembayaran diperbarui');
    }

    public function destroyBayar($id)
    {
        HutangBayar::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Riwayat pembayaran dihapus');
    }
}