<?php

require_once __DIR__ . "/../model/MPedidos.php";
    class CPedido{
        private MPedidos $model;
        public function __construct(){
            $this->model=new MPedidos();
        }
        public function index(){
           $pedido=$this->model->getAll();
           require_once __DIR__."\../view/pedidos/VPedidoIndex.php";
        }
    }
?>