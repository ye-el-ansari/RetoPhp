<?php
// ============================================================
// controller/CProducto.php  ·  CONTROLADOR del catálogo (CRUD de productos)
// Recibe las peticiones, usa el modelo MProductos y carga la vista.
// ============================================================

require_once __DIR__ . "/../model/MProductos.php";


class CProducto
{

    // Modelo de productos (acceso a BD)
    private MProductos $model;
    /*private MArma $modelArma;
    private MEscudo $modelEscudo;
*/
    public function __construct()
    {

        $this->model = new MProductos();
    }

    // READ (listado): obtiene todos los productos y muestra la tabla
    public function index()
    {


        $productos = $this->model->getAll();
        require_once __DIR__ . "/../view/productos/VProductoIndex.php";
    }
    // READ (detalle): muestra un producto con sus medidas y peso
    public function show($id)
    {

        $producto = $this->model->getById($id);
        require_once __DIR__ . "/../view/productos/VProductoVer.php";
    }

    // Muestra el formulario vacío para dar de alta un producto
    public function create()
    {
        require_once __DIR__ . "/../view/productos/VProductoCreate.php";
    }



    // CREATE: recoge los datos del formulario ($_POST) y los guarda en BD
    public function store()
    {

        // Cada campo: si existe en $_POST se usa, si no, null
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

        $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
        $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : null;
        $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
        $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
        $peso = isset($_POST['peso']) ? $_POST['peso'] : null;
        $alto = isset($_POST['altura']) ? $_POST['altura'] : null;
        $ancho = isset($_POST['ancho']) ? $_POST['ancho'] : null;
        $profundidad = isset($_POST['profundidad']) ? $_POST['profundidad'] : null;

        // Enviamos los datos al modelo para hacer los INSERT
        $this->model->store($nombre, $categoria, $marca, $modelo, $precio, $stock, $peso, $alto, $ancho, $profundidad);

        // Aviso que mostrará la vista del listado (view/aviso.php)
        $_SESSION['aviso'] = "Producto añadido correctamente.";

        // Volvemos al listado de productos
        header("Location: index.php?entity=producto&action=index");
        exit();
    }


    // Muestra el formulario de edición con los datos actuales del producto
    public function edit($id)
    {

        $producto = $this->model->getById($id);
        require_once __DIR__ . "/../view/productos/VProductoModificar.php";
    }


    // UPDATE: recoge los datos modificados y actualiza el producto
    public function update($id)
    {

        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

        $marca = isset($_POST['marca']) ? $_POST['marca'] : null;

        $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : null;
        $precio = isset($_POST['precio']) ? $_POST['precio'] : null;

          $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
            $peso = isset($_POST['peso']) ? $_POST['peso'] : null;
              $alto = isset($_POST['altura']) ? $_POST['altura'] : null;
                $ancho = isset($_POST['ancho']) ? $_POST['ancho'] : null;
                  $profundidad = isset($_POST['profundidad']) ? $_POST['profundidad'] : null;

        // Pasamos id + todos los datos al modelo para ejecutar los UPDATE
        $this->model->update(
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
        );

        // Aviso que mostrará la vista del listado (view/aviso.php)
        $_SESSION['aviso'] = "Producto modificado correctamente.";

        header("Location: index.php?entity=producto&action=index");
        exit();
    }


    // DELETE: elimina el producto y vuelve a mostrar el listado
    public function destroy($id)
    {

        $this->model->delete($id);

        // Aviso que mostrará la vista del listado (view/aviso.php)
        $_SESSION['aviso'] = "Producto eliminado correctamente.";

        $this->index();
    }
}
