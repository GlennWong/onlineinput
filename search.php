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
	
	if(isset($_GET['action'])&&$_GET['action']=='error'){
?>
	<div class="panel panel-danger">
	  <div class="panel-heading">
		<h3 class="panel-title">修改失败</h3>
	  </div>
	  <div class="panel-body">
		数据库已存在输入的ID/字符！
	  </div>
	</div>
<?php } ?>
<body>
<div class="well bs-component" style="width:600px; margin:50px auto;">
	<fieldset>
		<legend>搜索结果</legend>
		<table class="table table-striped table-hover ">
		  <thead>
			<tr>
			  <th>#</th>
			  <th>ID</th>
			  <th>创建时间</th>
			  <th>提交人</th>
			  <th>操作</th>
			</tr>
		  </thead>
		  <tbody>
<?php
if(isset($_POST['idbyid'])||isset($_POST['charbychar'])){
	if($_POST['idbyid']==''&&$_POST['charbychar']==''){
		echo "<tr class='danger'><td>没有输入ID/字符</td><td></td><td></td><td></td><td></td></tr>";
	}
	if($_POST['idbyid']!=''){
		$str = $_POST['idbyid'];
		$table = "t_order";
		$query = "select * from $table where item = '$str'";
	}
	if($_POST['charbychar']!=''){
		$str = $_POST['charbychar'];
		$table = "t_char";
		$query = "select * from $table where chars = '$str'";
	}
	$_SESSION['query'] = $query;
}else{
	$query = $_SESSION['query'];
}

	$table = substr($query,14,7);//获取 表名
	$result = $mysql->query($query);
	
	if($result){
		foreach($result as $result=>$keys){
			$keys = array_values($keys);
			if($username!="admin"){
				echo "<tr><td>".$keys[0]."</td><td>".$keys[1]."</td><td>".$keys[2]."</td><td>".$keys[3]."</td><td></td></tr>";
			}else{
			echo "<form method='post' action='updates.php'><tr><td>".$keys[0]."</td><td><input type='hidden' name='table' value=".$table."><input type='hidden' name='old' value=".$keys[1]."></input><input type='text' name='new' class='input' value=".$keys[1]."></input></td><td>".$keys[2]."</td><td>".$keys[3]."</td><td><input type='submit' class='1' value='改'><td></tr></form>";
			}
			
		}
	}else{
		echo "<tr class='danger'><td>无</td><td></td><td></td><td></td><td></td></tr>";
	}
?>
		</tbody>
	</table>
	<div class="input-group">
	<a href='index.php'>点击返回输入页面！</a>
	</div>
	</fieldset>
</div>
</body>