<?php
require_once("IUserDAO.php");
/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 28-05-2017
 * Time: 0:05
 */
class UserSQLDAO implements IUserDAO{

    protected $ds;
    protected $config;

    public function __construct() {
        $this->config = Config::singleton();
        include_once($this->config->get("basePath").$this->config->get("datasourcePath")."DataSourceSQL.php");

        $this->ds = new DataSourceSQL();
    }


    public function getByUsername($username){
        
        $query = "SELECT * FROM users WHERE username LIKE '".$username."';";       
        $results = $this->ds->ejecutar($query);
        
        $userVO = new UserVO();
        while ($row = $results->fetchArray()) {
            $userVO->setUsername($row["username"]);
            $userVO->setPassword($row["password"]);
            $userVO->setRoles($row["roles"]);
            //print_r($row);
        }
        return $userVO;
    }

    public function add(UserVO $userVO){
        $query ="INSERT INTO users (username, roles, password) VALUES ('".$userVO->getUsername()."','".$userVO->getRoles()."','".$userVO->getPassword()."');";        
        $results = $this->ds->ejecutar($query);
        if(!$results){
            return 0;
        }else{
            return 1;
        }
    }

    public function update(UserVO $userVO){
        $query ="UPDATE users SET password ='".$userVO->getPassword()."',roles='".$userVO->getRoles()."' WHERE username LIKE '".$userVO->getUsername()."';";        
        $results = $this->ds->ejecutar($query);
        if(!$results){
            return 0;
        }else{
            return 1;
        }
    }

    public function delete($username){
        $query = "DELETE FROM users WHERE username LIKE '".$username."';";
        $results = $this->ds->ejecutar($query);
        if(!$results){
            return 0;
        }else{
            return 1;
        }
    }

    public function listar($username){
        if(isset($username)){
            $query = "SELECT * FROM users WHERE username LIKE '".$username."'";
        }else{
            $query = "SELECT * FROM users;";
        }
        $results = $this->ds->ejecutar($query);
        $arr_users = array();

        while ($row = $results->fetchArray()) {
            $userVO = new UserVO();            
            $userVO->setUsername($row["username"]);
            $userVO->setPassword($row["password"]);
            $userVO->setRoles($row["roles"]);
            $arr_users[] = $userVO;            
        }
        return $arr_users;
    }

    public function validaUser(UserVO $userVO){
        $response = array("logueado"=>0, "isAdmin"=>0);
        $query = "SELECT * FROM users WHERE username LIKE '".$userVO->getUsername()."' AND password LIKE '".$userVO->getPassword()."' LIMIT 1;";
        $results = $this->ds->ejecutar($query);
        while ($row = $results->fetchArray()) {
            $userVO->setUsername($row["username"]);
            $userVO->setPassword($row["password"]);
            $userVO->setRoles($row["roles"]);
            $response["logueado"] = 1;
        }
        $roles = explode(",",$userVO->getRoles());
        if(in_array("admin", $roles)){
            $response["isAdmin"] = 1;
        }

        return $response;
    }
}