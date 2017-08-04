<?php
namespace tianjin;
function test(){
    echo 11;
    $arr = [];
    if($arr['name']=='aqie'){
        echo 'aqie';
    }else{
        echo 'no aqie';
    }
}
namespace china\beijing ;
function test(){
    echo "北京";
}

namespace china\shandong;
function test(){
    echo "山东";
}
namespace china;
function test(){
    echo "中国";
}
class People{
    static $name="中国人";
}

test();             // 非限定名称 当前命名空间 22
\tianjin\test();    // 完全限定名称 添加绝对路径  11
beijing\test();     //  限定名称   33

namespace meiguo\niuyue;
function test(){
    echo "美国";
}
class People{
    static $name="美国人";
}

test();
\china\shandong\test();


// 引入命名空间
use china\People as ch;   // 别名  (当前空间已经有people)
echo People::$name;

use china;
china\test();    // 必须加上最近的命名空间  函数

echo china\People::$name;  // 类

use meiguo\niuyue;
echo niuyue\People::$name;
