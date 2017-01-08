<?php
namespace app\admin\model;

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

    public function getRole($id)
    {
        return Db::table('role')->where('id',$id)->find();
    }

    public function queryUserList($where,$order='',$start='',$limit='',$field='*',$userPaginate=false){
        $query = Db::table('user')->field($field)->where($where);
        if(!empty($order)){
            $query=$query->order($order);
        }
        if(!empty($start) && !empty($limit) && !$userPaginate){
            $query = $query->limit($start,$limit);
        }
        if($userPaginate){
            $list = $query->paginate($limit);
        }else {
            $list = $query->select();
        }
        return empty($list)?[]:$list;
    }

    public function updateUser($data)
    {
        if(!empty($data['id'])){
            $res = Db::table('user')->update($data);
            return $data['id'];
        }
        return '';
    }
}