<?php
namespace app\index\controller;

use app\index\service\UserService;
use think\Controller;
use think\Cookie;

class Base extends Controller
{
    public function isLogin()
    {
        if(Cookie::has('user')){
            return true;
        }
        return false;
    }

    public function getUserInfo(){
        if($this->isLogin()){
            return Cookie::get('user');
        }
        return [];
    }

    public function userLogin($user){

        if($this->isLogin()) return true;
        Cookie::set('user',$user);
        return true;
    }

    public function ajaxSuccess($data='')
    {
        $return = [
            'state'=>1,
            'msg'=>'',
            'data'=>$data
        ];
        return json_encode($return);
    }
    public function ajaxFail($msg,$data='')
    {
        $return = [
            'state'=>0,
            'msg'=>$msg,
            'data'=>$data
        ];
        return json_encode($return);
    }

    public function clearCookie($key)
    {
        if(empty($key)){
            return false;
        }
        if(Cookie::has($key)) {
            Cookie::delete($key);
        }
        return true;
    }
}
