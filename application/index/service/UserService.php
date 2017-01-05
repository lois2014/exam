<?php
namespace app\index\service;

use app\index\model\User;

class UserService extends User
{
    public function add($data){
        $user=[
            'true_name'=>$data['name'],
            'user_name'=>$data['user_name'],
            'password'=>md5($data['password']),
            'mobile'=>$data['mobile'],
            'email'=>$data['mail'],
            'birthday'=>$data['birthday'],
            'marry'=>$data['marry']=='y'?2:1,
            'card_type'=>$data['cardType']=='IDCard'?'1':0,
            'card'=>$data['card'],
            'gender'=>$data['sex']
        ];

        return $this->addUser($user);
    }

    public function checkUser($userName,$password=''){
        if(empty($password)){
            return $this->getUserBy(['user_name'=>$userName]);
        }
        return $this->getUserBy(['user_name'=>$userName,'password'=>$password]);
    }
}