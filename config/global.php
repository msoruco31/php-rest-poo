<?php
require_once("core/Config.php");
/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 28-05-2017
 * Time: 0:32
 */
    $config = Config::singleton();
    $config->set('appName', 'yapo');
    $config->set('basePath', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR);
    $config->set('controllerPath', 'controller/');
    $config->set('modelPath', 'model/');
    $config->set('viewPath', 'view/');
    $config->set('DAOPath', 'lib/DAO/');
    $config->set('VOPath', 'lib/VO/');
    $config->set('ConfigPath', 'config/');
    $config->set('factoryPath', 'lib/factory/');
    $config->set('datasourcePath', 'lib/datasource/');

    $config->set('defaultController', 'UserController');
    $config->set('defaultAction', 'login');
    $config->set('DAOFile', 2);
    $config->set('DAOSql', 1);
    $config->set('databasePath', "bd");
    $config->set('duracionSession', 300);
?>




