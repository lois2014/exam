<?php
namespace app\admin\service;

use app\admin\model\User;

class UserService extends BaseService
{
    public function add($data){
        $user=[
            'true_name'=>$data['name'],
            'user_name'=>$data['user_name'],
            'password'=>md5($data['password']),
            'mobile'=>$data['mobile'],
            'email'=>$data['mail'],
            'birthday'=>$data['birthday'],
            'marry'=>$data['marry']=='y'?2:1,
            'card_type'=>$data['cardType']=='IDCard'?'1':0,
            'card'=>$data['card'],
            'gender'=>$data['sex']
        ];
        $userModel = new User();
        return $userModel->addUser($user);
    }

    public function checkUser($userName,$password=''){
        $userModel = new User();
        if(empty($password)){
            return $userModel->getUserBy(['user_name'=>$userName]);
        }
        return $userModel->getUserBy(['user_name'=>$userName,'password'=>$password]);
    }

    public function getList($limit)
    {
        $userModel = new User();
        $list = $userModel->queryUserList('','create_time DESC','',$limit,'*',true);
        $users = $list->toArray()['data'];
        foreach($users as &$user) {
            $role = $userModel->getRole($user['role_id']);
            if (!empty($role)) {
                $user['role_name'] = $role['name'];
            }
        }
        return [
            'list'=>$users,
            'page'=>$list->render()
        ];
    }

    public function getDetail($id)
    {
        if(empty($id)) return [];
        $userModel = new User();
        $user = $userModel->getUser($id);
        return $user;
    }

    public function updateUser($data)
    {
        $userModel = new User();
        return $userModel->updateUser($data);
    }
}