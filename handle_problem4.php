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
		else if(empty($_POST['message'])==false && strlen($_POST['message'])>=50)
		{
			return "<p>問題限於50字以內!</p>";
		}
		else
		{
			return "<p>問題未填!</p>";
		}
		
		return "ok.";
	}
	
	class msgInDomaninTest extends PHPUnit_Framework_TestCase
	{
		/** @test */
		public function msgTest()
		{
			//{strlen($_POST['message'])<50}
			$_POST['message'] = "";
			$res = check_value_message();
			$this -> assertEquals("<p>問題未填!</p>", $res);
			
			$_POST['message'] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
			//{strlen($_POST['message'])>=50}
			$str = "";
			for($counter=1;$counter<=100;$counter++)
				$str .= "a";
			$_POST['message'] = $str;
			$res = check_value_message();
			$this -> assertEquals("<p>問題限於50字以內!</p>", $res);
			
			
		}
	}
?>