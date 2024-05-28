<?php
$dbname = 'proyecto';
$host = 'localhost';
$user = 'postgres';
$password = '1063';
$port = '5432';

try {
    // Conexión a la base de datos
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=$port;user=$user;password=$password");
    // Verificar si la conexión se realizó correctamente
    if ($conn) {
        // Obtener los datos del formulario
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Consultar si el usuario existe
        $query_check = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario AND contrasena = :contrasena";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bindParam(':usuario', $usuario);
        $stmt_check->bindParam(':contrasena', $contrasena);
        $stmt_check->execute();
        $result = $stmt_check->fetchColumn();

        if ($result > 0) {
            echo "¡Bienvenido! Acceso permitido a la base de datos.";
            // Aquí puedes realizar las operaciones permitidas en la base de datos para este usuario
        } else {
            echo "Usuario o contraseña incorrectos. Acceso denegado.";
        }
    } else {
        echo "Error al conectar a la base de datos.<br>";
    }
} catch (PDOException $e) {
    echo "NO SE PUDO CONECTAR CON LA BASE DE DATOS: " . $e->getMessage();
}
?>
