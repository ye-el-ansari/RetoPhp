<?php

/*
// session_start() bakarrik hemen
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?entity=usuario");
    exit();
}

*/
class MUsuarios
{


    private $db;
    private $data;
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }


    public function getById($id)
    {
        // Corrección: Se añaden las comillas correspondientes al string de la consulta SQL
        $consulta = $this->db->prepare("SELECT 
            productos.nombre as productoNombre, 
            productos.id_producto as productoId, 
            productos.categoria as productoCategoria, 
            productos.marca as productoMarca, 
            productos.modelo as productoModelo, 
            productos.precio as productoPrecio, 
            productos.stock as productoStock, 
            detalles_producto.peso as productoPeso, 
            detalles_producto.alto as productoAlto, 
            detalles_producto.ancho as productoAncho, 
            detalles_producto.profundidad as productoProfundidad 
        FROM productos 
        INNER JOIN detalles_producto ON productos.id_producto = detalles_producto.id_producto 
        WHERE productos.id_producto = ?
    ");

        $consulta->bind_param("i", $id);
        $consulta->execute();

        $resultado = $consulta->get_result();

        // Almacenamos el array asociativo en una variable
        $producto = $resultado->fetch_assoc();

        // Buena práctica: Cerrar la consulta para liberar memoria
        $consulta->close();

        // Retorna el array con los datos o null si no se encontró el producto
        return $producto;
    }


    public function getAll()
    {

        $consulta = $this->db->query("SELECT * FROM productos");


        while ($filas = $consulta->fetch_assoc()) {

            $this->data[] = $filas;
        }
        $consulta->close();
        return $this->data;
    }

    public function delete($id)
    {

        $consulta = $this->db->prepare('DELETE FROM productos WHERE id_producto = ?');
        $consulta->bind_param('i', $id);
        $consulta->execute();
        $consulta->close();
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
        $consulta = $this->db->prepare('UPDATE productos SET nombre = ?, categoria = ?, marca = ?, modelo = ?, precio = ?, stock = ? WHERE id_producto = ?');
        $consulta->bind_param('ssssdii', $nombre, $categoria, $marca, $modelo, $precio, $stock, $id);
        $consulta->execute();


        $consultaDetalles = $this->db->prepare('UPDATE detalles_producto SET peso = ?, alto = ?, ancho = ?, profundidad = ? WHERE id_producto = ?');
        $consultaDetalles->bind_param('ddddi', $peso, $alto, $ancho, $profundidad, $id);
        $consultaDetalles->execute();   

       
    }




    public function store(
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


        // 1. Insertar en la tabla principal
        $consulta = $this->db->prepare(
            'INSERT INTO productos (nombre, categoria, marca, modelo, precio, stock)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $consulta->bind_param('ssssdi', $nombre, $categoria, $marca, $modelo, $precio, $stock);
        $consulta->execute();

        // 2. Recuperar el id del producto insertado
        $id_producto = $this->db->insert_id;
        $consulta->close();

        // 3. Insertar en la tabla secundaria
        $this->storeDetalles($id_producto, $peso, $alto, $ancho, $profundidad);

        return true;


    }

    public function storeDetalles($id_producto, $peso, $alto, $ancho, $profundidad)
    {
        $consulta = $this->db->prepare(
            'INSERT INTO detalles_producto (id_producto, peso, alto, ancho, profundidad)
         VALUES (?, ?, ?, ?, ?)'
        );

        if (!$consulta) {
            // Esto se ejecutará si falló el prepare (ej: columna mal escrita o tabla inexistente)
            die("Error en la estructura/Prepare de Detalles: " . $this->db->error);
        }

        $consulta->bind_param('idddd', $id_producto, $peso, $alto, $ancho, $profundidad);

        if (!$consulta->execute()) {
            // Esto se ejecutará si falló el execute (ej: error de llave foránea, tipos de datos vacíos)
            die("Error al ejecutar la inserción en Detalles: " . $consulta->error);
        }

        $consulta->close();
    }


}
