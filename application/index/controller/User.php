<?php
namespace app\index\controller;

use app\index\service\UserService;

class User extends Base
{
    public function login()
    {
        if($this->isLogin()){
            return $this->ajaxSuccess();
        }
        $data = $this->request->post();

        if(empty($data)){
           return $this->fetch();
        }
        $userSer = new UserService();

        if(isset($data['password'])){
            $data['password'] = md5($data['password']);
        }
        $isUser = $userSer->checkUser($data['userName'],$data['password']);
        if(!$isUser){
            return $this->ajaxFail('用户名或者密码错误');
        }
        $this->userLogin($data);
        return $this->ajaxSuccess();
    }

    public function register()
    {
        $data = $_POST;
        if(empty($data))  return $this->fetch();
        $userSer = new UserService();
        $res = $userSer->add($data);
        if($res){
            $user['userName'] = $data['userName'];
            $user['password'] = md5($data['password']);
            $this->userLogin($user);
            return $this->fetch('index/index');
        }

    }
}
