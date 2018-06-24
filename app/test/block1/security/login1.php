<?php
exit( "
<script  src='https://code.jquery.com/jquery-1.12.4.min.js'  integrity='sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ='  crossorigin='anonymous'></script>
<script  src='https://code.jquery.com/ui/1.12.1/jquery-ui.min.js'  integrity='sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU='  crossorigin='anonymous'></script>
<link href='https://code.jquery.com/ui/1.12.1/themes/vader/jquery-ui.css' rel='stylesheet'>
<style>
@import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

body{
	margin: 0;
	padding: 0;
	background: #fff;
	overflow:hidden;
	color: #fff;
	font-family: Arial;
	font-size: 12px;
}

.body{
	position: absolute;
	top: -20px;
	left: -20px;
	right: -40px;
	bottom: -40px;
	width: auto;
	height: auto;
	background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
	background-image: url(studior.jpg);
	background-size: cover;
	-webkit-filter: blur(5px);
	z-index: 0;
}

.grad{
	position: absolute;
	top: -20px;
	left: -20px;
	right: -40px;
	bottom: -40px;
	width: auto;
	height: auto;
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
	z-index: 1;
	opacity: 0.7;
}

.header{
	position: absolute;
	top: calc(50% - 35px);
	left: calc(50% - 255px);
	z-index: 2;
}

.header div{
	float: left;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 35px;
	font-weight: 200;
}

#sp_word{
	color: #5379fa;
}

@keyframes blink {  
  0% { color: red; }
  100% { color: black; }
}
@-webkit-keyframes blink {
  0% { color: red; }
  100% { color: black; }
}
.blink {
  -webkit-animation: blink 1s linear 3;
  -moz-animation: blink 1s linear 3;
  animation: blink 1s linear 3;
} 

.login{
	position: absolute;
	//top: calc(50% - 75px);
	top: calc(50% - 100px);
	left: calc(50% - 50px);
	height: 150px;
	width: 350px;
	padding: 10px;
	z-index: 2;
}

.login input[type=text]{
	width: 250px;
	height: 30px;
	background: transparent;
	border: 1px solid rgba(255,255,255,0.6);
	border-radius: 2px;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 4px;
}

.login input[type=password]{
	width: 250px;
	height: 30px;
	background: transparent;
	border: 1px solid rgba(255,255,255,0.6);
	border-radius: 2px;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 4px;
	margin-top: 10px;
}

.login input[type=button]{
	width: 260px;
	height: 35px;
	background: #fff;
	border: 1px solid #fff;
	cursor: pointer;
	border-radius: 2px;
	color: #a18d6c;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 6px;
	margin-top: 10px;
}

.login input[type=button]:hover{
	opacity: 0.8;
}

.login input[type=button]:active{
	opacity: 0.6;
}

.login input[type=text]:focus{
	outline: none;
	border: 1px solid rgba(255,255,255,0.9);
}

.login input[type=password]:focus{
	outline: none;
	border: 1px solid rgba(255,255,255,0.9);
}

.login input[type=button]:focus{
	outline: none;
}

::-webkit-input-placeholder{
   color: rgba(255,255,255,0.6);
}

::-moz-input-placeholder{
   color: rgba(255,255,255,0.6);
}
</style>
<div class='body'></div>
		<div class='grad'></div>
		<div class='all'>
			<div class='header'>
				<div>Studio<span id='sp_word'>.R</span></div><span id='login_result' class='bgcolor3'></span>
			</div>
		<br>
		<div class='login'>
			<form>
				<!--<input type='text' placeholder='username' name='user'><br>-->
				<input id='pwd' type='password' placeholder='password' name='password' onkeypress='return runScript(event)' /><br>
				<input id='login' type='button' value='Login'>
			</form>
		</div>
		</div>
<script>
function runScript(e) {
    if (e.keyCode == 13) {
        var tb = document.getElementById('pwd');
		e.preventDefault();
		q();
        //return false;
    }
}
$('#login').click(function(event){
    event.preventDefault();
	q();
});
</script>
<script>

function q(){//驗證驗證碼
	$.ajax({
	url: 'http://114.34.193.48:10057/verify2/share_include/data/D_security.php',
	type: 'get',
	data:{data:($('#pwd').val())},
	dataType: 'html',
	async: false,
	success: function(data) {
	result = data;
	} 
});

	console.log(result);
	var re = result.split('#',2)[1];
	if(re=='10'){
		s();
		    $('.header').animate({
        left: '-=2000',
    }, 1500, function(){
        //want to use callback function to load the page....
        //window.location = href;
    }
	);
	$('.login').animate({
        left: '+=2000',
    }, 1500, function(){
        //want to use callback function to load the page....
        //window.location = href;
    }
	);

    $('.body').animate({
		left: '=0',
    }, 2000, function(){
		$('.body').css({
                '-webkit-filter': 'blur('+0+'px)',
                'filter': 'blur('+0+'px)'
            });
		window.location.reload();
    }
	);
		$('#sp_word').css('color','');
		$('#sp_word').css('color','green');
		console.log('驗證成功');	
	}else if(re=='11'){
		$('#sp_word').addClass('blink');
		$('#sp_word').css('color','');
		$('#sp_word').css('color','red');
		var el = $('#sp_word'); 
		var newone = el.clone(true);
		el.before(newone);       
		$('.' + el.attr('class') + ':last').remove();
		console.log('驗證失敗！');	
	}else{
		console.log('請聯絡管理猿'+result);	
	}

}

function s(){//寫入session
	$.ajax({
	url: 'http://114.34.193.48:10057/verify2/share_include/renew_session.php',
	type: 'get',
	data:{},
	dataType: 'html',
	async: false,
	success: function(data) {
	result = data;
	} 
});
}
</script>");