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
    public function getAll()
    {
        $consulta = $this->db->query("SELECT 
        detalles_pedido.id_pedido AS numero_pedido,
        productos.nombre AS producto_nombre,
        usuarios.nombre AS usuario_nombre, detalles_pedido.cantidad,
        detalles_pedido.precio_unitario AS precio ,
        pedidos.estado, pedidos.fecha_pedido     
        FROM detalles_pedido INNER JOIN productos  
        ON detalles_pedido.id_producto = productos.id_producto
        INNER JOIN pedidos  ON detalles_pedido.id_pedido = pedidos.id_pedido
        INNER JOIN usuarios  ON pedidos.id_usuario = usuarios.id_usuario;
    ");

        while ($filas = $consulta->fetch_assoc()) {

            $this->data[] = $filas;
        }
        $consulta->close();
        return $this->data;
    }
}
