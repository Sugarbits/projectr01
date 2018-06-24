<?php
exit( "
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<link href='http://114.34.193.48:10057/verify2/share_include/login.css' rel='stylesheet'>
<script src='http://114.34.193.48:10057/verify2/share_include/plugin/jquery.min.js'></script>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
<div id='main'>
		<div class='s3'>
			<span id='login_result' class='bgcolor3'>輸入系統驗證</span>
		</div>
		<div class='s2'>
			<!--<span class='bgcolor2'>輸入</span>-->
			<input id='pwd' class='bgcolor2' />
		</div>
		<a href='#' class='3'>
			<span id='login_send'  class='bgcolor func'>OK</span>
		</a>
		
		<a href='#' class='3'>
			<span id='target1' class='bgcolor '></span>
		</a>
		<a href='#' class='3'>
			<span class='bgcolor dis'></span>
		</a>
		<a href='#' class='3'>
			<span class='bgcolor dis'></span>
		</a>

	</div>
</body>
</html>
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
		window.location.reload();
		//$('#clock').html('驗證成功！');	
	}else if(re=='11'){
		;
		//$('#clock').html('驗證失敗');
		$('#login_result').html('<b style=\'color:red;\'>驗證失敗！</b>');	
	}else{
		//$('#clock').html('請聯絡管理猿');
		$('#login_result').html('請聯絡管理猿'+result);
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



$(document).ready(function(){

$( '#target1' ).click(function() {
   var obj = window.parent;
   //obj.location.assign('http://114.34.193.48:10055/index.php');
   obj.location.assign('../../luft/cesium/_project2.php');
	
});
document.getElementById('login_send').addEventListener('click', function(){
    q();
});

});
</script>");
?>