<?php

require_once __DIR__ . "/../model/MPedidos.php";
require_once __DIR__ . "/../model/MProductos.php";
class CPedido
{
    private MPedidos $model;
    public function __construct()
    {
        $this->model = new MPedidos();
    }
    public function index()
    {
        $pedido = $this->model->getAll();
        require_once __DIR__ . "/../view/pedidos/VPedidoIndex_Admin.php";
    }

    public function show($id)
    {

        $data = $this->model->getPedidoById($id);

       
        require_once __DIR__ . "/../view/pedidos/VPedidoVer.php";
    }

    public function edit($id)
    {


        $data = $this->model->getPedidoById($id);
        $pedido = $this->model->getPedido();

        /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */

        require_once __DIR__ . "/../view/pedidos/VPedidoModificar_Admin.php";
    }
    

    
   /* UPDATE PARA CLIENTE 
   public function update($id)
    {

        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
        $precio = isset($_POST['precio']) ? $_POST['precio'] : null;

 

        $this->model->updateCliente(
            $cantidad,
            $precio,
            $id
        );

        header("Location: index.php?entity=pedido&action=index");
        exit();

    } */



         /* UPDATE PARA ADMIN */

        public function update($id)
    {

        $estado = isset($_POST['estado']) ? $_POST['estado'] : null;


        $this->model->updatePedido(
            $estado,
            $id
        );

        header("Location: index.php?entity=pedido&action=index");
        exit();

    }

}
