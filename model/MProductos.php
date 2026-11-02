<?php

/*
// session_start() bakarrik hemen
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?entity=usuario");
    exit();
}

*/
class MProductos
{


    private $db;
    private $data;
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }


    /* public function getById($id)
    {

        $consulta = $this->db->prepare("SELECT 
            caballero.nombre as caballeroNombre,
            caballero.id_caballero as caballeroId,
            caballero.fuerza as caballeroFuerza,
            caballero.nivel as caballeroNivel,
            arma.tipo as armaTipo,
            escudo.tipo as escudoTipo,
            escudo.id_escudo as escudoId,
            arma.id_arma as armaId

            FROM caballero INNER JOIN escudo
            ON caballero.id_escudo = escudo.id_escudo
            INNER JOIN arma ON caballero.id_arma = arma.id_arma
            WHERE caballero.id_caballero = ?");

        $consulta->bind_param('i', $id);
        $consulta->execute();

        // recoger los datos que vienen siendo ejecutado con el prepare + bind
        $resultado = $consulta->get_result(); //importante usar el get result aqui.
        return $resultado->fetch_assoc();
    }
 */

    public function getAll()
    {

        // 1. Verificamos si la conexión existe
        if (!$this->db) {
            die("Error: No hay conexión a la base de datos.");
        }

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
        $id_producto,
        $nombre,
        $categoria,
        $marca,
        $modelo,
        $precio,
        $stock 
    ) {
        $consulta = $this->db->prepare('UPDATE productos SET nombre = ?, precio = ?, descripcion = ? WHERE id_producto = ?');
        $consulta->bind_param('siii', $nombre, $precio, $descripcion, $id_producto);
        $consulta->execute();
    }




    public function store(
        $nombre,
        $precio,
        $descripcion
    ) {
        $consulta = $this->db->prepare('INSERT INTO productos (nombre, precio, descripcion) VALUES (?, ?, ?)');
        $consulta->bind_param('siii', $nombre, $precio, $descripcion);
        $consulta->execute();
    }



    public function store(
        $nombre,
        $fuerza,
        $nivel,
        $id_arma,
        $id_escudo
    ) {
        $consulta = $this->db->prepare('INSERT INTO caballero ( nombre, fuerza, nivel, id_arma, id_escudo) VALUES (?, ?, ?, ?, ?)');

        $consulta->bind_param(
            'siiii',
            $nombre,
            $fuerza,
            $nivel,
            $id_arma,
            $id_escudo
        );

        $consulta->execute();
    }
}
