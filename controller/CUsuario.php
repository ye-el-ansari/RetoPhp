<?php
require_once __DIR__ . "/../model/MUsuario.php";

class CUsuario{
    private $model;

    function __construct(){
        $this->model=new MUsuario();
        
    }

    function index(){
       $usuario= $this->model->getAll();
       require  __DIR__ .  "/../view/usuarios/VUsuariosIndex.php";
    }

    function show($id,$rol){
        $usuario=$this->model->getUsuario($id);
        require __DIR__ .  "/../view/usuarios/VUsuarioCuenta.php";
    }
}

?>