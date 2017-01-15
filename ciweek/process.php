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
//匹配topic的链接
preg_match_all('/<dl class="toppic">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$topiclink);
print_r($topiclink[1][0]);
//exit;
//匹配topic的图片
preg_match_all('/<dl class="toppic">[\s\S].*?<dt><a href=".*?<img src="(.*?)".*<\/a><\/dt>/is',$str,$topicarr);
//print_r($topicarr[1][0]);exit;

//匹配页码最大数
//preg_match("/\\?page=(\\d+)[^>]+>[\\x{4e00}-\\x{9fa5}]{2}</u",$str,$arr1);
preg_match("#\.\.<a.*?>(\d+)</a>#",$str,$arr1);//最完美匹配
//print_r($arr1[1]);
//exit;
//匹配列表的链接
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$link_arr);
//print_r($link_arr[1]);
//匹配列表的图片
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href=".*?<img src="(.*?)"/s',$str,$arr2);
//print_r($arr2[1]);
//遍历且组成一个新的数组thumbarr
echo '<pre>';
foreach ($link_arr[1] as $k=>$v){
	//print_r($v);
	$img = $arr2[1][$k];
	$thumbarr['http://www.ciweek.com'.$v]=$img;
	//print_r($thumbarr['http://www.ciweek.com'.$v]=$img);
}
//print_r($thumbarr);
///* 将 EUC-JP 转换成 UTF-7 */
//$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
$thumbarr['http://www.ciweek.com'.$topiclink[1][0]] = $topicarr[1][0];
$topic = array('http://www.ciweek.com'.$topiclink[1][0]=>$topicarr[1][0]);
foreach ($thumbarr as $key2 => $value2){
	phpQuery::newDocumentHtml(
		file_get_contents($key2)
 
 		);
	if($value2 == key($topic)){
		$rec['toppic']=1;
	}else{
		$res['toppic']=0;
	}
}