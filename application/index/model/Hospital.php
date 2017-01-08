<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Hospital extends Model
{
    public function getHospital($id)
    {
        $hospital = Db::table("hospital")->where('id',$id)->find();
        return empty($hospital)?[]:$hospital;
    }

    public function getUserBy($where){
        $user = Db::table("hospital")->where($where)->find();
        return empty($user)?[]:$user;
    }

    public function addHospital($data)
    {
        return Db::name('hospital')->insertGetId($data);
    }

    public function queryHospitalList($where,$order='',$start='',$limit='',$field='*',$usePaginate=false){
        $query = Db::table('hospital')->field($field)->where($where);
        if(!empty($order)){
            $query=$query->order($order);
        }
        if(!empty($start) && !empty($limit) && !$usePaginate){
            $query = $query->limit($start,$limit);
        }
        if($usePaginate){
            $list = $query->paginate($limit);
        }else{
            $list = $query->select();
        }

        return empty($list)?[]:$list;
    }
}