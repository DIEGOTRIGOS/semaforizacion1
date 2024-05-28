<?php
// Verificar si el archivo tcpdf.php se puede cargar correctamente
if (!file_exists('tcpdf/tcpdf.php')) {
    die('El archivo tcpdf.php no se ha encontrado. Verifica la ruta.');
}

require_once('tcpdf/tcpdf.php');

// Configuración de la base de datos
$dbname = 'proyecto';
$host = 'localhost';
$user = 'postgres';
$password = '1063';
$port = '5432';

try {
    // Conexión a la base de datos
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=$port;user=$user;password=$password");
    if ($conn) {
        // Obtener el usuario especificado (supongamos que se pasa por parámetro)
        $usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';

        // Consultar el usuario en la base de datos
        $query_select = "SELECT usuario, contrasena FROM usuarios WHERE usuario = :usuario";
        $stmt_select = $conn->prepare($query_select);
        $stmt_select->bindParam(':usuario', $usuario);
        $stmt_select->execute();
        $data = $stmt_select->fetch(PDO::FETCH_ASSOC);

        // Crear un nuevo objeto TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Autor');
        $pdf->SetTitle('Título del PDF');
        $pdf->SetSubject('Asunto del PDF');
        $pdf->SetKeywords('TCPDF, PDF, ejemplo, PHP');

        // Agregar una página
        $pdf->AddPage();

        // Imprimir datos en el PDF
        $pdf->SetFont('helvetica', '', 12);
        if ($data) {
            $pdf->Cell(0, 10, "Usuario: " . $data['usuario'] . ", Contraseña: " . $data['contrasena'], 0, true);
        } else {
            $pdf->Cell(0, 10, "Usuario no encontrado en la base de datos", 0, true);
        }

        // Cerrar la conexión
        $conn = null;

        // Salida del PDF (nombre del archivo)
        $pdf->Output('example.pdf', 'I');
    } else {
        echo "Error al conectar a la base de datos.<br>";
    }
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error inesperado: " . $e->getMessage();
}
?>
