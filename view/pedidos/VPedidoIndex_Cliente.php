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
    <title>Pedidos · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="?entity=producto&amp;action=index" aria-label="techUP, inicio">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6-6 6 6"/></svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
            <a href="?entity=producto&amp;action=index">Productos</a>
            <a href="?entity=pedido&amp;action=index" class="is-active" aria-current="page">Pedidos</a>
            <a href="?entity=usuario&amp;action=index">Usuarios</a>
            </nav>
             <span class="page-sub"> Hola  <?=$_SESSION["nombre"] ?></span>
            <a class="logout" href="?entity=login&amp;action=index">Cerrar sesión</a>
        </div>
    </header>

    <main class="page">
        <div class="page-head">
            <div>
                <h1>Pedidos</h1>
                <p class="page-sub">Pedidos de los clientes y su estado.</p>
            </div>
            <a href="?entity=pedido&action=create" class="btn btn-primary">Nuevo pedido</a>
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


                    foreach ($pedido as $dato) {

                    $precio_unitario;
                      $precio_unitario = $dato['precio_compra'] / $dato['cantidad'];
                        // Si el pedido actual es igual al anterior, dejamos la celda vacía
                        if ($dato['numero_pedido'] == $ultimo_pedido) {


                            echo "<td></td>"; // Número vacío
                            echo "<td>" . $dato['id_detalle'] . "</td>";
                            echo "<td>" . $dato['producto_nombre'] . "</td>";
                            echo "<td></td>"; // Usuario vacío
                            echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                            echo "<td class='num'>" . number_format($precio_unitario, 2)   . " €</td>";
                            echo "<td></td>"; // Estado vacío
                            echo "<td></td>"; // Fecha vacía
                            echo "<td class='actions'>
                            <a href='index.php?entity=pedido&action=edit&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-edit'>Modificar</a> <br>
                            <a href='index.php?entity=pedido&action=destroy&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-delete'>Eliminar</a><br>
                            </td>"; // Acciones
                        } else {
                            // Si es un pedido nuevo, mostramos todos los datos normalmente
                            echo "<td class='strong'>#" . $dato['numero_pedido'] . "</td>";
                            echo "<td>" . $dato['id_detalle'] . "</td>";
                            echo "<td>" . $dato['producto_nombre'] . "</td>";
                            echo "<td>" . $dato['usuario_nombre'] . "</td>";
                            echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                             echo "<td class='num'>" . number_format($precio_unitario, 2)   . " €</td>";
                            echo "<td><span class='badge badge-" . $dato['estado'] . "'>" . $dato['estado'] . "</span></td>";
                            echo "<td class='muted'>" . $dato['fecha_pedido'] . "</td>";
                            echo "<td class='actions'>
                            <a href='index.php?entity=pedido&action=show&id=" . $dato['numero_pedido'] . "' class='btn btn-sm btn-view'>Ver pedido</a> <br>
                            <a href='index.php?entity=pedido&action=edit&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-edit'>Modificar</a> <br>
                            <a href='index.php?entity=pedido&action=destroy&id=" . $dato['id_detalle'] . "'
                            class='btn btn-sm btn-delete'>Eliminar</a> 
                            
                            </td>";
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
</body>

</html>
