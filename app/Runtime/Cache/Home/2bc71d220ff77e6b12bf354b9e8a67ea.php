<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<style>
		body{
			position: relative;
			height: 1000px;
		}
		#p630{
			-webkit-animation: z630 5s ease infinite alternate;
			-o-animation: z630 5s ease infinite alternate;
			animation: z630 5s ease infinite alternate;
			position: absolute;
			top: 0;
			left: 0;
			width: 400px;
			height: 375px;
		}
		@keyframes z630{
			0%{
				top: 0;
				left: 0;
				color: red;
			}
			25%{
				top: 20%;
				left: 25%;
			}
			50%{
				top: 0;
				left: 50%;
			}
			75%{
				top: 20%;
				left: 75%;
			}
			100%{
				top: 0;
				left: 0;
			}
		}
		@-o-keyframes z630{
			
		}
		@-webkit-keyframes z630{
			
		}
	</style>
	<div style=" text-align: center; font-size: 300px; font-family: fantasy; letter-spacing: 39px; " id="p630">630</div>
</body>
</html>