<?php
namespace app\index\controller;
use app\index\model\Test as TestModel;

use think\Controller;
class test{
    public function index(){
        $testmodel = new TestModel();
        $testmodel->index();
    }

    /**
     * 返回json格式城市
     * @return mixed
     */
    public function weather(){
        //1.初始化curl
        $ch = curl_init();
        $url = 'http://api.yytianqi.com/citylist/id/2';
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        return $output;

    }

    /**
     * 获取到城市id
     */
    public function json(){
      $name = $_GET['city'];
      $city = '[
              {"city_id":"CH","name":"中国","en":"China","list":[
                {"city_id":"CH01","name1":"北京","en1":"b","list":[
                  {"city_id":"CH010100","name2":"北京","en2":"Beijing"}
                ]}]}]';
      // $city = $this->weather();
       $city = json_decode($city,true);
       //var_dump($city);die;
      var_dump($this->deep_in_array($name,$city));
    }

    function deep_in_array($value, $array) {
        static $en = "";
        foreach($array as $key => $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    $en = $key;
                    return $key;
                } else {
                    continue;
                }
            }
            if($this->deep_in_array($value, $item)) {
                return $en;
            }
        }
        return false;
    }
}