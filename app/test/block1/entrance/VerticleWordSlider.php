<?php
//?w1=123&w2=456&w3=qwe
if(isset($_GET['test'])){
	//die('lack parameter [test]');
	$_GET['w1'] = 'resolved';
	$_GET['w2'] = 'remarkable';
	$_GET['w3'] = 'reborn';
	;
}else{
	if((!isset($_GET['w1']))||(!isset($_GET['w2']))||(!isset($_GET['w3']))){
		die('lack pararmeter of w1.2.3');
	}
	
}
 ?>
<!DOCTYPE html>
<html>
<head>
<style>
@import url('https://fonts.googleapis.com/css?family=Roboto:700');

body {
  margin:0px;
  font-family:'Roboto';
  text-align:center;
}

#container {
  //color:#999;
 // -webkit-text-stroke: 1px white;
  color:#17B0B8;
  text-transform: uppercase;
  font-size:36px;
  font-weight:bold;
  padding-top:200px;  
  position:fixed;
  width:100%;
  bottom:45%;
  display:block;
}

#flip {
  height:50px;
  overflow:hidden;
}

#flip > div > div {
  color:#fff;
  padding:4px 12px;
  height:45px;
  margin-bottom:45px;
  display:inline-block;
}

#flip div:first-child {
  animation: show 5s linear infinite;
}

#flip div div {
  background:#42c58a;
}
#flip div:first-child div {
  background:#4ec7f3;
}
#flip div:last-child div {
  background:#DC143C;
}

@keyframes show {
  0% {margin-top:-270px;}
  5% {margin-top:-180px;}
  33% {margin-top:-180px;}
  38% {margin-top:-90px;}
  66% {margin-top:-90px;}
  71% {margin-top:0px;}
  99.99% {margin-top:0px;}
  100% {margin-top:-270px;}
}

p {
  position:fixed;
  width:100%;
  bottom:30px;
  font-size:12px;
  color:#999;
  margin-top:200px;
}
</head>
</style>
<div id=container>
  Make 
  <div id=flip>
    <div><div><?php echo $_GET['w1']; ?></div></div>
    <div><div><?php echo $_GET['w2']; ?></div></div>
    <div><div><?php echo $_GET['w3']; ?></div></div>
  </div>
  AweSoMe!
</div>
</html>