<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql=new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	$number=array();   //3,2,1
	$d=array();
	$x=array();
	$pie=array();
	
	$id=$_GET['id'];
	$aa=$mysql->query("select `d`,count(`id`) as number from `see` where `d-id` = '$id' group by `d`");
	while($a=mysqli_fetch_array($aa)){
		$number[]=$a['number'];
		$d[]=$a['d'];
	}
	
	$max=max($number)+1;  //7
	$den=count($number);  //4
	
	if($den >=3){
		$img=imagecreate(300,300);
		$bg=imagecolorallocate($img,255,255,255);
		$line=imagecolorallocate($img,0,0,0);
		$red=imagecolorallocate($img,255,0,0);
		
		$dd=360/$den;  //一開始
		$ddd=$dd;      //+的
		$gh=100/$max;  //一開始
		$ghh=$gh;      //+的
		for($l=1;$l<=$den;$l++){
			$h=$number[$l-1]*$ghh;
			$pie[]=150+$h*cos(deg2rad($dd));
			$pie[]=150+$h*sin(deg2rad($dd));
			
			$xx=150+115*cos(deg2rad($dd));
			$yy=150+115*sin(deg2rad($dd));
			imagettftext($img,10,0,$xx,$yy,$line,"abc.ttc",$d[$l-1]);
			$xx="";
			$yy="";
			
			$dd+=$ddd;
		}
		imagefilledpolygon($img,$pie,count($pie)/2,$red);
		
		$dd=360/$den;  //一開始
		$ddd=$dd;      //+的
		$gh=100/$max;  //一開始
		$ghh=$gh;      //+的
		for($i=1;$i<=$max;$i++){
			for($j=1;$j<=$den;$j++){
				$x[]=150+$gh*cos(deg2rad($dd));
				$x[]=150+$gh*sin(deg2rad($dd));
				$dd+=$ddd;
				$v++;
			}
			imagepolygon($img,$x,count($x)/2,$line);
			$dd-=360;
			$gh+=$ghh;
			unset($x);
		}
		
		header("Content-type:image/png");
		imagepng($img);
		imagedestroy($img);
	}
?>