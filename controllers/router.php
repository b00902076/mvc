<?php
    function __autoload($className)
    {
        //解析文件名，得到文件的存放路径，如News_Model表示存放在models文件夹里的news.php（这里是作者的命名约定）
        list($filename , $suffix) = split('_' , $className);
        
        $file = SERVER_ROOT . '/models/' . strtolower($filename) . '.php';
        
        if (file_exists($file))
        {
            include_once($file);
        }
        else
        {
            //autoloadview($className);
            die("File '$filename' containing class '$className' not found.");
        }
    }

    
    $request = $_SERVER['QUERY_STRING'];
    $parsed = explode('&' , $request);
    
    $page = array_shift($parsed);
    $getVars = array();
    foreach ($parsed as $argument)
    {
        //用"="分隔字符串，左边为变量，右边为值
        list($variable , $value) = split('=' , $argument);
        $getVars[$variable] = $value;
    }
    
    $target = SERVER_ROOT . '/controllers/' . $page . '.php';
    if (file_exists($target))
    {
        include_once($target);
        
        //修改page变量，以符合命名规范（如$page="news"，我们的约定是首字母大写，控制器的话就在后面加上“<strong>_Controller”</strong>,即News_Controller）
        $class = ucfirst($page) . '_Controller';
        
        //初始化对应的类
        if (class_exists($class))
        {
            $controller = new $class;
        }
        else
        {
            //类的命名正确吗？
            die('class does not exist!');
        }
    }
    else
    {
        //不能在controllers找到此文件
        die('page does not exist!');
    }
    
    $controller->main($getVars);
?>
