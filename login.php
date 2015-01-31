<?php
	if(isset($_POST['username'])&&isset($_POST['password'])){
		$username = $_POST['username'];
		$password = MD5($_POST['password']);
		require_once 'mysql.php';
		$array = $mysql->table('t_user')->where("username = '$username' and password = '$password'")->select();
		
		if ($array){
			foreach($array as $key=>$value){
				session_start();
				$_SESSION['username']=$value['username'];
			}
			header("location:index.php");
		}else{
?>
<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">错误提示</h3>
  </div>
  <div class="panel-body">
    请检查账号或密码是否正确！
  </div>
</div>
<?php
		}
	}
	require_once "header.php";
?>

<script language="javascript">
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
	}
</script>

<body>
<div class="well bs-component" style="width:370px; margin:50px auto;">
<!--登陆注册-->
	<form name="Form"  method="post" class="form-horizontal" action="login.php" onSubmit="return InputCheck(this)">
	  <fieldset>
		<legend>登录</legend>
		<div class="form-group">
		  <label for="inputEmail" class="col-lg-2 control-label">账号</label>
		  <div class="col-lg-10">
			<input type="text" class="form-control" id="username" name="username" placeholder="User" autocomplete="off">
		  </div>
		</div>
		<div class="form-group">
		  <label for="inputPassword" class="col-lg-2 control-label">密码</label>
		  <div class="col-lg-10">
			<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off">
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-lg-10 col-lg-offset-2">
			<button type="submit" class="btn btn-info">登录</button>
		  </div>
		</div>
	  </fieldset>
	</form>
</div>

</body>
</html>