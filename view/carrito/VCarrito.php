<?php
// VISTA del carrito del cliente. Recibe desde CPedido::carrito():
//   $pedidoPendiente (cabecera del pedido), $pedido (sus líneas) y $productos (catálogo).
// Exige sesión iniciada; si no, redirige al login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['nombre'])) {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi carrito · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">

            <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 15l6-6 6 6" />
                </svg></span>
            <span class="brand-name">tech<b>UP</b></span>
            <span class="brand-tag">Panel del Pedidos</span>
            </a>
            <nav class="nav" aria-label="Secciones">
                <a href="?entity=pedido&amp;action=index&amp;rol=1&amp;id=<?= $_SESSION["id"] ?>" class="is-active"
                    aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=show&amp;id=<?= $_SESSION["id"] ?>&amp;rol=1">Mi Cuenta</a>

            </nav>
            <span class="page-sub"> <?= $_SESSION["nombre"] ?>
                <?php

                // Se eliminó el print_r($_SESSION) para no romper el diseño HTML ni exponer datos
                if ($_SESSION['rol'] == 0) {
                    echo "[Administrador]";
                } else {
                    echo "[Cliente]";
                }
                ?></span>
            <a class="logout" href="?entity=login&amp;">Cerrar sesión</a>
        </div>
    </header>
    <main class="page">

        <div class="page-head">
            <div>
                <h1>Mi carrito</h1>
                <p class="page-sub">Gestiona los productos de tu pedido pendiente.</p>
            </div>
        </div>
        <?php

        // Muestro el numero de pedido y su estado actual.
        echo "<h2>Pedido #" . $pedidoPendiente['id_pedido'] . "</h2>
            <span class='badge badge-" . $pedidoPendiente['estado'] . "'>" . $pedidoPendiente['estado'] . "</span> ";

        ?>

        <!-- Tabla con las líneas del pedido pendiente -->
        <div class="panel table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="num">Cantidad</th>
                        <th class="num">Precio unitario</th>
                        <th class="num">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $total = 0;

                    // Recorremos las líneas: el subtotal es precio_compra y el precio unitario = subtotal / cantidad
                    foreach ($pedido as $dato) {
                        $subtotal = $dato['precio_compra'];

                        //sumamos al total en cada vuelta
                        $total = $total + $subtotal;


                        echo "<tr>";
                        echo "<td>" . $dato['producto_nombre'] . "</td>";
                        // cantidad
                        echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                        // precio por unidad (subtotal / cantidad)
                        echo "<td class='num'>" . number_format($subtotal / $dato['cantidad'], 2) . " €</td>";
                        // sutotal
                        echo "<td class='num'>" . number_format($subtotal, 2) . " €</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="page-head">
            <h2>Total: <?= number_format($total, 2) ?> €</h2>

            <div style="display: flex; gap: 10px; align-items: center;">

                <!-- Termina con el pedido, y cambia el estado a PAGADO -->
                <a href="index.php?entity=pedido&action=comprar&rol=1" class="btn btn-primary">
                    Finalizar compra
                </a>

                <!-- Formulario para eliminar el pedido, valida si existen productos dentro de este -->
                <form method="POST" action="index.php?entity=pedido&action=destroy&rol=1"
                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">

                    <input type="hidden" name="id_pedido" value="<?= $pedidoPendiente['id_pedido'] ?>">

                    <button type="submit" class="btn btn-danger">
                        Eliminar pedido
                    </button>

                </form>

            </div>
        </div>

        <!-- CATALOGO DE PRODUCTOS -->

        <div class="page-head">
            <div>
                <h2>Productos disponibles</h2>
                <p class="page-sub">Añade productos a tu pedido.</p>
            </div>
        </div>

        <div class="panel table-wrap">

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th class="num">Precio</th>
                        <th>Cantidad</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    // Una fila por producto del catálogo, con un mini formulario (cantidad + botón AÑADIR)
                    foreach ($productos as $producto) {

                        echo "<tr>";

                        // id del producto
                        echo "<td>" . $producto['id_producto'] . "</td>";
                        // nombre del producto
                        echo "<td>" . $producto['nombre'] . "</td>";
                        // precio con formato de 2 decimales.
                        echo "<td class='num'>" . number_format($producto['precio'], 2) . " €</td>";

                        echo "<td>";

                        // Cuando el usuario da click en el boton de añadir, el producto y la cantidad se añaden al pedido.
                        echo "<form method='POST' action='index.php?entity=pedido&action=anyadirProducto&rol=1'>";
                        echo "<input type='hidden' name='id_producto' value='" . $producto['id_producto'] . "'>";
                        echo "<input type='number' name='cantidad' value='1' min='1' class='form-control' style='width: 55px; text-align:center; height: 40px; display: inline-block;'>";
                        echo "</td>";

                        echo "<td>";
                        echo "<button type='submit' class='btn btn-sm btn-primary'>AÑADIR</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>

        </div>

    </main>

</body>

</html>