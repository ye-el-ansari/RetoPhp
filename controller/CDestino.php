<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} //si no existiera una session iniciada en este apartado
require_once __DIR__ . '/../db/Conectar.php';
require_once __DIR__ . '/CProducto.php';
require_once __DIR__ . '/CPedido.php';
require_once __DIR__ . '/CLogin.php';
require_once __DIR__ . '/CUsuario.php';

class CDestino
{

    static $controller = null;

    public static function enrutar()
    {
        // 1. Capturamos la acción de la URL (si no hay, por defecto es 'ver caballeros')
        $entity = isset($_GET['entity']) ? $_GET['entity'] : 'login';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';


        $id = isset($_GET['id']) ? $_GET['id'] : null;

        $rol = isset($_GET["rol"]) ? (int)$_GET["rol"] : -1;

        $id_usuario=isset($_SESSION["id"]) ? (int)$_SESSION["id"]:0;


        switch ($entity) {
            case 'producto':
                $controller = new CProducto();
                break;
            case 'pedido':
                $controller = new CPedido();
                break;
            case 'login':
                $controller = new CLogin();
                break;
            case 'usuario':
                $controller = new CUsuario();
                break;
        }


        // 2. Evaluamos qué quiere hacer el usuario
        switch ($action) {
            case 'index':
                $controller->index($id, $rol, $id_usuario);
                break; //  El break evita que se ejecuten los siguientes casos

            case 'show':
                $controller->show($id, $rol,$id_usuario);
                break;
            case 'create':
                $controller->create();
                break;

            case 'login':
                $controller->login();
                break;

            case 'store':
                $controller->store();
                break;

            case 'destroy':
                $controller->destroy($id);
                break;

            case 'edit':
                $controller->edit($id, $rol, $id_usuario);
                break;


            case 'update':
                $controller->update($id, $rol, $id_usuario);
                break;
            

            default:
                // Si ponen una acción que no existe, los mandamos al listado por seguridad
                if (!session_status() === PHP_SESSION_NONE) {
                    session_unset();  
                    session_destroy();
                }

                header("Location: index.php?action=login");
                break;
        }
    }
}
