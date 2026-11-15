<?php
class App {
    protected $controller = 'Admin'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // 1. Cek Controller
        if (isset($url[0])) {
            if (file_exists(__DIR__ . '/../controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            } else {
                die("Error 404: Controller tidak ditemukan.");
            }
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . 'Controller.php';
        $controllerName = $this->controller . 'Controller';
        $this->controller = new $controllerName;

        // 2. Cek Method
        if (isset($url[1])) {
            // Jika method ada, gunakan method tersebut
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
            // JIKA TIDAK ADA, biarkan method default (index) dan jadikan sisa URL sebagai parameter
        }

        // 3. Kumpulkan Parameter
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 4. Jalankan Controller & Method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
?>