<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
		exit();
	}else{
		$username = $_SESSION['username'];
	}
	require_once "header.php";
	require_once "mysql.php";
	$users = $mysql->query("select username from t_user");
?>

<script language="javascript">
	//自动清理空格
	function clearSpaces(string) {
	var temp = "";
	string = '' + string;
	splitstring = string.split(" ");
	for(i = 0; i < splitstring.length; i++)
	temp += splitstring[i];
	return temp;
	}
	//两个日期比较
	$(function(){
		var startDate = new Date();
		var endDate = new Date();
		$('#startDate').datepicker()
			.on('changeDate', function(ev){
				if (ev.date.valueOf() > endDate.valueOf()){
					$('#alert').show().find('strong').text('起始日期不能比当前日期大！');
				} else {
					$('#alert').hide();
					startDate = new Date(ev.date);
					$('#startDate').text($('#startDate').data('date'));
				}
				$('#startDate').datepicker('hide');
			});
		$('#endDate').datepicker()
			.on('changeDate', function(ev){
				if (ev.date.valueOf() < startDate.valueOf()){
					$('#alert').show().find('strong').text('终止日期不能比起始日期小！');
				} else {
					$('#alert').hide();
					endDate = new Date(ev.date);
					$('#endDate').text($('#endDate').data('date'));
				}
				$('#endDate').datepicker('hide');
			});
	});
</script>
<body>
<?php
	if(isset($_GET['action'])){
?>
	<div class="panel panel-success">
	  <div class="panel-heading">
		<h3 class="panel-title">修改成功</h3>
	  </div>
	  <div class="panel-body">
		所输入ID/字符串已提交数据库！
	  </div>
	</div>
<?php } ?>
<div class="well bs-component" style="width:480px; margin:50px auto;">
<div class="alert alert-danger" id="alert"><strong></strong></div>
<!--NAV-->
	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
	  <li class="active"><a href="#home" data-toggle="tab">输入猎聘网ID</a></li>
	  <li><a href="#inputchar" data-toggle="tab">输入三大招聘网站ID</a></li>
	  <li><a href="#search" data-toggle="tab">搜索</a></li>
<?php if($username=="admin"){ ?>
	  <li><a href="#searchadmin" data-toggle="tab">高级搜索</a></li>
<?php } ?>
	</ul>
	<div id="myTabContent" class="tab-content">
<!--ID输入-->
	  <div class="tab-pane fade active in" id="home">
		<form method="post" action="inputID.php" class="form-horizontal">
			<div class="form-group">
			  <div class="col-lg-12">
				<textarea name="id" class="form-control" rows="8" id="textArea" onBlur="this.value=clearSpaces(this.value);"></textarea>
				<span class="help-block">批量输入猎聘网ID号，以Enter分割</span>
			  </div>
			  <div class="col-lg-12 col-lg-offset-9">
				<button type="submit" class="btn btn-info">提交ID</button>
			  </div>
			</div>
		</form>
	  </div>
<!--字符输入-->
	  <div class="tab-pane fade" id="inputchar">
		<form method="post" action="inputChar.php" class="form-horizontal">
			<div class="form-group">
			  <div class="col-lg-12">
				<textarea name="chars" class="form-control" rows="8" id="textArea" onBlur="this.value=clearSpaces(this.value);"></textarea>
				<span class="help-block">批量输入三大招聘网站ID，以Enter分割</span>
			  </div>
			  <div class="col-lg-12 col-lg-offset-9">
				<button type="submit" class="btn btn-info">提交字符</button>
			  </div>
			</div>
		</form>
	  </div>
<!--搜索-->
	  <div class="tab-pane fade" id="search">
		<form method="post" action="search.php" class="form-horizontal">
		<div class="form-group col-lg-12" style="margin:10px 0px 15px 0px;">
		  <div class="input-group">
			<span class="input-group-addon">按猎聘网ID</span>
			<input name="idbyid" type="text" class="form-control"  placeholder="18667975">
			<span class="input-group-btn">
			  <button class="btn btn-info" type="submit">搜索</button>
			</span>
		  </div>
		</div>
		<div class="form-group col-lg-12" style="margin:10px 0px 15px 0px;">
		  <div class="input-group">
			<span class="input-group-addon">按三大招聘网站ID</span>
			<input name="charbychar" type="text" class="form-control"  placeholder="CRCCDD9900861">
			<span class="input-group-btn">
			  <button class="btn btn-info" type="submit">搜索</button>
			</span>
		  </div>
		</div>
		</form>
	  </div>
<!--高级搜索-->
	  <div class="tab-pane fade" id="searchadmin">
		<form method="post" action="searchadmin.php" class="form-horizontal">
		<div class="form-group col-lg-12" style="margin:10px 0px 15px 0px;">
			搜索：
			<input type="radio" name="opt" value="t_order" checked="">&nbsp;猎聘网ID&nbsp;&nbsp;&nbsp;
			<input type="radio" name="opt" value="t_char">&nbsp;三大招聘网站ID 
		</div>
		<div class="form-group col-lg-12" style="margin:10px 0px 15px 0px;">
		  <div class="input-group">
			<span class="input-group-addon">按日期</span>
			<input name="date1" type="text" class="form-control" id="startDate" data-date-format="yyyy-mm-dd" placeholder="默认全部">
			<span class="input-group-addon">至</span>
			<input name="date2" type="text" class="form-control" id="endDate" data-date-format="yyyy-mm-dd">
		  </div>
		</div>
		<div class="form-group col-lg-12"  style="margin:10px 0px 15px 0px;">
			<select class="form-control" id="select" name="selectuser">
			  <option value="all" select='selected'>选择用户，默认全部</option>
<?php foreach($users as $user=>$info)echo "<option value=".$info['username'].">".$info['username']."</option>";?>
			</select>
		</div>
			  <div class="col-lg-12 col-lg-offset-9">
				<button type="submit" class="btn btn-info">高级搜索</button>
			  </div>
		</form>
	  </div>
	</div>
<!--FOOTER-->
	<div class="form-group" style="margin:10px 0px;">
	<?php
	if($username=="admin"){
		echo "已作为管理员账号登入 |<a href='user.php'> 用户管理 </a>| 导出<a href='dumporder.php' target='_blank'> 猎聘网ID </a>或<a href='dumpchar.php' target='_blank'> 其他IDs </a>|<a href='logout.php'> 登出 </a>";
	}else{
		echo "已作为 ".$username." 账号登入|<a href='logout.php'> 登出 </a>";

	}?>
	</div>
</div>

</div>
</body>