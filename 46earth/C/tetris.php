<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>俄羅斯方塊</title>
	<?php
        session_start();
        error_reporting(E_ALL &~ E_NOTICE);
        $mysql= new mysqli('localhost','admin','1234','tetris');
        $mysql->query("set names `utf8`");
		
        $dn=$_SESSION['dn'];
        
		if($_POST['ok']){
			$name=$_POST['name'];
			$time=$_POST['time'];
			$hr=$_POST['hr'];
			$dn=$_POST['dn'];
			
			$mysql->query("INSERT INTO `".$dn."` (`name`, `time`, `hr`) VALUES ('".$name."','".$time."','".$hr."')");
			$id=mysqli_insert_id($mysql);
			
			header('location:pinumber.php?dn='.$dn.'&id='.$id);
		}
    ?>
	<style>
    	.border{
			width:605px;
			height:680px;
			border:#000 solid 1px;
		}
		.game{
			width:400px;
			height:680px;
			border:#000 solid 1px;
			float:left;
		}
		.menu{
			width:200px;
			height:680px;
			border:#000 solid 1px;
			float:right;
		}
		.button{
			width:100px;
			height:50px;
			font-size:20px;
		}
		.st{
			width:400px;
			height:380px;
			background-color:#333;
			float:left;
			font-size:40px;
			text-align:center;
			color:#FFF;
			padding-top:300px;
		}
		.over{
			width:400px;
			height:580px;
			background-color:#333;
			float:left;
			font-size:40px;
			text-align:center;
			color:#FFF;
			padding-top:100px;
		}
    </style>
    <script src="jquery.js" type="text/javascript"></script>
    <script>
		//變數
		var dn='<?=$dn?>';//等級(一般/困難)
		if(dn == 'eazsy'){//會不會跑出障礙方塊
			var grabage='';
		}else{
			var grabage='0';
		}
		var h=0;	//分鐘
		var m=0;	//秒
		var t;		//時間變數
		var tt;		//開始步驟變數
		
		var n;		//挑出7種方塊的其中一個
		var next;	//下一個方塊
		var keycode;//鍵盤
		
		var d=0;    //記數下降
		var rl=0;   //記數左右
		var save=[]; //保存已經下降的東西
		var hidden=0;//比對存變數的累加
		var rotation=0//轉次數
		
		var I =[[-1,5],[0,5],[1,5],[2,5],[2,3],[2,4],[2,5],[2,6]];
		var J =[[2,4],[0,5],[1,5],[2,5],[1,4],[1,5],[1,6],[2,6],[0,4],[1,4],[2,4],[0,5],[1,4],[2,4],[2,5],[2,6]];
		var L =[[0,4],[1,4],[2,4],[2,5],[2,4],[2,5],[2,6],[1,6],[0,4],[0,5],[1,5],[2,5],[1,4],[2,4],[1,5],[1,6]];
		var O =[[1,4],[1,5],[2,4],[2,5]];
		var S =[[2,4],[2,5],[1,5],[1,6],[0,4],[1,4],[1,5],[2,5]];
		var T =[[1,4],[1,5],[2,5],[1,6],[0,4],[1,4],[2,4],[1,5],[2,4],[1,5],[2,5],[2,6],[1,4],[0,5],[1,5],[2,5]];
		var Z =[[1,4],[1,5],[2,5],[2,6],[2,4],[1,4],[1,5],[0,5]];
		
		var tetris=[I,J,L,O,S,T,Z];
		
		var th=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u'];
		var menu=['v0','v1','v2','v3'];
		var color=['#0CF','#03F','#F90','#FF0','#6F3','#C6F','#F00'];
		
		
		$(function(){
			$("#sub").submit(function(){
				if($("[name='name']").val()==''){
					alert('暱稱未填');
					return false;
				}
			})
			
			if('<?=$_SESSION['true']?>' == 'true'){
				n='<?=$_SESSION['n']?>';
				next='<?=$_SESSION['next']?>';
				
				if(next!=''){
					for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
						box=tetris[next][a][0];
						line=tetris[next][a][1];
						box=box+1;
						ling=line-3;
						$("#"+menu[box]+ling).css('background-color',color[next]);
					}
				}
				
				m='<?=$_SESSION['m']?>';
				h='<?=$_SESSION['h']?>';
				hr='<?=$_SESSION['hr']?>';
				
				$("#m").text(<?=$_SESSION['m']?>);
				$("#h").text(<?=$_SESSION['h']?>);
				$("#hr").text(<?=$_SESSION['hr']?>);
				
				var sss=[];
				var ccc=[];
				var ss='<?=$_SESSION['save']?>';
				var cc='<?=$_SESSION['colors']?>';
				
				if(ss!=''){
					sss=ss.split(',');
				}
				if(cc!=''){
					ccc=cc.split('___');
				}
				
				sss.forEach(function(ssss){
					if(ssss!=''){
						save.push(ssss);
					}
				})
				
				ddd=0;
				ccc.forEach(function(cccc){
					if(cccc!=''){
						$("#"+save[ddd]).attr('style',cccc);
						ddd+=1;
					}	
				})
				time();
				work();
				return false;
			}
			
			d=0;
			rl=0;
			n=Math.floor(Math.random()*7);
			nextbox();
			time();
			work();
		})
		
		function time(){//時間
			if(m < 10){
				$("#m").text('0'+m);
			}else{
				$("#m").text(m);
			}
			if(h < 10){
				$("#h").text('0'+h);
			}else{
				$("#h").text(h);
			}
			
			if(grabage != ''){
				if(grabage==10){
					obstacle();
					grabage='0';
				}
				grabage++;
			}
			
			m++;
			if(m==60){
				m=0;
				h++;
			}
			t=setTimeout("time()", 1000);
		}
		function work(){//開始步驟
			judgment();
			boxDown();
			if(dn == 'eazsy'){
				tt=setTimeout("work()",1000);
			}else{
				tt=setTimeout("work()",250);	
			}
		}
		
		
		function takebox(){//拿出選擇好方塊
			rotation=0;
			d=0;
			rl=0;
			nextbox();
			boxDown();
		}
		function nextbox(){//選出下一個方塊
			if(next!= undefined){
				n=next;
				for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
					box=tetris[next][a][0];
					line=tetris[next][a][1];
					box=box+1;
					ling=line-3;
					$("#"+menu[box]+ling).css('background-color','');
				}
			}
			next='';
			next=Math.floor(Math.random()*7);
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
				box=tetris[next][a][0];
				line=tetris[next][a][1];
				box=box+1;
				ling=line-3;
				$("#"+menu[box]+ling).css('background-color',color[next]);
			}
		}
		function obstacle(){//生出障礙欄
			q=[];
			save.forEach(function(sa){
				co=$("#"+sa).attr('style');
				english=sa.split('');
				
				number=th.indexOf(english[0]);
				number--;
				id=th[number]+english[1];
				
				$("#"+id).attr('style',co);
				$("#"+sa).removeAttr('style');
				
				q.push(id);
			});
			
			save=[];
			q.forEach(function(qq){
				save.push(qq);
			});
			
			number='';
			number=Math.floor(Math.random()*9);
			for(i=0;i<=9;i++){
				if(i != number){
					id='u'+i;
					$("#"+id).css('background-color','#000');
					save.push(id);
				}
			}
			save.sort();
		}
		function judgment(){//塗顏色
			save.forEach(function(sa){
				for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
					box=tetris[n][i][0];
					line=tetris[n][i][1];
					boxg=box+d;
					pp=boxg;
					boxg++;
					ling=line+rl;
					da=th[boxg]+ling;
					if(sa == da || th[pp] == 'u'){
						for(j=0+parseInt(rotation);j<=3+parseInt(rotation);j++){
							box=tetris[n][j][0];
							line=tetris[n][j][1];
							boxg=box+d;
							ling=line+rl;
							da=th[boxg]+ling;
							save.push(da);
						}
						deletebox();
					}
				}
			});
		}
		
		
		document.onkeydown = function(){//鍵盤觸發事件
			keycode = event.which || event.keyCode;
			if(keycode == 32){
				if($("#hi").val()==''){
					boxfastdown();//急速降落
				}
			}if(keycode == 38){
				if($("#hi").val()==''){
					boxrotate();//旋轉
				}
			}if(keycode == 37){
				if($("#hi").val()==''){
					if(tetris[n][0+parseInt(rotation)][1]+rl>0){
						boxLeft(); //左邊
					}
				}
			}if(keycode == 39){
				if($("#hi").val()==''){
					if(tetris[n][3+parseInt(rotation)][1]+rl<9){
						boxRight();//右邊
					}
				}
			}if(keycode == 40){
				if($("#hi").val()==''){
					if(d <= 17){
						boxDown();//向下
					}
				}
			}
    	}
		function boxDown(){//往下
			var oooo='';
			save.forEach(function(sa){//判斷
				for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
					box=tetris[n][i][0];
					line=tetris[n][i][1];
					boxg=box+d;
					boxg++;
					ling=line+rl;
					da=th[boxg]+ling;
					if(sa == da){
						for(j=0+parseInt(rotation);j<=3+parseInt(rotation);j++){
							box=tetris[n][j][0];
							line=tetris[n][j][1];
							boxg=box+d;
							ling=line+rl;
							da=th[boxg]+ling;
							save.push(da);
						}
						oooo=1;
					}
				}
			});
			if(oooo != ''){
				return false;
			}
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){  //清除
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color','');
			}
			d++;
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){   //新增
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color',color[n]);
			}
			boxsave();
		}
		function boxRight(){//往右
			var oooo='';
			save.forEach(function(sa){//判斷
				for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
					box=tetris[n][i][0];
					line=tetris[n][i][1];
					boxg=box+d;
					ling=line+rl;
					ling++;
					da=th[boxg]+ling;
					if(sa == da){
						oooo=1;
					}
				}
			});
			if(oooo != ''){
				return false;
			}
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){  //清除
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color','');
			}
			rl++;
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){   //向右
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color',color[n]);
			}
			boxsave();
		}
		function boxLeft(){//往左
			var oooo='';
			save.forEach(function(sa){//判斷
				for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
					box=tetris[n][i][0];
					line=tetris[n][i][1];
					boxg=box+d;
					ling=line+rl;
					ling--;
					da=th[boxg]+ling;
					if(sa == da){
						oooo=1;
					}
				}
			});
			if(oooo != ''){
				return false;
			}
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){  //清除
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color','');
			}
			rl--;
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){   //向右
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color',color[n]);
			}
			boxsave();
		}
		function boxrotate(){//旋轉	
			fff=rotation;
			if(n==0){//I
				rotation+=4;
				if(rotation>4){
					rotation=0;
				}
			}
			if(n==1){//J
				rotation+=4;
				if(rotation>12){
					rotation=0;
				}
			}
			if(n==2){//L
				rotation+=4;
				if(rotation>12){
					rotation=0;
				}
			}
			if(n==4){//S
				rotation+=4;
				if(rotation>4){
					rotation=0;
				}
			}
			if(n==5){//T
				rotation+=4;
				if(rotation>12){
					rotation=0;
				}
			}
			if(n==6){//Z
				rotation+=4;
				if(rotation>4){
					rotation=0;
				}
			}
			save.forEach(function(sa){//判斷
				for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
					box=tetris[n][i][0];
					line=tetris[n][i][1];
					boxg=box+d;
					boxg++;
					ling=line+rl;
					da=th[boxg]+ling;
					if(sa == da){
						ok=1;
					}
				}
			});
			for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
				line=tetris[n][i][1];
				ling=line+rl;
				if(ling >= 10 || ling<0){
					ok=1;
				}
			}
			if(ok!=1){
				for(a=0+parseInt(fff);a<=3+parseInt(fff);a++){//清除
					box=tetris[n][a][0];
					line=tetris[n][a][1];
					boxg=box+d;
					ling=line+rl;
					$("#"+th[boxg]+ling).css('background-color','');
				}
				for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){//新增
					box=tetris[n][a][0];
					line=tetris[n][a][1];
					boxg=box+d;
					ling=line+rl;
					$("#"+th[boxg]+ling).css('background-color',color[n]);
				}
			}else{
				rotation=fff;
			}
		}
		function boxfastdown(){//急速降落
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){//清除
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color','');
			}
			var oooo='';
			for(i=1;i<=30;i++){
				if(save==''){
					ok='';
					for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
						box=tetris[n][a][0];
						boxg=box+d;
						if(th[boxg]!="u"){
							ok++;
						}
					}
					if(ok==4){
						d+=1;
					}else{
						break;
					}
				}else{
					save.forEach(function(sa){//判斷
						for(i=0+parseInt(rotation);i<=3+parseInt(rotation);i++){
							box=tetris[n][i][0];
							line=tetris[n][i][1];
							boxg=box+d;
							boxgg=box+d;
							boxgg++;
							ling=line+rl;
							da=th[boxgg]+ling;
							if(sa == da || th[boxg] == 'u'){
								oooo=1;
							}
						}
					});
					if(oooo == ''){
						d+=1;
					}else{
						break;
					}
				}
			}
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){//新增
				box=tetris[n][a][0];
				line=tetris[n][a][1];
				boxg=box+d;
				ling=line+rl;
				$("#"+th[boxg]+ling).css('background-color',color[n]);
			}
			boxsave();
		}
		
		
		function boxsave(){//儲存方塊
			ok="";
			for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
				box=tetris[n][a][0];
				boxg=box+d;
				if(th[boxg]=="u"){
					ok++;
				}
			}
			save.forEach(function(sa){
				for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
					box=tetris[n][a][0];
					line=tetris[n][a][1];
					boxg=box+d;
					boxg++;
					lineg=line+rl;
					id=th[boxg]+lineg;
					if(sa == id){
						ok++;
					}
				}
			})
			
			if(ok != ''){
				for(a=0+parseInt(rotation);a<=3+parseInt(rotation);a++){
					id='';
					box=tetris[n][a][0];
					line=tetris[n][a][1];
					boxg=box+d;
					lineg=line+rl;
					id=th[boxg]+lineg;
					save.push(id);
				}
				save.sort();
				$("#change").val('');
				deletebox();
			}
		}
		function deletebox(){//消除方塊+下降
			ooo='';
			for(i=0;i<=20;i++){
				var q=[];
				for(j=0;j<=9;j++){
					save.forEach(function(sa){
						da=th[i]+j;
						if(da == sa){
							ooo++;
						}
					})
				}
				if(ooo == 10){
					kkk='';
					save.forEach(function(sa){
						if(sa!=th[i]+0 && kkk==''){
							q.push(sa);
						}else{
							kkk++;
							return false;
						}
					})
					
					for(k=0;k<=9;k++){
						save=save.filter(function(s){
							return s!= th[i]+k;
						});
						$("#"+th[i]+k).removeAttr('style');
					}
					
					q.reverse();
					count=q.length-1;
					q.forEach(function(qq){
						co=$("#"+qq).attr('style');
						english=qq.split('');
						number=th.indexOf(english[0]);
						number++;
						id=th[number]+english[1];
						
						$("#"+id).attr('style',co);
						$("#"+qq).removeAttr('style');
						
						save.splice(count,1,id);
						count--;
					});
					
					ooo='';
					text=$("#hr").text();
					text++;
					$("#hr").text(text);
				}else{
					ooo='';
				}
			}
			endgame();
		}
		function endgame(){//方塊致頂，結束遊戲
			ooo='';
			save.forEach(function(sa){
				if(sa == 'd0' ||sa == 'd1' ||sa == 'd2' ||sa == 'd3' ||sa == 'd4' ||sa == 'd5' ||sa == 'd6' ||sa == 'd7' ||sa == 'd8' || sa == 'd9'){
					ooo++;
				}
			})
			if(ooo==''){
				takebox();
			}else{
				save=[];
				$("#hi").val(ooo);
				clearTimeout(t);
				clearTimeout(tt);
				
				
				$("#stop").attr('disabled','disabled');
				$("#start").attr('disabled','disabled');
				$("#out").attr('disabled','disabled');
				
				
				$(".game").attr('hidden','hidden');
				$(".over").removeAttr('hidden');
				
				time=$("#h").text()+':'+$("#m").text();
				hr=$("#hr").text();
				$("[name='time']").val(time);
				$("[name='hr']").val(hr);
			}
		}
		
		
		function stoptime(){//暫停遊戲
			$("#stop").attr('hidden','hidden');
			$("#start").removeAttr('hidden');
			clearTimeout(t);
			clearTimeout(tt);
			$(".game").attr('hidden','hidden');
			$(".st").removeAttr('hidden');
			
			$("#hi").val(1);
		}
		function starttime(){//繼續遊戲
			$("#stop").removeAttr('hidden');
			$("#start").attr('hidden','hidden');
			time();
			work();
			$(".game").removeAttr('hidden');
			$(".st").attr('hidden','hidden');
			
			$("#hi").val('');
		}
		function give_up(){//放棄
			if(confirm("你確定要放棄離開")){
				location.href='index.php';
			}
		}
		
		window.onunload=end;
		function end(theEvent){//頁面關閉
			if(keycode != 116){
				var colors=[];
				save.forEach(function(sa){
					co=$("#"+sa).attr('style');
					colors.push(co);
				})
				hr=$("#hr").text();
				
				$.ajax({
					url:"dnlu.php",
					type:"POST",
					data:{
						save:save,
						colors:colors,
						n:n,
						next:next,
						h:h,
						m:m,
						hr:hr
					},
				})
			}
		}
		
    </script>
</head>

<body>
	<h1><center>
        <div class="border">
            <div class="game">
                <table border="1" width="400px" height="680px" bgcolor="#999999">
                    <tr hidden id="a00">
                        <th id="a0"></th>
                        <th id="a1"></th>
                        <th id="a2"></th>
                        <th id="a3"></th>
                        <th id="a4"></th>
                        <th id="a5"></th>
                        <th id="a6"></th>
                        <th id="a7"></th>
                        <th id="a8"></th>
                        <th id="a9"></th>
                    </tr>
                    <tr hidden id="b00">
                        <th id="b0"></th>
                        <th id="b1"></th>
                        <th id="b2"></th>
                        <th id="b3"></th>
                        <th id="b4"></th>
                        <th id="b5"></th>
                        <th id="b6"></th>
                        <th id="b7"></th>
                        <th id="b8"></th>
                        <th id="b9"></th>
                    </tr>
                    <tr hidden id="c00">
                        <th id="c0"></th>
                        <th id="c1"></th>
                        <th id="c2"></th>
                        <th id="c3"></th>
                        <th id="c4"></th>
                        <th id="c5"></th>
                        <th id="c6"></th>
                        <th id="c7"></th>
                        <th id="c8"></th>
                        <th id="c9"></th>
                    </tr>
                    <tr hidden id="d00">
                        <th id="d0"></th>
                        <th id="d1"></th>
                        <th id="d2"></th>
                        <th id="d3"></th>
                        <th id="d4"></th>
                        <th id="d5"></th>
                        <th id="d6"></th>
                        <th id="d7"></th>
                        <th id="d8"></th>
                        <th id="d9"></th>
                    </tr>
                    <tr id="e00">
                        <th id="e0"></th>
                        <th id="e1"></th>
                        <th id="e2"></th>
                        <th id="e3"></th>
                        <th id="e4"></th>
                        <th id="e5"></th>
                        <th id="e6"></th>
                        <th id="e7"></th>
                        <th id="e8"></th>
                        <th id="e9"></th>
                    </tr>
                    <tr id="f00">
                        <th id="f0"></th>
                        <th id="f1"></th>
                        <th id="f2"></th>
                        <th id="f3"></th>
                        <th id="f4"></th>
                        <th id="f5"></th>
                        <th id="f6"></th>
                        <th id="f7"></th>
                        <th id="f8"></th>
                        <th id="f9"></th>
                    </tr>
                    <tr id="g00">
                        <th id="g0"></th>
                        <th id="g1"></th>
                        <th id="g2"></th>
                        <th id="g3"></th>
                        <th id="g4"></th>
                        <th id="g5"></th>
                        <th id="g6"></th>
                        <th id="g7"></th>
                        <th id="g8"></th>
                        <th id="g9"></th>
                    </tr>
                    <tr id="h00">
                        <th id="h0"></th>
                        <th id="h1"></th>
                        <th id="h2"></th>
                        <th id="h3"></th>
                        <th id="h4"></th>
                        <th id="h5"></th>
                        <th id="h6"></th>
                        <th id="h7"></th>
                        <th id="h8"></th>
                        <th id="h9"></th>
                    </tr>
                    <tr id="i00">
                        <th id="i0"></th>
                        <th id="i1"></th>
                        <th id="i2"></th>
                        <th id="i3"></th>
                        <th id="i4"></th>
                        <th id="i5"></th>
                        <th id="i6"></th>
                        <th id="i7"></th>
                        <th id="i8"></th>
                        <th id="i9"></th>
                    </tr>
                    <tr id="j00">
                        <th id="j0"></th>
                        <th id="j1"></th>
                        <th id="j2"></th>
                        <th id="j3"></th>
                        <th id="j4"></th>
                        <th id="j5"></th>
                        <th id="j6"></th>
                        <th id="j7"></th>
                        <th id="j8"></th>
                        <th id="j9"></th>
                    </tr>
                    <tr id="k00">
                        <th id="k0"></th>
                        <th id="k1"></th>
                        <th id="k2"></th>
                        <th id="k3"></th>
                        <th id="k4"></th>
                        <th id="k5"></th>
                        <th id="k6"></th>
                        <th id="k7"></th>
                        <th id="k8"></th>
                        <th id="k9"></th>
                    </tr>
                    <tr id="l00">
                        <th id="l0"></th>
                        <th id="l1"></th>
                        <th id="l2"></th>
                        <th id="l3"></th>
                        <th id="l4"></th>
                        <th id="l5"></th>
                        <th id="l6"></th>
                        <th id="l7"></th>
                        <th id="l8"></th>
                        <th id="l9"></th>
                    </tr>
                    <tr id="m00">
                        <th id="m0"></th>
                        <th id="m1"></th>
                        <th id="m2"></th>
                        <th id="m3"></th>
                        <th id="m4"></th>
                        <th id="m5"></th>
                        <th id="m6"></th>
                        <th id="m7"></th>
                        <th id="m8"></th>
                        <th id="m9"></th>
                    </tr>
                    <tr id="n00">
                        <th id="n0"></th>
                        <th id="n1"></th>
                        <th id="n2"></th>
                        <th id="n3"></th>
                        <th id="n4"></th>
                        <th id="n5"></th>
                        <th id="n6"></th>
                        <th id="n7"></th>
                        <th id="n8"></th>
                        <th id="n9"></th>
                    </tr>
                    <tr id="o00">
                        <th id="o0"></th>
                        <th id="o1"></th>
                        <th id="o2"></th>
                        <th id="o3"></th>
                        <th id="o4"></th>
                        <th id="o5"></th>
                        <th id="o6"></th>
                        <th id="o7"></th>
                        <th id="o8"></th>
                        <th id="o9"></th>
                    </tr>
                    <tr id="p00">
                        <th id="p0"></th>
                        <th id="p1"></th>
                        <th id="p2"></th>
                        <th id="p3"></th>
                        <th id="p4"></th>
                        <th id="p5"></th>
                        <th id="p6"></th>
                        <th id="p7"></th>
                        <th id="p8"></th>
                        <th id="p9"></th>
                    </tr>
                    <tr id="q00">
                        <th id="q0"></th>
                        <th id="q1"></th>
                        <th id="q2"></th>
                        <th id="q3"></th>
                        <th id="q4"></th>
                        <th id="q5"></th>
                        <th id="q6"></th>
                        <th id="q7"></th>
                        <th id="q8"></th>
                        <th id="q9"></th>
                    </tr>
                    <tr id="r00">
                        <th id="r0"></th>
                        <th id="r1"></th>
                        <th id="r2"></th>
                        <th id="r3"></th>
                        <th id="r4"></th>
                        <th id="r5"></th>
                        <th id="r6"></th>
                        <th id="r7"></th>
                        <th id="r8"></th>
                        <th id="r9"></th>
                    </tr>
                    <tr id="s00">
                        <th id="s0"></th>
                        <th id="s1"></th>
                        <th id="s2"></th>
                        <th id="s3"></th>
                        <th id="s4"></th>
                        <th id="s5"></th>
                        <th id="s6"></th>
                        <th id="s7"></th>
                        <th id="s8"></th>
                        <th id="s9"></th>
                    </tr>
                    <tr id="t00">
                        <th id="t0"></th>
                        <th id="t1"></th>
                        <th id="t2"></th>
                        <th id="t3"></th>
                        <th id="t4"></th>
                        <th id="t5"></th>
                        <th id="t6"></th>
                        <th id="t7"></th>
                        <th id="t8"></th>
                        <th id="t9"></th>
                    </tr>
                    <tr id="u00">
                        <th id="u0"></th>
                        <th id="u1"></th>
                        <th id="u2"></th>
                        <th id="u3"></th>
                        <th id="u4"></th>
                        <th id="u5"></th>
                        <th id="u6"></th>
                        <th id="u7"></th>
                        <th id="u8"></th>
                        <th id="u9"></th>
                    </tr>
                </table>
            </div>
            
            <div hidden class="over">
                遊戲結束
                <p>&nbsp;<p/>
                <form method="post" id="sub">
                    暱稱:<input type="text" name="name"><br/>
                    時間:<input type="text" name="time" readonly><br/>
                    行數:<input type="text" name="hr" readonly><p/>
                    <input type="hidden" name="dn" value="<?=$dn?>">
                    <input style="border:#63F solid 3px; background-color:#69F; font-size:40px; width:200px; height:70px;" type="submit" name="ok" value="送出">
                </form>
            </div>
            
            <div hidden class="st">
                暫停
            </div>
            
            <div class="menu">
                <table border="1" width="160px" height="160px"bgcolor="#999999">
                    <tr id="v0">
                        <th id="v00"></th>
                        <th id="v01"></th>
                        <th id="v02"></th>
                        <th id="v03"></th>
                    </tr>
                    <tr id="v1">
                        <th id="v10"></th>
                        <th id="v11"></th>
                        <th id="v12"></th>
                        <th id="v13"></th>
                    </tr>
                    <tr id="v2">
                        <th id="v20"></th>
                        <th id="v21"></th>
                        <th id="v22"></th>
                        <th id="v23"></th>
                    </tr>
                    <tr id="v3">
                        <th id="v30"></th>
                        <th id="v31"></th>
                        <th id="v32"></th>
                        <th id="v33"></th>
                    </tr>
                </table>
                
                <p>&nbsp;</p>
                
                等級:<label id="dn"><?php if($dn == 'eazsy'){echo'一般';}else{echo'困難';}?></label></p>
                行數:<label id="hr">0</label></p>
                時間:<label id="h"></label>:<label id="m"></label></p>
                
                <p>&nbsp;</p>
                <input type="hidden" name="hi" id="hi">
                <input type="button" id="start" class="button" value="繼續遊戲" onClick="starttime();" hidden>
                <input type="button" id="stop" class="button" value="遊戲暫停" onClick="stoptime();">
                <input type="button" id="out" class="button" value="放棄遊戲" onClick="give_up();">
            </div>
        </div>
        
    </center></h1>
</body>
</html>