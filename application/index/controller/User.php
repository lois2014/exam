<?php
namespace app\index\controller;

use app\index\service\UserService;

class User extends Base
{
    public function login()
    {
        if($this->isLogin()){
            return $this->fetch();
        }
        $data = $_POST;

        if(empty($data)){
           return $this->fetch();
        }
        $userSer = new UserService();

        if(isset($data['password'])){
            $data['password'] = md5($data['password']);
        }
        $isUser = $userSer->checkUser($data['userName'],$data['password']);
        if(!$isUser){
            return $this->error('用户名或者密码错误');
        }
        $user['password'] = $data['password'];
        $user['user_name'] = $data['userName'];
        $this->userLogin($data);
        return $this->success('登录成功','/examination/public');
    }

    public function register()
    {
        $data = $_POST;
        if(empty($data))  return $this->fetch();
//        var_dump($data);die;
        $userSer = new UserService();
        $isUser = $userSer->checkUser($data['user_name']);
        if($isUser) return $this->error('用户名已存在','examination/public/login');
        $res = $userSer->add($data);
        if($res){
            $user['user_name'] = $data['user_name'];
            $user['password'] = md5($data['password']);
            $this->userLogin($user);
            return $this->success('注册成功','/examination/public');
        }
        return $this->error('注册失败');
    }

    public function getUser(){
        $user = $this->getUserInfo();
//        var_dump($user);die;
        if(!$user){
            return $this->ajaxFail('未登录');
        }
        return $this->ajaxSuccess($user);
    }
}
