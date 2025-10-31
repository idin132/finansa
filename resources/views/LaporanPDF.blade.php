<!DOCTYPE html>
<html>
<head>
    <title>{{ $judul }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        h1 { text-align: center; margin-bottom: 5px; font-size: 18pt; }
        p.subheader { text-align: center; margin-bottom: 20px; font-size: 11pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; }
        .text-right { text-align: right; }
        .total-row td { background-color: #d9edf7; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Laporan Transaksi Keuangan</h1>
    <p class="subheader">{{ $judul }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th class="text-right">Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPemasukan = 0;
                $totalPengeluaran = 0;
            @endphp

            @forelse ($transaksis as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                
                @php
                    if ($item->jenis == 'pemasukan') {
                        $totalPemasukan += $item->nominal;
                    } else {
                        $totalPengeluaran += $item->nominal;
                    }
                @endphp

            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data transaksi yang ditemukan.</td>
                </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Pemasukan</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Pengeluaran</td>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Saldo Akhir</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i:s') }}
    </div>

</body>
</html>