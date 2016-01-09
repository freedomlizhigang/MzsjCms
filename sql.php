<?php
// // PDO方式操作数据库
$con = new PDO('mysql:host=localhost;dbname=wen', 'root', '123456sxsx');
//查询数据
$sql = "SELECT userid,username,ucenterid FROM mzsj_user where userid = 112";
$sth = $con->query($sql)->fetch();
var_dump($sth);
$dbh = null;
?>