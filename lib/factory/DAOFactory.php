<?php
/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 28-05-2017
 * Time: 21:46
 */
class DAOFactory{

    public function __construct(){

    }

    public static function getDAOFactory($tipoDAO){

        switch ($tipoDAO){
            case 1:
                return new UserSQLDAO();
                break;
            case 2:
                return new UserFileDAO();
        }
    }


}