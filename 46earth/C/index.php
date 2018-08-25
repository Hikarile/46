
<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	date_default_timezone_set("Asia/Taipei");
	$mysql=new mysqli('localhost','admin','1234','tetris');
	$mysql->query("set names `utf8`");
	
	unset($_SESSION['save']);
	unset($_SESSION['colors']);
	unset($_SESSION['n']);
	unset($_SESSION['next']);
	unset($_SESSION['h']);
	unset($_SESSION['m']);
	unset($_SESSION['hr']);
	unset($_SESSION['true']);
	
	if($_SESSION['dn']!=""){
		session_destroy();
	}
	if($_POST['ok']){
		$_SESSION['dn']=$_POST['dn'];
		header("location:tetris.php");
	}
	
	$aa=$mysql->query("SELECT * FROM `eazsy` ORDER BY `hr` DESC  Limit 1");
	$a=mysqli_fetch_array($aa);
	
	$bb=$mysql->query("SELECT * FROM `hard` ORDER BY `hr` DESC  Limit 1");
	$b=mysqli_fetch_array($bb);
	if($a['hr'] > $b['hr']){
		$number=$a['hr'];
	}else{
		$number=$b['hr'];
	}
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style>
	#border{
		width:600px;
		height:500px;
		border:#000 solid 2px;
		float:inherit;
		padding:20px;
		margin:100px;
	}
	#gamestart{
		width:250px;
		height:70px;
		font-size:30px;
		background-color:#69F;
	}
</style>
</head>

<body>
	
	<center><h1>
        <div id="border">
            <div style="widows:600px; height:120px; text-align:right">
            	最高排行數:<?=$number?></br>
                <a href="pinumber.php?dn=eazsy">查看排行榜</a>
            </div>
            
            <div style="widows:600px; height:100px; padding-top:50px; font-size:72px;">
            	俄羅斯方塊
            </div>
            
            <form method="post">
                <div style="width:250px; text-align:right;">
                    等級:
                    <select name="dn" method="post" style="font-size:23px; width:80px; height:30px;">
                        <option value="eazsy">一般</option>
                        <option value="hard">困難</option>
                    </select>	
                </div>
                
                <input id="gamestart" type="submit" name="ok" value="開始遊戲">
            </form>
        </div>
    </h1></center>
    
</body>
</html>