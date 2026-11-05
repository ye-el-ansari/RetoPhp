<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Caballeros</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <a href="?entity=login&action=index" class="btn btn-secondary">Logout</a>
    <div class="container mt-5">
        <a href="?entity=carrito&action=index" class="btn btn-primary">Ver Carrito</a>
        <a href="?entity=usuario&action=index" class="btn btn-primary">Ver Usuarios</a>
        <a href="?entity=producto&action=index" class="btn btn-primary">Ver Productos</a>
    </div>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Lista de Pedidos</h1>

        <table class="table table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">Numero del pedido</th>
                    <th scope="col">Nombre del producto</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ultimo_pedido = null; // Variable para recordar el pedido anterior, empieza en null por que no hay pedido anterior al inicio


                foreach ($pedido as $dato) {
                    echo "<tr>";

                    // Si el pedido actual es igual al anterior, dejamos la celda vacía
                    if ($dato['numero_pedido'] == $ultimo_pedido) {
                        echo "<td></td>"; // Número vacío
                        echo "<td>" . $dato['producto_nombre'] . "</td>";
                        echo "<td></td>"; // Usuario vacío
                        echo "<td>" . $dato['cantidad'] . "</td>";
                        echo "<td>$" . $dato['precio'] . "</td>";
                        echo "<td></td>"; // Estado vacío
                        echo "<td></td>"; // Fecha vacía
                        echo "<td>
                        <a href='index.php?entity=pedido&action=edit&id=" . $dato['id_detalle'] . "' 
                        class='btn btn-warning btn-sm'>Modificar</a> 
                        <a href='index.php?entity=pedido&action=destroy&id=" . $dato['id_detalle'] . "' 
                        class='btn btn-danger btn-sm'>Eliminar</a>
                        </td>"; // Acciones vacías
                    } else {
                        // Si es un pedido nuevo, mostramos todos los datos normalmente
                        echo "<td><strong>" . $dato['numero_pedido'] . "</strong></td>";
                        echo "<td>" . $dato['producto_nombre'] . "</td>";
                        echo "<td>" . $dato['usuario_nombre'] . "</td>";
                        echo "<td>" . $dato['cantidad'] . "</td>";
                        echo "<td>$" . $dato['precio'] . "</td>";
                        echo "<td>" . $dato['estado'] . "</td>";
                        echo "<td>" . $dato['fecha_pedido'] . "</td>";
                        echo "<td>
                       <a href='index.php?entity=pedido&action=show&id=" . $dato['numero_pedido'] . "' class='btn btn-info btn-sm'>Ver</a>
                       <br>
                        <a href='index.php?entity=pedido&action=edit&id=" . $dato['id_detalle'] . "' 
                        class='btn btn-warning btn-sm'>Modificar</a> 
                        <a href='index.php?entity=pedido&action=destroy&id=" . $dato['id_detalle'] . "' 
                        class='btn btn-danger btn-sm'>Eliminar</a>
                        
                      </td>";
                    }

                    echo "</tr>";

                    // Guardamos este número de pedido para compararlo en la siguiente vuelta
                    $ultimo_pedido = $dato['numero_pedido'];
                }
                ?>
            </tbody>
        </table>

        <a href="?entity=pedido&action=create" class="btn btn-primary">Crear Nuevo Pedido</a>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>