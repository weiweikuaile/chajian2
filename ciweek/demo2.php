<?php
header("Content-Type;text/html;charset=utf-8");
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
}else{  
    echo "数据库连接成功";
}
//exit;
mysqli_set_charset($link,"utf8");
mysqli_select_db($link,$mysql_database);//打开数据库
$list = "http://ciweek.com/v7/list.jsp?page=15&siteid=ciweek&ccid=7510";
$str = file_get_contents($list);
//$str = iconv('GB2312','UTF-8',$str);
//列表的图片
preg_match_all('/<dl class="clearfix">[\s\S].*?<dt[^>]*.<a href=".*?<img src="(.*?)<\/a><\/dt>/is',$str,$arr2);
echo '<pre>';
var_dump($arr2[1]);
exit;
//foreach ($arr2[1] as $key => $value) {
//$sql1 = "insert into v9_news(thumb) values('{$rec['thumb']['$value']}')";
//print_r($sql1);exit;
//$result = mysqli_query($link,$sql1);
//var_dump($link);exit;
echo '<pre>';
// var_dump(strtr($rec['content'], array('"' => '\"', )));
//if($result && $TT = mysqli_affected_rows($link)>0){     

        //echo "sql1语句成功执行";
//}else{
   //var_dump($sql1);die;
    /*echo '<script>
            alert("添加数据失败Fail out。");

            </script>';*/
            /*  \r\n是换行的意思
            *PHP_EOL是换行符
            */
          //$file = 'c.txt';
          //$checkerror =   $result.PHP_EOL.$TT.PHP_EOL.$articleid."\r\n".$sql1;
          //$current = file_put_contents($file,$checkerror,FILE_APPEND);
          //使用 FILE_APPEND 可避免删除文件中已有的内容。

//} 
