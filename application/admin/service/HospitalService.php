<?php
namespace app\admin\service;

use app\admin\model\Appointment;
use app\admin\model\Hospital;
use app\admin\model\Package;

class HospitalService extends BaseService
{
    public function getList($start = '', $limit = '', $usePaginate = false)
    {
        $hospitalModel = new Hospital();
        $list = $hospitalModel->queryHospitalList(['status' => 1, 'display' => 1], 'create_time DESC', $start, $limit, '*', $usePaginate);
        $packageModel = new Package();
        $appModel = new Appointment();
        if ($usePaginate) {
            $info = $list->toArray()['data'];
        } else {
            $info = $list;
        }
        foreach ($info as &$item) {
            $num = $packageModel->queryPackageList(['status' => 1, 'orga_id' => $item['id']], '', '', '', 'count(id) as num,min(price) as price');
            $item['package_num'] = empty($num) ? 0 : $num[0]['num'];
            $item['price'] = empty($num) ? 0 : intval($num[0]['price']);
            $peopleNum = $appModel->queryAppointmentList(['status' => 1, 'orga_id' => $item['id']], '', '', '', 'count(id) as num');
            $item['people_num'] = empty($peopleNum) ? 0 : $peopleNum[0]['num'];
        }
        if ($usePaginate) {
            $res = [
                'list' => $info,
                'page' => $list
            ];
            return $res;
        }
        return $info;
    }

    public function getHospital($id)
    {
        $hosModel = new Hospital();
        $hospital = $hosModel->getHospital($id);
        return $hospital;
    }

    public function add($data)
    {
        $hosModel = new Hospital();
        $id = $hosModel->addHospital($data);
        return $id;
    }

    public function update($data){
        $hosModel = new Hospital();
        $id = $hosModel->updateHospital($data);
        return $id;
    }
}