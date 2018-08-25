<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/script.js"></script>
		
		<title>模組C 繪圖系統</title>
	</head>
	
	<body>
		<div class="dPaint">
			<div class="dBlock">
				<div class="dShape"></div>
			</div>
			<div class="dBlock">
				<div class="dColor"></div>
				<div class="dLine"></div>
				<div class="dCanvas">
					<canvas id="drawPad">
						This text is displayed if your browser does not support HTML5 Canvas.
					</canvas>
				</div>
			</div>
			<div class="dBlock">
				<div class="dIllustration"></div>
				<div class="dBtn">
					<p>
						<button class="b1" id="repeat">重播</button>
					</p>
					<p>
						<button class="b1">存成圖片檔</button>
					</p>
					<p>
						<button class="b1">存成可編輯檔</button>
					</p>
					<p>
						<button class="b1">載入可編輯檔</button>
					</p>
				</div>
			</div>
		</div>
	</body>
</html>