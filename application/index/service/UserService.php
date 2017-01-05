<?php
namespace app\index\service;

use app\index\model\User;

class UserService extends User
{
    public function add($data){
        if(isset($data['password'])){
            $data['password'] = md5($data['password']);
        }
        return $this->addUser($data);
    }

    public function checkUser($userName,$password=''){
        if(empty($password)){
            return $this->getUserBy(['user_name'=>$userName]);
        }
        return $this->getUserBy(['user_name'=>$userName,'password'=>$password]);
    }
}