<?php

/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 27-05-2017
 * Time: 12:17
 */
class DataSourceSQL extends SQLite3{

    private $conexion;

    public function __construct(){
        $config = Config::singleton();
        $this->conexion = new SQLite3($config->get("basePath").$config->get("databasePath")."/users.db");
        //$this->creaTablas();
    }

    public function init(){
        $tablas = ["CREATE TABLE IF NOT EXISTS users (username VARCHAR(50) PRIMARY KEY, roles VARCHAR(10) NOT NULL, password VARCHAR(50) NOT NULL)"];
        foreach ($tablas as $tabla) {
            $this->conexion->exec($tabla);
        }

        $statement = $this->conexion->prepare("INSERT INTO users ('username','roles','password') VALUES (:username, :roles, :password);");
        $statement->bindValue(':username', "admin", SQLITE3_TEXT);
        $statement->bindValue(':roles', "1,2,3", SQLITE3_TEXT);
        $statement->bindValue(':password', "Franco3119", SQLITE3_TEXT);
        $statement->execute();
    }

    public function ejecutar($sql){
        $results = $this->conexion->query($sql);
        return $results;
    }

    public function cerrar(){
        $this->conexion->close();
    }

}
