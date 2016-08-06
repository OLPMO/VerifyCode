<?php
	class VerifyCode{
		private $bgColor;
		private $width;
		private $height;
		private $codeCnt;
		private $code;
		private $codeImg=NULL;
		//生成的验证码图片的格式
		private $picFormat;
		private $codeTable = "abcdefghkmnpqrstuvwsyzABCDEFHJKLMNPRSTUVWXYZ23456789";
		
		//每调用一次便生成一个新的验证码
		private function UpdateCode(){
			$this->code = '';
			for( $i = 0; $i < $this->codeCnt ; $i++){
				$this->code = $this->code.$this->codeTable[rand(0,strlen($this->codeTable)-1)];
				
			}
			
			return $this->code;
		}
		
		/*
		* resource SetDisturbFactor(resource $img,int $width,int $height,string $level = 'low')
		*功能：设置验证码的干扰元素
		*$img：要设置感染元素的图片资源
		*$width：该资源的宽度
		*$height：该资源的高度
		*$level：干扰级别，默认为轻
		*
		*返回值：设置了干扰元素的图片资源
		*/
		private function SetDisturbFactor($img,$width,$height,$level = 'low'){
		
			switch( $level ){
				case 'low':
					$lineCnt = 5;
					$pxCnt = 40;
					break;
				case 'medium':
					$lineCnt = 6;
					$pxCnt = 50;
					break;
				case 'high':
					$lineCnt = 7;
					$pxCnt = 60;
					break;
				default:
					$lineCnt = 5;
					$pxCnt = 40;
			}
			
			$lineColor = imagecolorallocate($img, rand(100, 180), rand(100, 180), rand(100, 180));
			for($i =0; $i < $lineCnt ;$i++){
				imageline($img,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),$lineColor);
			}
			
			//在[-45,45]之间旋转任意角度，旋转后空白的地方用背景色填充
			$roImg = imagerotate($img,rand(-45,45),$this->bgColor);
			
			for( $i=0 ; $i < $pxCnt ; $i++ ){
				//每十个点换一种颜色
				if( 0 == ($i%10) ){
					$pxColor = imagecolorallocate($roImg,rand(0, 50),rand(0, 50), rand(0, 50));
				}
				
				imagesetpixel($roImg,rand(1,$width-2),rand(1,$height-2),$pxColor);
			}
			return $roImg;
		}
		
		//默认生成的图片为120px*40px，4个验证码，图片格式为png
		public function __construct($width=120, $height=40, $num=4, $format = 'png') {
			$this->width = $width;
			$this->height = $height;
			$this->codeCnt = $num;
			$this->picFormat = $format;
			//创建验证码图
			$this->UpdateCodeImage();
		}
		
		public function GetHeight(){
			return $this->height;
		}
		
		public function GetWidth(){
			return $this->width;
		}
		
		//设置验证码生成表
		public function SetCodeTable($ctable){
			if( !is_string(ctable) ){
				return false;
			}
			$this -> codeTable = $ctable;
			return true;
		}
		
		
		//获取当前的验证码
		public function GetCode(){
			return $this->code;
		}
		
		//不区分大小写地校验用户输入
		public function CheckCode($userInput){
			if( 0 == strncasecmp(strtolower($userInput),strtolower($this->code),strlen($this->code)-1)){
				return true;
			}
			return false;
		}
	
		
		public function UpdateCodeImage( ){
			//先更新验证码
			$this->UpdateCode();
			
			//验证码生成出错要重新生成
			if( $this->codeCnt != strlen($this->code) ){
				$this->UpdateCode();
			}
			
			if( is_null($this->codeImg) ){
				$this->codeImg = imagecreatetruecolor($this->width,$this->height);
			}
			
			//分配背景色
			$this->bgColor =  imagecolorallocate($this->codeImg, rand(225, 255), rand(225, 255), rand(225, 255)); 
			imagefill($this->codeImg,0,0,$this->bgColor);
			
			$charImg = array();
			$charImgWidth = floor($this->width/$this->codeCnt);
			$charImgColor = array();
			for($i=0 ; $i< $this->codeCnt ; $i++){
				
				$charImg[$i] = imagecreatetruecolor($charImgWidth,$this->height);
				
				//没个字符的颜色
				$charImgColor[$i] = imagecolorallocate($charImg[$i],rand(0, 40), rand(0, 40), rand(0, 40));
				
				//生成字符画布的背景色应该和整幅验证码图的背景色一致
				imagefill($charImg[$i],0,0,$this->bgColor);
				
				$fontSize = 5;
				$x =  (int)(($charImgWidth/2) - 10);
				$y = rand(4,(int)(($this->height - imagefontheight( $fontSize ))/2));
				
				//画出每个字符
				imagechar($charImg[$i], $fontSize, $x, $y, $this->code[$i],$charImgColor[$i]);
				
				//生成干扰元素,干扰级别为轻度干扰
				$charImg[$i] = $this->SetDisturbFactor($charImg[$i],$charImgWidth ,$this->height,'low');
			}
			
			//bool imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
			
			for( $i = 0 ; $i < $this->codeCnt ; $i++){
				imagecopymerge($this->codeImg,$charImg[$i],$i*$charImgWidth,0,0,0,$charImgWidth,$this->height,100);
			}
			
		}
		
		public function OutputImage() {
			//根据用户设置来生成图片格式
			switch(strtolower($this->picFormat)){
				case 'jpeg':
				case 'jpg':
					 header("Content-type: image/jpeg");
					imagejpeg ($this->codeImg);
					break;
				case 'png':
					header('Content-type: image/png');
					imagepng($this->codeImg);
					break;
				default:
					header("Content-type: image/gif");
    				imagegif($this->codeImg);
			}
		
		}
		
		//用于自动销毁图像资源
		function __destruct() {
			imagedestroy($this->codeImg);
		}
		
	}
	
	
	
	
	