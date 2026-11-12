
<?php 

// ============================================================
// db/Conectar.php  ·  Clase de conexión a la base de datos
// Centraliza la conexión para que todos los modelos usen la misma.
// ============================================================
class ConexionBD{
    // Método estático: se puede usar sin crear un objeto -> ConexionBD::conectar()
    public static function conectar(){
        // Parámetros: servidor, usuario, contraseña, nombre de la base de datos
        $conexion = new mysqli("127.0.0.1","root","","tienda_informatica");
        // Fuerza la codificación UTF-8 para que tildes y ñ se guarden/lean bien
        $conexion -> query("SET NAMES 'UTF8' ");
        // Devolvemos la conexión abierta a quien la pida (los modelos)
        return $conexion;
    }
}
