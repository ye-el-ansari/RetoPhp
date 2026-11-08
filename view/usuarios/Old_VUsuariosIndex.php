<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a href="?entity=producto&action=index" class="btn btn-secondary">Volver</a>
        <h1 class="text-center mb-4">Ver Producto</h1>

        <section class="verPedido">

            <?php

            foreach ($usuario as $datos) {

                echo "<div>";
                echo "<p><strong>ID Usuario: </strong> " . $datos['id_usuario'] . "</p>";
                echo "<p><strong>Nombre del usuario: </strong> " . $pedido['producto_nombre'] . "</p>";
                echo "<p><strong>Rol: </strong> " . $pedido['usuario_nombre'] . "</p>";
                echo "<p><strong>Apellidos: </strong> " . $pedido['cantidad'] . "</p>";
                echo "<p><strong>Email: </strong> " . $pedido['precio'] . "</p>";
                echo "<p><strong>Telefono: </strong> " . $pedido['estado'] . "</p>";
                echo "<p><strong>Fecha_registro: </strong> " . $pedido['fecha_pedido'] . "</p>";
                echo "</div>";
            }


            ?>
        </section>

</body>
</html> -->