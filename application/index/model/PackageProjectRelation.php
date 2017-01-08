<?php
namespace app\index\model;

use think\Db;
use think\Model;

class PackageProjectRelation extends Model
{
    public function getProject($id)
    {
        $Project = Db::table('package_project_relation')->alias('p')
            ->where(['p.id'=>$id])
            ->select();
        return empty($Project)?[]:current($Project);
    }

    public function getProjectBy($where){
        $project = Db::table("package_project_relation")->where($where)->find();
        return empty($project)?[]:$project;
    }

    public function addProject($data)
    {
        return Db::name('package_project_relation')->insertGetId($data);
    }

    public function queryProjectList($where,$order='',$start='',$limit='',$field='*',$userPaginate=false){
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


}