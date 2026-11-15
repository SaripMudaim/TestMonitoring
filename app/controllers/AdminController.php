<?php
class AdminController extends Controller {
    
    public function __construct() {
        // Cek apakah session admin_id ada?
        if (!isset($_SESSION['admin_id'])) {
            // Jika tidak ada, tendang ke halaman login
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // Tampilkan Dashboard & Daftar Portofolio
    public function index() {
        $adminModel = $this->model('AdminModel');
        
        $data['judul'] = 'Dashboard Admin';
        $data['username'] = $_SESSION['admin_username'] ?? 'Admin';
        $data['portofolios'] = $adminModel->getPortofolioByAdmin($_SESSION['admin_id']);
        
        $this->view('admin/dashboard', $data);
    }

    // Menampilkan Form Tambah
    public function tambah() {
        $data['judul'] = 'Tambah Portofolio UMKM';
        $data['username'] = $_SESSION['admin_username'];
        $this->view('admin/tambah_portofolio', $data);
    }

    // Memproses Form Tambah
    public function prosesTambah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $adminModel = $this->model('AdminModel');

            // 1. Ambil data & bersihkan
            $nama_usaha = htmlspecialchars(trim($_POST['nama_usaha']));
            $slug = strtolower(trim($_POST['slug']));
            // Ganti spasi dengan strip (-) agar URL friendly
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug); 
            $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
            
            // 2. Validasi ketersediaan Slug menggunakan Function Database
            if (!$adminModel->cekSlug($slug)) {
                $_SESSION['flash_error'] = "Slug/URL '$slug' sudah dipakai! Gunakan yang lain.";
                header('Location: ' . BASEURL . '/admin/tambah');
                exit;
            }

            // 3. Logika Upload Logo
            $nama_logo = "";
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $target_dir = __DIR__ . '/../../public/uploads/';
                
                // Buat folder jika belum ada
                if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
                
                // Buat nama file unik
                $file_ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                $nama_logo = $slug . '-' . time() . '.' . $file_ext;
                $target_file = $target_dir . $nama_logo;
                
                // Pindahkan file
                move_uploaded_file($_FILES['logo']['tmp_name'], $target_file);
            }

            // 4. Simpan ke Database lewat Stored Procedure
            $data = [
                'admin_id' => $_SESSION['admin_id'],
                'nama_usaha' => $nama_usaha,
                'slug' => $slug,
                'deskripsi' => $deskripsi
            ];

            if ($adminModel->tambahPortofolio($data)) {
                $_SESSION['flash_success'] = "Portofolio $nama_usaha berhasil dibuat sebagai Draft!";
                header('Location: ' . BASEURL . '/admin');
            } else {
                $_SESSION['flash_error'] = "Gagal menyimpan ke database.";
                header('Location: ' . BASEURL . '/admin/tambah');
            }
            exit;
        }
    }

    // Fitur Publish
    public function publish($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->ubahStatus($id, 'publish');
        $_SESSION['flash_success'] = "Website berhasil di-Publish!";
        header('Location: ' . BASEURL . '/admin');
        exit;
    }

    // Fitur Unpublish (Tarik kembali ke Draft)
    public function unpublish($id) {
        $adminModel = $this->model('AdminModel');
        $adminModel->ubahStatus($id, 'draft');
        $_SESSION['flash_success'] = "Website berhasil ditarik kembali menjadi Draft.";
        header('Location: ' . BASEURL . '/admin');
        exit;
    }
}
?>