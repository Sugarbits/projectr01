<!DOCTYPE html>
<html>
<head>
<!-- Load icon library -->
<meta charset='UTF-8'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="../../plugin/jquery-3.3.1.min.js"></script>
<style>
/* Style the submit button */
.btn1 {
   background: transparent;
   border: 1px solid grey;  
   border-left: none; /* Prevent double borders */
   color: white;
   cursor: pointer;
   
}
 .btn1:hover {
	border: 1px solid white;
	border-left: none; /* Prevent double borders */
	
}
 .btn1:active {
	border: 1px solid white;
	border-left: none; /* Prevent double borders */
  background-color: rgba(100,100,100,0.2);
}
 .btn1:focus {
   outline: none;
}

</style>
<style>
body{
	background-color:transparent;
}
.side_btn1{
	position:absolute;
	top:20px;
	left:450px;
	width:20px;
}
.side_btn2{
	position:absolute;
	top:20px;
	left:400px;
	width:20px;
}
.panel1_btn{
   -moz-border-radius: 5px;
   -webkit-border-radius: 5px;
   border-radius: 5px;
   font-size: 17px;
   margin:2px;
   padding: 1px;
   width: 30px;
}
.panel1{
   -webkit-border-radius: 10px;
   -moz-border-radius: 10px;
   background: linear-gradient(to bottom right, rgba(0,0,0,0.3) 30%, rgba(51,102,204,0.3) 100%);
   border-radius: 10px;
   border-style:solid;
   border-width:0.5px;   
   color:white;
   float:left;
   height: 150px;
   width: 250px;
}

.panel2{
	position: relative;
   -webkit-border-radius: 10px;
   -moz-border-radius: 10px;
   border-radius: 10px;
   background: linear-gradient(to bottom right, rgba(0,0,0,0.3) 30%, rgba(51,102,204,0.3) 100%);
   border-width:0.5px;  
   border-style:solid;
   color:white;
   float:right;
   margin-right:50px;
   height: 250px;
   width: 420px;
}
.panel1_btn_container{
	margin-left:1.5em;
	margin-top:0.5em;
}
.container{
  margin:1.5em;
}

select{
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
  font-size:17px;
  color:white;
  margin-left:-10px;
  padding: 2px;
  border-left: none; /* Prevent double borders */
  //-webkit-appearance:none;
  background-color:transparent;
}
select:focus{
   outline: none;
}
select option {
    margin: 40px;
    background: rgba(0, 0, 0, 1);
    color: #fff;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
	 border-width:0.5px;  
}

/* Style the search field */
input[type=text] {
  -webkit-border-radius: 10px;
   -moz-border-radius: 10px;
   border-radius: 10px;
   width:130px;
  font-size:17px;
  color:white;
  padding-left: 20px;
  padding-top: 2px;
  padding-bottom: 2px;
  border: 1px solid grey;
  border-left: none; /* Prevent double borders */
  background-color:transparent;
}
input:focus{
    outline: none;
	border: 1px solid white;
}
.video-wrapper{
	position:absolute;
	top:0px;
	left:0px;
	width:95%;
	height:95%;
	padding-top:5px;
	padding-left:5px;
}
</style>
<style>
.target-type{
	display:none;
}

#myUL {
	box-sizing: border-box;
	list-style-type: none;
	margin-bottom: 20px;
	padding: 0;
}

#myUL li a {
  border: 1px solid #ddd;
  background-color:transparent;
  clear:both;
  color: white;
  display: block;
  margin-top: -1px; /* Prevent double borders */
  padding: 2px;
  position:inherit;
  text-decoration: none;
  
}

#myUL li span {
  padding-left: 5px; /* Prevent double borders */
  background-color:transparent;
  padding: 10px;
  text-decoration: none;
  font-size: 14px;
  text-align: right;

}
#myUL li a:hover:not(.header) {
  background-color:  rgba(100,100,100,0.2);
  color: grey;
}

#myUL li a:active:not(.header) {
  background-color:  rgba(100,100,255,0.2);
  color: red;
}
</style>
<style>
.panel1_list_container {
    background: transparent;
	max-height: 110px;
}
.scrollbar-y{
	overflow-y: auto;
}
.scrollbar8::-webkit-scrollbar {
    width: 5px;
    background-color: #000;
}
.scrollbar8::-webkit-scrollbar-thumb {
    background-color: #ddd;
}
.scrollbar8::-webkit-scrollbar-track {
    border: 1px solid black;
    background-color: #000;
}
</style>
<style>

@keyframes blink {  
  0% { color: red;}
  100% { color: black;}
}
@-webkit-keyframes blink {
  0% { color: red;}
  100% { color: black;}
}
.blink {
  -webkit-animation: blink 0.3s linear 2;
  -moz-animation: blink 0.3s linear 2;
  animation: blink 0.3s linear 2;
} 

</style>
<style>
iframe{
    width:100%;
    height:100%;
}
</style>
</head>

<body>
   <div class="panel1">
      <div class="panel1_btn_container">
         <button id='camera_btn' class='panel1_btn btn1' type="button"><i class="fa fa-camera"></i></button>
         <button id='block_btn' class='panel1_btn btn1' type="button"><i class="fa fa-eye"></i></button>
         <!--<button id='test_btn' class='panel1_btn btn1' type="button"><i class="fa fa-upload"></i></button>-->
		 <button id='clear_btn' class='panel1_btn btn1' type="button"><i class="fa fa-refresh"></i></button>
		 <button id='play_btn' class='panel1_btn btn1' type="button"><i class="fa fa-play"></i></button>
		 <!--fa-files-o copy-->
		 <!--fa-folder folder-->
	  </div>
	  <div class="panel1_list_container scrollbar-y scrollbar8">
	     <div id='list' class='list'>
		    <ul id="myUL">
			   <li data-id='1'><a href="#"><span class='target-type'>1</span><span class='target-name'>位置參數</span><span>&#176;N</span><span>&#176;E</span></a></li>
			   <li data-id='0'><input id='put' type='text' size='100'></li>
			</ul>
         </div>
      </div>
    </div>
  </body>

</html>
<script>
if (!window.jQuery) { throw new Error("LikeButtonModule requires jQuery") }
</script>
<script>
var sys={
 sec:0,
 times:1,
 old_ajax_time_val:0
};

/*
var pause_btn = document.getElementById("pause_btn");
pause_btn.addEventListener("click", function(){
	//todo 暫停socket
}
*/

var clear_btn = document.getElementById("clear_btn");
clear_btn.addEventListener("click", function(){
 var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  window.parent.location.reload();
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});

function now_time(){
	var d = new Date();
	var h = checkTime(d.getHours());
	var m = checkTime(d.getMinutes());
	var s = checkTime(d.getSeconds());
	return ""+ h + ":" + m + ":" + s + "";
}	
function checkTime(i) {
	if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	return i;
}
function ajax_text_read(file){
	var scriptUrl = "simulate/csv.php";
	var jqxhr = $.ajax({
		url: scriptUrl,
		type: 'get',
		data:{file:file},
		dataType: 'html',
		async: false,
		/*xhr: function () {
        var xhr = new window.XMLHttpRequest();
        //Download progress
        xhr.addEventListener("progress", function (evt) {
			console.log(evt.lengthComputable); // false
            if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                //progressElem.html(Math.round(percentComplete * 100) + "%");
				console.log(percentComplete);
				}
			}, false);
			return xhr;
		}*/        
	});
		return jqxhr;
}

</script>
<script>
$(document).on( "click","#test_btn", function() {
/* $.get("stream/LoopPlayer.php?video_url=S3uU8VDlhyU",function(data){  
        $("#player").html(data);//初始化加载界面  
    });  
*/

	
});
function playvedio(){
	document.getElementById('web_1').contentWindow.play();
}
$(document).on( "click","#block_btn", function() {
  //event.preventDefault();
  //console.log( $( this ).parent().attr('data-id') );
  //var id = $( this ).parent().attr('data-id') ;
  //var data = gain(id);
  var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  var data = $('#put').val();
	  window.parent.load_sence(data);
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});
$(document).on( "click","#camera_btn", function() {
  //event.preventDefault();
  //console.log( $( this ).parent().attr('data-id') );
  //var id = $( this ).parent().attr('data-id') ;
  //var data = gain(id);
  var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  $('#put').val(window.parent.save_sence());
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});
$(document).on( "click","#play_btn", function() {
  var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  window.parent.camera_autoplay();
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});

</script>
