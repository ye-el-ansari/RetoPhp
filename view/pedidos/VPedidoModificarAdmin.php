<?php
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
    <title>Editar pedido · techUP</title>
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
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
                <a href="?entity=producto&amp;action=index&rol=0">Productos</a>
                <a href="?entity=pedido&amp;action=index&rol=0" class="is-active" aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=index&rol=0">Usuarios</a>
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

        <a href="?entity=pedido&action=index&rol=0" class="back">← Volver a pedidos</a>

        <div class="page-head">
            <div>
                <h1>Editar pedido</h1>
                <p class="page-sub">Editar el estado de envio del pedido</p>
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

                $precio_unitario = $pedido['precio_compra'] / $pedido['cantidad'];

                echo "<p><strong>Precio: </strong> " . number_format($precio_unitario, 2) . "€</p>";

                echo "<p><strong>Subtotal: </strong> " . $pedido['precio_compra'] . "€</p>";
                echo "</div>";

                $total += $pedido['cantidad'] * $precio_unitario;

            }

            echo "<p><strong>Total: </strong> " . $total . "€</p>";

            ?>
        </section>



        <?php
        echo '<br><br><div class="page-head">';
        echo '<div>';
        echo "<h3>Estado del pedido: " . $data[0]['estado'] . "</h1>";
        echo '</div>';
        echo '</div>';
        ?>

        <form method="post" action="index.php?entity=pedido&action=update&rol=0&id=<?= $data[0]['numero_pedido'] ?>"
            class="panel form-card">
            <div class="form-grid">
                <div class="field">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" class="input">
                        <option value="pendiente" <?= $data[0]['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente
                        </option>
                         <option value="pendiente" <?= $data[0]['estado'] == 'pagado' ? 'selected' : '' ?>>Pagado
                        </option>
                        <option value="confirmado" <?= $data[0]['estado'] == 'confirmado' ? 'selected' : '' ?>>Confirmado
                        </option>
                        <option value="enviado" <?= $data[0]['estado'] == 'enviado' ? 'selected' : '' ?>>Enviado</option>
                        <option value="entregado" <?= $data[0]['estado'] == 'entregado' ? 'selected' : '' ?>>Entregado
                        </option>
                        <option value="cancelado" <?= $data[0]['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado
                        </option>
                    </select>
                </div>

            </div>
            <div class="form-actions">

                <a href="?entity=pedido&action=index&rol=0" class="btn btn-secondary">Cancelar</a>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>

            </div>

        </form>

    </main>

</body>

</html>