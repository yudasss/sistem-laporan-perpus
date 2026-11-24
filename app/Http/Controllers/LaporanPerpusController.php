<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPerpusController extends Controller
{
    private function ambilKoleksiBuku($kategori = 'Semua')
    {
        $semua_buku = [
            [
                'kode_buku'   => 'BK-101',
                'judul_buku'  => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'penulis'     => 'Robert C. Martin',
                'kategori'    => 'Pemrograman',
                'stok'        => 12,
                'harga_satuan'=> 350000
            ],
            [
                'kode_buku'   => 'BK-102',
                'judul_buku'  => 'Laravel: Up & Running (Modern PHP Framework)',
                'penulis'     => 'Matt Stauffer',
                'kategori'    => 'Pemrograman',
                'stok'        => 8,
                'harga_satuan'=> 420000
            ],
            [
                'kode_buku'   => 'BK-103',
                'judul_buku'  => 'Artificial Intelligence: A Modern Approach',
                'penulis'     => 'Stuart Russell & Peter Norvig',
                'kategori'    => 'Kecerdasan Buatan',
                'stok'        => 5,
                'harga_satuan'=> 550000
            ],
            [
                'kode_buku'   => 'BK-104',
                'judul_buku'  => 'Deep Learning with Python',
                'penulis'     => 'Francois Chollet',
                'kategori'    => 'Kecerdasan Buatan',
                'stok'        => 7,
                'harga_satuan'=> 480000
            ],
            [
                'kode_buku'   => 'BK-105',
                'judul_buku'  => 'Computer Networking: A Top-Down Approach',
                'penulis'     => 'James F. Kurose',
                'kategori'    => 'Jaringan & Keamanan',
                'stok'        => 10,
                'harga_satuan'=> 390000
            ],
            [
                'kode_buku'   => 'BK-106',
                'judul_buku'  => 'The Web Application Hackers Handbook',
                'penulis'     => 'Dafydd Stuttard',
                'kategori'    => 'Jaringan & Keamanan',
                'stok'        => 4,
                'harga_satuan'=> 460000
            ]
        ];

        if ($kategori !== 'Semua') {
            return array_values(array_filter($semua_buku, function ($buku) use ($kategori) {
                return $buku['kategori'] === $kategori;
            }));
        }

        return $semua_buku;
    }

    private function hitungRekapAset($daftar_buku)
    {
        $total_stok = 0;
        $total_nilai_aset = 0;

        foreach ($daftar_buku as $buku) {
            $subtotal = $buku['stok'] * $buku['harga_satuan'];
            $total_stok += $buku['stok'];
            $total_nilai_aset += $subtotal;
        }

        return [
            'total_judul'      => count($daftar_buku),
            'total_stok'       => $total_stok,
            'total_nilai_aset' => $total_nilai_aset
        ];
    }

    // 1. Halaman Utama Laporan Web (/perpus-laporan)
    public function index(Request $request)
    {
        $kategori = $request->query('kategori', 'Semua');
        $daftar_buku = $this->ambilKoleksiBuku($kategori);
        $rekap = $this->hitungRekapAset($daftar_buku);

        return view('perpus_laporan_index', [
            'daftar_buku'    => $daftar_buku,
            'kategori_aktif' => $kategori,
            'rekap'          => $rekap
        ]);
    }

    // 2. Export PDF DomPDF (/perpus-laporan/pdf)
    public function exportPdf(Request $request)
    {
        $kategori = $request->query('kategori', 'Semua');
        $mode = $request->query('mode', 'download');
        $daftar_buku = $this->ambilKoleksiBuku($kategori);
        $rekap = $this->hitungRekapAset($daftar_buku);

        $pdf = Pdf::loadView('perpus_laporan_pdf', [
            'daftar_buku'    => $daftar_buku,
            'kategori_aktif' => $kategori,
            'rekap'          => $rekap,
            'tanggal_cetak'  => date('d F Y')
        ])->setPaper('a4', 'landscape');

        $slug_kategori = str_replace([' ', '&'], ['-', 'dan'], $kategori);
        $nama_file = 'Laporan-Inventaris-Perpus-' . $slug_kategori . '-' . date('Ymd') . '.pdf';

        if ($mode === 'stream') {
            return $pdf->stream($nama_file);
        }

        return $pdf->download($nama_file);
    }

    // 3. Export Excel / CSV UTF-8 BOM (/perpus-laporan/excel)
    public function exportExcel(Request $request)
    {
        $kategori = $request->query('kategori', 'Semua');
        $daftar_buku = $this->ambilKoleksiBuku($kategori);
        $rekap = $this->hitungRekapAset($daftar_buku);

        $slug_kategori = str_replace([' ', '&'], ['-', 'dan'], $kategori);
        $nama_file = 'Laporan-Inventaris-Perpus-' . $slug_kategori . '-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$nama_file\"",
        ];

        return response()->streamDownload(function () use ($daftar_buku, $rekap) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM agar Excel Indonesia membaca kolom dengan rapi
            fwrite($handle, "\xEF\xBB\xBF");

            // Header Kolom
            fputcsv($handle, [
                'No',
                'Kode Buku',
                'Judul Buku',
                'Penulis',
                'Kategori',
                'Stok (Eks)',
                'Harga Satuan (Rp)',
                'Subtotal Nilai Aset (Rp)'
            ], ';');

            // Isi Baris Data
            $no = 1;
            foreach ($daftar_buku as $buku) {
                $subtotal = $buku['stok'] * $buku['harga_satuan'];
                fputcsv($handle, [
                    $no++,
                    $buku['kode_buku'],
                    $buku['judul_buku'],
                    $buku['penulis'],
                    $buku['kategori'],
                    $buku['stok'],
                    $buku['harga_satuan'],
                    $subtotal
                ], ';');
            }

            // Rekapitulasi Total
            fputcsv($handle, [], ';');
            fputcsv($handle, ['', '', '', '', 'TOTAL JUDUL BUKU', $rekap['total_judul'] . ' Judul', '', ''], ';');
            fputcsv($handle, ['', '', '', '', 'TOTAL EKSEMPLAR STOK', $rekap['total_stok'] . ' Eks', '', ''], ';');
            fputcsv($handle, ['', '', '', '', 'TOTAL NILAI ASET KOLEKSI', '', '', $rekap['total_nilai_aset']], ';');

            fclose($handle);
        }, $nama_file, $headers);
    }
}