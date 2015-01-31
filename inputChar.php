<?php
	//检测是否登录
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
		exit();
	}else{
		$username = $_SESSION['username'];	//获取当前用户
	}
	require_once "header.php";
	//连接数据库，提交数据
	require_once 'mysql.php';
	//获取当前时间
	$create_time = date("Y-m-d H:i:s",time());
?>
<body>
<div class="well bs-component" style="width:380px; margin:50px auto;">
	<fieldset>
		<legend>输入结果</legend>
<?php
	if(isset($_POST['chars'])){
		$str = $_POST['chars'];
		if($str==""){
			echo "您未输入任何ID，请返回 <a href='index.php'>主页</a> 进行输入!";
			exit();
		}
		$newstr = preg_replace("/\s+/","\n",$str);//过滤字符串符号
		$array = explode("\n",$newstr);//拆分字符串为数组
		$array=array_filter($array);
		
		foreach ($array as $title=>$key){

			$mysql->startTrans();
			$id = $mysql->count("select * from t_char");
			$id++;
			$mysql->execute("INSERT INTO `t_char` VALUES('$id','$key','$create_time','$username')");
			$error = $mysql->error();

			if($error){
				$mysql->rollback();
				echo 
				"<div class='alert alert-dismissable alert-danger'><button type='button' class='close' data-dismiss='alert'>X</button>字符："
				.$key.
				" 提交失败，数据库已存在此字符</div>";
			}else{
				$mysql->commit();
				echo "<div class='alert alert-dismissable alert-success'><button type='button' class='close' data-dismiss='alert'>X</button>字符：".$key." 成功提交！</div>";
			}
		}
	}
?>
	<div class="form-group">
	<a href='index.php'>点击返回输入页面！</a>
	</div>
	<fieldset>
</div>
</body>