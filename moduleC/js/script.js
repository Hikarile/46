/* Pen class */
function Pen(){//畫筆的基本屬性
	this.color = 'black'; 	// color
	this.line = 3;			// width
	this.type = 'shape';	// 無論是形狀還是插圖 shape---illustration
	this.shape = 'pen';		// 形狀的類型
	this.illustration = '';	// 插圖的類型
}

/* Shape class */
function Shape(color, line, type, shape, illustration, x, y, w, h){
	this.color = color	                || '#000000';
	this.line = line	                || 1;
	this.type = type	                || 'shape';
	this.shape = shape	                || 'none';
    this.illustration = illustration    || '';
	this.points = [];//n邊形的點
	this.x = x			                || 0;
	this.y = y			                || 0;
	this.w = w			                || 1;
	this.h = h			                || 1;
	this.leftTop = {x : 0, y : 0};
	this.rightBottom = {x : 1, y : 1};
}

/* 繪製形狀 */
Shape.prototype.draw=function(ctx){
    this.setRange();
	if (this.type == 'shape'){//畫線
		ctx.lineWidth = this.line;//線條粗細
		ctx.strokeStyle = this.color;//顏色
		
		ctx.beginPath();
		switch (this.shape) {
			case 'pen':
				var points = points;
				ctx.moveTo(this.x, this.y);
				for (var i = 0; i < this.points.length; i++) {
					var x = points[i].x, y = points[i].y;
					ctx.lineTo(x, y);
					ctx.moveTo(x, y);
				}
				break;
			case 'line':
				ctx.moveTo(this.x, this.y);
				ctx.lineTo(this.x + this.w,  this.y + this.h);
				break;
			case 'circle':
				ctx.arc(this.x + this.w / 2, this.y, Math.abs(this.w / 2), 0, Math.PI * 2);
				var rotate = rotate || Math.PI / 6;
				break;
			case 'triangle':
				var countOfSide = countOfSide || 3;
				var rotate = rotate || Math.PI / 6;
			case 'square':
				var countOfSide = countOfSide || 4
				var rotate = rotate || Math.PI / 4;
			case 'hexagon':
				var countOfSide = countOfSide || 6;
				var rotate = rotate || Math.PI / 2;
				
				var angle = 2*Math.PI/countOfSide;
				var center = {x : this.x + this. w / 2, y : this.y};
				var size = this.w / 2;
				for (var i = 0; i <= countOfSide; i++) {
					var x = center.x + Math.cos(i * angle + rotate) * size;
					var y = center.y + Math.sin(i * angle + rotate) * size;
					ctx.lineTo(x, y);
					ctx.moveTo(x, y);
				}
				break;
			case 'star':
				var countOfCorner = 5;
				var rotate = Math.PI / 10;
				var angle = 2 * Math.PI / countOfCorner;
				var center = {x : this.x + this. w / 2, y : this.y};
				var size = this.w / 2;
				for (var i = 0; i <= countOfCorner; i++) {
					var x = center.x + Math.cos(i * angle - rotate) * size;
					var y = center.y + Math.sin(i * angle - rotate) * size;
					ctx.lineTo(x, y);
					ctx.moveTo(x, y);
					x = center.x + Math.cos(i * angle + angle * 0.5 - rotate) * size / 2;
					y = center.y + Math.sin(i * angle + angle * 0.5 - rotate) * size / 2;
					ctx.lineTo(x, y);
					ctx.moveTo(x, y);
				}
				break;
		}
		ctx.closePath();
		ctx.stroke();
		
	}else if (this.type == "illustration") {//蓋章
        ctx.drawImage($("#"+this.illustration)[0], this.x, this.y, this.w, this.h);
    }
}

/*設置形狀的範圍x和y*/
Shape.prototype.setRange = function(){
    var leftTop = this.leftTop;
    var rightBottom = this.rightBottom;
    leftTop = {x : this.x, y : this.y};
    rightBottom = {x : this.x + this.w, y : this.y + this.h};
	if (this.type == 'shape') {
		switch (this.shape) {
		case 'pen'		:
			var points = this.points;
			for (var i = 0; i < points.length; i++) {
				if (points[i].x < leftTop.x) {
					leftTop.x = points[i].x;
				}
				if (points[i].x > rightBottom.x) {
					rightBottom.x = points[i].x;
				}
				if (points[i].y < leftTop.y) {
					leftTop.y = points[i].y;
				}
				if (points[i].y > rightBottom.y) {
					rightBottom.y = points[i].y;
				}
			}
			break;
		case 'line'		:
			leftTop.x = this.w >= 0 ? this.x : this.x + this.w;
			leftTop.y = this.h >= 0 ? this.y : this.y + this.h;
			rightBottom.x = this.w < 0 ? this.x : this.x + this.w;
			rightBottom.y = this.h < 0 ? this.y : this.y + this.h;
			break;
		case 'circle'	:
		case 'triangle'	:
		case 'square'	:
		case 'hexagon'	:
        case 'star'    :
			leftTop.x = this.w >= 0 ? this.x : this.x + this.w;
			rightBottom.x = this.w < 0 ? this.x : this.x + this.w;
			leftTop.y = this.w >= 0 ? this.y - this.w / 2 : this.y + this.w / 2;
			rightBottom.y = this.w < 0 ? this.y - this.w / 2 : this.y + this.w / 2;
			break;
		}
	}
    else if (this.type == 'illustration') {
        leftTop.x = this.x;
        leftTop.y = this.y;
        rightBottom.x = this.x + this.w;
        rightBottom.y = this.y + this.h;
    }
    this.leftTop = leftTop;
    this.rightBottom = rightBottom;
}

/* 判斷鼠標是否包含形狀 */
Shape.prototype.contains = function(mx, my){
	return (this.leftTop.x <= mx) && (this.rightBottom.x >= mx) && (this.leftTop.y <= my) && (this.rightBottom.y >= my);
}



function CanvasState(canvas, pen){
	this.test = $('body');
	this.canvas = canvas;
	this.width = $(this.canvas).width();
	this.height = $(this.canvas).height();
	this.ctx = canvas.getContext('2d');
	var ctx = this.ctx;
	ctx.lineCap = 'round';
	ctx.fillStyle = 'white';
	ctx.fillRect(0, 0, this.width, this.height);
	
	this.pen = pen;
	
	this.paddingLeft	= parseInt($(canvas).css('padding-left'), 10)		|| 0;
	this.paddingTop		= parseInt($(canvas).css('padding-top'), 10)		|| 0;
	this.borderLeft		= parseInt($(canvas).css('border-left-width'), 10)	|| 0;
	this.borderTop		= parseInt($(canvas).css('border-top-width'), 10)	|| 0;
	
	var html = $('html');
	this.htmlTop = html.offset().top;
	this.htmlLeft = html.offset().left;
	
	this.shapes = [];
    this.imageDatas = [];
    this.drawStep = 0;
	this.valid = false;
	this.newShape = false;
    this.anchor = null;
    this.onAnchor = false;
	this.select = false;
	this.selection = null;
	this.selectoffx = 0;
	this.selectoffy = 0;
    this.repeat=false;
	
	var myState = this;
	$(canvas).on('mousedown', function(e) {
        if(!myState.repeat) {
            var mouse = myState.getMouse(e);
            var mx = mouse.x, my = mouse.y;
			
            if(myState.pen.type == 'shape' && myState.pen.shape == 'none') {//鼠標
                if (myState.anchor && myState.anchor.contains(mx, my)) {
                    myState.onAnchor = true;
                    return;
                }
                for (var i = myState.shapes.length - 1; i >= 0; i--) {
                    var shape = myState.shapes[i];
                    if(shape.contains(mx,my)){
                        var mySel = shape;
                        myState.selectoffx = mx - mySel.x;
                        myState.selectoffy = my - mySel.y;
                        myState.select = true;
                        myState.selection = mySel;
                        myState.valid = false;
                        return;
                    }
                }
            }else if (myState.pen.type == "illustration"){//圖片
                var mySel = new Shape;
                mySel.type = myState.pen.type;
                mySel.illustration = myState.pen.illustration;
                mySel.x = mx; mySel.y = my;
                mySel.w = document.getElementById(mySel.illustration).width;
                mySel.h = document.getElementById(mySel.illustration).height;
				
                myState.addShape(mySel);
				
                myState.newShape = true;
                myState.selection = mySel;
				
                myState.valid = false;
				
                return;
            }else {//圖形
                var mySel = new Shape;
				
                mySel.color = myState.pen.color;
                mySel.line = myState.pen.line;
                mySel.type = myState.pen.type;
                mySel.shape = myState.pen.shape;
                mySel.x = mx; mySel.y = my;
				
                if (mySel.type == 'pen'){
                    mySel.points.push(mouse);
                }
				
                myState.addShape(mySel);
				
                myState.newShape = true;
                myState.selection = mySel;
                myState.valid = false;
                return;
            }
        }
	}).on('mousemove', function(e) {
        if (!myState.repeat) {
            var mouse = myState.getMouse(e);
            var shape = myState.selection;
            if (myState.onAnchor) {//鼠標
                var move = {
                    w : mouse.x - shape.x,
                    h : mouse.y - shape.y
                };
                if (myState.selection.type == 'illustration') {
                    if (myState.selection.x < mouse.x) {
                        myState.selection.w = move.w;
                    }
                    if (myState.selection.y < mouse.y) {
                        myState.selection.h = move.h;
                    }
                }
                else {
                    if (myState.selection.w > 0) {
                        myState.selection.w = move.w;
                    }
                    else {
                        myState.selection.w -= move.w;
                        myState.selection.x += move.w;
                    }
                }
                myState.valid = false;
            }else if (myState.select) {
                var move = {
                    x : mouse.x - myState.selectoffx - shape.x,
                    y : mouse.y - myState.selectoffy - shape.y
                };
                shape.x = mouse.x - myState.selectoffx;
                shape.y = mouse.y - myState.selectoffy;
                if (shape.shape == 'pen') {
                    for (var i = 0; i < shape.points.length; i++) {
                        shape.points[i].x += move.x;
                        shape.points[i].y += move.y;
                    }
                }
                myState.valid = false;
            }else if (myState.newShape) {
                if (myState.pen.type == 'illustration') {
                    shape.x = mouse.x;
                    shape.y = mouse.y;
                }else {
                    shape.w = mouse.x - shape.x;
                    shape.h = mouse.y - shape.y;
                    if (shape.shape == 'pen') {
                        shape.points.push(mouse);
                    }
                }
                myState.valid = false;
            }
        }
	}).on('mouseup', function(){
        var imageData = myState.ctx.getImageData(0, 0, myState.width, myState.height);
        myState.imageDatas.push(imageData);
		myState.select = false;
		myState.newShape = false;
        myState.onAnchor = false;
	});
	this.selectionColor = 'red';
	this.selectionWidth = 2;
	this.interval = 30;
	
	setInterval(function() { myState.draw(); }, myState.interval);
}

/* 在畫布中添加一個shape */
CanvasState.prototype.addShape = function(shape){
	this.shapes.push(shape);
	this.valid = false;
}

/* 清除繪製的畫布 */
CanvasState.prototype.clear = function(){
	var ctx = this.ctx;
	ctx.lineCap = 'round';
	ctx.fillStyle = 'white';
	ctx.fillRect(0, 0, this.width, this.height);
}

/* 畫畫布 */
CanvasState.prototype.draw = function(){
    /* if (!this.repeat) {
        var imageData = this.ctx.getImageData(0, 0, this.width, this.height);
        this.imageDatas.push(imageData);
    }
    if (this.repeat) {
        this.ctx.putImageData(this.imageDatas[this.drawStep++], 0, 0);
        if (this.drawStep >= this.imageDatas.length) {
            this.drawStep = 0;
            this.repeat = false;
        }
    }
	else  */if (!this.valid) {
		var ctx = this.ctx;
		var shapes = this.shapes;
		this.clear();
		for (var i = 0; i < shapes.length; i++) {
			var shape = shapes[i];
			if (this.select && (shape.leftTop.x > this.width || shape.leftTop.y > this.height || shape.rightBottom.x < 0 || shape.rightBottom.y < 0)) {
					continue;
			}
			shapes[i].draw(ctx);
		}
		if (this.select && this.selection != null) {
			ctx.strokeStyle = this.selectionColor;
			ctx.lineWidth = this.selectionWidth;
			var mySel = this.selection;
			ctx.strokeRect(mySel.leftTop.x, mySel.leftTop.y, mySel.rightBottom.x - mySel.leftTop.x, mySel.rightBottom.y - mySel.leftTop.y);
            if (this.selection.shape != 'pen' && this.selection.shape != 'line') {
                var anchor = new Anchor(mySel.rightBottom.x, mySel.rightBottom.y);
                this.anchor = anchor;
                anchor.draw(ctx);
            }
		}
		this.valid = true;
	}
}

/* 得到滑鼠的位置 */
CanvasState.prototype.getMouse = function(e){
	var offsetX = $(this.canvas).offset().left + this.borderLeft + this.paddingLeft;
	var mx = e.pageX - offsetX;
	var offsetY = $(this.canvas).offset().top + this.borderTop + this.paddingTop;
	var my = e.pageY - offsetY;
	return {x : mx, y : my};
}

CanvasState.prototype.runRepeat = function(){
    this.repeat = true;
}


$(function() {
	var pen = new Pen();
	var canvas = $('#drawPad')[0];
	canvas.width = $(canvas).parent().width();
	canvas.height = 500;
	var canvasState = new CanvasState(canvas, pen);
	
	/* 生成形狀 */
	var shapes = 'none;pen;line;circle;triangle;square;hexagon;star'.split(';');
	var dShape = [];
	$(shapes).each(function(index, value) {
		dShape.push('<p><img src="img/'+value+'.png" data-shape="'+value+'" class="shape" /></p>');
	});
	$('.dShape').html(dShape.join('\n'));
	$('.shape[data-shape="pen"]').css('border', '5px solid red');
	
	/* 生成顏色 */
	var colors = 'red;orange;yellow;green;blue;indigo;purple;white'.split(';');
	var dColors = [];
	$(colors).each(function(index, value) {
		dColors.push('<div data-color="'+value+'" class="color" style="background-color: '+value+'"></div>');
	});
	dColors.push('<div><span>自訂：</span><input type="color" id="color" class="color" style="border-color: black"/></div>');
	$('.dColor').html(dColors.join('\n'));
	
	/* 生成畫筆粗細 */
	var dLine = [];
	for (var i = 1; i <= 8; i++) {
		dLine.push('<div class="line"><div style="margin-top: #px;  margin-left: #px; width: %px; height: %px; background-color: black" data-line="@"></div></div>'.replace(/%/g, i).replace(/#/g, (30 - i) / 2).replace(/@/g, i));
	}
	dLine.push('<div><span>粗細：</span><input type="number" id="line" value="1" /></div>');
	$('.dLine').html(dLine.join('\n'));
	$('.line [data-line="3"]').parent().css('border-color', 'black');
	
	/* 生成印章 */
	var dIllustration = [];
	for (var i = 1; i <= 8; i++) {
		dIllustration.push('<img src="img/'+i+'.png" id="img'+i+'" class="illustration" />');
		if (i % 4 == 0) {
			dIllustration.push('<br/>');
		}
	}
	dIllustration.push('<img src="img/9.png" id="img9" class="illustration" style="width: 80%" />');
	$('.dIllustration').html(dIllustration.join('\n'));
	
	
	
	/* 點擊形狀 */
	$('.shape').click(function() {
		$('.shape').css('border', 'none');
		$('.illustration').css('border', 'none');
		$(this).css('border', '5px solid red');
		pen.type = 'shape';
		pen.shape = $(this).data('shape');
	});
	
	/* 點擊顏色 */
	$('#color').change(function() {
		pen.color = $(this).val();
		$('.color').css('border-color', 'gray');
		$(this).css('border-color', 'black');
	});
	
	$('.color').click(function() {
		if ($(this).data('color')) {
			$('.color').css('border-color', 'gray');
			$(this).css('border-color', 'black');
		}
		var color = $(this).data('color');
		if (color) {
			pen.color = $(this).data('color');
		}
	});
	
	/* 點擊畫筆粗細 */
	$('.line').click(function() {
		$('.line, #line').css('border-color', 'gray');
		$(this).css('border-color', 'black');
		pen.line = $(this).children().data('line');
		$('#line').val(pen.line);
	});
	$('#line').on('input', function() {
		$('.line').css('border-color', 'gray');
		var line = parseInt($(this).val());
		if (line > 24 || line < 1) {
			line = 1;
			$(this).val(line);
		}
		pen.line = line;
	}).focus(function() {
		$('.line').css('border-color', 'gray');
	});
	
	/* 點擊印章 */
	$('.illustration').click(function() {
		$('.shape').css('border', 'none');
		$('.illustration').css('border', 'none');
		$(this).css('border', '5px solid red');
		pen.type = 'illustration';
		pen.illustration = $(this).attr('id');
	});
    
	
	
    /* 當重複點擊相同按鈕 */
    $('#repeat').click(function() {
        canvasState.runRepeat();
    });
	
});