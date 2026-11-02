<?php
// Cargamos el controlador jefe
require_once __DIR__ . '/controller/CDestinoCaballeros.php';

// Le decimos al jefe que empiece a dirigir el tráfico
CDestino::enrutar();
