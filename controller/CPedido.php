<?php
// ============================================================
// controller/CPedido.php  ·  CONTROLADOR de pedidos y carrito
// Distingue entre administrador (rol 0) y cliente (rol 1).
// El "carrito" es un pedido en estado 'pendiente'.
// ============================================================

require_once __DIR__ . "/../model/MPedidos.php";
require_once __DIR__ . "/../model/MProductos.php";
class CPedido
{
    // Modelo de pedidos y modelo de productos (para el catálogo del carrito)
    private MPedidos $model;
    private MProductos $modelProducto;
    public function __construct()
    {
        $this->model = new MPedidos();
        $this->modelProducto = new MProductos();
    }
    // Listado de pedidos: el admin ve todos, el cliente solo los suyos
    public function index($id, $rol, $id_usuario)
    {
        if ($rol === 0) {
            // Administrador: todos los pedidos
            $pedido = $this->model->getAll();
            require_once __DIR__ . "/../view/pedidos/VPedidoAdmin.php";

        } else {
            // Cliente: solo los pedidos de su usuario
            $pedido = $this->model->getpedidoUsuario($id_usuario);
            require __DIR__ . "/../view/pedidos/VPedidoCliente.php";
        }
    }
    // Detalle de un pedido (líneas, estado, total)
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

    // Formulario de edición: admin cambia el estado, cliente cambia la cantidad de una línea
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


    // Guarda los cambios del formulario de edición
    function update($id, $rol, $id_usuario)
    {

        if ($rol === 0) {

            // Admin: solo cambia el estado del pedido
            $estado = isset($_POST['estado']) ? $_POST['estado'] : null;


            $this->model->updatePedido(
                $estado,
                $id
            );

            header("Location: index.php?entity=pedido&action=index&rol=0");
            exit();
        } else {

            // Cliente: cambia cantidad y precio total de una línea del pedido
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



    // borra el pedido el cual sea PENDIENTE
    public function destroy()
    {
        // Usuario logueado y pedido a eliminar (llega por POST desde el carrito)
        $id_usuario = $_SESSION['id'];
        $id_pedido = $_POST['id_pedido'];

        // valida que hayan productos dentro del pedido pendiente.
        $pedido = $this->model->getPedidoPendiente($id_usuario);
        if (!empty($pedido)) { // si tiene productos dentro
            $this->model->destroy($id_pedido, $id_usuario);
            header("Location: index.php?entity=pedido&action=index&rol=1");
            exit();

        } else { // si no tiene productos

            header("Location: index.php?entity=pedido&action=carrito&rol=1");
            exit();
        }



    }

    // Elimina una linea concreta de un pedido pendiente.
    public function destroyLinea($id)
    {
        // Usuario logueado y linea que queremos eliminar
        $id_usuario = $_SESSION['id'];

        // Comprobamos que el usuario tenga un pedido pendiente
        $pedido = $this->model->getPedidoPendienteUsuario($id_usuario);

        if (!empty($pedido)) {

            // Eliminamos la linea del pedido
            $this->model->destroyLinea($id, $pedido['id_pedido'], $id_usuario);

            // Volvemos al carrito
            header("Location: index.php?entity=pedido&action=carrito&rol=1");
            exit();

        } else {

            // Si no tiene pedido pendiente, volvemos al carrito
            header("Location: index.php?entity=pedido&action=carrito&rol=1");
            exit();
        }
    }


    // FUNCIONES DEL CARRITO
    // Muestra el carrito: pedido pendiente + sus líneas + catálogo para añadir
    public function carrito()
    {
        $id_usuario = $_SESSION['id'];

        //Busca el pedido PENDIENTE de un usuario
        $pedidoPendiente = $this->model->getPedidoPendienteUsuario($id_usuario);


        //Si el pedido no existe, lo creamos.
        if ($pedidoPendiente == null) {
            $this->model->crearPedido($id_usuario);
            //lo volvemos a llamar.
            $pedidoPendiente = $this->model->getPedidoPendienteUsuario($id_usuario);
        }

        //Trae la linea de pedidos de ese pedido/usuario
        $pedido = $this->model->getPedidoPendiente($id_usuario);

        //Trae todos los productos
        $productos = $this->modelProducto->getAll();

        require_once __DIR__ . "/../view/carrito/VCarrito.php";


    }


    // funcion para añadir un producto al pedido.
    public function anyadirProducto()
    {
        $id_usuario = $_SESSION['id'];

        // Traemos el producto y la cantidad.
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];

        // Buscamos el pedido pendiente del usuario
        $pedido = $this->model->getPedidoPendienteUsuario($id_usuario);

        // si el pedido existe
        if ($pedido != null) {

            $id_pedido = $pedido['id_pedido'];

            // Añadimos el producto al pedido
            $this->model->addProductoPedido($id_pedido, $id_producto, $cantidad);
        }

        // Recargamos el carrito
        header("Location: index.php?entity=pedido&action=carrito&rol=1");
        exit();
    }


    // Finaliza la compra: cambia el estado del pedido pendiente
    public function comprar()
    {
        $id_usuario = $_SESSION['id'];

        // valida que hayan productos dentro del pedido
        // comprueba que no pedido no este vacio
        $pedido = $this->model->getPedidoPendiente($id_usuario);
        if (!empty($pedido)) {
            $this->model->comprar($id_usuario);
            header("Location: index.php?entity=pedido&action=index&rol=1");
            exit();

        } else {

            header("Location: index.php?entity=pedido&action=carrito&rol=1");
            exit();
        }


    }
}
