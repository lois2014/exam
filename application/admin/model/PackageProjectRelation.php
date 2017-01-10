<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class PackageProjectRelation extends Model
{
    public function getRelation($id)
    {
        $Project = Db::table('package_project_relation')->alias('p')
            ->where(['p.id'=>$id])
            ->select();
        return empty($Project)?[]:current($Project);
    }

    public function getRelationsBy($where){
        $project = Db::table("package_project_relation")->where($where)->select();
        return empty($project)?[]:$project;
    }

    public function addRelation($data)
    {
        return Db::name('package_project_relation')->insertGetId($data);
    }

    public function queryRelationList($where,$order='',$start='',$limit='',$field='*',$userPaginate=false){
        $query = Db::table('package_project_relation')->field($field)->where($where);
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

    public function deleteRelation($where)
    {
        if(empty($where)) return false;
        $res = Db::table('package_project_relation')->where($where)->delete();
        return true;
    }

}