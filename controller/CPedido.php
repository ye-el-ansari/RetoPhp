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

    public function show($id)
    {

        $data = $this->model->getPedidoById($id);

       /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */
        require_once __DIR__ . "/../view/pedidos/VPedidoVer.php";
    }

    public function edit($id)
    {

        $this->modelProducto = new MProductos;
        $productos = $this->modelProducto->getAll();

        $data = $this->model->getDetalleById($id);

        /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */

        require_once __DIR__ . "/../view/pedidos/VPedidoModificar.php";
    }

}
