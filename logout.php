<?php
	session_start();
	unset($_SESSION['username']);
	header("Location:index.php");
?>
<br><a href="index.php">会员页面</a> 