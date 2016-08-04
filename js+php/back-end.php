<?php

	class VerifyCode{
		//验证码字符串
		private $code = '';
		//原生的验证码生成表，把容易让用户混淆的字母与数字剔除掉了，如数字‘0’和字母‘O’等等
		private $codeTable = "abcdefghikmnpqrstuvwsyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
		
		//设置验证码生成表
		public function SetCodeTable($ctable){
			if( !is_string(ctable) ){
				return false;
			}
			$this -> codeTable = $ctable;
			return true;
		}
		//每调用一次便生成一个新的验证码
		public function CreateCode($codeCnt = 4 ){
			$this->code = '';
			for( $i = 0; $i < $codeCnt ; $i++){
				$this->code = $this->code.$this->codeTable[rand(0,strlen($this->codeTable))];
				
			}
			
			return $this->code;
		}
		
		//获取当前的验证码
		public function GetCode(){
			return $this->code;
		}
		
		//不区分大小写地教验用户输入
		public function CheckCode($userInput){
			if( 0 == strncasecmp($userInput,$this->code,strlen($this->code)-1)){
				return true;
			}
			return false;
		}
	}
	
	$codeCnt = 4;
	if(isset($_POST['codeCnt'])){
		$codeCnt = $_POST['codeCnt'];
	}
	$vcode = new VerifyCode;
	

	echo(json_encode($vcode->CreateCode($codeCnt)));
	