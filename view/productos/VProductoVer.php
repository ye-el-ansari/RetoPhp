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
    <title>Detalle de producto · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6-6 6 6"/></svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
            <a href="?entity=producto&amp;action=index" class="is-active" aria-current="page">Productos</a>
            <a href="?entity=pedido&amp;action=index&rol=0">Pedidos</a>
            <a href="?entity=usuario&amp;action=index">Usuarios</a>
           
            </nav>
            <span class="page-sub">  <?= $_SESSION["nombre"] ?>
                <?php

                // Se eliminó el print_r($_SESSION) para no romper el diseño HTML ni exponer datos
                if ($_SESSION['rol'] == 0) {
                    echo "[Administrador]";
                } else {
                    echo "[Cliente]";
                }
                ?>
            </span>
            <a class="logout" href="?entity=login&amp;action=index">Cerrar sesión</a>
        </div>
    </header>

    <main class="page page-narrow">
        <a href="?entity=producto&action=index" class="back">← Volver a productos</a>
        <div class="page-head">
            <div>
                <h1>Detalle de producto</h1>
                <p class="page-sub">Toda la información del artículo.</p>
            </div>
        </div>

        <div class="panel detail detail-grid">
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
        </div>
    </main>
</body>

</html>
