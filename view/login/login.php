<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · techUP</title>
    <link rel="stylesheet" href="view/styles.css">
</head>

<body class="auth">
    <aside class="auth-aside">
        <div class="brand">
            <span class="brand-mark" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#12151e" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6-6 6 6"/></svg></span>
            <span class="brand-name">tech<b>UP</b></span>
        </div>
        <div>
            <h2 class="auth-slogan">Tu Hardware, Un Nivel Más Arriba</h2>
            <p class="auth-lead">Panel de gestión de productos, pedidos y usuarios de la tienda.</p>
        </div>
    </aside>

    <main class="auth-main">
        <div class="auth-card">
            <h1>Iniciar sesión</h1>
            <p class="page-sub">Accede con tu usuario para gestionar la tienda.</p>

            <form action="index.php?action=login" method="POST">
                <div class="field">
                    <label for="usuario">Nombre de usuario</label>
                    <input type="text" class="input" id="usuario" name="usuario" autocomplete="username" required>
                </div>
                <div class="field">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" class="input" id="contrasena" name="contrasena" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>

            <div class="hint">
                <p>Usuarios: Carlos, Laura, Javier, Ana</p>
                <p>Pass: del 1 al 4</p>
            </div>
        </div>
    </main>
</body>

</html>
