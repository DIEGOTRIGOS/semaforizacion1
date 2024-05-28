<?php
include("conexion.php");
if(isset($_POST['eliminar_del_carrito'])) {
    $index = $_POST['eliminar_item'];
    
    // Consulta SQL para eliminar el elemento del carrito según el índice
    $query = "DELETE FROM carrito WHERE id = $index";

    // Ejecutar la consulta
    $result = pg_query($conn, $query);
    
    // Verificar si la consulta se ejecutó correctamente
    if ($result) {
        echo "Se ha eliminado el elemento con éxito.";
    } else {
        echo "Error al eliminar el elemento: " . pg_last_error($conn);
    }
}
?>
