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
    public function index()
    {
        $pedido = $this->model->getAll();
        require_once __DIR__ . "/../view/pedidos/VPedidoIndex.php";
    }

    public function show($id, $rol,$id_usuario)
    {
        /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */
        if ($rol === 0) {
            $pedido = $this->model->getPedidoById($id);
            require __DIR__ . "/../view/pedidos/VPedidoVer.php";
        } else {
            $pedido = $this->model->getpedidoUsuario($id_usuario);
            require __DIR__ . "/../view/pedidos/VPedidoUsuario.php";
        }
    }

    public function edit($id)
    {

        $this->modelProducto = new MProductos;
        $productos = $this->modelProducto->getAll();

        $data = $this->model->getDetalleById($id);

        require_once __DIR__ . "/../view/pedidos/VPedidoModificar.php";

        /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */
    }
    function update($id)
    {
        $estado = isset($_POST["estado"]) ? $_POST["estado"] : "cancelado";
        if ($this->model->edit($id, $estado)) {
            $this->index();
            exit;
        }
        require_once __DIR__ . "/../view/pedidos/VPedidoModificar.php";
    }
}
