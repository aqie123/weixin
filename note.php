1.安装 composer create-project topthink/think tp5  --prefer-dist
2.自动生成
    build.php放到application里面
    a.在入口文件index.php (使用生成文件)
        //获取自动生成定义文件
        $build = include APP_PATH.'build.php';
        // 运行自动生成
        \think\Build::run($build);
    b.在入口文件index.php (不使用生成文件)

3. index.php/模块/控制器/方法
    http://www.tp5.com/index.php/admin/index/aqie
    http://www.tp5.com/index.php/index/index/index  (默认访问)
4.模块设计
    a.多模块(前后台)
    b.命名空间：（惰性加载，命名空间转换为实际目录）
        namespace app\admin\controller;
        namespace app\index\controller;
    c.use think\Controller  引入空间类元素 library/think/Controller.php
    d.