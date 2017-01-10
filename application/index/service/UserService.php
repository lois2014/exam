<?php
namespace app\index\service;

use app\index\model\User;

class UserService extends BaseService
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
        $userModel = new User();
        return $userModel->addUser($user);
    }

    public function checkUser($userName,$password=''){
        $userModel = new User();
        if(empty($password)){
            return $userModel->getUserBy(['user_name'=>$userName]);
        }
        return $userModel->getUserBy(['user_name'=>$userName,'password'=>$password]);
    }

    public function getUser($userName,$password)
    {
        $userModel = new User();
        if(empty($password) || empty($password)){
            return [];
        }
        return $userModel->getUserBy(['user_name'=>$userName,'password'=>$password]);
    }
}