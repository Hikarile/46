<?php
	error_reporting(E_ALL &~ E_NOTICE);
	session_start();
	$mysql= new mysqli('localhost','admin','1234','tetris');
	$mysql->query("set names `utf8`");
	
	$_SESSION['save']='';
	$_SESSION['colors']='';
	$_SESSION['n']='';
	$_SESSION['next']='';
	$_SESSION['h']='';
	$_SESSION['m']='';
	$_SESSION['hr']='';
	$_SESSION['true']='';
	
	foreach($_POST['save'] as $sa){
		$_SESSION['save']=$_SESSION['save'].','.$sa;
		
	}
	foreach($_POST['colors'] as $color){
		$_SESSION['colors']=$_SESSION['colors'].'___'.$color;
	}
	
	$_SESSION['n']=$_POST['n'];
	$_SESSION['next']=$_POST['next'];
	$_SESSION['h']=$_POST['h'];
	$_SESSION['m']=$_POST['m'];
	$_SESSION['hr']=$_POST['hr'];
	$_SESSION['true']='true';
?>