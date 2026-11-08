<?php
class MUsuario{
    private $db;
    function __construct(){
        $this->db=ConexionBD::conectar();
    }

    function getAll(){
        $query=$this->db->query("SELECT * from usuarios");
        return $query->fetch_all(MYSQLI_ASSOC);
    }
    function getUsuario($id){
        $query=$this->db->prepare("SELECT * from usuarios where id_usuario=?;");
        $query->bind_param("i",$id);
        $query->execute();
        $result=$query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}
?>