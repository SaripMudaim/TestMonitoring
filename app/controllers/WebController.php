<?php
class WebController extends Controller {
    
    public function index($slug = '') {
        if (empty($slug)) {
            echo "<h1>Halaman Utama Website Builder</h1>";
            return;
        }

        $adminModel = $this->model('AdminModel');
        $website = $adminModel->getWebsiteBySlug($slug);

        if (!$website) {
            http_response_code(404);
            $this->view('public/404');
            return;
        }

        $data['website'] = $website;
        $this->view('public/umkm', $data);
    }
}
?>