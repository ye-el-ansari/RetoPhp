<?php
// VISTA listado de productos (CRUD del administrador).
// Recibe $productos desde CProducto::index(). Exige sesión iniciada.
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
    <title>Productos · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <!-- Barra superior del administrador -->
    <header class="topbar">
        <div class="topbar-inner">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 15l6-6 6 6" />
                    </svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
                <a href="?entity=producto&amp;action=index&rol=0" class="is-active" aria-current="page">Productos</a>
                <a href="?entity=pedido&amp;action=index&rol=0">Pedidos</a>
                <a href="?entity=usuario&amp;action=index&rol=0">Usuarios</a>
            </nav>
            <span class="page-sub"> <?= $_SESSION["nombre"] ?>
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

    <main class="page">
        <div class="page-head">
            <div>
                <h1>Productos</h1>
                <p class="page-sub">Catálogo de la tienda.</p>
            </div>
            <!-- Enlace al formulario de alta (CProducto::create) -->
            <a href="?entity=producto&action=create" class="btn btn-primary">Nuevo producto</a>
        </div>

        <div class="panel table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col" class="num">Precio</th>
                        <th scope="col" class="num">Stock</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Una fila por producto con los botones Ver (show), Modificar (edit) y Eliminar (destroy)
                    foreach ($productos as $dato) {
                        echo "<tr>
                            <td class='muted'>" . $dato['id_producto'] . "</td>";
                        echo "<td class='strong'>" . $dato['nombre'] . "</td>";
                        echo "<td>" . $dato['categoria'] . "</td>";
                        echo "<td>" . $dato['marca'] . "</td>";
                        echo "<td>" . $dato['modelo'] . "</td>";
                        echo "<td class='num'>" . $dato['precio'] . " €</td>";
                        echo "<td class='num'>" . $dato['stock'] . "</td>";

                        echo "<td class='actions'>
                            <a href='?entity=producto&action=show&id=" . $dato['id_producto'] . "' class='btn btn-sm btn-view'>Ver</a>
                            <a href='?entity=producto&action=edit&id=" . $dato['id_producto'] . "' class='btn btn-sm btn-edit'>Modificar</a>
                            <a href='?entity=producto&action=destroy&id=" . $dato['id_producto'] . "' class='btn btn-sm btn-delete'>Eliminar</a>
                            </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
