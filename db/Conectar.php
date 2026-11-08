
<?php 

class ConexionBD{
    public static function conectar(){
        $conexion = new mysqli("127.0.0.1","root","","tienda_informatica");
        $conexion -> query("SET NAMES 'UTF8' ");
        return $conexion;
    }
}