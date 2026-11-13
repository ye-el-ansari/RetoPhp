<?php
// VISTA listado de pedidos del CLIENTE. Recibe $pedido desde CPedido::index() (rol 1).
// Exige sesión iniciada; si no, redirige al login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos · techUP</title>
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
            <a class="logout" href="?entity=login&amp;action=logout">Cerrar sesión</a>
        </div>
    </header>

    <main class="page">
        <div class="page-head">
            <div>
                <h1>Pedidos</h1>
                <p class="page-sub">Pedidos de los clientes y su estado.</p>
            </div>
            <!-- Acceso al carrito (CPedido::carrito) -->
            <a href="?entity=pedido&action=carrito&rol=1" class="btn btn-primary">Mi carrito</a>
        </div>

        <div class="panel table-wrap">
            <table class="table table-groups">
                <thead>
                    <tr>
                        <th scope="col">Nº pedido</th>
                        <th scope="col">ID Detalle</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Usuario</th>
                        <th scope="col" class="num">Cantidad</th>
                        <th scope="col" class="num">Precio unitario</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ultimo_pedido = null; // Variable para recordar el pedido anterior, empieza en null por que no hay pedido anterior al inicio
                    

                    // Cada fila es una LÍNEA de pedido; las líneas del mismo pedido se agrupan visualmente
                    foreach ($pedido as $dato) {

                    echo "<tr>";
                        // precio unitario = precio total de la línea / cantidad
                        $precio_unitario = $dato['precio_compra'] / $dato['cantidad'];
                        // Si el pedido actual es igual al anterior, dejamos la celda vacía
                        if ($dato['numero_pedido'] == $ultimo_pedido) {


                            echo "<td></td>"; // Número vacío
                            echo "<td>" . $dato['id_detalle'] . "</td>";
                            echo "<td>" . $dato['producto_nombre'] . "</td>";
                            echo "<td></td>"; // Usuario vacío
                            echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                            echo "<td class='num'>" . number_format($precio_unitario, 2) . " €</td>";
                            echo "<td></td>"; // Estado vacío
                            echo "<td></td>"; // Fecha vacía
                            echo "<td class='actions'>";

                            // Solo se puede modificar o eliminar una línea si el pedido está pendiente
                            if($dato['estado'] == 'pendiente'){

                                echo "<a href='index.php?entity=pedido&action=edit&rol=1&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-edit'>Modificar</a> <br>
                            <a href='index.php?entity=pedido&action=destroyLinea&rol=1&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-delete' onclick=\"return confirm('¿Seguro que quieres eliminar este producto del pedido?');\">Eliminar</a> 
                            
                            </td>";
                            
                            } 
                            


                        } else {
                            // Si es un pedido nuevo, mostramos todos los datos normalmente
                            echo "<td class='strong'>#" . $dato['numero_pedido'] . "</td>";
                            echo "<td>" . $dato['id_detalle'] . "</td>";
                            echo "<td>" . $dato['producto_nombre'] . "</td>";
                            echo "<td>" . $dato['usuario_nombre'] . "</td>";
                            echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                            echo "<td class='num'>" . number_format($precio_unitario, 2) . " €</td>";
                            echo "<td><span class='badge badge-" . $dato['estado'] . "'>" . $dato['estado'] . "</span></td>";
                            echo "<td class='muted'>" . $dato['fecha_pedido'] . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='index.php?entity=pedido&action=show&rol=1&id=" . $dato['numero_pedido'] . "' class='btn btn-sm btn-view'>Ver pedido</a> <br>";

                            if($dato['estado'] == 'pendiente'){
                                echo "<a href='index.php?entity=pedido&action=edit&rol=1&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-edit'>Modificar</a> <br>

                            <a href='index.php?entity=pedido&action=destroyLinea&rol=1&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-delete' onclick=\"return confirm('¿Seguro que quieres eliminar este producto del pedido?');\">Eliminar</a> 
                            
                            </td>";
                            
                            } 
                            
                            
                        }

                        echo "</tr>";

                        // Guardamos este número de pedido para compararlo en la siguiente vuelta
                        $ultimo_pedido = $dato['numero_pedido'];
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php require __DIR__ . '/../aviso.php'; ?>
</body>

</html>
