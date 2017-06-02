<?php

/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 28-05-2017
 * Time: 12:36
 */
abstract class  Controller{

    private $config;

    public function __construct(){
        require("config/global.php");
        $config = Config::singleton();
    }

}