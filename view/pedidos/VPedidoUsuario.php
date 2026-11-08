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
    <title>Pedidos · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="?entity=pedido&amp;action=show&amp;id=<?= $_SESSION["id"] ?>" aria-label="techUP, inicio">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 15l6-6 6 6" />
                    </svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel del Usuario</span>
            </a>
            <nav class="nav" aria-label="Secciones">
                <a href="?entity=pedido&amp;action=show&amp;rol=1&amp;id=<?= $_SESSION["id"] ?>" class="is-active" aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=show&amp;id=<?= $_SESSION["id"] ?>&amp;rol=1">Mi Cuenta</a>
                
            </nav>
            <span class="page-sub"> Hola <?= $_SESSION["nombre"] ?></span>
            <a class="logout" href="?entity=login&amp;">Cerrar sesión</a>
        </div>
    </header>

    <main class="page">
        <div class="page-head">
            <div>
                <h1>Pedidos</h1>
                <p class="page-sub">Mi Pedidos y su estado.</p>
            </div>
<a href="?entity=pedido&action=create&rol=1&id=<?= $_SESSION['id'] ?>" class="btn btn-primary">Nuevo pedido</a>
        </div>

        <div class="panel table-wrap">
            <table class="table table-groups">
                <thead>
                    <tr>
                        <th scope="col">Nº pedido</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Usuario</th>
                        <th scope="col" class="num">Cantidad</th>
                        <th scope="col" class="num">Precio</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ultimo_pedido = null; // Variable para recordar el pedido anterior, empieza en null por que no hay pedido anterior al inicio


                    foreach ($pedido as $dato) {
                        // La clase solo sirve para el estilo: agrupa visualmente las líneas del mismo pedido
                        echo "<tr class='" . ($dato['numero_pedido'] == $ultimo_pedido ? "is-cont" : "is-first") . "'>";

                        // Si el pedido actual es igual al anterior, dejamos la celda vacía
                        if ($dato['numero_pedido'] == $ultimo_pedido) {
                            echo "<td></td>"; // Número vacío
                            echo "<td>" . $dato['producto_nombre'] . "</td>";
                            echo "<td></td>"; // Usuario vacío
                            echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                            echo "<td class='num'>" . $dato['precio'] . " €</td>";
                            echo "<td></td>"; // Estado vacío
                            echo "<td></td>"; // Fecha vacía
                          
                        } else {
                            // Si es un pedido nuevo, mostramos todos los datos normalmente
                            echo "<td class='strong'>#" . $dato['numero_pedido'] . "</td>";
                            echo "<td>" . $dato['producto_nombre'] . "</td>";
                            echo "<td>" . $dato['usuario_nombre'] . "</td>";
                            echo "<td class='num'>" . $dato['cantidad'] . "</td>";
                            echo "<td class='num'>" . $dato['precio'] . " €</td>";
                            echo "<td><span class='badge badge-" . $dato['estado'] . "'>" . $dato['estado'] . "</span></td>";
                            echo "<td class='muted'>" . $dato['fecha_pedido'] . "</td>";
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