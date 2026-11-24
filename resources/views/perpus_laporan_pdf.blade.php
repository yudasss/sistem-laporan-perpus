<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resmi Inventaris E-Perpustakaan</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #222; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 18px; }
        .kop-surat h2 { margin: 0; font-size: 17px; text-transform: uppercase; }
        .kop-surat h4 { margin: 4px 0; font-size: 13px; font-weight: normal; }
        .kop-surat p { margin: 2px 0; font-size: 10px; color: #555; }
        .meta-info { width: 100%; margin-bottom: 14px; }
        .meta-info td { padding: 3px 0; border: none; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .data-table th, .data-table td { border: 1px solid #333; padding: 7px; text-align: left; }
        .data-table th { background-color: #1e293b; color: #ffffff; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row { background-color: #f1f5f9; font-weight: bold; }
        .ttd-table { width: 100%; margin-top: 35px; }
        .ttd-table td { border: none; text-align: center; width: 50%; vertical-align: top; }
        .ruang-ttd { height: 60px; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>UPT Perpustakaan Pusat Universitas Pamulang</h2>
        <h4>Laporan Rekapitulasi Inventaris & Nilai Aset Koleksi Buku</h4>
        <p>Jl. Raya Puspitek, Buaran, Kec. Pamulang, Kota Tangerang Selatan | Email: perpustakaan@unpam.ac.id</p>
    </div>

    <table class="meta-info">
        <tr>
            <td style="width: 18%;"><b>Filter Kategori</b></td>
            <td style="width: 32%;">: {{ $kategori_aktif }}</td>
            <td style="width: 18%;"><b>Tanggal Cetak</b></td>
            <td style="width: 32%;">: {{ $tanggal_cetak }}</td>
        </tr>
        <tr>
            <td><b>Total Judul</b></td>
            <td>: {{ $rekap['total_judul'] }} Judul Buku</td>
            <td><b>Jenis Dokumen</b></td>
            <td>: Laporan Audit Inventaris Resmi</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Kode</th>
                <th style="width: 31%;">Judul Buku</th>
                <th style="width: 16%;">Penulis</th>
                <th style="width: 13%;">Kategori</th>
                <th style="width: 7%;">Stok</th>
                <th style="width: 9%;">Harga (Rp)</th>
                <th style="width: 9%;">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftar_buku as $buku)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $buku['kode_buku'] }}</td>
                <td>{{ $buku['judul_buku'] }}</td>
                <td>{{ $buku['penulis'] }}</td>
                <td class="text-center">{{ $buku['kategori'] }}</td>
                <td class="text-center">{{ $buku['stok'] }}</td>
                <td class="text-right">{{ number_format($buku['harga_satuan'], 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($buku['stok'] * $buku['harga_satuan'], 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL EKSEMPLAR STOK</td>
                <td class="text-center">{{ $rekap['total_stok'] }} Eks</td>
                <td colspan="2"></td>
            </tr>
            <tr class="total-row" style="background-color: #dbeafe;">
                <td colspan="7" class="text-right">TOTAL NILAI ASET KOLEKSI PERPUSTAKAAN</td>
                <td class="text-right">Rp {{ number_format($rekap['total_nilai_aset'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                <b>Kepala UPT Perpustakaan</b>
                <div class="ruang-ttd"></div>
                <u><b>( ................................. )</b></u>
            </td>
            <td>
                Tangerang Selatan, {{ $tanggal_cetak }}<br>
                <b>Koordinator Inventaris & Katalog</b>
                <div class="ruang-ttd"></div>
                <u><b>( Yuda Prima)</b></u>
            </td>
        </tr>
    </table>
</body>
</html>