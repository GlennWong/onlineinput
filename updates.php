<?php
	session_start();
	require_once 'mysql.php';
	if($_POST['new']==$_POST['old']){
		header("location:search.php?action=error");
		exit();
	}else{
		$table = $_POST['table'];
		if($table=="t_order"){
			$idchar = "item";
		}else{
			$idchar = "chars";
		}
		$old = $_POST['old'];
		$new = $_POST['new'];
		$mysql->execute("update $table set $idchar = '$new' where $idchar = '$old'");
		//echo "update $table set $idchar = '$new' where $idchar = '$old'";exit();
		if($mysql->error()){
			header("location:search.php?action=error");
			exit();
		}else{
			header("location:index.php?action=change");
			exit();
		}
	}
?>