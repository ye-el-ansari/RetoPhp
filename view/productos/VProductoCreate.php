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
    <title>Alta de Producto</title>
    <!-- Bootstrap CSS -->
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

        
    </style>
    <div class="container mt-5">
        <a href="?entity=producto&action=index" class="btn btn-secondary">Volver</a>

        <h1 class="text-center mb-4">Formulario de Alta de Producto</h1>

        <form method="post" action="index.php?action=store">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <input name="categoria" type="text" class="form-control" id="categoria" placeholder="Ingresa la categoria" required>
            </div>

            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input name="marca" type="text" class="form-control" id="marca" placeholder="Ingresa la marca" required>
            </div>

            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input name="modelo" type="text" class="form-control" id="modelo" placeholder="Ingresa el modelo" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input name="precio" type="number" class="form-control" id="precio" placeholder="Ingresa el precio" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input name="stock" type="number" class="form-control" id="stock" placeholder="Ingresa el stock" required>
            </div>

            <div class="mb-3">
                <label for="peso" class="form-label">Peso</label>
                <input name="peso" type="number" class="form-control" id="peso" placeholder="Ingresa el peso" required>
            </div>

            <div class="mb-3">
                <label for="altura" class="form-label">Altura</label>
                <input name="altura" type="number" class="form-control" id="altura" placeholder="Ingresa la altura" required>
            </div>

            <div class="mb-3">
                <label for="ancho" class="form-label">Ancho</label>
                <input name="ancho" type="number" class="form-control" id="ancho" placeholder="Ingresa el ancho" required>
            </div>

            <div class="mb-3">
                <label for="profundidad" class="form-label">Profundidad</label>
                <input name="profundidad" type="number" class="form-control" id="profundidad" placeholder="Ingresa la profundidad" required>
            </div>

            <button type="submit" class="btn btn-primary">Dar de Alta</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>