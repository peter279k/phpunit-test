<?php
	//name,email,message
	require "vendor/autoload.php";
	/*
	function check_value()
	{
		if(empty($_POST['name'])==false)
		{
			$name = $_POST['name'];
		}
		else
		{
			return "<p>姓名未填!</p>";
		}
		if(empty($_POST['email'])==false)
		{
			$email = $_POST['email'];
		}
		else
		{
			return "<p>信箱未填!</p>";
		}
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
		
		$check_format = preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $email);
		if(!$check_format)
		{
			return "<p>信箱格式錯誤!</p>";
		}
		
		return "ok.";
	}
	*/
	
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
	
	class checkValueTest extends PHPUnit_Framework_TestCase
	{
		/** @test */
		public function valueMsgTest()
		{
			//empty($_POST['message'])==false true
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
			//empty($_POST['message'])==false false
			$_POST["message"] = "";
			$res = check_value_message();
			$this -> assertEquals("<p>問題未填!</p>", $res);
			
			//strlen($_POST['message'])<50 true
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
			//strlen($_POST['message'])<50 false
			$str = "";
			for($counter=1;$counter<=100;$counter++)
				$str .= "a";
			$_POST["message"] = $str;
			$res = check_value_message();
			$this -> assertEquals("<p>問題限於50字以內!</p>", $res);

			//empty($_POST['message'])==false true
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
			//empty($_POST['message'])==false false
			$_POST["message"] = "";
			$res = check_value_message();
			$this -> assertEquals("<p>問題未填!</p>", $res);

			//strlen($_POST['message'])>=50 true
			$str = "";
			for($counter=1;$counter<=100;$counter++)
				$str .= "a";
			$_POST["message"] = $str;
			$res = check_value_message();
			$this -> assertEquals("<p>問題限於50字以內!</p>", $res);
			
			//strlen($_POST['message'])>=50 false
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
		}
	}
	
	/*
	if(!empty($name) && !empty($email) && !empty($message) && $check_format)
	{
		$link = new SQLite3('../sqlite/books_web.s3db');
		if($link)
		{
			$sql_cmd = "INSERT INTO problem(name,email,message) VALUES('$name','$email','$message')";
			$link -> query($sql_cmd);
			$sql_cmd = "SELECT message FROM problem WHERE message = '$message'";
			$result = $link -> query($sql_cmd);
			$row = $result -> fetchArray(SQLITE3_NUM);
			
			if($row!=0)
			{
				echo "回報問題成功!";
			}
			else
			{
				echo "<p>回報問題失敗!</p>";
			}
			$link -> close();
		}
		else
		{
			echo "<span>cannot link database.</span>";
		}
	}
	
	*/
?>