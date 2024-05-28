<?php
include ("conexion.php");

// Función para agregar un producto al carrito en la base de datos
function agregarAlCarritoDB($conn, $producto, $precio, $cantidad, $ciudad) {
    // Consulta preparada para insertar el producto en el carrito
    $query = "INSERT INTO carrito (producto, precio, cantidad, ciudad) VALUES ($1, $2, $3, $4)";
$params = array($producto, $precio, $cantidad, $ciudad);

// Preparar la consulta
$result = pg_prepare($conn, "agregar_carrito", $query);

if (!$result) {
    echo "Error al preparar la consulta: " . pg_last_error($conn);
    return;
}

// Ejecutar la consulta con los parámetros
$result = pg_execute($conn, "agregar_carrito", $params);

if (!$result) {
    echo "Error al ejecutar la consulta: " . pg_last_error($conn);
} else {
    echo "Producto agregado al carrito con éxito";
}
}

// Verificar si se envió el formulario para agregar al carrito
if(isset($_POST['agregar_carrito'])) {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
    
    // Verificar si 'ciudad' está definido y no es nulo antes de asignarlo
    $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';

    echo "Producto: " . $producto . "<br>";
    echo "Precio: " . $precio . "<br>";
    echo "Cantidad: " . $cantidad . "<br>";
    echo "Ciudad: " . $ciudad . "<br>";

    // Añadir el producto al carrito utilizando la función agregarAlCarritoDB
    agregarAlCarritoDB($conn, $producto, $precio, $cantidad, $ciudad);


}
?>
