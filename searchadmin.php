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
	require_once 'page.php';
	$pagination = new Pagination();
	$records_per_page = 300;
	$pagination->records_per_page($records_per_page);
	//搜索分页使用的是SESSION传递，检测是否已输入
if(isset($_POST['opt'])||isset($_POST['date1'])||isset($_POST['date2'])||isset($_POST['selectuser'])){
	$table = $_POST['opt'];
	$query = "select * from $table";
	
	if($_POST['date1']!=''&&$_POST['date2']!=''){
		$date1 = $_POST['date1'];
		$date1 .= " 00:00:00";
		$date2 = $_POST['date2'];
		$date2 .= " 23:59:59";
		$query .= " where create_time between '$date1' and '$date2'";
	}
	//选择用户
	if($_POST['selectuser']!='all'){
		$user = $_POST['selectuser'];
		if($_POST['date1']==''&&$_POST['date2']==''){
		$query .= " where username = '$user'";
		}else{
		$query .= " and username = '$user'";}
	}
	$_SESSION['query'] = $query;
}else{
	$query = $_SESSION['query'];
}

	$rows = $mysql->count($query);
	$pagination->records($rows);
	$limit = " order by id LIMIT ".(($pagination->get_page() - 1) * $records_per_page).", ".$records_per_page;
	$query .= $limit;
	$result = $mysql->query($query);
?>
<body>
<div class="well bs-component" style="width:550px; margin:50px auto;">
	<fieldset>
		<legend>搜索结果：<small>共<?php echo $rows;?>条记录</small></legend>
		<table class="table table-striped table-hover ">
		  <thead>
			<tr>
			  <th>#</th>
			  <th>ID</th>
			  <th>创建时间</th>
			  <th>提交人</th>
			</tr>
		  </thead>
		  <tbody>
<?php

if($result){
	foreach($result as $result=>$keys){
		$keys = array_values($keys);
		echo "<tr><td>".$keys[0]."</td><td>".$keys[1]."</td><td>".$keys[2]."</td><td>".$keys[3]."</td></tr>";
	}
	
}else{
	echo "<tr class='danger'><td></td><td></td><td></td><td></td></tr>";
}
	
?>
		</tbody>
	</table>
<?php if($result)$pagination->render(); ?>
	<div class="input-group">
	<a href='index.php'>点击返回输入页面！</a>
	</div>
	</fieldset>
</div>
</body>