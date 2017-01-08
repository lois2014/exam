<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Package extends Model
{
    public function getPackage($id)
    {
        $package = Db::table('package')->alias('p')
            ->where(['p.id'=>$id])
            ->field('p.*,h.name as orga_name,h.level,h.address,h.avaliable_time,h.picture as orga_picture')
            ->join('hospital h','h.id = p.orga_id','left')
            ->select();
        return empty($package)?[]:current($package);
    }

    public function getPackageBy($where){
        $user = Db::table("package")->where($where)->find();
        return empty($user)?[]:$user;
    }

    public function addPackage($data)
    {
        return Db::name('package')->insertGetId($data);
    }

    public function queryPackageList($where,$order='',$start='',$limit='',$field='*',$userPaginate=false){
        $query = Db::table('package')->field($field)->where($where);
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

    public function updatePackage($data)
    {
        if(!empty($data['id'])) {
            $pack = new Package();
            $pack->allowField(true)->update($data);
            return $data['id'];
        }
        return '';
    }
}