<?php
// Muestra (una sola vez) el aviso que un controlador dejó en $_SESSION['aviso'] tras una acción CRUD.
// Se incluye al final del <body> de las vistas que reciben la redirección.
if (!empty($_SESSION['aviso'])) {
    echo "<script>alert(" . json_encode($_SESSION['aviso']) . ");</script>";
    unset($_SESSION['aviso']);
}
?>
