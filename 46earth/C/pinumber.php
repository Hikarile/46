<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql=new mysqli('localhost','admin','1234','tetris');
	$mysql->query("set names `utf8`");
	session_destroy();
	
	$kkk=0;
	$dn=$_GET['dn'];
	$aa=$mysql->query("SELECT * FROM `".$dn."` ORDER BY `hr` DESC");
	
?>
<style>
	.dn{
		border:#000 solid 2px;
		border-radius:20px;
		width:100px;
		height:50px;
		float:left;
		padding-top:10px;
		margin-left:10px;
	}
	.back{
		border:#000 solid 2px;
		border-radius:20px;
		width:100px;
		height:50px;
		float:right;
		padding-top:10px;
	}
	.rank{
		width:800px;
		height:500px;
		float:left;
	}
</style>
<script src="jquery.js" type="text/javascript"></script>
<script>
	$(function(){
		if('<?=$dn?>' == 'eazsy'){
			$("#eazsy").css('background-color','#69F');
		}else{
			$("#hard").css('background-color','#69F');
		}
	})
</script>
</head>

<body>
	<center><h1>
        <div style="position:relative; width:800px; margin-top:50px;">
        
        	<div id="eazsy" class="dn" onClick="location.href='pinumber.php?dn=eazsy'">
            	一般
            </div>
            <div id="hard" class="dn" onClick="location.href='pinumber.php?dn=hard'">
            	困難
            </div>
            <div class="back" onClick="location.href='index.php'">
            	返回
            </div><br/>
            
            <div class="rank">
            	<table width="100%" border="1">
                	<tr bgcolor="#6699FF">
                    	<th>名次</th>
                        <th>暱稱</th>
                        <th>行數</th>
                        <th>時間</th>
                    </tr>
                    <?php
					$i=0;
					while($a=mysqli_fetch_array($aa)){
						$i=$i+1;
						if($i<=5){
							if($_GET['id'] == $a['id']){
								?>
                                <tr bgcolor="#CCCCCC" height="60px">
                                    <td><?=$i?></td>
                                    <td><?=$a['name']?></td>
                                    <td><?=$a['hr']?></td>
                                    <td><?=$a['time']?></td>
                                </tr>
                                <?php
							}else{
								$kkk++;
								?>
                                <tr height="60px">
                                    <td><?=$i?></td>
                                    <td><?=$a['name']?></td>
                                    <td><?=$a['hr']?></td>
                                    <td><?=$a['time']?></td>
                                </tr>
                                <?php
							}
						}
						if(isset($_GET['id']) && $kkk==5 && $_GET['id'] == $a['id']){
						?>
						<tr bgcolor="#CCCCCC" height="60px">
							<td><?=$i?></td>
							<td><?=$a['name']?></td>
							<td><?=$a['hr']?></td>
							<td><?=$a['time']?></td>
						</tr>
						<?php
					}
					}
					?>
                </table>
            </div>
        </div>
    </h1></center>
</body>
</html>