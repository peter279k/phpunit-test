<?php
	session_start();
	require "vendor/autoload.php";
	$lifetime = 10;
	session_set_cookie_params($lifetime);

	function handle_admin()
	{
		if(empty($_POST['admin_account'])==false && empty($_POST['admin_password'])==false)
		{
			$account = $_POST['admin_account'];
			$password = md5($_POST['admin_password']);
			//password: ccc95
			$file_path = "../sqlite/books_web.s3db";
			if(file_exists($file_path))
			{
				$link = new SQLite3($file_path);
				$sql_cmd = "SELECT password FROM root_account WHERE password='$password'";
				$result = $link -> query($sql_cmd);
			
				$i = 0;
				$row = array();
				while($res = $result -> fetchArray(SQLITE3_ASSOC))
				{
					$row[$i]['password'] = $res['password'];
					$i++;
				}
				if(count($row)!=0)
				{
					$_SESSION['root'] = "root";
					return "admin login success.";
				}
				else
				{
					return "admin login failed.";
				}
				$link -> close();
			}
			else
			{
				return "cannot link database.";
			}
		}
		else
		{
			return "post error";
		}
	}
	
	class handleAdminTest extends PHPUnit_Framework_TestCase
	{
		/** @test */ 
		public function adminTest()
		{
			//[1,2]
			$res = handle_admin();
			$this -> assertEquals("post error", $res);
			
			//[1,3]
			$_POST['admin_account'] = "text-account";
			$_POST['admin_password'] = "text-pass";
			
			//[3,4]
			//sqlite database file was not existed.
			copy("../sqlite/books_web.s3db", "./books_web.s3db");
			@unlink("../sqlite/books_web.s3db");
			$res = handle_admin();
			$this -> assertEquals("cannot link database.", $res);
			
			//[3,5]
			copy("./books_web.s3db", "../sqlite/books_web.s3db");
			//sqlite database file already has existed.
			
			//[5,7]
			$res = handle_admin();
			$this -> assertEquals("admin login failed.", $res);
			
			//[5,6]
			$_POST['admin_account'] = "text-account";
			$_POST['admin_password'] = "ccc95";
			$res = handle_admin();
			$this -> assertEquals("admin login success.", $res);
		}
	}
?>