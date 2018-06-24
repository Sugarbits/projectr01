<?php
session_start();
ini_set('date.timezone','Asia/Taipei');

if(isset($_SESSION['code_8517'])){
	if(time() < ($_SESSION['code_8517']+600)){
	   if(isset($_GET['test'])){
		   if($_GET['test']=='roof'){
			   echo "[after ".(600+($_SESSION['code_8517']-time()))." s expire]";
		   }else if($_GET['test']=='cls'){
			   $_SESSION['code_8517']=-1;
			   //header("location:http://114.34.193.48:10057/sys/share_include/login.php", TRUE, 302);
			   require_once('login1.php');
		   }
	   }
	   $_SESSION['code_8517'] = (String)time();//動作同步更新token
	}else{
		//die($_SESSION['code_8517']."-".(string)time());
		//header("location:http://114.34.193.48:10057/sys/share_include/login.php", TRUE, 302);
		require_once('login1.php');
	}
}else{
		//include("localhost\git\sys\share_include\login.php");
		//header("location:http://114.34.193.48:10057/sys/share_include/login.php", TRUE, 302);
		require_once('login1.php');
}
//echo "[after ".(600+($_SESSION['code_8517']-time()))." s expire]";
?>