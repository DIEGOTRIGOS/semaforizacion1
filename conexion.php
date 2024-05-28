<?php

// Conexión a la base de datos PostgreSQL
$dbname = 'Factura';
$host = 'localhost';
$user = 'postgres';
$password = '1063';
$port = '5432';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Error de conexión a la base de datos: " . pg_last_error());
} else {

}
?>
