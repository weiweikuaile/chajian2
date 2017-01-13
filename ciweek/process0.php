<?php

include 'phpQuery.php';
$pages = glob('pages/*.shtml');
$mysql_server_name="localhost";//服务器
$mysql_username='root';//数据库用户名
$mysql_password='';//密码
$mysql_database='testgrab';//数据库名
//连接数据库
//var_dump($pages);
$link=mysqli_connect($mysql_server_name,$mysql_username,$mysql_password) or die('error connecting');
//echo $link;exit;
mysqli_set_charset($link,"utf8");
mysqli_select_db($link,$mysql_database);//打开数据库

foreach ($pages as $key => $value) {
    phpQuery::newDocumentHtml(
        iconv('gbk', 'utf-8',file_get_contents($value)));
    //var_dump($value);'http://ciweek.com/article/'
    //$rec['url'] =pq("dl.toppic a:eq(0)","href");
    $rec['url'] = "填充数据，后期拼接数据内容";
    var_dump($rec['url']);
    $rec['keywords'] =pq("meta[name='keywords']")->attr('content');
    //echo($keywords . "\n");
    $rec['description'] =pq("meta[name='description']")->attr('content');
    // echo($description ."\n");

    $rec['posids'] = 0;
    // echo($posids ."\n");
    $rec['date'] = pq("span.date hidden-xs")->html();
    
    $rec['_title'] = pq("p.title")->text();
    // echo($_title ."\n");
    $rec['spdate'] = pq("span.spdate")->text();
    // echo($spdate ."\n");

    $rec['spauthor'] = pq("span.spauthor")->text();
    // echo($spauthor ."\n");

    $rec['text'] = pq("div.text")->html();
    // echo($text ."\n");

    $rec['author'] = pq("span.author")->html();
    // echo($author ."\n");
    // 插入一条数据的sql语句
//$sql1 = 'insert into article(releasetime,title,image) values('.$data['releasetime'][0].',"'.$data['title'][0].'","'.$data['img'][0].'")';
$sql1 = 'insert into article(author) values("'.$rec['author'].'")';

echo '<pre>';
var_dump($sql1);exit;

$result = mysqli_query($link,$sql1);



//var_dump($result);exit;
if($result && mysqli_affected_rows($link)>0){

        $articleid=mysqli_insert_id($link);
        $sql2 = 'insert into article_content(content,articleid) value("",'.$articleid.')';
        $result=mysqli_query($link,$sql2);
        if($result && mysqli_affected_rows($link)>0){
            echo '<script>
                alert("添加数据成功Success");

                </script>';
        }else{
            echo '<script>
            alert("添加数据失败Fail");

            </script>';
        }
}else{
    echo '<script>
            alert("添加数据失败Fail out。");

            </script>';
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

