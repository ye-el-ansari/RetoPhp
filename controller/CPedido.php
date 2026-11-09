<?php

require_once __DIR__ . "/../model/MPedidos.php";
require_once __DIR__ . "/../model/MProductos.php";
class CPedido
{
    private MPedidos $model;
    private MProductos $modelProducto;
    public function __construct()
    {
        $this->model = new MPedidos();
    }
    public function index($id, $rol, $id_usuario)
    {
        if ($rol === 0) {
            $pedido = $this->model->getAll();
            require_once __DIR__ . "/../view/pedidos/VPedidoAdmin.php";
        } else {
            $pedido = $this->model->getpedidoUsuario($id_usuario);
            require __DIR__ . "/../view/pedidos/VPedidoCliente.php";
        }
    }
    public function show($id, $rol, $id_usuario)
    {
        /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */

        if ($rol === 0) {

            $data = $this->model->getPedidoById($id);
            require __DIR__ . "/../view/pedidos/VPedidoVerAdmin.php";

        } else {

            $data = $this->model->getPedidoById($id);
            require __DIR__ . "/../view/pedidos/VPedidoVerCliente.php";
        }


    }

    public function edit($id, $rol, $id_usuario)
    {

        if ($rol === 0) {



            $data = $this->model->getPedidoById($id);
            $pedido = $this->model->getPedido();

            require_once __DIR__ . "/../view/pedidos/VPedidoModificarAdmin.php";


        } else {

            $data = $this->model->getDetalleById($id);
            $pedido = $this->model->getPedido();

            require_once __DIR__ . "/../view/pedidos/VPedidoModificarCliente.php";
        }
    }


    function update($id, $rol, $id_usuario)
    {

        if ($rol === 0) {

            $estado = isset($_POST['estado']) ? $_POST['estado'] : null;


            $this->model->updatePedido(
                $estado,
                $id
            );

            header("Location: index.php?entity=pedido&action=index&rol=0");
            exit();
        } else {

            $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : null;



            $this->model->updateCliente(
                $cantidad,
                $precio,
                $id
            );

            header("Location: index.php?entity=pedido&action=index&rol=1");
            exit();
        }
    }
}
