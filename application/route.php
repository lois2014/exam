<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    'login'=>'index/User/login',
    'register'=>'index/User/register',
    '/'=>'index/Index/index',
    'getUser'=>'index/User/getUser',
    'logout'=>'index/User/logout',
    'hospital_list'=>'index/Hospital/getHospitals',
    'package_list'=>'index/Package/getPackages',
    'package_detail'=>'index/Package/getPackage',
    'hospital_detail'=>'index/Hospital/detail',
    'order'=>'index/Order/getPackage',
    'addOrder'=>'index/Order/addOrder',
    'orderTime'=>'index/Order/edit',
    'getEnableTime'=>'index/Order/getAppointmentTimes',
    'pay'=>'index/Order/complete',
    'orderDetail'=>'index/Order/detail',

    '/admin'=>'admin/Index/index',
    'admin/userList'=>'admin/User/getUserList',
    'admin/userDetail'=>'admin/User/getUserDetail',
    'admin/appointmentList'=>'admin/Order/getAppointmentList',
    'admin/userEdit'=>'admin/User/setStatus',
    'admin/packageList'=>'admin/Package/getPackages',
    'admin/packageEdit'=>'admin/Package/editPackage',
    'admin/packageAdd'=>'admin/Package/addPackage',
    'admin/packageDel'=>'admin/Package/delPackage',
    'admin/hospitalList'=>'admin/Hospital/getHospitals',
    'admin/hospitalEdit'=>'admin/Hospital/edit',
    'admin/hospitalAdd'=>'admin/Hospital/addHospital',
    'admin/hospitalDel'=>'admin/Hospital/delHospital',
    'admin/projectList'=>'admin/Project/getProjects',
    'admin/projectEdit'=>'admin/Project/editProject',
    'admin/projectAdd'=>'admin/Project/addProject',
    'admin/projectDel'=>'admin/Project/delProject',
];
