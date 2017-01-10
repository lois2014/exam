<?php
namespace app\admin\service;

use app\admin\model\Appointment;
use app\admin\model\Hospital;
use app\admin\model\Package;
use app\admin\model\PackageProjectRelation;
use app\admin\model\Project;

class PackageService extends BaseService
{
    public function getList($start='',$limit=''){
        $packModel = new Package();
        $list = $packModel->queryPackageList(['status'=>1,'display'=>1],['create_time DESC'],$start,$limit);
        $hospModel = new Hospital();
        $appModel = new Appointment();
        foreach($list as &$item){
            $item['hospital']=$hospModel->getHospital($item['orga_id']);
            $num = $appModel->queryAppointmentList(['status'=>1,'pack_id'=>$item['id'],'appointment_status'=>2],'','','',['sum(num) as num']);
            $item['sale_num'] = empty($num)?0:$num[0]['num'];
        }
        return empty($list)?[]:$list;
    }

    public function getPaginateList($limit='')
    {
        $packModel = new Package();
        $res = $packModel->queryPackageList(['status'=>1,'display'=>1],['create_time DESC'],'',$limit,'',true);
        $hospModel = new Hospital();
        $appModel = new Appointment();
        $list = $res->toArray()['data'];
        foreach($list as &$item){
            $item['hospital']=$hospModel->getHospital($item['orga_id']);
            $num = $appModel->queryAppointmentList(['status'=>1,'pack_id'=>$item['id'],'appointment_status'=>2],'','','',['sum(num) as num']);
            $item['sale_num'] = empty($num)?0:$num[0]['num'];
        }
        $ret=[
            'list'=>$list,
            'page'=>$res
        ];
        return $ret;
    }

    public function getPackage($id)
    {
        $packModel = new Package();
        $package = $packModel->getPackage($id);
        $appModel = new Appointment();
        $num = $appModel->queryAppointmentList(['status'=>1,'pack_id'=>$package['id']],'','','',['count(id) as num']);
        $package['sale_num'] = empty($num)?0:$num[0]['num'];
        $proModel = new Project();
        $project=$proModel->getProjectsByPackageId($id);
//        $proList = [];
//        $cnt=0;
//        foreach ($project as $key=>$item){
//            $proList[$item['cate_name']]['list'][]=$item;
//            $proList[$item['cate_name']]['size']=isset( $proList[$item['cate_name']]['size'])? $proList[$item['cate_name']]['size']+1:1;
//            $proList[$item['cate_name']]['cate_name']=$item['cate_name'];
//        }
        $package['project'] = $project;
        return empty($package)?[]:$package;
    }

    public function updatePackage($data)
    {
        $packModel = new Package();
        $proModel = new Project();
        $relModel = new PackageProjectRelation();
        $relModel->deleteRelation(['pack_id'=>$data['id']]);
        if(isset($data['projects'])){
            foreach ($data['projects'] as $proId){
                $add=[
                    'pack_id'=>$data['id'],
                    'pro_id'=>$proId,
                    'type'=>1
                ];
                $ids[]=$relModel->addRelation($add);
            }
            unset($data['projects']);
        }
        return $packModel->updatePackage($data);
    }

    public function addPackage($data)
    {
        $packModel = new Package();
        if(!empty($data['projects'])) {
            $projects = $data['projects'];
            unset($data['projects']);
        }
        $id = $packModel->addPackage($data);
        if(isset($projects)){
            foreach ($projects as $proId){
                $add=[
                    'pack_id'=>$id,
                    'pro_id'=>$proId,
                    'type'=>1
                ];
                $relModel = new PackageProjectRelation();
                $ids[]=$relModel->addRelation($add);
            }
        }

        return $id;
    }

    public function updateRelation($pack_id,$data){
        $relModel = new PackageProjectRelation();
        return $relModel->where(['pack_id'=>$pack_id])->update($data);
    }
}