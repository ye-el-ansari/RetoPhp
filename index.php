<?php
// ============================================================
// index.php  ·  PUNTO DE ENTRADA ÚNICO de la aplicación (Front Controller)
// Todas las peticiones del navegador pasan primero por este archivo.
// ============================================================

// Cargamos el controlador jefe (el enrutador) que decide a dónde va cada petición
require_once __DIR__ . '/controller/CDestino.php';
// Le decimos al jefe que empiece a dirigir el tráfico
CDestino::enrutar();
