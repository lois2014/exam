<?php
namespace app\index\controller;

use app\index\service\HospitalService;
use think\View;

class Hospital extends Base
{

    public function getHospitals()
    {
        $hospitalSer = new HospitalService();
        $res = $hospitalSer->getList(0,10,true);
        extract($res);
        $this->assign('list',$list);
        $this->assign('page',$page->render());
        return $this->fetch('hospital_list');
    }

    public function detail()
    {
        $id = $this->request->get('id');
        $hosSer = new HospitalService();
        $hospital = $hosSer->getHospital($id);
//        var_dump($hospital);die;
        $this->assign('hospital',$hospital);
        return $this->fetch('hospital_detail');
    }

}
