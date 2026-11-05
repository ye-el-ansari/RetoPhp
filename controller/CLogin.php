<?php
    class CLogin{
        private MLogin $model;
        public function __construct(){
            $this->model->MLogin();
        }
        
        public function index(){
            require_once __DIR__."\../view/login/login.php";
            require __DIR__."\../model/MLogin.php";

        }
        public function login(){
            $user=isset($_POST['usuario']) ? $_POST['usuario']:null;
            $contrasena=isset($_POST['contrasena']) ? $_POST['contrasena']:null;
            $this->model->MLogin();
        }
    }
?>