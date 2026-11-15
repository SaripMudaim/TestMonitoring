<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Definisikan URL Utama
define('BASEURL', 'http://localhost/website-builder');

require_once 'app/core/App.php';
require_once 'app/core/Controller.php';
require_once 'config/Database.php';

$app = new App();
?>