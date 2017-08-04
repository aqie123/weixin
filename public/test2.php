<?php

namespace china\beijing ;
function test(){
echo "北京";
}

include ("./common.php");
namespace china\shandong;
function test(){
echo "山东";
}
class People{
    static $name = "山东人";
}

//include ("./common.php");
test();
\test();            // 访问公共命名空间 函数
echo \People::$name;   // 访问公共命名空间 类