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
	
	class msgBoundaryTest extends PHPUnit_Framework_TestCase
	{
		/** @test */
		public function msgTest()
		{
			//0, 20, 50, 51
			$_POST["message"] = "";
			$str = "";
			$res = check_value_message();
			$this -> assertEquals("<p>問題未填!</p>", $res);
			
			$arr = array(20,50,51);
			$msg = array("ok.","<p>問題限於50字以內!</p>","<p>問題限於50字以內!</p>");
			$len = count($arr);
			for($index=0;$index<$len;$index++)
			{
				for($counter=1;$counter<=$arr[$index];$counter++)
				{
					$str .= "a";
				}
				
				$_POST["message"] = $str;
				$str = "";
				$res = check_value_message();
				$this -> assertEquals($msg[$index], $res);
			}
			
			//49,50,51
			$arr = array(49,50,51);
			$len = count($arr);
			for($index=0;$index<$len;$index++)
			{
				for($counter=1;$counter<=$arr[$index];$counter++)
				{
					$str .= "a";
				}

				$_POST["message"] = $str;
				$str = "";
				$res = check_value_message();
				$this -> assertEquals($msg[$index], $res);
			}
		}
	}
?>