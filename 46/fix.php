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
	<style>
		#w{
			width:95%;
		}
	</style>
    <script src="jquery.js" type="text/javascript"></script>
	<script>
        function yn(i){
			$('.yn'+i).show();
			$('.ot'+i).hide();
			$('.wi'+i).hide();
        }
		function one(i){
			$('.yn'+i).hide();
			$('.ot'+i).show();
			$('.wi'+i).hide();
			
			sh=$('.p'+i).val();
			for(j=1;j<=sh;j++){
				$(".d"+j+i).show();
			}
        }
		function two(i){
			$('.yn'+i).hide();
			$('.ot'+i).show();
			$('.wi'+i).hide();
			
			sh=$('.p'+i).val();
			for(j=1;j<=sh;j++){
				$(".d"+j+i).show();
			}
        }
		function wi(i){
			$('.yn'+i).hide();
			$('.ot'+i).hide();
			$('.wi'+i).show();
        }
		
		function ga(i){
			p=$('.p'+i).val();
			if(p >= 8){
				alert("答案已無法新增")
			}else{
				p++;
				$(".d"+p+i).show();
				$('.p'+i).val(p);	
			}
        }
		function gn(i){
			p=$('.p'+i).val();
			if(p <= 0){
				alert("答案已無法刪除")
			}else{
				$(".d"+p+i).hide();
				p--;
				$('.p'+i).val(p);	
			}
		}
		
		function ne(){
			ppp=$('.ppp').val();
			ppp++;
			$.ajax({
				url:"new.php",
				type:"POST",
				data:{ii:ppp},
				success: function(pp){
					$('.hidd').before(pp);
				}
			})
			$('.ppp').val(ppp);
		}
		$(document).on('click','.d',function(){
			d=$(this).parents('.big');
			$(d).remove();
			ppp=$('.ppp').val();
			ppp--;
			$('.ppp').val(ppp);
		})
		
    </script>
    </head>

<body bgcolor="#6699FF">
	<center><h1><?=$a['name']?></h1></center>
    
    <p>&nbsp;</p>
    
    <h1><form method="post" action="fixadd.php">
    	<table border="1" width="90%">
        	<?php
			$i=0;
            while($b=mysqli_fetch_array($bb)){
				$i++;
				$a=explode(',',$b['a']);
			?>
        	<tr class="big">
            	<th width="5%"><?=$i?></th>
                <td>
                	問題類型:</br>
                    <input type="radio" name="type[<?=$i?>]" value="0">未選擇&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="1" <?php if($b['type'] ==1){echo 'checked';}?> onClick="yn(<?=$i?>)">是非題&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="2" <?php if($b['type'] ==2){echo 'checked';}?> onClick="one(<?=$i?>)">單選題&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="3" <?php if($b['type'] ==3){echo 'checked';}?> onClick="two(<?=$i?>)">多選題&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="4" <?php if($b['type'] ==4){echo 'checked';}?> onClick="wi(<?=$i?>)">問答擇&nbsp;&nbsp;
                    <input type="checkbox" name="be[<?=$i?>]" value="1" <?php if($b['be'] ==1){echo 'checked';}?>>必填&nbsp;
                    <input type="checkbox" name="ta[<?=$i?>]" value="1" <?php if($b['ta'] ==1){echo 'checked';}?>>其他&nbsp;
                    <input type="button" value="刪除題目"  class="d"></p>
                    
                    <script>
                    	$(function(){
							if(<?=$b['type']?> == 1){
								yn(<?=$i?>);
							}
							if(<?=$b['type']?> == 2){
								one(<?=$i?>);
							}
							if(<?=$b['type']?> == 3){
								two(<?=$i?>);
							}
							if(<?=$b['type']?> == 4){
								wi(<?=$i?>);
							}
						})
                    </script>
                    
                    題目問題:</br>
                    <textarea name="q[<?=$i?>]" id="w"><?=$b['q']?></textarea></p>
                    
                    題目選項:</br>
                    <label class="yn<?=$i?>" hidden>1.是&nbsp;&nbsp;2.否</label>
                    <label class="ot<?=$i?>" hidden>
                    	<label class="d1<?=$i?>" hidden>1.<input type="text" name="n[1][<?=$i?>]" value="<?=$a[0]?>"></label>
                        <label class="d2<?=$i?>" hidden>2.<input type="text" name="n[2][<?=$i?>]" value="<?=$a[1]?>"></label>
                        <label class="d3<?=$i?>" hidden>3.<input type="text" name="n[3][<?=$i?>]" value="<?=$a[2]?>"></label>
                        <label class="d4<?=$i?>" hidden>4.<input type="text" name="n[4][<?=$i?>]" value="<?=$a[3]?>"></label>
                        <label class="d5<?=$i?>" hidden>5.<input type="text" name="n[5][<?=$i?>]" value="<?=$a[4]?>"></label>
                        <label class="d6<?=$i?>" hidden>6.<input type="text" name="n[6][<?=$i?>]" value="<?=$a[5]?>"></label>
                        <label class="d7<?=$i?>" hidden>7.<input type="text" name="n[7][<?=$i?>]" value="<?=$a[6]?>"></label>
                        <label class="d8<?=$i?>" hidden>8.<input type="text" name="n[8][<?=$i?>]" value="<?=$a[7]?>"></label>
                        
                        <input type="hidden" name="h[<?=$i?>]" class="p<?=$i?>" value="<?=$b['h']?>">
                        <input type="button" name="ga[<?=$i?>]" value="新增答案" onClick="ga(<?=$i?>);">
                        <input type="button" name="gn[<?=$i?>]" value="刪除答案" onClick="gn(<?=$i?>);">
                    </label>
                    <label class="wi<?=$i?>" hidden>自由填寫</label>
                </td>
            </tr>
            <?php
			}
			?>
            <input type="hidden" class="hidd" name="hidd" value="<?=$id?>">
        </table>
        
        <center>
        	<input type="hidden" class="ppp" name="ppp" value="<?=$i?>">
        	<input type="button" value="新增題目" onClick="ne()">
        	<input type="submit" value="確定" name="ok">
        </center>
        
    </form></h1>
    
</body>
</html>