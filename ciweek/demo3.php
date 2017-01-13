<?php
$str = "http://images.enet.com.cn/i/2016/1021/041120436.jpg";
$arr = array(0=>"http://images.enet.com.cn/i/2016/1021/051800897.jpg",1=>"http://images.enet.com.cn/i/2016/1021/051347840.jpg",2=>"http://images.enet.com.cn/i/2016/1021/050128659.jpg",3=>"http://images.enet.com.cn/i/2016/1021/045442841.jpg",4=>"http://images.enet.com.cn/i/2016/1021/044826623.jpg",5=>"http://images.enet.com.cn/i/2016/1021/044239151.jpg",6=>"http://images.enet.com.cn/i/2016/1021/043250580.jpg",7=>"http://images.enet.com.cn/i/2016/1021/042507322.jpg",8=>"http://images.enet.com.cn/i/2016/1021/041120436.jpg");
echo '<pre>';
print_r($arr);
/*if(in_array($str,$arr)){
	echo 'ok';
};*/
 $key = array_search($str,$arr); 
 print_r($key);
 echo '<hr>';
 //2015-12-17
 $time = strtotime(2016-10-08);
 echo $time;
    