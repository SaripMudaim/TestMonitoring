<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $judul; ?></title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #1b263b; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #415a77; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        textarea { height: 100px; resize: vertical; }
        .btn { padding: 10px 15px; background: #1b263b; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #415a77; }
        .btn-batal { background: #e63946; }
        .error { color: #e63946; background: #ffe3e3; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Portofolio UMKM Baru</h2>

        <?php if(isset($_SESSION['flash_error'])): ?>
            <div class="error"><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/admin/prosesTambah" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Usaha</label>
                <input type="text" name="nama_usaha" required placeholder="Contoh: Kue Enak Bu Sri">
            </div>
            
            <div class="form-group">
                <label>Slug URL (Unik)</label>
                <input type="text" name="slug" required placeholder="Contoh: kue-enak-bu-sri">
                <small style="color:#888;">Hanya huruf kecil, angka, dan strip (-).</small>
            </div>

            <div class="form-group">
                <label>Deskripsi Usaha</label>
                <textarea name="deskripsi" required placeholder="Ceritakan tentang usaha Anda..."></textarea>
            </div>

            <div class="form-group">
                <label>Logo Usaha (Opsional)</label>
                <input type="file" name="logo" accept="image/*">
            </div>

            <button type="submit" class="btn">Simpan sebagai Draft</button>
            <a href="<?= BASEURL; ?>/admin" class="btn btn-batal">Batal</a>
        </form>
    </div>
</body>
</html>