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
        $consulta = $this->db->prepare("SELECT 
        productos.nombre AS producto_nombre,
        detalles_pedido.id_pedido AS numero_pedido,
        pedidos.fecha_pedido,
        detalles_pedido.cantidad,
        pedidos.estado,
        usuarios.nombre AS usuario_nombre,
        detalles_pedido.precio_unitario AS precio
        FROM detalles_pedido
        INNER JOIN productos  
        ON detalles_pedido.id_producto = productos.id_producto
        INNER JOIN pedidos  
        ON detalles_pedido.id_pedido = pedidos.id_pedido
        INNER JOIN usuarios  
        ON pedidos.id_usuario = usuarios.id_usuario;
    ");
    }
}
