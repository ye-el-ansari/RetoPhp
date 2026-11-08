<!-- <?php
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
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        .container {
            width: 40%;
            background-color: #dfdfdf;
            border: solid 1px #949494;
            margin-bottom: 100px;
            padding: 30px;
            border-radius: 10px
        }

        a
    </style>
    <div class="container mt-5">
        <a href="?entity=producto&action=index" class="btn btn-secondary">Volver</a>
        <h1 class="text-center mb-4">Ver Producto</h1>

        <?php
        echo "<p><strong>ID Producto: </strong> " . $producto['productoId'] . "</p>";
        echo "<p><strong>Nombre: </strong> " . $producto['productoNombre'] . "</p>";
        echo "<p><strong>Categoría: </strong> " . $producto['productoCategoria'] . "</p>";
        echo "<p><strong>Marca: </strong> " . $producto['productoMarca'] . "</p>";
        echo "<p><strong>Modelo: </strong> " . $producto['productoModelo'] . "</p>";
        echo "<p><strong>Precio: </strong> " . $producto['productoPrecio'] . "</p>";
        echo "<p><strong>Stock: </strong> " . $producto['productoStock'] . "</p>";
        echo "<p><strong>Peso: </strong> " . $producto['productoPeso'] . "</p>";
        echo "<p><strong>Alto: </strong> " . $producto['productoAlto'] . "</p>";
        echo "<p><strong>Ancho: </strong> " . $producto['productoAncho'] . "</p>";
        echo "<p><strong>Profundidad: </strong> " . $producto['productoProfundidad'] . "</p>";

        ?>

</html> -->