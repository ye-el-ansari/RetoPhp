
<?php 

class ConexionBD{
    public static function conectar(){
        $conexion = new mysqli("localhost","root","","tienda_informatica");
        $conexion -> query("SET NAMES 'UTF8' ");
        return $conexion;
    }
}