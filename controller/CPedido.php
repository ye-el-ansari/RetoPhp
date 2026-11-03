<?php
    class CPedido{
        public function __construct(){
            $this->model=new MPedidos();
        }
        public function index(){
           $pedidos=$this->model->getAll();
           require_once __DIR__."\../view/pedidos/VPedidoIndex.php";
        }
    }
?>