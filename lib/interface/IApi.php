<?php

/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 30-05-2017
 * Time: 3:39
 */
interface IApi{

    public function get($id);
    public function add($user);
    public function eliminar($id);
    public function update($user);


}