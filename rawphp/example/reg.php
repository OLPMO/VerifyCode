<?php
	session_start();
if(isset($_POST['dosubmit'])) {
	if(strtoupper($_SESSION['code']) == strtoupper($_POST['code']) ) {
		echo "输入成功!<br>";
	}else{
		echo "输入不对!<br>";
	}
}
?>

<body>
	<form action="reg.php" method="post">
		username: <input type="text" name="username"> <br>
		password: <input type="password" name="password"> <br>
		code: <input type="text" onkeyup="if(this.value!=this.value.toUpperCase()) this.value=this.value.toUpperCase()" size="6" name="code"> 
		      <img src="code.php" onclick="this.src='code.php?'+Math.random()" />  <br>

		<input type="submit" name="dosubmit" value="登 录"> <br>
		
	</form>
</body>
