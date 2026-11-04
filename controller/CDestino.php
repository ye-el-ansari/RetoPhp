<?php

require_once __DIR__ . '/../db/Conectar.php';
require_once __DIR__ . '/CProducto.php';
require_once __DIR__ . '/CPedido.php';
// require_once __DIR__ . '/CLogin.php';

class CDestino
{

    static $controller = null;

    public static function enrutar()
    {
        // 1. Capturamos la acción de la URL (si no hay, por defecto es 'ver caballeros')
        $entity = isset($_GET['entity']) ? $_GET['entity'] : 'producto';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';


        $id = isset($_GET['id']) ? $_GET['id'] : null;


        switch ($entity) {
            case 'producto':
                $controller = new CProducto();
                break;
            case 'pedido':
                $controller = new CPedido();
                break;
        }


        // 2. Evaluamos qué quiere hacer el usuario
        switch ($action) {
            case 'index':
                $controller->index();
                break; //  El break evita que se ejecuten los siguientes casos

            case 'show':
                $controller->show($id);
                break;
            case 'create':
                $controller->create();
                break;
            /* 
            case 'login':
                 $controller->login();
                 break; 
  */

            case 'store':
                $controller->store();
                break;

            case 'destroy':
                $controller->destroy($id);
                break;
            
             case 'edit':
                 $controller->edit($id);
                 break;

                 
             case 'update':
                 $controller->update($id);
                 break; 


            default:
                // Si ponen una acción que no existe, los mandamos al listado por seguridad
                header("Location: index.php?action=index");
                break;
        }
    }
}
