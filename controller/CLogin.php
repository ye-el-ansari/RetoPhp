<?php
require_once __DIR__."/../model/MLogin.php";
    class CLogin{
        private MLogin $model;
        public function __construct(){
            $this->model=new MLogin();
        }
        
        public function index(){
            require __DIR__."/../view/login/login.php";

        }
        public function login(){
            $user=isset($_POST['usuario']) ? $_POST['usuario']:null;
            $contrasena=isset($_POST['contrasena']) ? $_POST['contrasena']:null;
            $usuario=$this->model->hasPermission($user,$contrasena);
    if($usuario){
        session_start();
            $_SESSION['nombre']=$usuario['nombre'];
            $_SESSION['rol']=$usuario['rol'];
    header("Location: index.php?entity=producto&action=index");
    exit; //para detener la ejecucion
        }else{
            header("Location: index.php");
        }
    }
    }
?>