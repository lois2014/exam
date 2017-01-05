<?php
namespace app\index\model;

use think\Db;
use think\Model;

class User extends Model
{
    public function getUser($id)
    {
        $user = Db::table("user")->where('id',$id)->find();
        return empty($user)?[]:$user;
    }

    public function getUserBy($where){
        $user = Db::table("user")->where($where)->find();
        return empty($user)?[]:$user;
    }

    public function addUser($data)
    {
        return Db::name('user')->insertGetId($data);
    }
}