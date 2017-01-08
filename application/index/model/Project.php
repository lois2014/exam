<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Project extends Model
{
    public function getProject($id)
    {
        $Project = Db::table('Project')->alias('p')
            ->where(['p.id'=>$id])
            ->field('p.*,h.name as orga_name')
            ->join('hospital h','h.id = p.orga_id','left')
            ->select();
        return empty($Project)?[]:current($Project);
    }

    public function getProjectBy($where){
        $project = Db::table("Project")->where($where)->find();
        return empty($project)?[]:$project;
    }

    public function addProject($data)
    {
        return Db::name('Project')->insertGetId($data);
    }

    public function queryProjectList($where,$order='',$start='',$limit='',$field='*',$userPaginate=false){
        $query = Db::table('Project')->field($field)->where($where);
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

    public function getProjectsByPackageId($id){
        $list = Db::table('project')
            ->alias('pr')
            ->field('c.name as cate_name,c.id as cate_id,pr.name as pro_name,pr.target')
            ->join('package_project_relation r','r.pro_id = pr.id','left')
            ->join('project_category c','c.id = pr.cate_id')
            ->where(['r.pack_id'=>$id,'pr.status'=>1])
            ->select();
        return empty($list)?[]:$list;
    }

}