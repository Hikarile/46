<?php
	session_start();
	error_reporting(E_ALL &~ E_NOTICE);
	$mysql= new mysqli('localhost','admin','1234','46');
	$mysql->query("set names `utf8`");
	if($_SESSION['dnlu'] == ""){
		header("location:s1.php");
	}
	
	$i=$_POST['ii'];
	echo '<tr class="big">
            	<th width="5%">'.$i.'</th>
                <td>
                	問題類型:</br>
                    <input type="radio" name="type['.$i.']" value="0" checked>未選擇&nbsp;
                    <input type="radio" name="type['.$i.']" value="1" onClick="yn('.$i.')">是非題&nbsp;
                    <input type="radio" name="type['.$i.']" value="2" onClick="one('.$i.')">單選題&nbsp;
                    <input type="radio" name="type['.$i.']" value="3" onClick="two('.$i.')">多選題&nbsp;
                    <input type="radio" name="type['.$i.']" value="4" onClick="wi('.$i.')">問答擇&nbsp;&nbsp;
                    <input type="checkbox" name="be['.$i.']" value="1" checked>必填&nbsp;
                    <input type="checkbox" name="ta['.$i.']" value="1">其他&nbsp;
                    <input type="button" value="刪除題目"  class="d"></p>
                    
                    題目問題:</br>
                    <textarea name="q['.$i.']" id="w"></textarea></p>
                    
                    題目選項:</br>
                    <label class="yn'.$i.'" hidden>1.是&nbsp;&nbsp;2.否</label>
                    <label class="ot'.$i.'" hidden>
                    	<label class="d1'.$i.'">1.<input type="text" name="n[1]['.$i.']"></label>
                        <label class="d2'.$i.'">2.<input type="text" name="n[2]['.$i.']"></label>
                        <label class="d3'.$i.'">3.<input type="text" name="n[3]['.$i.']"></label>
                        <label class="d4'.$i.'">4.<input type="text" name="n[4]['.$i.']"></label>
                        <label class="d5'.$i.'"  hidden>5.<input type="text" name="n[5]['.$i.']"></label>
                        <label class="d6'.$i.'"  hidden>6.<input type="text" name="n[6]['.$i.']"></label>
                        <label class="d7'.$i.'"  hidden>7.<input type="text" name="n[7]['.$i.']"></label>
                        <label class="d8'.$i.'"  hidden>8.<input type="text" name="n[8]['.$i.']"></label>
                        
                        <input type="hidden" name="h['.$i.']" class="p'.$i.'" value="4">
                        <input type="button" name="ga['.$i.']" value="新增答案" onClick="ga('.$i.');">
                        <input type="button" name="gn['.$i.']" value="刪除答案" onClick="gn('.$i.');">
                    </label>
                    <label class="wi'.$i.'" hidden>自由填寫</label>
                </td>
            </tr>'
?>