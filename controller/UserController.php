<?php
/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 28-05-2017
 * Time: 0:19
 */
require_once ("lib/interface/IApi.php");
class UserController implements IApi { 

    protected $config;

    function __construct(){
        $this->config = Config::singleton();
        include_once($this->config->get("basePath").$this->config->get("VOPath")."UserVO.php");
        include_once($this->config->get("basePath").$this->config->get("DAOPath")."UserSQLDAO.php");
        include_once($this->config->get("basePath").$this->config->get("factoryPath")."DAOFactory.php");
    }


    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->data['controller'] = "User";
            $this->data['action'] ="login";
            include($this->config->get("basePath").$this->config->get("viewPath")."login.php");
        }else{
            $username = $_POST["user"];
            $password = $_POST["password"];

            $userVO = new UserVO();
            $userVO->setPassword($password);
            $userVO->setUsername($username);

            $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));
            $response = $dao->validaUser($userVO);
            if($response["logueado"]){                
                $_SESSION["username"]=$username;
                $_SESSION["logged"]=true;
                $_SESSION['LAST_ACTIVITY'] = time();

                $userVO = $dao->getByUsername($username);
                $paginas = explode(",", $userVO->getRoles());                
                $this->data["paginas"] = $paginas;
                $this->data["username"] = $userVO->getUsername();
                include($this->config->get("basePath").$this->config->get("viewPath")."index.php");
            }else{
                session_destroy();
                echo("Usuario Inv&aacute;lido");
                include($this->config->get("basePath").$this->config->get("viewPath")."login.php");
            }
        }
    }

    public function isAdmin($username, $password){
        $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));
        $userVO = new UserVO();
        $userVO->setPassword($password);
        $userVO->setUsername($username);
        
        $response = $dao->validaUser($userVO);
        if($response["logueado"] && $response["isAdmin"]){
            $response = 2;
        }else if($response["logueado"]){
            $response = 1;
        }else{
            $response = 0; 
        }
        return $response;

    }


    public function render(){        
        if($_SESSION["logged"]){    
            $username = $_SESSION["username"];
            $pagina_requerida = $_GET["pagina"];

            //echo("User: ".$_SESSION["username"]."   : ".$pagina);
            $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));
            $userVO = new UserVO();
            $userVO = $dao->getByUsername($username);
            $paginas_permitidas = explode(",",$userVO->getRoles());
            
            if(in_array($pagina_requerida, $paginas_permitidas)){
                $this->data["username"] = $userVO->getUsername();
                $this->data["paginas"] = $paginas_permitidas;
                include($this->config->get("basePath").$this->config->get("viewPath")."page$pagina_requerida.php");
            }else{
                http_response_code(401);
                echo("401 - La p&aacute;gina que intenta acceder no se encuentra dentro de su rol");
            }
        }else{
                http_response_code(401);
                echo("401 - Session Inv&aacute;lida, Debes loguearte como usuario");
              include($this->config->get("basePath").$this->config->get("viewPath")."login.php");
        }
    }

    public function logout(){        
        session_unset();
        session_destroy();
        echo("Sesi&oacute;n cerrada exitosamente");
        include($this->config->get("basePath").$this->config->get("viewPath")."login.php");
    }

    //Métodos API
    public function get($username = null){
        $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));        
        $users = $dao->listar($username);
        return($users);
    }

    public function add($user){
        
        $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));   

        $userVO = new UserVO();        
        $userVO->setUsername($user->username);
        $userVO->setPassword($user->password);
        $userVO->setRoles($user->roles);

        $response = $dao->add($userVO);

        return($response);
        
    }

    public function eliminar($username){
        $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));
        $response = $dao->delete($username);
        return($response);
    }

    public function update($user){
        $dao = DAOFactory::getDAOFactory($this->config->get("DAOSql"));

        $userVO = new UserVO();
        $userVO->setUsername($user->username);
        $userVO->setPassword($user->password);
        $userVO->setRoles($user->roles);

        $response = $dao->update($userVO);

        return($response);
    }
}