<?php
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	
	$id=$_GET['id'];
	$aa=$mysql->query("select `d`, COUNT(`id`) as number from `see` where `d-id` = '$id' group by `d`");
	
	while($a=mysqli_fetch_array($aa)){
		
	}
	
?>