<?php
namespace app\index\controller;

use app\index\service\PackageService;
use think\View;

class Package extends Base
{

    public function getPackages()
    {
        $packSer = new PackageService();
        $res = $packSer->getPaginateList(10);
        extract($res);
        $this->assign('list',$list);
        $this->assign('page',$page->render());
        return $this->fetch('package_list');
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
}
