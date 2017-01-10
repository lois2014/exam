<?php
namespace app\index\controller;

use app\index\service\AppointmentService;
use app\index\service\PackageService;
use think\View;

class Order extends Base
{
    public function getPackage()
    {
        $post = $this->request->post();
        if(empty($post)) {
            return $this->error('出错了！！', '/examination/public');
        }
        $packSer = new PackageService();
        $package = $packSer->getPackage($post['package_id']);
        $package['num'] = $post['quantity'];
        $package['total_price'] = $post['quantity'] * $package['price'];
//        var_dump($package);die;
        $this->assign('package',$package);
        return $this->fetch('order');
    }

    protected function setOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    public function addOrder()
    {
        $post = $this->request->post();
        if(empty($post)) {
            return $this->error('出错了！！', '/examination/public');
        }

        $packSer = new PackageService();
        $package = $packSer->getPackage($post['package_id']);
        $data=[
            'user'=>$post['personalName'],
            'mobile'=>$post['personalTel'],
            'num'=>$post['num'],
            'price'=>$post['price'],
            'pack_id'=>$post['package_id'],
            'pack_name'=>$package['name'],
            'orga_id'=>$package['orga_id'],
            'orga_name'=>$package['orga_name'],
            'order_no'=>$this->setOrderNo(),
            'appointment_status'=>1
        ];
        $appSer = new AppointmentService();
        $id = $appSer->addAppointment($data);
        if($id){
            return $this->success('下单成功','/examination/public/orderTime?id='.$id);
        }
        return $this->error('下单失败','/examination/public/order');
    }

    public function edit()
    {
        $post = $this->request->post();
        if(empty($post)){
            $id = $this->request->get('id');
            if(empty($id))   return $this->error('出错了！！', '/examination/public');
            $this->assign('id',$id);
            return $this->fetch('order_time');
        }
        $post = array_merge($post,['appointment_status'=>2]);
        $appSer = new AppointmentService();
        $res = $appSer->updateAppointment($post);
        if(!$res){
            return $this->error('/examination/public/orderTime');
        }else{
            return $this->success('预约成功','/examination/public/pay?id='.$post['id']);
        }
    }

    public function getAppointmentTimes()
    {
        $id = $this->request->get('id');
        $appSer = new AppointmentService();
        $res = $appSer->getTimes($id);
        $times = array_column($res,'available_time');
        return $this->ajaxSuccess($times);
    }
    
    public function  complete()
    {
        $id = $this->request->get('id');
        $appSer = new AppointmentService();
        $app = $appSer->getAppointment($id);
        $this->assign('appointment',$app);
        return $this->fetch('pay');
    }

    public function detail()
    {
        $orderNo = $this->request->get('no');
        $appSer = new AppointmentService();
        $res = $appSer->getDetail($orderNo);
        $this->assign('appointment',$res['appointment']);
        $this->assign('package',$res['package']);
       return $this->fetch('order_detail');
    }
}
