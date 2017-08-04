<?php
/**
 * 公共空间
 */
include ("./common2.php");
function test(){
    echo "天津";
}
class People{
    static $name = "天津人";
}
test();   // 当前元素  天津
\test(); // 绝对访问方式  天津

china\beijing\test();  // 无命名空间访问有命名空间要写全

/*
 1.命名空间 对类，函数，常量起作用
2.命名空间虚拟抽象空间，不是存在的目录
3.声明命名空间前不能有任何代码