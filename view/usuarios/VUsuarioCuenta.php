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
    <title>Usuarios · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="?entity=producto&amp;action=index" aria-label="techUP, inicio">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6-6 6 6"/></svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel del Usuario</span>
            </a>
            <nav class="nav" aria-label="Secciones">
             <a href="?entity=pedido&amp;action=show&amp;rol=1&amp;id=<?= $_SESSION["id"] ?>" class="is-active" aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=show&amp;id=<?= $_SESSION["id"] ?>&amp;rol=1">Mi Cuenta</a>
            
            </nav>
             <span class="page-sub"> Hola  <?=$_SESSION["nombre"] ?></span>
            <a class="logout" href="?entity=login&amp;action=index">Cerrar sesión</a>
        </div>
    </header>

    <main class="page">
        <div class="page-head">
            <div>
                <h1>Mi Cuenta</h1>
                <p class="page-sub">Datos Personales.</p>
            </div>
        </div>

        <div class="panel table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Email</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($usuario as $datos) {

                        echo "<tr>";
                        echo "<td class='muted'>" . $datos['id_usuario'] . "</td>";
                        echo "<td class='strong'>" . $datos['nombre'] . "</td>";
                        echo "<td>" . $datos['apellidos'] . "</td>";
                        echo "<td>" . $datos['email'] . "</td>";
                        echo "<td>" . $datos['telefono'] . "</td>";
                        echo "<td class='muted'>" . $datos['fecha_registro'] . "</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
