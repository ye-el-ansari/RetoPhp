<?php

require_once __DIR__ . "/../model/MProductos.php";


class CProducto
{

    private MProductos $model;
    /*private MArma $modelArma;
    private MEscudo $modelEscudo;
*/
    public function __construct()
    {

        $this->model = new MProductos();
    }

    public function index()
    {


        $productos = $this->model->getAll();
        require_once __DIR__ . "\../view/productos/VProductoIndex.php";
    }
    public function show($id)
    {

        $producto = $this->model->getById($id);
        require_once __DIR__ . "/../view/productos/VProductoVer.php";
    }

    public function create()
    {
        require_once __DIR__ . "/../view/productos/VProductoCreate.php";
    }



    public function store()
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

        $this->model->store($nombre, $categoria, $marca, $modelo, $precio, $stock, $peso, $alto, $ancho, $profundidad);

        header("Location: index.php?entity=producto&action=index");
        exit();
    }


    public function edit($id)
    {

        $producto = $this->model->getById($id);
        require_once __DIR__ . "/../view/productos/VProductoModificar.php";
    }


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

        header("Location: index.php?entity=producto&action=index");
        exit();
    }


    public function destroy($id)
    {

        $this->model->delete($id);
        $this->index();
    }
}
