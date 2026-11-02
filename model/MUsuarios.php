<?php

class MUsuarios
{

    private $db;
    private $data;
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }

    
    public function hasPermission($usuario, $contrasena)
    {
        $consulta = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");

        $consulta->bind_param('s', $usuario);

        // 1. Ejecutamos explícitamente
        $consulta->execute();

        // 2. Sacamos el resultado
        $resultado = $consulta->get_result();

        $usuarioEncontrado = $resultado->fetch_assoc();
        
        if ($usuarioEncontrado && password_verify($contrasena, $usuarioEncontrado['contrasenia'])) {

            // Si todo coincide, devolvemos el array con los datos del usuario
            return $usuarioEncontrado;
        }

        // Si el usuario no existe o la contraseña está mal, devolvemos false
        return false;
    }
}
