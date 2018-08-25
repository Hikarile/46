<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql=new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	$d=array();
	$number=array();
	
	$jd=$_GET['id'];
	$aa=$mysql->query("select `d`, count(`id`) as number from `see` where `d-id` = '$jd' group by `d`");
	while($a=mysqli_fetch_array($aa)){
		$number[]=$a['number'];
		$d[]=$a['d'];
	}
	$max=max($number)+1;
	$aaa=count($number);
	
	$img=imagecreate(300,300);
	$bg=imagecolorallocate($img,255,255,255);
	$line=imagecolorallocate($img,0,0,0);
	
	imageline($img,30,0,30,270,$line);
	imageline($img,30,270,300,270,$line);
	
	$h=270/$max;
	$hh=$h;
	for($j=1;$j<=$max;$j++){
		imageline($img,30,$h,300,$h,$line);
		imagettftext($img,10,0,15,$h,$line,"abc.ttc",$max-$j);
		
		$h+=$hh;
	}
	$z40=40;
	$heigh=270/$max;
	for($i=1;$i<=$aaa;$i++){
		$w=$number[$i-1]*$heigh;
		
		$color=imagecolorallocate($img,rand(50,200),rand(50,200),rand(50,200));
		imagefilledrectangle($img,$z40,270,$z40+30,270-$w,$color);
		imagettftext($img,15,0,$z40+15,290,$line,"abc.ttc",$d[$i-1]);
		
		$z40+=60;
	}
	
	header("Content-type:image/png");
	imagepng($img);
	imagedestroy($img);
?>