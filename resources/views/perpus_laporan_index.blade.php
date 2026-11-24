<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris Koleksi E-Perpustakaan</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; padding: 30px; color: #1e293b; }
        .container { max-width: 1040px; margin: auto; background: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
        h2 { margin-top: 0; color: #0f172a; border-bottom: 3px solid #2563eb; padding-bottom: 12px; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; }
        select { padding: 8px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 14px; }
        .btn { padding: 8px 14px; border-radius: 6px; text-decoration: none; color: white; font-size: 13px; font-weight: bold; border: none; cursor: pointer; display: inline-block; }
        .btn-filter { background: #334155; }
        .btn-preview { background: #d97706; }
        .btn-pdf { background: #dc2626; }
        .btn-excel { background: #059669; }
        .btn-print { background: #2563eb; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 11px 12px; border: 1px solid #cbd5e1; text-align: left; }
        th { background: #1e293b; color: white; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge-kat { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .summary-box { margin-top: 20px; padding: 16px; background: #eff6ff; border-left: 5px solid #2563eb; border-radius: 6px; line-height: 1.8; font-size: 15px; }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
            .container { box-shadow: none; max-width: 100%; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Inventaris & Aset Koleksi E-Perpustakaan (Kategori: {{ $kategori_aktif }})</h2>

        <div class="toolbar no-print">
            <form method="GET" action="{{ url('/perpus-laporan') }}">
                <label><b>Filter Kategori Buku:</b></label>
                <select name="kategori">
                    <option value="Semua" {{ $kategori_aktif == 'Semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="Pemrograman" {{ $kategori_aktif == 'Pemrograman' ? 'selected' : '' }}>Pemrograman</option>
                    <option value="Kecerdasan Buatan" {{ $kategori_aktif == 'Kecerdasan Buatan' ? 'selected' : '' }}>Kecerdasan Buatan</option>
                    <option value="Jaringan & Keamanan" {{ $kategori_aktif == 'Jaringan & Keamanan' ? 'selected' : '' }}>Jaringan & Keamanan</option>
                </select>
                <button type="submit" class="btn btn-filter">Terapkan Filter</button>
            </form>

            <div>
                <a href="{{ url('/perpus-laporan/pdf?kategori=' . urlencode($kategori_aktif) . '&mode=stream') }}" target="_blank" class="btn btn-preview">Preview PDF</a>
                <a href="{{ url('/perpus-laporan/pdf?kategori=' . urlencode($kategori_aktif) . '&mode=download') }}" class="btn btn-pdf">Download PDF</a>
                <a href="{{ url('/perpus-laporan/excel?kategori=' . urlencode($kategori_aktif)) }}" class="btn btn-excel">Export Excel (CSV)</a>
                <button onclick="window.print()" class="btn btn-print">Cetak Langsung</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th class="text-center">Stok</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal Nilai Aset</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftar_buku as $buku)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><b>{{ $buku['kode_buku'] }}</b></td>
                    <td>{{ $buku['judul_buku'] }}</td>
                    <td>{{ $buku['penulis'] }}</td>
                    <td><span class="badge-kat">{{ $buku['kategori'] }}</span></td>
                    <td class="text-center">{{ $buku['stok'] }} Eks</td>
                    <td class="text-right">Rp {{ number_format($buku['harga_satuan'], 0, ',', '.') }}</td>
                    <td class="text-right"><b>Rp {{ number_format($buku['stok'] * $buku['harga_satuan'], 0, ',', '.') }}</b></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-box">
            <b>Total Judul Terdata:</b> {{ $rekap['total_judul'] }} Judul Buku <br>
            <b>Total Eksemplar Fisik:</b> {{ $rekap['total_stok'] }} Eksemplar <br>
            <b>Total Nilai Aset Koleksi:</b> <span style="font-size: 16px; color: #1d4ed8;"><b>Rp {{ number_format($rekap['total_nilai_aset'], 0, ',', '.') }}</b></span>
        </div>
    </div>
</body>
</html>