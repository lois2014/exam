<?php
namespace app\index\controller;

use app\index\service\HospitalService;
use app\index\service\PackageService;
use think\View;

class Index extends Base
{
    public function index()
    {
        $hospitalSer = new HospitalService();
        $packSer = new PackageService();
        $hospitalList = $hospitalSer->getList(0,6);
        $packList = $packSer->getList(0,6);
        $this->assign('hospitals',$hospitalList);
        $this->assign('packages',$packList);
        return $this->fetch();
    }
}
