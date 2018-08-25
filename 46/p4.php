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
	$red=imagecolorallocate($img,255,0,0);
	
	imageline($img,30,0,30,270,$line);
	imageline($img,30,270,300,270,$line);
	
	$h=270/$max;
	$hh=$h;
	for($j=1;$j<=$max;$j++){
		imageline($img,30,$h,300,$h,$line);
		imagettftext($img,10,0,15,$h,$line,"abc.ttc",$max-$j);
		
		$h+=$hh;
	}
	
	$hhh=270/$max;
	$z30=40;
	for($i=1;$i<=$aaa;$i++){
		$den=270-($number[$i-1]*$hhh);
		imagefilledarc($img,$z30,$den,10,10,0,360,$line,IMG_ARC_PIE);
		
		$x1=$z30;
		$y1=$den;
		imagettftext($img,15,0,$x1,$y1+20,$line,"abc.ttc",$d[$i-1]);
		if($i != 1){	
			imageline($img,$x1,$y1,$x2,$y2,$red);
		}
		
		
		$x2=$z30;
		$y2=$den;
		
		$z30+=40;
	}
	
	header("Content-type:image/png");
	imagepng($img);
	imagedestroy($img);
?>