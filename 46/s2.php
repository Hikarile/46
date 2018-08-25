
<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	if($_POST['name']){
		$name=$_POST['name'];
		$pp=$_POST['pp'];
		$page=$_POST['page'];
		
		$n=array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		shuffle($n);
		for($j=1;$j<=10;$j++){
			$number.=$n[$j];
		}
		$mysql->query("INSERT INTO `work` (`name`,`number`,`pp`,`page`) VALUES ('$name', '$number', '$pp', '$page')");
		$id=mysqli_insert_id($mysql);
		
		header("location:s3.php?id=".$id);
	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<script src="jquery.js" type="text/javascript"></script>
<script>
	function hi(){
		$('#hi').hide();
		$('#sh').show();
	}
</script>
</head>

<body bgcolor="#6699FF">
	<center>
        <h1>問卷管理</h1>
        <input type="button" value="登出" onClick="location.href='s1.php'">
    </center>
    
    <p>&nbsp;</p>
    
    <center>
    	<input type="button" value="新增問卷" id="hi" onClick="hi()">
        
        <form method="post" id="sh" hidden>
        	問卷名稱:<input type="text" name="name"></br>
            題目數量:<input type="text" name="pp"></br>
            分頁設定;<select name="page">
            	<option value="0">不分頁</option>
                <?php
                	for($i=1;$i<=20;$i++){
						echo '<option value="'.$i.'">每'.$i.'題分頁</option>';
					}
				?>
            </select></br>
            <input type="submit" name="ok" value="確定">
        </form>
    </center>
    
    <p>&nbsp;</p>
    
    <h1><table border="1" width="95%">
    	<tr>
        	<th>問卷名稱</th>
            <th>邀請碼</th>
            <th>分頁設定</th>
            <th>編輯</th>
        </tr>
        <?php
		$aa=$mysql->query("SELECT * FROM `work`");
        while($a=mysqli_fetch_array($aa)){
		?>
		<tr>
        	<td><?=$a['name']?></td>
            <td><?=$a['number']?></td>
            <td><?=$a['page']?></td>
            <td>
            	<input type="button" value="刪除" onClick="location.href='d.php?id=<?=$a['id']?>'">
                <input type="button" value="修改" onClick="location.href='fix.php?id=<?=$a['id']?>'">
                <input type="button" value="檢視" onClick="location.href='see.php?id=<?=$a['id']?>'">
                <input type="button" value="統計" onClick="location.href='pag.php?id=<?=$a['id']?>'">
            </td>
        </tr>
		<?php
		}
		?>
    </table></h1>
</body>
</html>