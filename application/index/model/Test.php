<?php
namespace app\index\model;

use think\Model;
class Test extends Model{
    public function index(){
        echo "test model 方法";
    }
}