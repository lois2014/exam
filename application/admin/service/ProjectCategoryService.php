<?php
namespace app\admin\service;

use app\admin\model\Appointment;
use app\admin\model\Hospital;
use app\admin\model\Package;
use app\admin\model\Project;
use app\admin\model\ProjectCategory;

class ProjectCategoryService extends BaseService
{
    public function getList($start='',$limit=''){
        $proModel = new  ProjectCategory();
        $list = $proModel->queryProjectCategoryList(['status'=>1],'',$start,$limit);
        return empty($list)?[]:$list;
    }

    public function getPaginateList($limit='')
    {
        $proModel = new Project();
        $res = $proModel->queryProjectList(['status'=>1],['create_time DESC'],'',$limit,'id',true);
        $list = $res->toArray()['data'];
        foreach($list as &$item){
            $item = $proModel->getProject($item['id']);
        }
        $ret=[
            'list'=>$list,
            'page'=>$res->render()
        ];
        return $ret;
    }

    public function getProject($id)
    {
        $proModel = new Project();
        $package = $proModel->getProject($id);
        return empty($package)?[]:$package;
    }

    public function updateProject($data)
    {
        $proModel = new Project();
        return $proModel->updateProject($data);
    }
}