<?php

/**
 * Created by PhpStorm.
 * User: msoruco
 * Date: 27-05-2017
 * Time: 12:15
 */
interface IUserDAO{
    public function getByUsername($username);
    public function add(UserVO $userVO);
    public function update(UserVO $userVO);
    public function delete ($username);
    public function listar($username);
    public function validaUser(UserVO $userVO);
}