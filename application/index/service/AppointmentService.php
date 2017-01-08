<?php
namespace app\index\service;

use app\admin\model\Appointment;
use app\admin\model\Package;
use app\admin\model\PackageAppointment;

class AppointmentService extends BaseService
{
    public function addAppointment($data)
    {
        $appSer = new Appointment();
        $id = $appSer->addAppointment($data);
        return $id;

    }public function getAppointment($id)
    {
        $appSer = new Appointment();
        $res = $appSer->getAppointment($id);
        return $res;
    }

    public function updateAppointment($data)
    {
        $appModel = new Appointment();
        if(!empty($data['id'])){
            $res = $appModel->updateAppointment($data);
            return true;
        }
        return false;
    }

    public function getTimes($app_id)
    {
        $appSer = new Appointment();
        $app = $appSer->getAppointment($app_id);
        if(!isset($app['pack_id'])) return [];
        $packAppModel = new PackageAppointment();
        $apps = $packAppModel->getPackageAppointmentsBy(['status'=>1,'pack_id'=>$app['pack_id']]);
        return $apps;
    }

    public function getDetail($orderNo){
        $appModel = new Appointment();
        $app = $appModel->getAppointmentBy(['status'=>1,'order_no'=>$orderNo]);
        $packModel = new Package();
        $package = $packModel->getPackage($app['pack_id']);
        $ret['package'] = $package;
        $ret['appointment']=$app;
        if(empty($ret)) return [];
        return $ret;
    }
}