<?php
$str = "php中国+';lj  lkjlk";
$content2 = str_replace("'", "''", $str);
$content1 =  htmlspecialchars($content2,ENT_QUOTES);

print_r($content1);
echo '<br>';
print_r($content2);


header("Content-Type;text/html;charset=utf-8");

$list = 'http://ciweek.com/v7/list.jsp';
$str = file_get_contents($list);
$str = iconv('GB2312','UTF-8',$str);
preg_match("/\\?page=(\\d+)[^>]+>[\\x{4e00}-\\x{9fa5}]{2}</u",$str,$arr1);//

//preg_match("/\\?page=(\\d+)[^>]+>[\\x{4e00}-\\u9fa5]{2}</u",$str,$arr1);
echo '<pre>';
var_dump($arr1[1]);exit;
?>