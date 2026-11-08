<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['nombre'])) {
    header("Location: ../../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar pedido · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="?entity=producto&amp;action=index" aria-label="techUP, inicio">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 15l6-6 6 6" />
                    </svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
                <a href="?entity=producto&amp;action=index">Productos</a>
                <a href="?entity=pedido&amp;action=index" class="is-active" aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=index">Usuarios</a>
                
            </nav>
            <a class="logout" href="?entity=login&amp;action=index">Cerrar sesión</a>
        </div>
    </header>

    <main class="page page-narrow">
        <a href="?entity=pedido&action=index" class="back">← Volver a pedidos</a>
        <div class="page-head">
            <div>
                <h1>Editar pedido</h1>
                <p class="page-sub">Cambia el producto o la cantidad; el total se calcula solo.</p>
            </div>
        </div>

        <form method="post" action="index.php?entity=pedido&amp;action=update&amp;id=<?= $data['id_detalle'] ?>" class="panel form-card">
            <div class="form-grid">
                <div class="field full">
                    <label for="producto">Producto</label>
                    <select name="producto" id="producto" class="select" required disabled>
                        <?php

                        $precio = 0;
                        foreach ($productos as $a) {
                            if ($a['id_producto'] == $data['id_producto']) {
                                echo "<option value='" . $a['id_producto'] . "' data-precio='" . $a['precio'] . "' selected>";
                                echo $a['nombre'];
                                echo "</option>";
                                $precio = $a['precio'];
                            } else {
                                echo "<option value='" . $a['id_producto'] . "' data-precio='" . $a['precio'] . "'>";
                                echo $a['nombre'];
                                echo "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="field">
                    <label for="cantidad">Cantidad</label>
                    <input name="cantidad" type="number" class="input" id="cantidad" value="<?= $data['cantidad'] ?>"
                        placeholder="Unidades" required disabled>
                </div>

                <div class="field">
                    <label for="precio">Total del pedido</label>
                    <div class="input-unit">
                        <input name="precio" type="number" class="input" id="precio"
                            value="<?= $precio * $data['cantidad']   ?>" required disabled>
                        <span class="unit">€</span>
                    </div>
                </div>
                <div class="field full">
                    <label for="producto">Estado</label>
                    <select name="estado" id="estado" class="select" required>
                        <?php
                        //segun el estado actual se guardan aqui el resto
                        $resto = [];
                        //match como el switch moderno de php
                        $resto = match ($data["estado"]) {
                            "pendiente" => ["pagado", "enviado", "entregado"],
                            "pagado"    => ["enviado", "entregado"],
                            "enviado"   => ["entregado"],
                            "entregado" => ["enviado"],
                            default     => [$data["estado"]], // maneja cualquier estado
                        };

                        ?>

                        <option value="<?= $data["estado"]  ?>" selected><?= $data["estado"]  ?></option>
                        <?php 
                        foreach($resto as $estado):
                        ?>
                        <option value="<?= $estado ?>"><?= $estado ?></option>
                        <?php endforeach;?>

                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="?entity=pedido&action=index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </main>

    <script>
        // JavaScript para actualizar el precio total en tiempo real
        const selectProducto = document.getElementById('producto');
        const inputCantidad = document.getElementById('cantidad');
        const totalPantalla = document.getElementById('precio');

        function recalcular() {
            const opcion = selectProducto.options[selectProducto.selectedIndex];
            const precio = parseFloat(opcion.dataset.precio) || 0;
            const cantidad = parseInt(inputCantidad.value) || 0;

            // Mostramos el resultado formateado a 2 decimales
            totalPantalla.value = (precio * cantidad).toFixed(2);
        }

        selectProducto.addEventListener('change', recalcular);
        inputCantidad.addEventListener('input', recalcular);
    </script>
</body>

</html>