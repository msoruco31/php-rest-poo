<?php
/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 28-05-2017
 * Time: 0:28
 */
class FrontController{
    
    public function main($vars){
        $this->validateSession();
        $config = Config::singleton();
        //Obtengo Controlador solicitado
        if(isset($vars['controller'])) {
            $controllerName = ucfirst($vars['controller']).'Controller';
        }else {
            $controllerName = $config->get("defaultController");
        }
        $controllerPath = $config->get("controllerPath").$controllerName.'.php';
        if(is_file($controllerPath)) {
            include_once $controllerPath;
        }else {
           $this->response(404, "error", "El controller solicitado no existe");
        }

        //Obtengo Action solicitada
        if(isset($vars['action'])) {
            $action = $vars['action'];
        }else {
            $action = $config->get("defaultAction");
        }

        //Si no existe la clase que buscamos y su acción, mostramos un error 404
        if (is_callable(array($controllerName, $action)) == false){
           $this->response(404, "error", "La accion sobre el controller $controllerName no existe");
        }
        $controller = new $controllerName();
        $controller->$action();
    }

    public function api($vars){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Yapo"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Autentificación cancelada';
            exit;
        } else {
            $UserController = new UserController();
            $isAdmin =$UserController->isAdmin($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);            
            $config = Config::singleton();

            //Obtengo Controlador solicitado
            $controllerName = ucfirst($vars["controller"].'Controller');
            $controllerPath = $config->get("controllerPath").$controllerName.'.php';
            $controller = new $controllerName();
            if(is_file($controllerPath)) {
                include_once $controllerPath;
            }else {
                $this->response(404, "error", "El recurso solicitado no existe");
            }



            //Obtengo Action de api según el request            
            $metodo = $_SERVER['REQUEST_METHOD'];
            //echo($metodo."->".$_SERVER['PATH_INFO']."\n");
            switch ($metodo) {
                case "GET":
                    if($isAdmin < 1){
                       $this->response(401, "error", "Usuario no Logueado");                       
                    }else{
                        $action = "get";
                        $username = $vars["username"];
                        $users = $controller->$action($username);
                        $arr_users = array();
                        foreach ($users as $user){
                            $user->setPassword('******');
                            $arr_users[] = $user->toJson();
                        }
                        echo json_encode($arr_users);
                    }
                   
                    break;
                case "POST":                    
                    if($isAdmin < 2){
                       $this->response(401, "error", "Permisos Insuficientes");
                    }else{
                        $action = "add";                      
                        $cuerpo = file_get_contents('php://input');                       
                        $usuario = json_decode($cuerpo);                       
                        $response =$controller->$action($usuario);
                        if($response){
                            $this->response(200, "success", "Recurso ingresado correctamente");
                        }else{
                            $this->response(409, "error", "Problemas al insertar el Recurso");
                        }
                    }
                    break;
                case "DELETE":
                    if($isAdmin < 2){
                        $this->response(401, "error", "Permisos Insuficientes");
                    }else{
                        $action = "eliminar";
                        $username = $vars["username"];
                        $response = $controller->$action($username);
                        if($response){
                            $this->response(200, "success", "Recurso eliminado correctamente");
                        }else{
                            $this->response(409, "error", "Problemas al eliminar el Recurso");
                        }

                    }
                    break;
                case "PUT":                    
                    if($isAdmin < 2){
                       $this->response(401, "error", "Permisos Insuficientes");
                    }else{
                        $action = "update";
                        $cuerpo = file_get_contents('php://input');
                        $usuario = json_decode($cuerpo);
                        $response =$controller->$action($usuario);
                        if($response){
                            $this->response(200, "success", "Recurso actualizado correctamente");
                        }else{
                            $this->response(409, "error", "Problemas al actualizar el Recurso");
                        }
                    }
                default:
                    $this->response(400, "error", "Metodo request no existe");
                    break;
            }           
           
            
        }

    }

    private function response($code=200, $status="", $message="") {
        http_response_code($code);
        if( !empty($status) && !empty($message) ){
            $response = array("status" => $status ,"message"=>$message);  
            echo json_encode($response,JSON_PRETTY_PRINT);    
            die();
        }            
    }

    private function validateSession(){
        $config = Config::singleton();        
        if (isset($_SESSION["LAST_ACTIVITY"])) {
            if (time() - $_SESSION["LAST_ACTIVITY"] > $config->get("duracionSession")) {
                
                session_unset();     
                session_destroy();                
            } else if (time() - $_SESSION["LAST_ACTIVITY"] > 60) {
                $_SESSION["LAST_ACTIVITY"] = time(); // update last activity time stamp
            }
        }        
    }

}