<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();

        $total_pemasukan = Transaksi::where('user_id', $user_id)->where('jenis', 'pemasukan')->sum('nominal');
        $total_pengeluaran = Transaksi::where('user_id', $user_id)->where('jenis', 'pengeluaran')->sum('nominal');
        $total_pengeluaran_hari_ini = Transaksi::where('user_id', $user_id)->where('jenis', 'pengeluaran')->whereDate('tanggal', now()->toDateString())->sum('nominal');
        $total_pemasukan_hari_ini = Transaksi::where('user_id', $user_id)->where('jenis', 'pemasukan')->whereDate('tanggal', now()->toDateString())->sum('nominal');
        $uang_tersisa = $total_pemasukan - $total_pengeluaran;
        return view('dashboard', compact('total_pemasukan', 'total_pengeluaran', 'total_pengeluaran_hari_ini', 'total_pemasukan_hari_ini', 'uang_tersisa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
