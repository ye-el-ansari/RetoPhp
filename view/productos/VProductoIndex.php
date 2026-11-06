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
    <title>Lista de Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <a href="?entity=login&action=index" class="btn btn-secondary">Logout</a>
<div class="container mt-5">
    <a href="?entity=carrito&action=index" class="btn btn-primary">Ver Carrito</a>
    <a href="?entity=usuario&action=index" class="btn btn-primary">Ver Usuarios</a>
    <a href="?entity=pedido&action=index" class="btn btn-primary">Ver Pedidos</a>
</div>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Lista de Productos</h1>

        <table class="table table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Stock</th>
                    <!--<th scope="col">Arma</th>
                     <th scope="col">Escudo</th> -->
                     
                     <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de caballero -->


                <?php
                foreach ($productos as $dato) {
                    echo "<tr>
                        
                            <td>" . $dato['id_producto'] . "</td>";
                    echo "<td>" . $dato['nombre'] . "</td>";
                    echo "<td>" . $dato['categoria'] . "</td>";
                    echo "<td>" . $dato['marca'] . "</td>";
                    echo "<td>" . $dato['modelo'] . "</td>";
                    echo "<td>" . $dato['precio'] . "</td>";
                    echo "<td>" . $dato['stock'] . "</td>";
                   
                   /* echo "<td>" . $dato['id_arma'] . "</td>";
                    echo "<td>" . $dato['id_escudo'] . "</td>";
*/

                    echo "<td>
                        <a href='?entity=producto&action=show&id=" . $dato['id_producto'] . "' class='btn btn-info btn-sm'>Ver</a>
                        <a href='?entity=producto&action=edit&id=" . $dato['id_producto'] . "' class='btn btn-warning btn-sm'>Modificar</a>
                        <a href='?entity=producto&action=destroy&id=" . $dato['id_producto'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                            </td>
                            
                            </tr>";
                }
                ?>



                <!-- Agrega más filas según sea necesario -->
            </tbody>
        </table>

        <a href="?entity=producto&action=create" class="btn btn-primary">Crear Nuevo Producto</a>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>