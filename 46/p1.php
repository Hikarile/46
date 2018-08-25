<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	$number= array();
	$d=array();
	$x=array();
	$y=array();
	
	$id=$_GET['id'];
	$aa=$mysql->query("select `d`, COUNT(`id`) as number from `see` where `d-id` = '$id' group by `d`");
	while($a=mysqli_fetch_array($aa)){
		$number[]=$a['number'];
		$d[]=$a['d'];
	}
	$aaa=array_sum($number);
	$max=count($number);
	
	$img=imagecreate(300,300);
	$bg=imagecolorallocate($img,255,255,255);
	$line=imagecolorallocate($img,0,0,0);
	
	$do=0;
	foreach($number as $i => $val){
		$pi=$val/$aaa*360;
		
		$color=imagecolorallocate($img,rand(50,200),rand(50,200),rand(50,200));
		
		imagefilledarc($img,150,150,200,200,$do,$pi+$do,$color,IMG_ARC_PIE);
		
		$x[]=150+120*cos(deg2rad($pi/2+$do));
		$y[]=150+120*sin(deg2rad($pi/2+$do));
		
		$do+=$pi;
	}
	
	for($j=1;$j<=$max;$j++){
		imagettftext($img,10,0,$x[$j-1],$y[$j-1],$line,"abc.ttc",$d[$j-1].' ('.$number[$j-1].')');
	}
		
	header("Content-type:image/png");
	imagepng($img);
	imagedestroy($img);
?> 