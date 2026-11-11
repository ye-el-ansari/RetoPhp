<?php
class MPedidos
{
    private $db;
    private $data;
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }

    public function getPedidoById($id)
    { {
            // Recojo todo lo que tenga el numero de pedido que le paso por parametro

            $consulta = $this->db->prepare("SELECT 
            detalles_pedido.id_detalle,
        detalles_pedido.id_pedido AS numero_pedido,
        productos.nombre AS producto_nombre,
        usuarios.nombre AS usuario_nombre, 
        detalles_pedido.cantidad,
        detalles_pedido.precio_compra ,
        productos.precio AS precio,
        pedidos.estado, pedidos.fecha_pedido     
        FROM detalles_pedido INNER JOIN productos  
        ON detalles_pedido.id_producto = productos.id_producto
        INNER JOIN pedidos  ON detalles_pedido.id_pedido = pedidos.id_pedido
        INNER JOIN usuarios  ON pedidos.id_usuario = usuarios.id_usuario
        WHERE detalles_pedido.id_pedido = ?
    ");

            $consulta->bind_param("i", $id);
            $consulta->execute();

            $resultado = $consulta->get_result();

            // Almacenamos el array asociativo en una variable
            while ($filas = $resultado->fetch_assoc()) {
                $this->data[] = $filas;
            }

            // Buena práctica: Cerrar la consulta para liberar memoria
            $consulta->close();

            // Retorna el array con los datos o null si no se encontró el producto
            return $this->data;
        }
    }


    public function getDetalleById($id)
    { {
            // Recojo todo lo que tenga el numero de pedido que le paso por parametro

            $consulta = $this->db->prepare("SELECT 
            detalles_pedido.id_producto,
            detalles_pedido.id_detalle,
        detalles_pedido.id_pedido AS numero_pedido,
        productos.nombre AS producto_nombre,
        usuarios.nombre AS usuario_nombre, detalles_pedido.cantidad,
        detalles_pedido.precio_compra AS precio ,
        productos.precio AS precio_producto ,
        pedidos.estado, pedidos.fecha_pedido     
        FROM detalles_pedido INNER JOIN productos  
        ON detalles_pedido.id_producto = productos.id_producto
        INNER JOIN pedidos  ON detalles_pedido.id_pedido = pedidos.id_pedido
        INNER JOIN usuarios  ON pedidos.id_usuario = usuarios.id_usuario
        WHERE detalles_pedido.id_detalle = ? 
    ");

            $consulta->bind_param("i", $id);
            $consulta->execute();

            $resultado = $consulta->get_result();

            // Almacenamos el array asociativo en una variable
            $filas = $resultado->fetch_assoc();

            // Buena práctica: Cerrar la consulta para liberar memoria
            $consulta->close();

            // Retorna el array con los datos o null si no se encontró el producto
            return $filas;
        }
    }


    public function getAll()
    {
        $consulta = $this->db->query("SELECT 
         detalles_pedido.id_detalle,
        detalles_pedido.id_pedido AS numero_pedido,
        productos.nombre AS producto_nombre,
        usuarios.nombre AS usuario_nombre, detalles_pedido.cantidad,
        detalles_pedido.precio_compra,
        productos.precio AS precio_producto ,
        pedidos.estado, pedidos.fecha_pedido     
        FROM detalles_pedido INNER JOIN productos  
        ON detalles_pedido.id_producto = productos.id_producto
        INNER JOIN pedidos  ON detalles_pedido.id_pedido = pedidos.id_pedido
        INNER JOIN usuarios  ON pedidos.id_usuario = usuarios.id_usuario
        ORDER BY detalles_pedido.id_pedido;
    ");

        while ($filas = $consulta->fetch_assoc()) {

            $this->data[] = $filas;
        }
        $consulta->close();
        return $this->data;
    }


    //NUEVO
    function getpedidoUsuario($id_usuario)
    {
        $query = $this->db->prepare("SELECT 
            detalles_pedido.id_detalle,
        detalles_pedido.id_pedido AS numero_pedido,
        productos.nombre AS producto_nombre,
        usuarios.nombre AS usuario_nombre, detalles_pedido.cantidad,
        detalles_pedido.precio_compra,
        productos.precio AS precio_producto ,
        pedidos.estado, pedidos.fecha_pedido        
        FROM detalles_pedido INNER JOIN productos  
        ON detalles_pedido.id_producto = productos.id_producto
        INNER JOIN pedidos  ON detalles_pedido.id_pedido = pedidos.id_pedido
        INNER JOIN usuarios  ON pedidos.id_usuario = usuarios.id_usuario
        where usuarios.id_usuario=?
         ORDER BY detalles_pedido.id_pedido
         ;");
        $query->bind_param("i", $id_usuario);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getPedido()
    {
        $consulta = $this->db->query("SELECT 
         *    
        FROM  pedidos  ;
    ");

        while ($filas = $consulta->fetch_assoc()) {

            $this->data[] = $filas;
        }
        $consulta->close();
        return $this->data;
    }

    public function updateCliente(
        $cantidad,
        $precio,
        $id
    ) {
        $consulta = $this->db->prepare(
            'UPDATE detalles_pedido 
        SET cantidad = ?, precio_compra = ?
        WHERE id_detalle = ?'


        );
        $consulta->bind_param('iii', $cantidad, $precio, $id);
        $consulta->execute();


        /* --- ACTUALIZAR LA LINEA DE ARRIBA CON ESTA AL TERMINAR ------
            UPDATE detalles_pedido
            INNER JOIN pedidos  ON detalles_pedido.id_pedido = pedidos.id_pedido
            SET detalles_pedido.cantidad = ?,  detalles_pedido.precio_compra = ?
            WHERE detalles_pedido.id_detalle = ? AND pedidos.estado = 'pendiente'; */
    }


    public function updatePedido(
        $estado,
        $id
    ) {
        $consulta = $this->db->prepare(
            'UPDATE pedidos 
        SET estado = ?
        WHERE id_pedido = ?'


        );
        $consulta->bind_param('si', $estado, $id);
        $consulta->execute();
    }



     // borra el pedido el cual sea PENDIENTE de un usuario.
    public function destroy($id_pedido, $id_usuario)
    {
        $query = $this->db->prepare("DELETE FROM pedidos
        WHERE id_pedido = ?
        AND id_usuario = ?
        AND estado = 'pendiente'");

        $query->bind_param("ii", $id_pedido, $id_usuario);
        $query->execute();
    }



    // Funcion para crear un pedido con estado PENDIENTE y la fecha y hora de hoy 
    public function crearPedido($id_usuario)
    {
        $query = $this->db->prepare("INSERT INTO pedidos
        (id_usuario, fecha_pedido, estado)
        VALUES (?, NOW(), 'pendiente')");

        $query->bind_param("i", $id_usuario);
        $query->execute();
    }



    // busca si el usuario tiene un pedido en estado pendiente, aunque todavía no tenga ningún producto añadido.
    function getPedidoPendienteUsuario($id_usuario)
    {
        $query = $this->db->prepare("SELECT *
        FROM pedidos
        WHERE id_usuario = ?
        AND estado = 'pendiente'");

        $query->bind_param("i", $id_usuario);
        $query->execute();

        $result = $query->get_result();

        return $result->fetch_assoc();
    }


    // Con esta funcion muestro los detalles del pedido PENDIENTE del usuario
    function getPedidoPendiente($id_usuario)
    {
        $query = $this->db->prepare("SELECT 
        detalles_pedido.id_detalle,
        detalles_pedido.id_pedido AS numero_pedido,
        productos.nombre AS producto_nombre,
        detalles_pedido.cantidad,
        detalles_pedido.precio_compra,
        productos.precio AS precio_producto,
        pedidos.estado,
        pedidos.fecha_pedido

        FROM detalles_pedido

        INNER JOIN productos
        ON detalles_pedido.id_producto = productos.id_producto

        INNER JOIN pedidos
        ON detalles_pedido.id_pedido = pedidos.id_pedido

        WHERE pedidos.id_usuario = ?
        AND pedidos.estado = 'pendiente'

        ORDER BY detalles_pedido.id_pedido");

        $query->bind_param("i", $id_usuario);
        $query->execute();

        $result = $query->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function addProductoPedido($id_pedido, $id_producto, $cantidad)
    {
        // Obtener precio del producto que vamos a añadir al carrito
        $query = $this->db->prepare("SELECT precio FROM productos WHERE id_producto = ?");
        $query->bind_param("i", $id_producto);
        $query->execute();

        // recogemos el precio de ese producto
        $result = $query->get_result();
        $producto = $result->fetch_assoc();

        // Calculamos el total, la cantidad elegida por el usuario * el precio del producto que eligio.
        $precio = $producto['precio'] * $cantidad;

        // Insertamos el producto, su cantidad, y precio de compra
        $query = $this->db->prepare("INSERT INTO detalles_pedido
        (id_pedido, id_producto, cantidad, precio_compra)
        VALUES (?, ?, ?, ?)");

        $query->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio);
        $query->execute();
    }

    // cuando el usuario finalice su pedido, pasara a ser de PENDIENTE a PAGADO
    public function comprar($id_usuario)
    {
        $query = $this->db->prepare("UPDATE pedidos
        SET estado = 'confirmado'
        WHERE id_usuario = ?
        AND estado = 'pendiente'");

        $query->bind_param("i", $id_usuario);
        $query->execute();
    }
}
