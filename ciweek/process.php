<?php
header("Content-type:text/html;charset=utf-8");
include 'phpQuery.php';
$pages = glob('pages/*.shtml');
$link=mysqli_connect("localhost","root","") or die('error connecting');
if(!$link){
	die("数据库连接失败".mysql_errno());
}
mysqli_select_db($link,"phpcmsv9");
mysqli_set_charset($link,"utf8");
$list = "http://www.ciweek.com/list-1.shtml";
$str = file_get_contents($list);
//print_r($str);exit;
//我写的
//preg_match('/<dl class="toppic">[\s\S].*?<dt><a href="(.*?)"/is',$str,$toplink);
//你之前写的
preg_match_all('/<dl class="toppic">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$topiclink);
//preg_match_all('/<dl class="toppic">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$toplink);
//为什么这里打印print_r($toplink[0])或print_r($toplink[0][0][0])匹配不到/article/2017/0109/A2017010919048.shtml
//print_r($topiclink);
print_r($topiclink[1][0]);
