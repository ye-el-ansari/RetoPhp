<?php
    session_start();
    if(!isset($_SESSION['nombre'])){
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Producto</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="view/styles.css">
    
</head>

<body>
    <div class="container">
        <a href="?entity=producto&action=index" class="btn btn-secondary">Volver</a>
        <h1 class="text-center mb-4">Ver Producto</h1>

        <section class="verPedido">

            <?php

            foreach ($data as $pedido) {

                echo "<div>";
                echo "<p><strong>ID Producto: </strong> " . $pedido['numero_pedido'] . "</p>";
                echo "<p><strong>Nombre del producto: </strong> " . $pedido['producto_nombre'] . "</p>";
                echo "<p><strong>Usuario: </strong> " . $pedido['usuario_nombre'] . "</p>";
                echo "<p><strong>Cantidad: </strong> " . $pedido['cantidad'] . "</p>";
                echo "<p><strong>Precio: </strong> " . $pedido['precio'] . "</p>";
                echo "<p><strong>Estado: </strong> " . $pedido['estado'] . "</p>";
                echo "<p><strong>Fecha: </strong> " . $pedido['fecha_pedido'] . "</p>";
                echo "</div>";
            }


            ?>
        </section>




</html>