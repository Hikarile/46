<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	$d=array();
	$number=array();
	
	$id=$_GET ['id'];
	$aa=$mysql->query("select `d`, count(`id`) as number from `see` where `d-id` = '$id' group by `d`");
	while($a=mysqli_fetch_array($aa)){
		$number[]=$a['number'];
		$d[]=$a['d'];
	}
	
	$max=max($number)+1;   //4
	$aaa=count($number);  //2
	
	$img=imagecreate(300,300);
	$bg=imagecolorallocate($img,255,255,255);
	$line=imagecolorallocate($img,0,0,0);
	
	imageline($img,30,0,30,270,$line);
	imageline($img,30,270,300,270,$line);
	
	$w=270/$max;
	$ww=$w;
	for($j=1;$j<=$max;$j++){
		imageline($img,300-$w,0,300-$w,270,$line);
		imagettftext($img,10,0,300-$w,290,$line,"abc.ttc",$max-$j);
		$w+=$ww;
	}
	
	$z30=30;
	$wi=270/$max;
	for($i=1;$i<=$aaa;$i++){
		$wit=$wi*$number[$i-1];
		$color=imagecolorallocate($img,rand(50,200),rand(50,200),rand(50,200));
		
		imagefilledrectangle($img,30,$z30,$wit+30,$z30+30,$color);
		imagettftext($img,15,0,0,$z30+15,$line,"abc.ttc",$d[$i-1]);
		$z30+=60;
	}
	
	header("Content-type:image/png");
	imagepng($img);
	imagedestroy($img);
?>