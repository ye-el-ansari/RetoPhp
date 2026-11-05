<?php
    class CLogin{
        public function __construct(){
            require __DIR__."\../model/MLogin.php";
        }
        
        public function index(){
            require_once __DIR__."\../view/login/login.php";

        }
        public function login(){
            $usuario=isset($_POST['usuario']) ? $_POST['usuario']:null;
            $contrasena=isset($_POST['contrasena']);
        }
    }
?>