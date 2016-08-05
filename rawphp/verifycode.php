<?php
	class VerifyCode{
		
	}
	$img = imagecreatetruecolor(150,50);
	if( !$img ){
		echo 'fail to create screen <br>';
	}
	
	//定义画布颜色
	$gray = imagecolorallocate($img, 0xC0, 0xC0, 0xC0);
	$darkgray = imagecolorallocate($img, 0x90, 0x90, 0x90);
	$navy = imagecolorallocate($img, 0x00, 0x00, 0x80);
	$darknavy = imagecolorallocate($img, 0x00, 0x00, 0x50);
	$red = imagecolorallocate($img, 0xFF, 0x00, 0x00);
	$darkred = imagecolorallocate($img, 0x90, 0x00, 0x00);
	$black=imagecolorallocate($img,0x00,0x00,0x00);
	$white=imagecolorallocate($img,0xFF,0xFF,0xFF);
	
	imagefill($img,0,0,$black);
	
	
	
	$code = "123a";
	for($i =0;$i< 4;$i++){
		$fontSize = rand(3,5);
		$x = $i * 35 + 4;
		$y = rand(4,(int)((50 - imagefontheight( $fontSize ))/2));
		//画出每个字符
		imagechar($img, $fontSize, $x, $y, $code[$i], $white);
	}
	
	
	header('Content-type: image/png');
	imagepng($img);
	imagedestroy($img);
	
	
	
	
	
	
	
	
	
	
	
	
	