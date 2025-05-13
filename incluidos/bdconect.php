<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mibase';
$port = 3307; // Especificar el puerto

// Conexión con el puerto incluido
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
