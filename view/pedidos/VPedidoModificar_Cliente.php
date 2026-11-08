<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: ../../index.php");
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
            <a class="brand" href="?entity=producto&amp;action=index" aria-label="techUP, inicio">
                <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 15l6-6 6 6" />
                    </svg></span>
                <span class="brand-name">tech<b>UP</b></span>
                <span class="brand-tag">Panel de gestión</span>
            </a>
            <nav class="nav" aria-label="Secciones">
                <a href="?entity=producto&amp;action=index">Productos</a>
                <a href="?entity=pedido&amp;action=index" class="is-active" aria-current="page">Pedidos</a>
                <a href="?entity=usuario&amp;action=index">Usuarios</a>
                <a href="?entity=carrito&amp;action=index">Carrito</a>
            </nav>
            <a class="logout" href="?entity=login&amp;action=index">Cerrar sesión</a>
        </div>
    </header>

    <main class="page page-narrow">
        <a href="?entity=pedido&action=index" class="back">← Volver a pedidos</a>
        <div class="page-head">
            <div>
                <h1>Editar pedido</h1>
                <p class="page-sub">Cambia el producto o la cantidad; el total se calcula solo.</p>
            </div>
        </div>

        <form method="post" action="index.php?entity=pedido&action=update&id=<?= $data['id_detalle'] ?>" class="panel form-card">
            <div class="form-grid">
                <div class="field full">
                    <label for="producto">Producto</label>
                    
                    <?php echo "<input name='producto' id='producto' class='select' disabled required value='".$data['producto_nombre']."'"; 
                  
                        
                    
                        ?>
                        
    
                    </input>
                </div>

                <div class="field">
                    <label for="cantidad">Cantidad</label>
                    <input name="cantidad" type="number" class="input" id="cantidad" value="<?= $data['cantidad'] ?>"
                        placeholder="Unidades" required min="1">
                </div>

                <div class="field">
                    <label for="precio">Total del pedido</label>
                    <div class="input-unit">
                        <input name="precio" type="number" class="input" id="precio" value="<?= $data['precio'] ?>"
                            required readonly>
                        <span class="unit">€</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="?entity=pedido&action=index" class="btn btn-secondary">Cancelar</a>
                <a href="?entity=pedido&action=update" >
                    <button type="submit" class="btn btn-primary">Guardar cambios</button></a>
                
            </div>
        </form>
    </main>

    <script>
        // JavaScript para actualizar el precio total en tiempo real

        const inputCantidad = document.getElementById('cantidad');
        const inputPrecio = document.getElementById('precio');

        // Guardamos el precio unitario original
        const precioUnitario = parseFloat(inputPrecio.value) / parseInt(inputCantidad.value);

        inputCantidad.addEventListener('change', function () {

            let cantidad = parseInt(this.value);

            // Calculamos el precio total
            let totalPantalla = precioUnitario * cantidad;

            // Mostramos el resultado con 2 decimales
            inputPrecio.value = totalPantalla.toFixed(2);

        });
    </script>
</body>

</html>