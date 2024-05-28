<?php
include("conexion.php");

// Recuperar los elementos del carrito desde la base de datos
$query = "SELECT * FROM carrito";
$result = pg_query($conn, $query);
if (!$result) {
    die("Error al recuperar datos de la base de datos: " . pg_last_error($conn));
}

// Verificar si hay elementos en el carrito
if (pg_num_rows($result) > 0) {
    // Mostrar los elementos en una lista junto con botones de eliminar
    echo "<ul>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<li>" . " - Producto: " . $row['producto'] . " - Ciudad: " . $row['ciudad'] . " - Precio: " . $row['precio'] . " - Cantidad: " . $row['cantidad'];
        echo "<form action='eliminar_compras.php' method='POST'>";
        echo "<input type='hidden' name='eliminar_item' value='" . $row['id'] . "'>";
        echo "<button type='submit' name='eliminar_del_carrito'>Eliminar</button>";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    // Mostrar un mensaje si el carrito está vacío
    echo "<p>No hay productos en el carrito.</p>";
}
?>
