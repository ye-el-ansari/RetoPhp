<?php
// ============================================================
// controller/CLogin.php  ·  CONTROLADOR de autenticación
// Gestiona mostrar el formulario, iniciar sesión y cerrarla.
// ============================================================
require_once __DIR__ . "/../model/MLogin.php";
class CLogin
{
    // Modelo que consulta la tabla usuarios
    private MLogin $model;
    // Constructor: crea el modelo al instanciar el controlador
    public function __construct()
    {
        $this->model = new MLogin();
    }

    // Muestra la vista con el formulario de login
    public function index()
    {
        require __DIR__ . "/../view/login/login.php";
    }
    // Procesa el formulario de login (llega por POST)
    public function login()
    {
        // Recogemos usuario y contraseña enviados; si no existen, null
        $user = isset($_POST['usuario']) ? $_POST['usuario'] : null;
        $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;
        // Preguntamos al modelo si los datos son correctos
        $usuario = $this->model->hasPermission($user, $contrasena);
        if ($usuario) {
            // Login correcto: guardamos los datos del usuario en la sesión
            session_start();
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION["id"] = (int)$usuario["id_usuario"];

            // Redirigimos según el rol: 0 (admin) -> productos, otro (cliente) -> sus pedidos
            $_SESSION["rol"] === 0
                ? header("Location: index.php?entity=producto&action=index&rol=0")
                : header("Location: index.php?entity=pedido&action=index&id=" . $_SESSION['id'] . "&rol=1");
            exit; //para detener la ejecucion
        } else {
            // Login incorrecto: volvemos al formulario
            header("Location: index.php");
            exit;
        }
    }
    // Cierra la sesión del usuario
    public function logout()
    {
         if (session_status() === PHP_SESSION_NONE) {
            $_SESSION=[];
              session_unset();    // 2. Vaciamos todas las variables 
            session_destroy();
    
}
      

        header("Location: index.php");
        exit;
    }
}
