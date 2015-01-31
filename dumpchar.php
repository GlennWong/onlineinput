<?php
require_once 'mysql.php';

$time = time();
$mysql->execute("select * into outfile '../../www/download/$time.txt' from t_char order by id");
if($mysql->error()){
	echo $mysql->error();
	exit();
}

header("location:/download/$time.txt");
?>