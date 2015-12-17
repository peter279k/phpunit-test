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
	
	class checkValueTest extends PHPUnit_Framework_TestCase
	{
		/** @test */
		public function valueMsgTest()
		{
			//empty($_POST['message'])==false true
			//strlen($_POST['message'])<50 true
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);
			
			
			//empty($_POST['message'])==false true
			//strlen($_POST['message'])<50 false
			$str = "";
			for($counter=1;$counter<=50;$counter++)
				$str .= "d";
			$_POST["message"] = $str;
			$res = check_value_message();
			$this -> assertEquals("<p>問題限於50字以內!</p>", $res);
			
			//empty($_POST['message'])==false false
			//strlen($_POST['message'])<50 true
			$_POST["message"] = "";
			$res = check_value_message();
			$this -> assertEquals("<p>問題未填!</p>", $res);
			
			//empty($_POST['message'])==false false
			//strlen($_POST['message'])<50 false
			
			//empty($_POST['message'])==false true
			//strlen($_POST['message'])>=50 true
			$str = "";
			for($counter=1;$counter<=50;$counter++)
				$str .= "d";
			$_POST["message"] = $str;
			$res = check_value_message();
			$this -> assertEquals("<p>問題限於50字以內!</p>", $res);
			
			
			//empty($_POST['message'])==false true
			//strlen($_POST['message'])>=50 false
			$_POST["message"] = "text-message";
			$res = check_value_message();
			$this -> assertEquals("ok.", $res);

			//empty($_POST['message'])==false false
			//strlen($_POST['message'])<50 true
			$_POST["message"] = "";
			$res = check_value_message();
			$this -> assertEquals("<p>問題未填!</p>", $res);
			
			//empty($_POST['message'])==false false
			//strlen($_POST['message'])<50 false
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