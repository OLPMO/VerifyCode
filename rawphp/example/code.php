<?php
	//开启session
	session_start();
	include "../verifycode.class.php";
	//构造方法
	$vcode = new VerifyCode(120,40,4,'png');
	
	//将验证码放到服务器自己的空间保存一份
	$_SESSION['code'] = $vcode->GetCode();
	//将验证码图片输出
	$vcode->OutputImage();
