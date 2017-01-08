<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class ProjectCategory extends Model
{

    public function queryProjectCategoryList($where,$order='',$start='',$limit='',$field='*',$userPaginate=false){
        $query = Db::table('project_category')->field($field)->where($where);
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