<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Appointment extends Model
{
    public function getAppointment($id)
    {
        $user = Db::table("appointment")->where('id',$id)->find();
        return empty($user)?[]:$user;
    }

    public function getAppointmentBy($where){
        $user = Db::table("appointment")->where($where)->find();
        return empty($user)?[]:$user;
    }

    public function addAppointment($data)
    {
        return Db::name('appointment')->insertGetId($data);
    }

    public function queryAppointmentList($where,$order='',$start='',$limit='',$field='*'){
        $query = Db::table('appointment')->field($field)->where($where);
        if(!empty($order)){
            $query=$query->order($order);
        }
        if(!empty($start) && !empty($limit)){
            $query = $query->limit($start,$limit);
        }
        $list = $query->select();
        return empty($list)?[]:$list;
    }

    public function updateAppointment($data)
    {
        if(!empty($data['id'])){
            $res = Db::table('appointment')->update($data);
            return true;
        }
        return false;
    }
}