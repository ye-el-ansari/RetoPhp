<?php
    class MPedidos{
    private $db;
    private $data;
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }
        public function getAll(){
            $consulta=$this->db->prepare("");
        }
    }
?>