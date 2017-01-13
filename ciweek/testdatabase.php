<?php

//$mysql_server_name="localhost";//服务器
/*$mysql_server_name="127.0.0.1:3306";//服务器
$mysql_username="root";//数据库用户名
$mysql_password="123456";//密码
$mysql_database="phpcmsv9";//数据库名
/*$mysql_server_name="localhost";//服务器
$mysql_username="root";//数据库用户名
$mysql_password="";//密码
$mysql_database="testgrab";//数据库名*/
//连接数据库
//var_dump($pages);
	
// 	$link=mysqli_connect($mysql_server_name,$mysql_username,$mysql_password);

// if(!$link){
//     die("数据库连接失败".mysql_errno());
// }else{  
//     echo "数据库连接成功";
// }
try {
$pdo = new  PDO("mysql:host=localhost;dbname=phpcmsv9","root","");
	
} catch (PDOException $e) {
	echo $e->getMessage();
}

	//$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	//$pdo->beginTransactiono();
	$sql='insert into article(author) values("testwei")';
	//var_dump($sql);exit;
	iconv('gbk', 'utf-8',$sql);
	$PDOStatement = $pdo->exec($sql);


	//$res = $PDOStatement->fetchAll();
