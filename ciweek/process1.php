<?php
header("Content-Type;text/html;charset=utf-8");
include 'phpQuery.php';
$pages = glob('pages/*.shtml');
$mysql_server_name="localhost";//服务器
$mysql_username="root";//数据库用户名
$mysql_password="";//密码
$mysql_database="phpcmsv9";//数据库名
/*$mysql_server_name="localhost";//服务器
$mysql_username="root";//数据库用户名
$mysql_password="";//密码
$mysql_database="testgrab";//数据库名*/
//连接数据库
//var_dump($pages);
$link=mysqli_connect($mysql_server_name,$mysql_username,$mysql_password);

if(!$link){
    die("数据库连接失败".mysql_errno());
}
mysqli_set_charset($link,"utf8");
mysqli_select_db($link,$mysql_database);//打开数据库
$list = "http://ciweek.com/v7/list.jsp";
$str = file_get_contents($list);
$str = iconv('GB2312','UTF-8',$str);
//匹配topic的链接
preg_match_all('/<dl class="toppic">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$topiclink);
//匹配topic的图片
preg_match_all('/<dl class="toppic">[\s\S].*?<dt[^>]*.<a href=".*?<img src="(.*?)".*<\/a><\/dt>/is',$str,$topicarr);

//var_dump($topic);
//exit;
preg_match("/\\?page=(\\d+)[^>]+>[\\x{4e00}-\\x{9fa5}]{2}</u",$str,$arr1);//分页的最大页码数
// 获取所有分页
$page = array();
$i = 1;
for($i=1;$i<$arr1[1]+1;$i++){
 $page[$i] = $i;
$list2[]="http://ciweek.com/v7/list.jsp?page={$page[$i]}&siteid=ciweek&ccid=7510";

}
echo '<pre>';
//遍历所有分页内容(每页)
foreach ($list2 as $key1 =>$value1){

  $str = file_get_contents($value1);
  //var_dump($str);die;
  $str = mb_convert_encoding($str,'UTF-8','GB2312');
//匹配列表的链接
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href="(.*?)"/is',$str,$link_arr);

//匹配列表的图片
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href=".*?<img src="(.*?)<\/a><\/dt>/is',$str,$arr2);
//var_dump($link_arr[1]);die;
//var_dump($arr2[1]);die;
  foreach ($link_arr[1] as $k => $v){
    $url = 'pages'.substr($v,strrpos($v,'/'));
    $img = $arr2[1][$k];
    $thumbarr[$url] = $img; 
  }
}
//var_dump($thumbarr);


//var_dump($thumbarr['pages/A20151112568595.shtml']);
//打印出了string(53) "http://images.enet.com.cn/i/2016/1021/051800897.jpg">"
//var_dump($topicarr[1][0]);die;//http://images.enet.com.cn/2016/1019/11/8476108.jpg
$thumbarr['pages'.substr($topiclink[1][0],strrpos($topiclink[1][0],'/'))] = $topicarr[1][0];
$topic = array('pages'.substr($topiclink[1][0],strrpos($topiclink[1][0],'/'))=>$topicarr[1][0]);
var_dump($topic);// 'pages/A20161019574275.shtml' => string 'http://images.enet.com.cn/2016/1019/11/8476108.jpg' (length=50)
//获取文章数据
foreach ($pages as $key2 => $value2) {
  var_dump($value2);//pages/A20151112568595.shtml
    phpQuery::newDocumentHtml(
    //iconv('gbk','utf-8',file_get_contents($value2))
      mb_convert_encoding(file_get_contents($value2),'UTF-8','GB2312')
    );
    //var_dump($value2);exit;//'http://ciweek.com/article/'
    //$rec['url'] =pq("dl.toppic a:eq(0)","href");
  if($value2 == key($topic)){
    $rec['toppic']=1;
  }else{
    $rec['toppic']=0;
  }

  $rec['typeid'] = 0;
  //echo($_title ."\n");
  $rec['thumb'] =$thumbarr[$value2];
  //var_dump( $rec['thumb']);die;
  $rec['relation'] ='';
  //$rec['relation'] ='';
  $rec['inputtime'] =strtotime(pq("span.spdate")->text());

  if($rec['inputtime']){
    //var_dump('11111111111');
  }else{
    $rec['inputtime'] =0;
    //var_dump('2222222222');
    var_dump(pq("span.spdate")->text());
  }
  //var_dump($rec['inputtime']);
  $rec['updatetime'] = 0;
  $rec['islink'] = 0;
  $rec['username'] =pq("span.author")->html();
  $rec['template'] = '';
  $rec['allow_comment'] = '1'; 
  $rec['readpoint'] = '0'; 
  $rec['paytype'] = '0'; 
  $rec['catid'] = '9'; 
  $rec['title'] = pq("p.title")->text(); 
  $rec['keywords'] = pq("meta[name='keywords']")->attr('content');
  $rec['copyfrom'] = pq("span.spauthor")->text();
  $rec['description'] = pq("meta[name='description']")->attr('content');
  //$rec['content'] =  htmlentities(pq("div.text")->html());


  $aa =pq("div.text")->html();
  $rec['content'] =  htmlspecialchars(str_replace("'", "''", $aa),ENT_QUOTES);
  //$rec['content'] =  htmlspecialchars(pq("div.text")->html());
  //$rec['content'] =  addcslashes(pq("div.text")->html(),"'");
  //$rec['content'] =  stripcslashes(pq("div.text")->html());
 //$rec['content'] =  addslashes(pq("div.text")->html());
  //$rec['content'] =  stripslashes(pq("div.text")->html());
  //$rec['content'] =  quotemeta(pq("div.text")->html());
  $rec['paginationtype'] = '0';
  $rec['maxcharperpage'] = '10000';
  $rec['posids'][0] =1;
  $rec['groupids_view' ]='1';
  $rec['voteid'] = '0';
  $rec['status'] =99; 
  $rec['style']='';
  $rec['style_color' ]='';
  $rec['style_font_weight'] ='';
  //$rec['style_font_weight'] ='';

  $rec['copyfrom_data'] ='0';
  $rec['page_title_value']='';
  $rec['add_introduce'] ='1' ;
  $rec['introcude_length'] ='200';
  $rec['auto_thumb' ]='1';
  $rec['auto_thumb_no'] ='1';
  $rec['dosubmit'] ='保存后自动关闭';
  $rec['pc_hash' ]='GwcB3O';
  //$rec['pc_hash' ]=  'GwcB3O';
  $rec['listorder'] = 0;
  $rec['sysadd'] = 0;
  $str = explode('/',$value2);
  $rec['url'] ='http://ciweek.com/article/'.substr($str[1],1,4).'/'.substr($str[1],5,4).'/'.$str[1];
  
  //$rec['url'] = "$value";
 // $rec['url'] = 'http://ciweek.com/article/'."$value";
  
  /*$str = substr($value,0,strpos($value,'/'));
  $rec['url'] ='http://ciweek.com/article/'.date('Y',time()).'/'.date('md',time()).$str[1];*/
  /*$str = substr($value,0,strpos($value,'/'));
  $rec['url'] ='http://ciweek.com/article/'.date('Y',time()).'/'.date('md',time()).'/'.$str;*/ 
  //$rec['url'] ='http://ciweek.com/article/'.date('Y',time()).'/'.date('md',time()).'/'.$str[1];
  //$value='pages/A20151112568595.shtml';
//http://www.weili.project.cn/pages/A20161008574246.shtml
  //函数截取掉pages后，拼上http://ciweek.com/article/2016/1008
  //即'http://ciweek.com/article/2016/1008'.$value
  //2016/1008要根据$value的第7位到10位，11位到14位，来拼接
//http://ciweek.com/article/2016/1008/A20161008574246.shtml
    //var_dump($rec['url']);
   // $rec['keywords'] =pq("meta[name='keywords']")->attr('content');
    //echo($keywords . "\n");
   // $rec['description'] =pq("meta[name='description']")->attr('content');
    // echo($description ."\n");
   // $rec['posids'] = 0;
    // echo($posids ."\n");
    //$rec['date'] = pq("span.date hidden-xs")->html();
    //$rec['spdate'] = pq("span.spdate")->text();
    // echo($spdate ."\n");
    //$rec['spauthor'] = pq("span.spauthor")->text();
    // echo($spauthor ."\n");
    //$rec['text'] = pq("div.text")->html();
    // echo($text ."\n");
    //$rec['author'] = pq("span.author")->html();
    // echo($author ."\n");
    // 插入一条数据的sql语句
//$sql1 = 'insert into article(releasetime,title,image) values('.$data['releasetime'][0].',"'.$data['title'][0].'","'.$data['img'][0].'")';
//$sql1 = "insert into v9_news(catid,typeid,title,style,thumb,keywords,description,posids,url,listorder,status,sysadd,islink,username,inputtime,updatetime) values('.$rec['catid'].','.$rec['typeid'].',"'.$rec['title'].'","'.$rec['style'].'","'.$rec['thumb'].'","'.$rec['keywords'].'","'.$rec['description'].'",'.$rec['posids'][0].',"'.$rec['url'].'",'.$rec['listorder'].','.$rec['status'].','.$rec['sysadd'].','.$rec['islink'].',"'.$rec['username'].'",'.$rec['inputtime'].','.$rec['updatetime'].')";
$sql1 = "insert into v9_news(catid,typeid,title,style,thumb,keywords,description,posids,url,listorder,status,sysadd,islink,username,inputtime,updatetime) values('{$rec['catid']}','{$rec['typeid']}','{$rec['title']}','{$rec['style']}','{$rec['thumb']}','{$rec['keywords']}','{$rec['description']}','{$rec['posids'][0]}','{$rec['url']}','{$rec['listorder']}','{$rec['status']}','{$rec['sysadd']}','{$rec['islink']}','{$rec['username']}','{$rec['inputtime']}','{$rec['updatetime']}')";
//print_r($sql1);exit;

$result = mysqli_query($link,$sql1);
//var_dump($link);exit;
echo '<pre>';
// var_dump(strtr($rec['content'], array('"' => '\"', )));
if($result && $TT = mysqli_affected_rows($link)>0){     

        $articleid=mysqli_insert_id($link);
       // $sql2 = "insert into v9_news_data(content,readpoint,groupids_view,paginationtype,maxcharperpage,template,paytype,relation,voteid,allow_comment,copyfrom) values("'.$rec['content'].'",'.$rec['readpoint'].',"'.$rec['groupids_view'].'",'.$rec['paginationtype'].','.$rec['maxcharperpage'].',"'.$rec['template'].'",'.$rec['paytype'].',"'.$rec['relation'].'",'.$rec['voteid'].','.$rec['allow_comment'].',"'.$rec['copyfrom'].'")";
         $sql2 = "insert into v9_news_data(id,content,readpoint,groupids_view,paginationtype,maxcharperpage,template,paytype,relation,voteid,allow_comment,copyfrom) values('{$articleid}','{$rec['content']}','{$rec['readpoint']}','{$rec['groupids_view']}','${rec['paginationtype']}','{$rec['maxcharperpage']}','{$rec['template']}','{$rec['paytype']}','{$rec['relation']}','{$rec['voteid']}','{$rec['allow_comment']}','{$rec['copyfrom']}')";


         //var_dump($articleid);
         //exit();
        // $sql2 = 'insert into v9_news_data(id,content,readpoint,groupids_view,paginationtype,maxcharperpage,template,paytype,relation,voteid,allow_comment,copyfrom) values("'.$articleid.'","'.$rec["content"].'","'.$rec["readpoint"].'","'.$rec["groupids_view"].'","'.$rec["paginationtype"].'","'.$rec["maxcharperpage"].'","'.$rec["template"].'","'.$rec["paytype"].'","'.$rec["relation"].'","'.$rec["voteid"].'","'.$rec["allow_comment"].'","'.$rec["copyfrom"].'")';
        $result=mysqli_query($link,$sql2);
        if($result && mysqli_affected_rows($link)>0){ 
            echo "sql2语句成功执行";
        }else{
          //var_dump($sql2);die;
          $file = 'a.txt';
          $checkerror = $articleid."\r\n".$sql2;
          $current = file_put_contents($file,$checkerror,FILE_APPEND);
            /*echo '<script>
            alert("添加数据失败Fail");

            </script>';*/
        }
}else{
   //var_dump($sql1);die;
    /*echo '<script>
            alert("添加数据失败Fail out。");

            </script>';*/
            /*  \r\n是换行的意思
            *PHP_EOL是换行符
            */
          $file = 'b.txt';
          $checkerror =   $result.PHP_EOL.$TT.PHP_EOL.$articleid."\r\n".$sql1;
          $current = file_put_contents($file,$checkerror,FILE_APPEND);
          //使用 FILE_APPEND 可避免删除文件中已有的内容。

}     

    //

    // $res = [];
    // $res[] = $video_title;
    // $video_jacket_img = pq("img#video_jacket_img")->attr('src');

    // $res[] = $video_jacket_img;

    // $video_id = pq("div#video_id")->text();
    // $res[] =  $video_id;

    // $video_date = pq("div#video_date")->text();
    // $res[] =  $video_date;

    // $video_cast = pq("div#video_cast")->text();
    // $res[] =  $video_cast;

    // $video_maker = pq("div#video_maker")->text();
    // $res[] =  $video_maker;

    // $video_genres = pq("div#video_genres")->text();
    // $res[] =  $video_genres;
    /*echo '<pre>';
    var_dump($rec);*/
}
  













// error_reporting(0);

// date_default_timezone_set("Asia/Chongqing");
// if ($_POST && !$_GET) {
//     $_GET = $_POST;
// }
// $ac = $_GET['ac'];
// switch ($ac) {
//     case 'getPathFiles':
//         $path = $_GET['path'];
//         // echo($path);
//         $files = glob($path.'/*');
//         // print_r($files);
//         echo(json_encode($files));
//         exit();
//         break;
//     case 'getAvInfo':
//         include 'phpQuery.php';
//         $bango = $_GET['bango'];
//         // print_r($bango);
//         echo(json_encode(getavPage($bango[0])));
//         exit();
//         break;
//     case 'doIt':
//         $avinfo = $_GET['data'];
//         foreach ($avinfo as $key => $value) {
//             $avinfo[$key] = str_replace(' ', '_', trim($value));
//         }
//         // $cmd = 'wget -O avimg/x.jpg ' .$avinfo[1];
//         // echo($cmd);
//         // system($cmd);
//         file_put_contents("avimg/{$avinfo[0]}.jpg", file_get_contents($avinfo[1]));
//         break;
//     default:
//         # code...
//         break;
// }


// include 'phpQuery.php';

// $bangaopreg = '/(([A-Z]{3,})[^\\/:\*\?"\'<>|]?(\d{3,}))/';
// $prefix =array();
// foreach (glob('/Volumes/memDisk/www.yanjiuseng.com/fanhao/*.html') as $key => $value) {
//     $bangao = array();
//     $strs = file_get_contents($value);
//     preg_match_all($bangaopreg, $strs, $bangao);
//     // print_r($bangao);
//     foreach ($bangao[2] as $kk => $vv) {
//         $prefix[$vv]++;
//     }
//     # code...
// }
// arsort($prefix);
// var_export($prefix);
// getavPage("EBOD-395");

// function getavPage($gangao){
//     // $host = "http://www.javlibrary.com/cn/vl_searchbyid.php?keyword={$gangao}";
//     $host = "https://avmo.pw/cn/search/".$gangao;
    
//     // Create a stream
//     $data = array('keyword' =>$gangao );
//     $data = http_build_query($data);
//     $opts = array(
//         'http'=>array(
//             // 'request_fulluri' => true,
//             'proxy' => '127.0.0.1:8787',
//             'method'=>"GET",  
//             'header'=>"Content-type: application/x-www-form-urlencoded\r\n".
//                         "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36".
//                        "Content-length:".strlen($data)."\r\n".
//                        "Referer:https://avmo.pw/cn/\r\n",
//             'content' => $data
//             )
//     );
//     print_r($opts);

//     $context = stream_context_create($opts);

//     // Open the file using the HTTP headers set above
//     $file = file_get_contents($host, false, $context);
// exit($file);
//     phpQuery::newDocumentHtml($file);
//     $video_title = pq("div#video_title>h3>a")->text();
//     $res = [];
//     $res[] = $video_title;
//     $video_jacket_img = pq("img#video_jacket_img")->attr('src');

//     $res[] = $video_jacket_img;

//     $video_id = pq("div#video_id")->text();
//     $res[] =  $video_id;

//     $video_date = pq("div#video_date")->text();
//     $res[] =  $video_date;

//     $video_cast = pq("div#video_cast")->text();
//     $res[] =  $video_cast;

//     $video_maker = pq("div#video_maker")->text();
//     $res[] =  $video_maker;

//     $video_genres = pq("div#video_genres")->text();
//     $res[] =  $video_genres;
    

//     // $video_id = pq("div#video_id")->text();
//     // $res[] =  $video_id;
//     return cleanCol($res);
// }
// function cleanCol($data)
// {
//     foreach ($data as $key => $value) {
//         $data[$key] = str_replace(["\n"," ","\t"], '', $value);
//     }
//     return $data;
// }
?>

