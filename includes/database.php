<?php
// conexión a la base de datos
//$db = mysqli_connect('localhost', 'root', '', 'appsalon');
//depurar($_ENV);
$db = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'] ?? '', $_ENV['DB_BD']);

// definimos caracteres utf 8 para los tíldes, ñ , etc
$db->set_charset("utf8");


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
