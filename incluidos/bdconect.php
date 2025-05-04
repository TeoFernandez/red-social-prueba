<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mi_base';

$conn = new mysqli($host,$user,$pass,$dbname);

if($conn -> connect_error){
    die("Conexión fellida: ".$conn->connect_error);

}

?>