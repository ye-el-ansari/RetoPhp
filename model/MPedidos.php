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
        usuarios.nombre AS usuario_nombre, detalles_pedido.cantidad,
        detalles_pedido.precio_compra AS precio ,
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
        detalles_pedido.precio_compra AS precio ,
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

    public function update(
        $id,
        $nombre,
        $categoria,
        $marca,
        $modelo,
        $precio,
        $stock,
        $peso,
        $alto,
        $ancho,
        $profundidad
    ) {
        $consulta = $this->db->prepare('UPDATE productos 
        SET nombre = ?, categoria = ?, marca = ?, modelo = ?, precio = ?, stock = ? 
        WHERE id_producto = ?');
        $consulta->bind_param('ssssdii', $nombre, $categoria, $marca, $modelo, $precio, $stock, $id);
        $consulta->execute();


        $consultaDetalles = $this->db->prepare('UPDATE detalles_producto SET peso = ?, alto = ?, ancho = ?, profundidad = ? WHERE id_producto = ?');
        $consultaDetalles->bind_param('ddddi', $peso, $alto, $ancho, $profundidad, $id);
        $consultaDetalles->execute();
    }
}
