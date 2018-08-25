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
        }
		function two(i){
			$('.yn'+i).hide();
			$('.ot'+i).show();
			$('.wi'+i).hide();
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
    
    <h1><form method="post" action="add.php">
    	<table border="1" width="90%">
        	<?php
            for($i=1;$i<=$a['pp'];$i++){
			?>
        	<tr class="big">
            	<th width="5%"><?=$i?></th>
                <td>
                	問題類型:</br>
                    <input type="radio" name="type[<?=$i?>]" value="0" checked>未選擇&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="1" onClick="yn(<?=$i?>)">是非題&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="2" onClick="one(<?=$i?>)">單選題&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="3" onClick="two(<?=$i?>)">多選題&nbsp;
                    <input type="radio" name="type[<?=$i?>]" value="4" onClick="wi(<?=$i?>)">問答擇&nbsp;&nbsp;
                    <input type="checkbox" name="be[<?=$i?>]" value="1" checked>必填&nbsp;
                    <input type="checkbox" name="ta[<?=$i?>]" value="1">其他&nbsp;
                    <input type="button" value="刪除題目"  class="d"></p>
                    
                    題目問題:</br>
                    <textarea name="q[<?=$i?>]" id="w"></textarea></p>
                    
                    題目選項:</br>
                    <label class="yn<?=$i?>" hidden>1.是&nbsp;&nbsp;2.否</label>
                    <label class="ot<?=$i?>" hidden>
                    	<label class="d1<?=$i?>">1.<input type="text" name="n[1][<?=$i?>]"></label>
                        <label class="d2<?=$i?>">2.<input type="text" name="n[2][<?=$i?>]"></label>
                        <label class="d3<?=$i?>">3.<input type="text" name="n[3][<?=$i?>]"></label>
                        <label class="d4<?=$i?>">4.<input type="text" name="n[4][<?=$i?>]"></label>
                        <label class="d5<?=$i?>"  hidden>5.<input type="text" name="n[5][<?=$i?>]"></label>
                        <label class="d6<?=$i?>"  hidden>6.<input type="text" name="n[6][<?=$i?>]"></label>
                        <label class="d7<?=$i?>"  hidden>7.<input type="text" name="n[7][<?=$i?>]"></label>
                        <label class="d8<?=$i?>"  hidden>8.<input type="text" name="n[8][<?=$i?>]"></label>
                        
                        <input type="hidden" name="h[<?=$i?>]" class="p<?=$i?>" value="4">
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
        	<input type="hidden" class="ppp" name="ppp" value="<?=$a['pp']?>">
        	<input type="button" value="新增題目" onClick="ne()">
        	<input type="submit" value="確定" name="ok">
        </center>
        
    </form></h1>
    
</body>
</html>