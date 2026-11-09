<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    if(!isset($_SESSION['nombre'])){
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del pedido · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="?entity=producto&amp;action=index&rol=1" aria-label="techUP, inicio">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6-6 6 6"/></svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
            <a href="?entity=pedido&amp;action=index&amp;rol=1&amp;id=<?= $_SESSION["id"] ?>" class="is-active" aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=show&amp;id=<?= $_SESSION["id"] ?>&amp;rol=1">Mi Cuenta</a>
            </nav>
            <a class="logout" href="?entity=login&amp;action=index&rol=1">Cerrar sesión. </a>
        </div>
    </header>

    <main class="page page-narrow">
        <a href="?entity=pedido&action=index&rol=1" class="back">← Volver a pedidos</a>
        <div class="page-head">
            <div>
                <h1>Detalles del pedido</h1>
                <p class="page-sub">Líneas y estado del pedido seleccionado.</p>
            </div>
        </div>

        
        <section class="verPedido">

            <?php

                $total = 0;
                echo "<p><strong>Nº de pedido: </strong> " . $data[0]['numero_pedido'] . "</p>";
                 echo "<p><strong>Usuario: </strong> " . $data[0]['usuario_nombre'] . "</p>";
                  echo "<p><strong>Estado: </strong> <span class='badge badge-" . $data[0]['estado'] . "'>" . $data[0]['estado'] . "</span></p>";
                  echo "<p><strong>Fecha: </strong> " . $data[0]['fecha_pedido'] . "</p>";
            foreach ($data as $pedido) {

                echo "<div>";
                echo "<p><strong>Nombre del producto: </strong> " . $pedido['producto_nombre'] . "</p>";
               
                echo "<p><strong>Cantidad: </strong> " . $pedido['cantidad'] . "</p>";

                $precio_unitario = $pedido['precio_compra'] /  $pedido['cantidad'];

                echo "<p><strong>Precio: </strong> " . number_format($precio_unitario, 2)  . "€</p>";
                
                echo "<p><strong>Subtotal: </strong> " . $pedido['precio_compra'] . "€</p>";
                echo "</div>";

                $total += $pedido['cantidad'] * $precio_unitario;

            }

            echo "<p><strong>Total: </strong> " . $total . "€</p>";

            ?>
        </section>
    </main>
</body>

</html>
