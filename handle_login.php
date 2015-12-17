<?php
	session_start();
	function handle_login()
	{
		$file_path = '../sqlite/books_web.s3db';
		$account = "";
		$password = "";
		if(file_exists($file_path))
		{
			$link = new SQLite3($file_path);
			if(empty($_POST['account'])==false)
			{
				$account = $_POST['account'];
			}
			if(empty($_POST['password'])==false)
			{
				$password = $_POST['password'];
			}
		
			$sql_cmd = "SELECT account,password,name FROM accounts WHERE account='$account' AND password='$password'";
			$result = $link -> query($sql_cmd);
			$i = 0;
			$row = array();
			$row2 = array();
			while($res = $result->fetchArray(SQLITE3_ASSOC))
			{
				$row[$i]['account'] = $res['account'];
				$row[$i]['name'] = $res['name'];
				$row2[$i]['password'] = $res['password'];
				$i++;
			}
		
			if(count($row)==0)
			{
				return '<p>帳號錯誤!</p>';
			}
			/*
			else if(count($row2)==0)
			{
				return '<p>密碼錯誤!</p>';
			}
			*/
			else
			{
				//session set
				$_SESSION['user'] = $row[$i-1]['name'];//姓名
				return "登入成功!使用完後，務必登出以免遭他人使用!";
			}
			$link -> close();
		}
		else
		{
			return '<span>error,cannot link database.</span>';
		}
	}
	
	class handleLoginTest extends PHPUnit_Framework_TestCase
	{
		/** @test */
		public function loginTest()
		{
			//using http post method to post empty strings. 
			$_POST['account'] = "";
			$_POST['password'] = "";
			$res = handle_login();
			$this -> assertEquals('<p>帳號錯誤!</p>', $res);
			
			//using http post method to post big strings.Their string length 100,but $_POST['account'] is normal.
			$str = "";
			for($counter=1;$counter<=100;$counter++)
			{
				$str .= "a";
			}
			
			$_POST['account'] = "10011204";
			$_POST['password'] = $str;
			$res = handle_login();
			$this -> assertEquals('<p>帳號錯誤!</p>', $res);
			
			//$_POST['account'] is normal, but password is abnormal string to check SQL injection.
			$_POST['account'] = "10011201";
			$_POST['password'] = '"1" OR "1" = "1"';
			$res = handle_login();
			$this -> assertEquals('<p>帳號錯誤!</p>', $res);
			
			//There are abnormal string to check SQL injection.(It has SQL injection.)
			$_POST['account'] = "1' OR '1'='1";
			$_POST['password'] = "1' OR '1'='1";
			$res = handle_login();
			$this -> assertEquals('登入成功!使用完後，務必登出以免遭他人使用!', $res);
			
			//check if sqlite file is not existed.
			copy("../sqlite/books_web.s3db", "./books_web.s3db");
			@unlink("../sqlite/books_web.s3db");
			$res = handle_login();
			$this -> assertEquals('<span>error,cannot link database.</span>', $res);
		}
	}
?>