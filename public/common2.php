<?php

namespace china\beijing ;
function test(){
    echo "北京";
}


namespace china\shandong;
function test(){
    echo "山东";
}
function test2(){
    echo "山东人2";
}
class People{
    static $name = "山东人";
}