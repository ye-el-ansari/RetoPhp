<?php
// ============================================================
// model/MUsuario.php  ·  MODELO de usuarios (tabla usuarios)
// ============================================================
class MUsuario{
    private $db;
    // Abre la conexión a la BD al crear el modelo
    function __construct(){
        $this->db=ConexionBD::conectar();
    }

    // Devuelve todos los usuarios como array de arrays asociativos
    function getAll(){
        $query=$this->db->query("SELECT * from usuarios");
        return $query->fetch_all(MYSQLI_ASSOC);
    }
    // Devuelve un usuario por su id (consulta preparada, 'i' = entero)
    function getUsuario($id){
        $query=$this->db->prepare("SELECT * from usuarios where id_usuario=?;");
        $query->bind_param("i",$id);
        $query->execute();
        $result=$query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}
?>
