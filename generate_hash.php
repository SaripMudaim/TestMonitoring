<?php
$password_asli = 'admin123';
$hash = password_hash($password_asli, PASSWORD_DEFAULT);
echo "Password Asli: " . $password_asli . "<br>";
echo "Hash untuk Database: <br><b>" . $hash . "</b>";
?>