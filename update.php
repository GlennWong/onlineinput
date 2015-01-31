<?php
require_once 'mysql.php';
$mysql->execute("update t_char set create_time = DATE_ADD(create_time,INTERVAL 8 HOUR)");
$mysql->execute("update t_order set create_time = DATE_ADD(create_time,INTERVAL 8 HOUR)");
unlink('update.php');
?>