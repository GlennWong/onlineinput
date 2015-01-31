<?php
	session_start();
	require_once("mysql.php");
	if(isset($_GET['username'])){
		$deluser = $_GET['username'];
		$mysql->table('t_user')->where("username='$deluser'")->delete();
		header("Location:user.php?action=done");
	}
?>