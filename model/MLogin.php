<?php
    // ============================================================
    // model/MLogin.php  ·  MODELO de autenticación
    // Comprueba en la tabla usuarios si el nombre y la contraseña son válidos.
    // ============================================================
    class MLogin{
            private $db;
    private $data;
    // Al crear el modelo se abre la conexión a la BD
    public function __construct()
    {
        $this->db = ConexionBD::conectar();
        $this->data = array();
    }

    
    // Devuelve los datos del usuario si el login es correcto; false si no
    public function hasPermission($usuario, $contrasena)
    {
        // Consulta preparada (?) para evitar inyección SQL
        $consulta = $this->db->prepare("SELECT * FROM usuarios WHERE nombre = ?");

        // 's' = el parámetro es un string
        $consulta->bind_param('s', $usuario);

        // 1. Ejecutamos explícitamente
        $consulta->execute();

        // 2. Sacamos el resultado
        $resultado = $consulta->get_result();

        // Primera (y única) fila encontrada como array asociativo
        $usuarioEncontrado = $resultado->fetch_assoc();
        
        // Si existe el usuario y la contraseña coincide con el hash guardado en la BD
        // (password_verify compara el texto escrito con el hash generado por password_hash)
        if ($usuarioEncontrado && password_verify($contrasena, $usuarioEncontrado['contrasenia'])) {

            // Si todo coincide, devolvemos el array con los datos del usuario
            return $usuarioEncontrado;
        }

        // Si el usuario no existe o la contraseña está mal, devolvemos false
        return false;
    }
        }
?>
