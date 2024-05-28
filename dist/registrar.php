<?php
$dbname = 'proyecto';
$host = 'localhost';
$user = 'postgres';
$password = '1063';
$port = '5432';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=$port;user=$user;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el usuario ya está registrado
    $sql_check = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':usuario', $usuario);
    $stmt_check->execute();
    $row_count = $stmt_check->fetchColumn();

    if ($row_count > 0) {
        // El usuario ya está registrado
        echo "El usuario ya está en la base de datos.";
    } else {
        // El usuario no está registrado, proceder con la inserción
        $sql_insert = "INSERT INTO usuarios (usuario, contrasena) VALUES (:usuario, :contrasena)";
        $ps = $conn->prepare($sql_insert);
        $ps->bindParam(':usuario', $usuario);
        $ps->bindParam(':contrasena', $contrasena);
        $ps->execute();
        echo "Usuario registrado correctamente.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
