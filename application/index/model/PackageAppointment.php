<?php
namespace app\index\model;

use think\Db;
use think\Model;

class PackageAppointment extends Model
{
    public function getPackageAppointment($id)
    {
        $user = Db::table("package_appointment")->where('id',$id)->find();
        return empty($user)?[]:$user;
    }

    public function getPackageAppointmentsBy($where){
        $user = Db::table("package_appointment")->where($where)->select();
        return empty($user)?[]:$user;
    }

    public function addAppointment($data)
    {
        return Db::name('package_appointment')->insertGetId($data);
    }

    public function queryAppointmentList($where,$order='',$start='',$limit='',$field='*'){
        $query = Db::table('package_appointment')->field($field)->where($where);
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
            $res = Db::table('package_appointment')->update($data);
            return true;
        }
        return false;
    }
}