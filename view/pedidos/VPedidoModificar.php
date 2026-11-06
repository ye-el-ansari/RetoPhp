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
    <title>Editar Pedido</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            width: 40%;
            background-color: #dfdfdf;
            border: solid 1px #949494;
            margin-bottom: 100px;
            padding: 30px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <a href="?entity=pedido&action=index" class="btn btn-secondary">Volver</a>
        <h1 class="text-center mb-4">Formulario de edición de Pedido</h1>

        <form method="post" action="index.php?action=update&id=<?= $data['id_detalle'] ?>">


            <label for="producto" class="form-label">Producto</label>
            <select name="producto" id="producto" class="form-select" required>
                <?php

                $precio = 0;
                foreach ($productos as $a) {
                    if ($a['id_producto'] == $data['id_producto']) {
                        echo "<option value='" . $a['id_producto'] . "' selected>";
                        echo $a['nombre'];
                        echo "</option>";
                        echo "<div id='precioProducto' styles='display=hidden'>" .$a['precio']."</div>";
                        $precio = $a['precio'];
                    } else {
                        echo "<option value='" . $a['id_producto'] . "'>";
                        echo $a['nombre'];
                        echo "</option>";
                    }
                }
                ?>
            </select>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input name="cantidad" type="number" class="form-control" id="cantidad" value="<?= $data['cantidad'] ?>"
                    placeholder="Ingresa la cantidad del producto" required min="1">
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input name="precio" type="number" class="form-control" id="precio"
                    value="<?= $precio * $data['cantidad']   ?>" placeholder="Ingresa la marca del producto"
                    required disabled>
            </div>


           

            <button type="submit" class="btn btn-primary w-100">Modificar Producto</button>
        </form>
    </div> <!-- Cierre correcto del container -->

    <script>
        // JavaScript para actualizar el precio total en tiempo real
        const inputCantidad = document.getElementById('cantidad');
        const totalPantalla = document.getElementById('precio');
        const precio = parseFloat(document.getElementById('precioProducto').innerText);

        inputCantidad.addEventListener('change', function () {
            let cantidad = parseInt(this.value);

            // Calculamos el precio total
            let precioTotal = precio * cantidad;

            // Mostramos el resultado formateado a 2 decimales
            
            totalPantalla.value = precioTotal.toFixed(2);
        });
    </script>


</body>

</html>