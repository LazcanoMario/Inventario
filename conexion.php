<?php
$servername = "localhost";
$username = "root";
$password = "butcher2709";
$dbname = "almacen";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
