
<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] != ""){
		session_destroy();
	}
	
	if($_POST['ac']){
		$ac=$_POST['ac'];
		$ps=$_POST['ps'];
		
		$aa=$mysql->query("SELECT * FROM `one` where `ac` = '$ac' and `ps` = '$ps'");
		if(mysqli_fetch_array($aa)){
			$_SESSION['dnlu']="tt";
			header("location:s2.php");
		}
		else{
			echo "<script>alert('登入失敗')</script>";
		}
	}
	
	if($_POST['number']){
		$number=$_POST['number'];
		$bb=$mysql->query("SELECT * FROM `work` where `number` = '$number'");
		if($b=mysqli_fetch_array($bb)){
			header("location:aaa.php?id=".$b['id']);
		}
		else{
			echo "<script>alert('無此邀請碼')</script>";
		}
	}
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body bgcolor="#6699FF">
	<center><h1>管理者登入</h1></center>
    
    <p>&nbsp;</p>
    
    <center>
    	輸入邀請碼</br>
        <form method="post">
        	<input type="text" name="number"></br>
            <input type="submit" value="確定">
        </form>
        
        <p>&nbsp;</p>
        
        <form method="post">
        	帳號:<input type="text" name="ac"></p>
            密碼:<input type="password" name="ps"><p>
            <input type="submit" name="ok" value="確定">
        </form>
        
    </center>
    
</body>
</html>