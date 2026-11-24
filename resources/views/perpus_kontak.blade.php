<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontak & Layanan E-Perpustakaan</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; padding: 40px; color: #1e293b; }
        .card { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
        h2 { margin-top: 0; color: #2563eb; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; }
        p { line-height: 1.7; font-size: 15px; }
        .btn { display: inline-block; margin-top: 15px; padding: 9px 16px; background: #1e293b; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Informasi & Kontak UPT Perpustakaan</h2>
        <p><b>Alamat:</b> Jl. Raya Puspitek, Buaran, Kec. Pamulang, Kota Tangerang Selatan</p>
        <p><b>Jam Operasional:</b> Senin – Sabtu, Pukul 08.00 – 20.00 WIB</p>
        <p><b>Email Layanan:</b> perpustakaan@unpam.ac.id</p>
        <p><b>Telepon / WhatsApp:</b> (021) 7412566</p>
        <a href="{{ url('/perpus-laporan') }}" class="btn">&laquo; Kembali ke Laporan Inventaris</a>
    </div>
</body>
</html>