<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	$id=$_GET['id'];
	$mysql->query("DELETE FROM `work` WHERE `id` = '$id'");
	$aa=$mysql->query("DELETE FROM `qa` WHERE `w-id` = '$id'");
	
	$a=mysqli_fetch_array($aa);
	$sid=$a['id'];
	$mysql->query("DELETE FROM `see` WHERE `id` = '$sid'");
	
	header("location:s2.php");
?>