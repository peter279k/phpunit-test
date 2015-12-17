<?php
	//name,email,message
	require "vendor/autoload.php";
	
	function check_value_message()
	{
		$message = "";
		if(empty($_POST['message'])==false && strlen($_POST['message'])<50)
		{
			$message = $_POST['message'];
		}
		if(empty($_POST['message'])==false && strlen($_POST['message'])>=50)
		{
			return "<p>問題限於50字以內!</p>";
		}
		
		return "ok.";
	}
	
	class msgInDomaninTest extends PHPUnit_Framework_TestCase
	{
		/** @test */
		public function msgTest()
		{
			//$_POST["message"] = "text-message"
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
			//$_POST["message"] = 超過長度 50;
			$str = "";
			for($counter=1;$counter<=50000;$counter++)
				$str .= "a";
			$_POST["message"] = $str;
			$res = check_value_message();
			$this -> assertEquals("<p>問題限於50字以內!</p>", $res);
			
			//$_POST["message"] = ""
		}
	}
?>