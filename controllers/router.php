<?php 
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
    print "The page your requested is '$page'";
    print '<br/>';
    $vars = print_r($getVars, TRUE);
    print "The following GET vars were passed to the page:<pre>".$vars."</pre>";
?>
