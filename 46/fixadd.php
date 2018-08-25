<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	$id=$_POST['hidd'];
	
	$mysql->query("DELETE FROM `qa` WHERE `w-id` = '$id'");
	foreach($_POST['q'] as $i => $val){
		$a="";
		$type=$_POST['type'][$i];
		$be=$_POST['be'][$i];
		$ta=$_POST['ta'][$i];
		$h=$_POST['h'][$i];
		
		if($type == '2'){
			for($j=1;$j<=$h;$j++){
				$a.=$_POST['n'][$j][$i].',';
			}
		}else if($type == '3'){
			for($j=1;$j<=$h;$j++){
				$a.=$_POST['n'][$j][$i].',';
			}
		}else{
			$a="";
		}
		
		$mysql->query("INSERT INTO `qa` (`w-id`,`q`,`type`,`be`,`ta`,`a`,`h`) VALUES ('$id','$val','$type','$be','$ta','$a','$h')");
		header("location:s2.php");
	}
	
?>