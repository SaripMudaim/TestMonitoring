<?php
class Controller {
    public function view($view, $data = []) {
        extract($data);
        
        // Tentukan path lengkapnya
        $filePath = __DIR__ . '/../views/' . $view . '.php';
        
        // Cek keberadaan file
        if (file_exists($filePath)) {
            require_once $filePath;
        } else {
            // Tampilkan path aslinya agar kita tahu PHP mencari di mana
            die("ERROR: File view tidak ditemukan. PHP mencari file di: <br><b>" . $filePath . "</b>");
        }
    }

    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }
}
?>