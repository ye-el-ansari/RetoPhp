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
    <title>Alta de producto · techUP</title>
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
            <a href="?entity=producto&amp;action=index" class="is-active" aria-current="page">Productos</a>
            <a href="?entity=pedido&amp;action=index">Pedidos</a>
            <a href="?entity=usuario&amp;action=index">Usuarios</a>
            <a href="?entity=carrito&amp;action=index">Carrito</a>
            </nav>
            <a class="logout" href="?entity=login&amp;action=index">Cerrar sesión</a>
        </div>
    </header>

    <main class="page page-narrow">
        <a href="?entity=producto&action=index" class="back">← Volver a productos</a>
        <div class="page-head">
            <div>
                <h1>Alta de producto</h1>
                <p class="page-sub">Completa los datos para añadirlo al catálogo.</p>
            </div>
        </div>

        <form method="post" action="index.php?action=store" class="panel form-card">
            <fieldset>
                <legend>Información del producto</legend>
                <div class="form-grid">
                    <div class="field full">
                        <label for="nombre">Nombre del producto</label>
                        <input name="nombre" type="text" class="input" id="nombre" placeholder="Ej. Tarjeta gráfica RTX 4070" required>
                    </div>
                    <div class="field">
                        <label for="categoria">Categoría</label>
                        <input name="categoria" type="text" class="input" id="categoria" placeholder="Ej. Tarjetas gráficas" required>
                    </div>
                    <div class="field">
                        <label for="marca">Marca</label>
                        <input name="marca" type="text" class="input" id="marca" placeholder="Ej. NVIDIA" required>
                    </div>
                    <div class="field">
                        <label for="modelo">Modelo</label>
                        <input name="modelo" type="text" class="input" id="modelo" placeholder="Ej. RTX 4070" required>
                    </div>
                    <div class="field">
                        <label for="precio">Precio</label>
                        <div class="input-unit"><input name="precio" type="number" class="input" id="precio" step="0.01" min="0" placeholder="0.00" required><span class="unit">€</span></div>
                    </div>
                    <div class="field">
                        <label for="stock">Stock</label>
                        <div class="input-unit"><input name="stock" type="number" class="input" id="stock" step="0.01" min="0" placeholder="Unidades" required><span class="unit">uds</span></div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Peso y dimensiones</legend>
                <div class="form-grid">
                    <div class="field">
                        <label for="peso">Peso</label>
                        <div class="input-unit"><input name="peso" type="number" class="input" id="peso" step="0.01" min="0" placeholder="0" required><span class="unit">g</span></div>
                    </div>
                    <div class="field">
                        <label for="altura">Altura</label>
                        <div class="input-unit"><input name="altura" type="number" class="input" id="altura" step="0.01" min="0" placeholder="0" required><span class="unit">mm</span></div>
                    </div>
                    <div class="field">
                        <label for="ancho">Ancho</label>
                        <div class="input-unit"><input name="ancho" type="number" class="input" id="ancho" step="0.01" min="0" placeholder="0" required><span class="unit">mm</span></div>
                    </div>
                    <div class="field">
                        <label for="profundidad">Profundidad</label>
                        <div class="input-unit"><input name="profundidad" type="number" class="input" id="profundidad" step="0.01" min="0" placeholder="0" required><span class="unit">mm</span></div>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a href="?entity=producto&action=index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Dar de alta</button>
            </div>
        </form>
    </main>
</body>

</html>
