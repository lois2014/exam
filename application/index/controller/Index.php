<?php
namespace app\index\controller;

use think\View;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}
