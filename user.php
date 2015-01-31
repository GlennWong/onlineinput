<?php
	require_once "header.php";
	require_once 'mysql.php';

	if(isset($_POST['username'])&&isset($_POST['password'])){
		$username = $_POST['username'];
		$password = MD5($_POST['password']);
		$mysql->execute("update t_user set password='$password' where username='$username'");
		
		if($mysql->numRows==1){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">
			<h3 class="panel-title">修改成功</h3>
		  </div>
		  <div class="panel-body">
		    该账号密码已经修改！
		  </div>
		</div>
		<?php
		}else{
		?>
		<div class="panel panel-danger">
		  <div class="panel-heading">
			<h3 class="panel-title">修改失败</h3>
		  </div>
		  <div class="panel-body">
			账号密码没有发生改变！
		  </div>
		</div>
		<?php
		}
	}
	
	if(isset($_POST['newusername'])&&isset($_POST['newpassword'])){
		$newusername=$_POST['newusername'];
		$newpassword=$_POST['newpassword'];
		$mysql->execute("INSERT INTO `t_user` VALUES('$newusername','$newpassword')");
		if($mysql->numRows==1){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">
			<h3 class="panel-title">创建成功</h3>
		  </div>
		  <div class="panel-body">
		    账号以创建成功！
		  </div>
		</div>
		<?php
		}else{
		?>
		<div class="panel panel-danger">
		  <div class="panel-heading">
			<h3 class="panel-title">账号创建失败</h3>
		  </div>
		  <div class="panel-body">
			请确认此账号是否存在，且符合规范！
		  </div>
		</div>
		<?php
		}
	}
	
	if(isset($_GET['action'])){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">
			<h3 class="panel-title">删除成功</h3>
		  </div>
		  <div class="panel-body">
		    该账号已经被删除！
		  </div>
		</div>
		<?php
	}?>
	
<script language=JavaScript>
	function InputCheck(Form){
		if (Form.username.value == ""){
			alert("请输入用户名!");
			Form.username.focus();
			return (false);
		}
		if (Form.password.value == ""){
			alert("请输入密码!");
			Form.password.focus();
			return (false);
		}
		if (Form.orders.value == ""){
			alert("请输入密码!");
			Form.orders.focus();
			return (false);
		}
	}
</script>
<body>
<div class="well bs-component" style="width:380px; margin:50px auto;">
<!--登陆注册-->
	<fieldset>
	  <legend>用户管理</legend>
		<div class="form-group">
		  <label style="margin:0px 3px;">账号</label>
		  <label style="margin:0px 80px;">密码</label>
		</div>
	<?php
		$users = $mysql->query("select username from t_user");
		foreach($users as $users=>$user){
			$o_username = $user['username'];
	?>
		<form name="Form"  method="post" class="form-horizontal" action="user.php" onSubmit="return InputCheck(this)">
			<div class="form-group">
			  <div class="col-lg-4 ">
				<input type="text" class="form-control" id="username" name="username" value="<?php echo $o_username;?>" autocomplete="off" readonly="readonly">
			  </div>
			  <div class="col-lg-4">
				<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off" >
			  </div>
			  <button type="submit" class="btn btn-info" title="修改">修改</button>
			  <button type="button" class="btn btn-danger" title="删除" onclick="window.location.href='delete.php?username=<?php echo $o_username;?>'" <?php if($o_username=='admin'){echo 'disabled="disabled"';}?>>删除</button>
			</div>
		</form>
	<?php } ?>
	
		<form name="Form"  method="post" class="form-horizontal" action="user.php" onSubmit="return InputCheck(this)">
			<div class="form-group">
			  <div class="col-lg-4 ">
				<input type="text" class="form-control" id="username" name="newusername" placeholder="User" autocomplete="off">
			  </div>
			  <div class="col-lg-4">
				<input type="password" name="newpassword" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off">
			  </div>
			  <button type="submit" class="btn btn-info" title="新建">新建</button>
			</div>
		</form>
	</fieldset>
	<?php echo "已作为管理员账号登入 |<a href='index.php'> 返回主页 </a>|<a href='logout.php'> 登出 </a>";?>
</div>