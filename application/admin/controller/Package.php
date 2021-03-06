<?php
namespace app\admin\controller;

use app\admin\service\AppointmentService;
use app\admin\service\HospitalService;
use app\admin\service\PackageService;
use app\admin\service\ProjectService;
use think\View;

class Package extends Base
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function getPackages()
    {
        $packSer = new PackageService();
        $res = $packSer->getPaginateList(10);
        extract($res);
        $this->assign('list',$list);
        $this->assign('page',$page->render());
        return $this->fetch('index');
    }

    public function getPackage()
    {
        $id = $this->request->get('id');
        $packSer = new PackageService();
        $package = $packSer->getPackage($id);
//        var_dump($package);die;
        $this->assign('package',$package);
        return $this->fetch('package_detail');
    }

    public function editPackage()
    {
        $data = $this->request->post();
        $packSer = new PackageService();
        $proSer = new ProjectService();
        $hosSer = new HospitalService();
        if(empty($data)){
            $id = $this->request->get('id');
            if(empty($id)) return $this->error('出错了！！',ADMIN_URL_PATH);
            $package = $packSer->getPackage($id);
            $projects = $proSer->getList();
            $hospitals = $hosSer->getList();
            foreach ($projects as &$project) {
                foreach ($package['project'] as $pro){
                    if(intval($project['id']) == intval($pro['id'])){
                        $project['select'] = 1;break;
                    }
                }
            }

            $appSer = new AppointmentService();
            $res = $appSer->getTimes($id);
            $times = array_column($res,'available_time');
            $this->assign('package',$package);
            $this->assign('projects',$projects);
            $this->assign('hospitals',$hospitals);

            return $this->fetch('detail');
        }
        $file = !empty($_FILES['package_pic'])?$_FILES['package_pic']:'';
        if($file && !empty($file['name'])){
            $res = json_decode($this->checkImg($file),true);
            if($res['state'] == 0){
                return $this->error($res['msg'],ADMIN_URL_PATH.'packageList');
            }
            $filePath = $this->upload($file);
            if(!$filePath)  return $this->error('更新失败',ADMIN_URL_PATH.'packageList');
            $data['picture'] = $filePath;
        }
        // echo 'fail';die;
        unset($data['MAX_FILE_SIZE']);
        $package = $packSer->updatePackage($data);
        return $this->success('更新成功',ADMIN_URL_PATH.'packageList');
    }
    public function delPackage()
    {
        $id = $this->request->get('id');
        if(empty($id)) return $this->error('出错了！！',ADMIN_URL_PATH);
        $id = $this->request->get('id');
        $packSer = new PackageService();
        $data=[
            'id'=>$id,
            'status'=>0
        ];
        $package = $packSer->updatePackage($data);
        $res = $packSer->updateRelation($id,['status'=>0]);
        return $this->success('删除成功',ADMIN_URL_PATH.'packageList');
    }

    public function addPackage()
    {
        $data = $this->request->post();
        $packSer = new PackageService();
        $proSer = new ProjectService();
        $hosSer = new HospitalService();
        if(empty($data)){
            $projects = $proSer->getList();
            $hospitals = $hosSer->getList();

//            var_dump($projects);die;
            $this->assign('projects',$projects);
            $this->assign('hospitals',$hospitals);

            return $this->fetch('add');
        }
        $file = !empty($_FILES['picture'])?$_FILES['picture']:'';
        if($file && !empty($file['name'])){
            $res = json_decode($this->checkImg($file),true);
            if($res['state'] == 0){
                return $this->error($res['msg'],ADMIN_URL_PATH.'packageList');
            }
            $fileName = $file['name'];
            
            $filePath = $this->upload($file);
            if(!$filePath)  return $this->error('新增失败',ADMIN_URL_PATH.'packageList');
            $data['picture'] = $filePath;
            unset($_FILES['picture']);
        }
        unset($data['MAX_FILE_SIZE']);
        $package = $packSer->addPackage($data);
        return $this->success('新增成功',ADMIN_URL_PATH.'packageList');
    }
}
