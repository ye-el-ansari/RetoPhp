<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
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
        <a href="?entity=producto&action=index" class="btn btn-secondary">Volver</a>
        <h1 class="text-center mb-4">Formulario de edición de Producto</h1>

        <form method="post" action="index.php?action=update&id=<?= $data['id_detalle'] ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input name="nombre" type="text" class="form-control" id="nombre" value="<?= $data['producto_nombre'] ?>" required>
            </div>


            <label for="arma" class="form-label">Arma</label>
            <select name="arma" id="arma" class="form-select" required>
                <?php
                foreach ($arma as $a) {
                    if ($a['id_arma'] == $caballero['armaId']) {
                        echo "<option value='" . $a['id_arma'] . "' selected>";
                        echo $a['tipo'];
                        echo "</option>";
                    } else {
                        echo "<option value='" . $a['id_arma'] . "'>";
                        echo $a['tipo'];
                        echo "</option>";
                    }
                }
                ?>
            </select>


            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input name="categoria" type="text" class="form-control" id="categoria" value="<?= $data['productoCategoria'] ?>" placeholder="Ingresa la categoría del producto" required>
            </div>

            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input name="marca" type="text" class="form-control" id="marca" value="<?= $data['productoMarca'] ?>" placeholder="Ingresa la marca del producto" required>
            </div>


            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input name="modelo" type="text" class="form-control" id="modelo" value="<?= $data['productoModelo'] ?>" placeholder="Ingresa el modelo del producto" required>
            </div>


            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input name="precio" type="number" class="form-control" id="precio" value="<?= $data['productoPrecio'] ?>" placeholder="Ingresa el precio del producto" required>
            </div>


            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input name="stock" type="number" class="form-control" id="stock" value="<?= $data['productoStock'] ?>" placeholder="Ingresa el stock del producto" required>
            </div>


            <div class="mb-3">
                <label for="peso" class="form-label">Peso</label>
                <input name="peso" type="number" class="form-control" id="peso" value="<?= $data['productoPeso'] ?>" placeholder="Ingresa el peso" required>
            </div>

            <div class="mb-3">
                <label for="altura" class="form-label">Altura</label>
                <input name="altura" type="number" class="form-control" id="altura" value="<?= $data['productoAlto'] ?>" placeholder="Ingresa la altura" required>
            </div>

            <div class="mb-3">
                <label for="ancho" class="form-label">Ancho</label>
                <input name="ancho" type="number" class="form-control" id="ancho" value="<?= $data['productoAncho'] ?>" placeholder="Ingresa el ancho" required>
            </div>

            <div class="mb-3">
                <label for="profundidad" class="form-label">Profundidad</label>
                <input name="profundidad" type="number" class="form-control" id="profundidad" value="<?= $data['productoProfundidad'] ?>" placeholder="Ingresa la profundidad" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Modificar Producto</button>
        </form>
    </div> <!-- Cierre correcto del container -->

</body>

</html>