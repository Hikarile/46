
<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	
	$id=$_GET['id'];
	
	$aa=$mysql->query("SELECT * FROM `work` where `id` = '$id'");
    $a=mysqli_fetch_array($aa);
	
	$page=$a['page'];
	
	$bb=$mysql->query("SELECT * FROM `qa` where `w-id` = '$id'");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<script src="jquery.js" type="text/javascript"></script>
<script>
	var a=<?=$page?>;
	function nex(page,maxx){
		$('#on').show();
		for(i=1;i<=maxx;i++){
			$('#big'+i).hide();
		}
		for(j=a+1;j<=a+page;j++){
			$('#big'+j).show();
		}
		a+=page;
		if(a == maxx){
			$('#next').hide();
		}
	}
	function one(page,maxx){
		a-=page;
		$('#next').show();
		for(i=1;i<=maxx;i++){
			$('#big'+i).hide();
		}
		for(j=a+1;j<=a+page;j++){
			$('#big'+j).show();
		}
		
		if(a == 0){
			$('#on').hide();
		}
	}
</script>
<style>
	#te{
		width:80%;
		height:150px;
	}
</style>
</head>

<body bgcolor="#6699FF">
	<center><h1><?=$a['name']?></h1></center>
    
    <center><h1>
    	<form>
            <table border="1" width="95%">
				<?php
					$i=0;
					while($b=mysqli_fetch_array($bb)){
					$i++;
					$da=explode(',',$b['a']);
                ?>
                <tr id="big<?=$i?>" hidden>
                    <th width="10%"><?=$i?></th>
                    <td>
						<?=$b['q']?>?
                        <?php
                        if($b['be'] == 1){
                        echo "(*必填*)</p>";
                        }
                        ?>
                        
                        <?php
                        if($b['type'] == 1){
                        ?>
                        <input type="radio" name="ot[<?=$i?>]" value="是">是&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ot[<?=$i?>]" value="否">否&nbsp;&nbsp;&nbsp;
                        <?php
                        }
                        if($b['type'] == 2){
                        	for($j=1;$j<=$b['h'];$j++){
                        ?>
                        <input type="radio" name="one[<?=$i?>]" value="<?=$da[$j-1]?>"><?=$da[$j-1]?>&nbsp;&nbsp;&nbsp;
                        <?php
                        	}
                        }
                        if($b['type'] == 3){
							echo '<input type="hidden" name="h['.$i.']" value="'.$b['h'].'">';
                        	for($j=1;$j<=$b['h'];$j++){
                        ?>
                        <input type="checkbox" name="two[<?=$i?>][<?=$j?>]" value="<?=$da[$j-1]?>"><?=$da[$j-1]?>&nbsp;&nbsp;&nbsp;
                        <?php
                        	}
							
                        }
                        if($b['type'] == 4){
                        ?>
                        <textarea id="te" name="wi[<?=$i?>]"></textarea>
                        <?php	
                        }
                        ?>
                        <input type="hidden" name="qid[<?=$i?>]" value="<?=$b['id']?>">
                        <input type="hidden" name="type[<?=$i?>]" value="<?=$b['type']?>">
                    </td>
                </tr>
                <?php
                	}
                ?>
				<script>
					$(function (){
						var page =<?=$page?>;
						if(page == 0){
							for(i=1;i<= <?=$i?> ;i++){
								$('#big'+i).show();
								$('#next').hide();
							}
						}else{
							for(i=1;i<=page;i++){
								$('#big'+i).show();
								$('#next').show();
							}
						}
					})
				</script>
            </table>
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="button" value="上一頁" id="on" hidden onClick="one(<?=$page?>,<?=$i?>)">
        <input type="button" value="下一頁" id="next" onClick="nex(<?=$page?>,<?=$i?>)">
        <input type="button" value="確定">
        </form>
    </h1></center>
    
</body>
</html>