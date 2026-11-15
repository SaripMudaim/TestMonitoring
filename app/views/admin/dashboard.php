<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $judul; ?></title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #1b263b; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-publish { background: #d4edda; color: #155724; }
        .badge-draft { background: #fff3cd; color: #856404; }
        .btn { padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 13px; color: white; display: inline-block; }
        .btn-publish { background: #28a745; }
        .btn-unpublish { background: #ffc107; color: #212529; }
        .btn-view { background: #17a2b8; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Dashboard Admin</h1>
            <a href="<?= BASEURL; ?>/auth/logout" style="color: red; text-decoration: none;">Logout (<?= $username; ?>)</a>
        </div>
        
        <hr>

        <?php if(isset($_SESSION['flash_success'])): ?>
            <div class="alert-success"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>

        <a href="<?= BASEURL; ?>/admin/tambah" style="background: #1b263b; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 10px;">+ Tambah Portofolio Baru</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Usaha</th>
                    <th>Slug URL</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($portofolios)): ?>
                    <tr><td colspan="5" style="text-align: center; color: #888;">Belum ada data portofolio.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach($portofolios as $p): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($p['nama_usaha']); ?></td>
                        <td><?= htmlspecialchars($p['slug']); ?></td>
                        <td>
                            <?php if($p['status'] == 'publish'): ?>
                                <span class="badge badge-publish">Publish</span>
                            <?php else: ?>
                                <span class="badge badge-draft">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($p['status'] == 'draft'): ?>
                                <a href="<?= BASEURL; ?>/admin/publish/<?= $p['id']; ?>" class="btn btn-publish" onclick="return confirm('Publish website ini?')">Publish</a>
                            <?php else: ?>
                                <a href="<?= BASEURL; ?>/admin/unpublish/<?= $p['id']; ?>" class="btn btn-unpublish" onclick="return confirm('Tarik kembali menjadi Draft?')">Unpublish</a>
                                <a href="<?= BASEURL; ?>/web/<?= $p['slug']; ?>" target="_blank" class="btn btn-view">Lihat Web</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>