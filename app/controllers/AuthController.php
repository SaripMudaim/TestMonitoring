<?php
class AuthController extends Controller {
    
    // Tampilkan halaman login
    public function index() {
        // Jika sudah login, langsung lempar ke dashboard
        if (isset($_SESSION['admin_id'])) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
        
        $this->view('auth/login');
    }

    // Proses submit form login
    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $adminModel = $this->model('AdminModel');
            $admin = $adminModel->findByUsername($username);

            // Verifikasi Password (Menggunakan password_verify karena di DB pakai hash)
            if ($admin && password_verify($password, $admin['password'])) {
                // Set Session
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];

                // Redirect ke dashboard
                header('Location: ' . BASEURL . '/admin');
                exit;
            } else {
                // Gagal login
                $_SESSION['flash_error'] = "Username atau password salah!";
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        }
    }

    // Proses Logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}
?>