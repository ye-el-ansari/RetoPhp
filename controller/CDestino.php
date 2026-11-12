<?php
// ============================================================
// controller/CDestino.php  ·  ENRUTADOR (router) del patrón MVC
// Lee la URL (?entity=...&action=...) y llama al controlador
// y al método adecuados.
// Ejemplo: index.php?entity=producto&action=edit&id=3
// ============================================================

// Arrancamos la sesión si todavía no existe (guarda el usuario logueado)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} //si no existiera una session iniciada en este apartado
// Cargamos la conexión y todos los controladores que podremos necesitar
require_once __DIR__ . '/../db/Conectar.php';
require_once __DIR__ . '/CProducto.php';
require_once __DIR__ . '/CPedido.php';
require_once __DIR__ . '/CLogin.php';
require_once __DIR__ . '/CUsuario.php';

class CDestino
{

    static $controller = null;

    // Método principal: decide qué controlador y qué acción ejecutar
    public static function enrutar()
    {
        // 1. Capturamos la acción de la URL (si no hay, por defecto es 'ver caballeros')
        // entity = qué "módulo" se quiere (producto, pedido, login, usuario). Por defecto: login
        $entity = isset($_GET['entity']) ? $_GET['entity'] : 'login';
        // action = qué operación se quiere hacer (index, show, store...). Por defecto: index
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';


        // id del registro sobre el que se actúa (si viene en la URL)
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        // rol enviado por URL: 0 = administrador, 1 = cliente, -1 = no indicado
        $rol = isset($_GET["rol"]) ? (int) $_GET["rol"] : -1;

        // id del usuario logueado, tomado de la sesión (0 si no hay sesión)
        $id_usuario = isset($_SESSION["id"]) ? (int) $_SESSION["id"] : 0;


        // Según la entidad, creamos el controlador correspondiente
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
        // Cada case llama al método del controlador con el mismo nombre
        switch ($action) {
            case 'index':
                // Listado
                $controller->index($id, $rol, $id_usuario);
                break; //  El break evita que se ejecuten los siguientes casos

            case 'show':
                // Ver el detalle de un registro
                $controller->show($id, $rol, $id_usuario);
                break;
            case 'create':
                // Mostrar el formulario de alta
                $controller->create();
                break;

            case 'login':
                // Comprobar usuario y contraseña
                $controller->login();
                break;

            case 'store':
                // Guardar un registro nuevo (INSERT)
                $controller->store();
                break;

            case 'destroy':
                // Borrar un registro (DELETE)
                $controller->destroy($id);
                break;

            case 'destroyLinea':
                // Borrar un registro (DELETE)
                $controller->destroyLinea($id);
                break;

            case 'edit':
                // Mostrar el formulario de edición
                $controller->edit($id, $rol, $id_usuario);
                break;


            case 'update':
                // Guardar los cambios de un registro (UPDATE)
                $controller->update($id, $rol, $id_usuario);
                break;
                
            case "logout":
                $controller->logout();
                break;





            // opciones del carrito 
            case 'carrito':
                // Mostrar el carrito (pedido pendiente) del usuario
                $controller->carrito();
                break;

            case 'anyadirProducto':
                // Añadir un producto al carrito
                $controller->anyadirProducto();
                break;
            case 'comprar':
                // Finalizar la compra
                $controller->comprar();
                break;

            default:
                // Si ponen una acción que no existe, los mandamos al listado por seguridad
                if (session_status() === PHP_SESSION_NONE) {
                    session_unset();
                    session_destroy();
                }

                header("Location: index.php?action=login");
                break;
        }
    }
}
