<?php

/*
// session_start() bakarrik hemen
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?entity=usuario");
    exit();
}

*/
// ============================================================
// model/MProductos.php  ·  MODELO de productos
// Gestiona las tablas productos y detalles_producto (relación 1:1).
// ============================================================
class MProductos
{


    private $db;
    private $data;
    // Abre la conexión a la BD y prepara el array donde se guardan los resultados
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }


    // Devuelve UN producto con sus detalles (peso y medidas) uniendo las dos tablas
    public function getById($id)
    {
        // Corrección: Se añaden las comillas correspondientes al string de la consulta SQL
        // INNER JOIN une productos con detalles_producto por id_producto
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

        // 'i' = el id es un entero
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


    // Devuelve TODOS los productos (para el listado y el catálogo del carrito)
    public function getAll()
    {

        $consulta = $this->db->query("SELECT * FROM productos");


        // Recorremos el resultado fila a fila y lo guardamos en $data
        while ($filas = $consulta->fetch_assoc()) {

            $this->data[] = $filas;
        }
        $consulta->close();
        return $this->data;
    }

    // Elimina un producto por id (sus detalles se borran por ON DELETE CASCADE)
    public function delete($id)
    {

        $consulta = $this->db->prepare('DELETE FROM productos WHERE id_producto = ?');
        $consulta->bind_param('i', $id);
        $consulta->execute();
        $consulta->close();
    }

    // Actualiza el producto y sus detalles (dos UPDATE, uno por tabla)
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
        // Tipos: s = string, d = decimal, i = entero -> 'ssssdii'
        $consulta = $this->db->prepare('UPDATE productos SET nombre = ?, categoria = ?, marca = ?, modelo = ?, precio = ?, stock = ? WHERE id_producto = ?');
        $consulta->bind_param('ssssdii', $nombre, $categoria, $marca, $modelo, $precio, $stock, $id);
        $consulta->execute();


        // Segundo UPDATE: tabla de detalles (peso y medidas)
        $consultaDetalles = $this->db->prepare('UPDATE detalles_producto SET peso = ?, alto = ?, ancho = ?, profundidad = ? WHERE id_producto = ?');
        $consultaDetalles->bind_param('ddddi', $peso, $alto, $ancho, $profundidad, $id);
        $consultaDetalles->execute();   

       
    }




    // Inserta un producto nuevo: primero en productos y luego en detalles_producto
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
        // insert_id = id autogenerado (AUTO_INCREMENT) del último INSERT
        $id_producto = $this->db->insert_id;
        $consulta->close();

        // 3. Insertar en la tabla secundaria
        $this->storeDetalles($id_producto, $peso, $alto, $ancho, $profundidad);

        return true;


    }

    // Inserta la fila 1:1 de detalles (peso y medidas) asociada al producto
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
