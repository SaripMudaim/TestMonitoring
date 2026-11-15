<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; text-align: center; }
        .container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { font-size: 80px; margin: 0; color: #e63946; }
        p { color: #415a77; font-size: 18px; }
        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #1b263b; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, website UMKM yang Anda cari tidak ada, belum dipublikasikan, atau sudah dihapus.</p>
        <a href="<?= BASEURL; ?>">Kembali ke Beranda</a>
    </div>
</body>
</html>