<?php
set_time_limit(0);
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
//print_r($str);
//匹配topic的链接
preg_match_all('/<dl class="toppic">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$topiclink);
//print_r($topiclink[1][0]);///article/2017/0109/A2017010919048.shtml
//exit;
//匹配topic的图片
preg_match_all('/<dl class="toppic">[\s\S].*?<dt><a href=".*?<img src="(.*?)".*<\/a><\/dt>/is',$str,$topicarr);
//print_r($topicarr[1][0]);exit;

//匹配页码最大数
//preg_match("/\\?page=(\\d+)[^>]+>[\\x{4e00}-\\x{9fa5}]{2}</u",$str,$arr1);
preg_match("#\.\.<a.*?>(\d+)</a>#",$str,$arr1);//最完美匹配
//print_r($arr1[1]);exit;//此时得到页码最大数字
$pagearr=array();
for($i=1;$i<=$arr1[1];$i++){	
	$pagearr[]="http://www.ciweek.com/list-{$i}.shtml";
}
//echo '<pre>';print_r($pagearr);exit;
//遍历所有分页内容（每页）
foreach ($pagearr as $k => $v){
	$list2 = file_get_contents($v);
	//print_r($list2);
//print_r($str);exit;
//exit;
//匹配列表的链接
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$link_arr);
//print_r($link_arr[1]);
//匹配列表的图片
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href=".*?<img src="(.*?)"/s',$str,$arr2);
//print_r($arr2[1]);exit;//打印出图片的数组
//遍历且组成一个新的数组thumbarr
echo '<pre>';
foreach ($link_arr[1] as $k=>$v){
	//print_r($v);exit;// 打印出/article/2017/0109/A2017010919047.shtml
	//print_r($k);exit;//打印出$link_arr的下标，$link_arr[1]的$k和$arr2[1]的$k是一致的
	$img = $arr2[1][$k];
	$thumbarr['http://www.ciweek.com'.$v]=$img;
	//print_r($thumbarr['http://www.ciweek.com'.$v]=$img);
}
//print_r($thumbarr);exit;//打印所有列表的链接为键名和图片为键值
///* 将 EUC-JP 转换成 UTF-7 */
//$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
$thumbarr['http://www.ciweek.com'.$topiclink[1][0]] = $topicarr[1][0];
$topic = array('http://www.ciweek.com'.$topiclink[1][0]=>$topicarr[1][0]);
//print_r($thumbarr);
//print_r($topic);exit;
//新闻正文
foreach ($thumbarr as $key2 => $value2){
	phpQuery::newDocumentHtml(
		//mb_convert_encoding(file_get_contents($key2),'UTF-8','GB2312') 
		file_get_contents($key2)
 		);
	//print_r(key($topic))) ;//函数返回数组中内部指针指向的当前单元的键名
	if($key2 == key($topic)){
		$rec['toppic']=1;
	}else{
		$res['toppic']=0;
	}
$rec['thumb'] = $value2;//图片
//print_r($rec['thumb']);
$rec['url']= $key2;//链接
$rec['typeid']= 0;
$rec['relation'] = '';
$rec['inputtime'] =strtotime(pq("span.spdate")->text());//时间戳
	if($rec['inputtime']){

	}else{
		var_dump(strtotime(pq("span.spdate")->text()));
	}

$rec['updatetime'] = 0;
$rec['islink'] = 0;
$rec['username'] = pq("span.author")->html();
$rec['template'] ='';
$rec['allow_comment'] ='1';
$rec['readpoint'] = '0';
$rec['paytype'] ='0';
$rec['catid'] ='6';
$rec['title'] = pq("p.title")->text();
//$rec['keywords'] = pq("meta[name='keywords']")->attr('content');
$rec['keywords'] = '从数据库里输出keywords';
$rec['copyfrom'] = pq("span.spauthor")->text();
//$rec['description'] = pq("meta[name='description']")->attr('content');
$rec['description'] = '从数据库里输出description';
$content=pq("div.text")->html();
//print_r($content);
$rec['content'] =htmlspecialchars(str_replace("'","''",$content),ENT_QUOTES);
//print_r($rec['content']);//看不出来有什么变化
$rec['paginationtype'] = '0';
  $rec['maxcharperpage'] = '10000';
  $rec['posids'][0] =1;
  $rec['groupids_view' ]='1';
  $rec['voteid'] = '0';
  $rec['status'] =99; 
  $rec['style']='';
  $rec['style_color' ]='';
  $rec['style_font_weight'] ='';
  $rec['copyfrom_data'] ='0';
  $rec['page_title_value']='';
  $rec['add_introduce'] ='1' ;
  $rec['introcude_length'] ='200';
  $rec['auto_thumb' ]='1';
  $rec['auto_thumb_no'] ='1';
  $rec['dosubmit'] ='保存后自动关闭';
  $rec['pc_hash' ]='GwcB3O';
  $rec['listorder'] = 0;
  $rec['sysadd'] = 0;
  $str=explode('/',$value2);
  //print_r($str);
  //打印出来
  /*Array(
    [0] => http:
    [1] => 
    [2] => images.enet.com.cn
    [3] => i
    [4] => 2017
    [5] => 0109
    [6] => 032942445.jpg
)
*/
$sql1 = "insert into v9_news_copy(catid,typeid,title,style,thumb,keywords,description,posids,url,listorder,status,sysadd,islink,username,inputtime,updatetime) values('{$rec['catid']}','{$rec['typeid']}','{$rec['title']}','{$rec['style']}','{$rec['thumb']}','{$rec['keywords']}','{$rec['description']}','{$rec['posids'][0]}','{$rec['url']}','{$rec['listorder']}','{$rec['status']}','{$rec['sysadd']}','{$rec['islink']}','{$rec['username']}','{$rec['inputtime']}','{$rec['updatetime']}')";

//var_dump($sql1);
//exit;
echo "<br>";
    $result = mysqli_query($link,$sql1);
	if($result && $TT =mysqli_affected_rows($link)>0){
		$articleid =mysqli_insert_id($link);
		$sql2 = "insert into v9_news_data_copy(id,content,readpoint,groupids_view,paginationtype,maxcharperpage,template,paytype,relation,voteid,allow_comment,copyfrom) values('{$articleid}','{$rec['content']}','{$rec['readpoint']}','{$rec['groupids_view']}','${rec['paginationtype']}','{$rec['maxcharperpage']}','{$rec['template']}','{$rec['paytype']}','{$rec['relation']}','{$rec['voteid']}','{$rec['allow_comment']}','{$rec['copyfrom']}')";
		
		$result=mysqli_query($link,$sql2);
		if($result && mysqli_affected_rows($link)>0){
			echo "sql2语句成功执行";
		}else{
			$file='a.txt';
			$checkerror =$articleid."\r\n".$sql2;
			$current =file_put_contents($file,$checkerror,FILE_APPEND);
		}
		//print_r($sql1);//每页循环10条新闻列表
	}else{
		$file="b.txt";
		$checkerror =$result.PHP_EOL.$TT.PHP_EOL.$articleid."\r\n".$sql1;
		$current =file_put_contents($file,$checkerror,FILE_APPEND);
	}
}
}