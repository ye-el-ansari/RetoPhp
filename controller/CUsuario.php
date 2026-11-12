<?php
// ============================================================
// controller/CUsuario.php  ·  CONTROLADOR de usuarios
// ============================================================
require_once __DIR__ . "/../model/MUsuario.php";

class CUsuario{
    // Modelo que accede a la tabla usuarios
    private $model;

    function __construct(){
        $this->model=new MUsuario();
        
    }

    // Lista todos los usuarios (vista del administrador)
    function index(){
       $usuario= $this->model->getAll();
       require  __DIR__ .  "/../view/usuarios/VUsuariosIndex.php";
    }

    // Muestra los datos de un usuario concreto ("Mi Cuenta")
    function show($id,$rol){
        $usuario=$this->model->getUsuario($id);
        require __DIR__ .  "/../view/usuarios/VUsuarioCuenta.php";
    }
}

?>
