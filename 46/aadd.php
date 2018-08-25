<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	
	$id=$_POST['id'];
	foreach($_POST['qid'] as $i => $val){
		$type=$_POST['type'.$i];
		$d="";
		if($type == 1){
			$d=$_POST['ot'][$i];
			
			if($d != ""){
				$mysql->query("INSERT INTO `see` (`d-id`, `d`) VALUES ('$val', '$d')");
			}
		}
		if($type == 2){
			$d=$_POST['one'][$i];
			
			if($d != ""){
				$mysql->query("INSERT INTO `see` (`d-id`, `d`) VALUES ('$val', '$d')");
			}
		}
		if($type == 3){
			$h=$_POST['h'][$i];
			for($j=1;$j<=$h;$j++){
				$d=$_POST['two'][$i][$j];
				
				if($d != ""){
					$mysql->query("INSERT INTO `see` (`d-id`, `d`) VALUES ('$val', '$d')");
				}
			}	
		}
		if($type == 4){
			$d=$_POST['wi'][$i];
			
			if($d != ""){
				$mysql->query("INSERT INTO `see` (`d-id`, `d`) VALUES ('$val', '$d')");
			}
		}
		header("location:think.php");
	}
	
?>