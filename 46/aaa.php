
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
	var a=0;
	function nex(page,maxx){
		if(a>=maxx-page){alert("已經到最後一頁了");return;}
		a+=page;
		for(j=1;j<=maxx;j++){
			$("#big"+j).hide();
		}
		for(k=a+1;k<=a+page;k++){
			$('#big'+k).show();
		}
	}
	function o(page,maxx){
		if(a<=0){alert("已經到第一頁了");return;}
		a-=page;
		for(j=1;j<=maxx;j++){
			$("#big"+j).hide();
		}
		for(k=a+1;k<=a+page;k++){
			$('#big'+k).show();
		}
	}
	
</script>
<style>
	@media only screen and (max-device-width: 500px) {
		body{
			font-size:72px;
		}
		input[type=radio], [type=checkbox]
		{
			width:50px;
			height:50px;
		}
		input
		{
			font-size:72px;
		}
	}
</style>
</head>

<body bgcolor="#6699FF">

	<center><h1>
		<?=$a['name']?></p>
       完成度:<label id="do">0</label>%</p>
    </h1></center>
    
    <center><h1>
    	<form action="aadd.php"  method="post" id="submitForm">
            <table border="1" width="95%">
				<?php
					$i=0;
					while($b=mysqli_fetch_array($bb)){
					$i++;
					$da=explode(',',$b['a']);
                ?>
                <tr id="big<?=$i?>" hidden>
                    <th width="10%"><?=$i?></th>
                    <td id="big<?=$i?>">
						<?=$b['q']?>?</br>
                        <?php
                        if($b['be'] == 1){
                       		echo "(*必填*)</p>";
							echo '<input type="hidden" name="be'.$i.'" value="'.$b['be'].'">';
                        }
                        ?>
                        
                        <?php
                        if($b['type'] == 1){
                        ?>
                        <input id="dan<?=$i?>" type="radio" name="ot[<?=$i?>]" value="是"<?php if($b['be'] == 1){ echo"required";}?> onchange="qi()">是&nbsp;&nbsp;&nbsp;
                        <input id="dan<?=$i?>" type="radio" name="ot[<?=$i?>]" value="否"<?php if($b['be'] == 1){ echo"required";}?> >否&nbsp;&nbsp;&nbsp;
                        <?php
                        }
                        if($b['type'] == 2){
                        	for($j=1;$j<=$b['h'];$j++){
                        ?>
                        <input id="dan<?=$i?>" type="radio" name="one[<?=$i?>]" value="<?=$da[$j-1]?>"<?php if($b['be'] == 1){ echo"required";}?> ><?=$da[$j-1]?>&nbsp;&nbsp;&nbsp; 
                        <?php
                        	}
                        }
                        if($b['type'] == 3){
                        	for($j=1;$j<=$b['h'];$j++){
                        ?>
                        <input id="dan<?=$i?>[<?= $j ?>]" type="checkbox" name="two[<?=$i?>][<?=$j?>]" value="<?=$da[$j-1]?>"><?=$da[$j-1]?>&nbsp;&nbsp;&nbsp;
                        <?php
                        	}
                        }
						if($b['ta'] == 1){
						?>
                        其他:<input type="text" name="two[<?=$i?>][<?=$j?>]">
						<?php
							echo '<input type="hidden" name="h['.$i.']" value="'.($b['h']+1).'">';
						}else{
							echo '<input type="hidden" name="h['.$i.']" value="'.$b['h'].'">';
						}
                        if($b['type'] == 4){
                        ?>
                        <textarea id="dan<?=$i?>" name="wi[<?=$i?>]" style="width:80%; height:150px;"></textarea>
                        <?php	
                        }
                        ?>
                        <input type="hidden" name="qid[<?=$i?>]" value="<?=$b['id']?>">
                        <input type="hidden" name="type<?=$i?>" value="<?=$b['type']?>">
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
								$("#on").show();
							}
						}
					})
				</script>
            </table>
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="button" value="上一頁" id="on" onClick="o(<?=$page?>,<?=$i?>)">
        <input type="button" value="下一頁" id="next" onClick="nex(<?=$page?>,<?=$i?>)">
        <input type="submit" value="確定">
        </form>
    </h1></center>
    <script>
	var p=0;
	var ot=0;
	$('[name^="ot"], [name^="one"], [name^="two"], [name^="wi"]').change(function() {
		var count=<?=$i?>;
		ot = 0;
		for(k=1;k<=count;k++){
			if($('[name="type'+k+'"]').val() == 1){
				if ($('[name="ot['+k+']"]').is(':checked')){
					ot++;
				}
			}if($('[name="type'+k+'"').val() == 2){
				if ($('[name="one['+k+']"]').is(':checked')){
					ot++;
				}
			}if($('[name="type'+k+'"').val() == 3){
				if ($('[name^="two['+k+']"').is(':checked')){
					ot++;
				}	
			}if($('[name="type'+k+'"').val() == 4){
				if ($('[name="wi['+k+']"]').val() != ''){
					ot++;
				}
			}
		}
		p=ot/count*100;
		$("#do").text('');
		$("#do").text(p);
		p=0;
	})
	
	
	
	$(function(){
		$('#submitForm').submit(function(){
			var count=<?=$i?>;
			for(i=1;i<=count;i++){
				var no = 0;
				if($('[name="type'+i+'"').val() == 3){
					var be =$('[name="be'+i+'"]').val();
					if(be==1){
						var h= $('[name="h['+i+']"]').val();
						for (index = 1; index <= h; index++){
							if (!$('[id="dan'+i+'['+index+']"]').is(':checked')){
								no++;
							}
						}
						if(no==h){
							alert("未填寫完成");
							return false;
						}
					}
				}
				if($('[name="type'+i+'"').val() == 4){
					var be =$('[name="be'+i+'"]').val();
					if(be==1){
						var wi=$("#dan"+i).val();
						if(wi == ""){
							alert("未填寫完成");
							return false;
						}	
					}
				}
			}
		});	
	});
    </script>
</body>
</html>