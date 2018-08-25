<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	
	
	$id=$_GET['id'];
	$aa=$mysql->query("SELECT * FROM `work` where `id` = '$id'");
	$a=mysqli_fetch_array($aa);
	
	$bb=$mysql->query("SELECT * FROM `qa` where `w-id` = '$id'");
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<script src="jquery.js" type="text/javascript"></script>
</head>

<body bgcolor="#6699FF">
	<center><h1><?=$a['name']?></h1></center>
    <script>
            $('body').on('click', '[id^="download"]', function() {
                var id = $(this).attr('id').substr(8);
                var a = document.createElement('a');
                a.href= 'p1.php?id='+id;
                a.download = 'donl.jpg';
                $('body').append(a);
                a.click();
				a.href= 'p2.php?id='+id;
                a.download = 'donl.jpg';
                $('body').append(a);
                a.click();
				a.href= 'p3.php?id='+id;
                a.download = 'donl.jpg';
                $('body').append(a);
                a.click();
				a.href= 'p4.php?id='+id;
                a.download = 'donl.jpg';
                $('body').append(a);
                a.click();
				a.href= 'p5.php?id='+id;
                a.download = 'donl.jpg';
                $('body').append(a);
                a.click();
				a.remove();
            })
			
			$('body').on('click','[id^="do"]',function(){
				var id = $(this).attr('id').substr(3);
				var a = document.createElement('a');
				a.href='text.php?id='+id;
				a.download='text.csv';
				a.click();
				a.remove();
			})
            </script>
    <center><h1>
        <?php
		$i=0;
        while($b=mysqli_fetch_array($bb)){
			$i++;
        ?>
            <hr>
            <?=$i.'.'.$b['q']?></p>
            
            <?php
            if($b['type'] == 4){
            ?>
            	*不產生圖表*
            <?php	
            }else{
			?>
			
            	<img name="don<?=$i?>" src="p1.php?id=<?=$b['id']?>">
            	<img name="don<?=$i?>" src="p2.php?id=<?=$b['id']?>">
                <img name="don<?=$i?>" src="p3.php?id=<?=$b['id']?>">
                <img name="don<?=$i?>" src="p4.php?id=<?=$b['id']?>">
                <img name="don<?=$i?>" src="p5.php?id=<?=$b['id']?>"></br>
                <button id="download<?=$b['id']?>">圖片下載</button>
                <button id="do<?=$b['id']?>">資料下載</button>
            <?php
			}
            ?>
            
        <?php
        }
        ?>
        </p>
        <input type="button" value="返回" onClick="location.href='s2.php'">
    </h1></center>
</body>
</html> 