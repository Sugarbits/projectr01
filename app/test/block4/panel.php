<!DOCTYPE html>
<html>
<head>
<!-- Load icon library -->
<meta charset='UTF-8'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="../../plugin/jquery-3.3.1.min.js"></script>
<style>
body{
	background-color:transparent;
}
.side_btn1{
	position:absolute;
	top:20px;
	left:430px;
	width:20px;
}
.side_btn2{
	position:absolute;
	top:20px;
	left:400px;
	width:20px;
}
.main_btn{
	margin:10px;
}
div.n1 {
  -webkit-border-radius: 10px;
   -moz-border-radius: 10px;
   border-radius: 10px;
  height: 150px;
  width: 200px;
  background: linear-gradient(to bottom right, rgba(0,0,0,0.3) 30%, rgba(51,102,204,0.3) 100%);
  border-width:0.5px;  
 border-style:solid;
  color:white;
}

div.header {
 text-align:center
}
.container{
  margin:1.5em;
}
div.list{
	width:100%;
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

/* Style the submit button */
button {
   -webkit-border-radius: 10px;
   -moz-border-radius: 10px;
   border-radius: 10px;
  width: 70px;
  padding: 2px;
  //background: #2196F3;
  background: transparent;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none; /* Prevent double borders */
  cursor: pointer;
}

 button:hover {
	border: 1px solid white;
	border-left: none; /* Prevent double borders */
	
}
 button:active {
	border: 1px solid white;
	border-left: none; /* Prevent double borders */
  background-color: rgba(100,100,100,0.2);
}
 button:focus {
   outline: none;
}


</style>
<style>
.target-type{
	display:none;
}

#myUL {
	box-sizing: border-box;
	list-style-type: none;
	padding: 0;
	margin-bottom: 20px;
}

#myUL li a {
  clear:both;
  	  position:inherit;
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
   background-color:transparent;
  padding: 12px;
  text-decoration: none;
  color: white;
  display: block;
}

#myUL li span {
  padding-left: 5px; /* Prevent double borders */
  background-color:transparent;
  padding: 12px;
  text-decoration: none;
  font-size: 16px;
  text-align: right;

}
.target-lat{
}
.target-lon{
}
.target-name{
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
.scrollbar {
    margin-left: 0px;
    float: left;
    height: 100%;
    width: 100%;
    background: transparent;
    overflow-y: auto;
    //margin-bottom: 100px;
	max-height: 170px;
}
.force-overflow {
	//background-color:red;
    
}
#style-8::-webkit-scrollbar {
    width: 5px;
    background-color: #000;
}
#style-8::-webkit-scrollbar-thumb {
    background-color: #ddd;
}
#style-8::-webkit-scrollbar-track {
    border: 1px solid black;
    background-color: #000;
}
</style>
  </head>

  <body>
    <div class="n1">
      <div class="header">    
      </div>
 <!--     <div class="container">
        <select id='myselect'>
        <option value='0'>類別</option>
        <option value='1'>Airport</option>
        <option  value='2'>RadarStation</option>
        </select>
      <input id='myInput' type='text' />
	  &nbsp;
       <button id='search_btn' type="button"><i class="fa fa-search"></i></button>
        </div>
-->
  <button id='play_btn' class='main_btn' type="button"><i class="fa fa-plane"></i>&nbsp;&nbsp;飛行</button></br>
  <button id='clear_btn' class='main_btn' type="button"><i class="fa fa-refresh"></i>&nbsp;&nbsp;重置</button>
		<!--<div class="scrollbar" id="style-8">
	      <div class="force-overflow">
		  	<div id='list' class='list'>
			</div>
		  </div>-->
	    </div>
    </div>
  </body>

</html>
<script>


var search_btn = document.getElementById("play_btn");
search_btn.addEventListener("click", function(){
  var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  window.parent.fly();
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});
var refresh_btn = document.getElementById("clear_btn");
refresh_btn.addEventListener("click", function(){
 var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  window.parent.location.reload();
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});

function initail_clear() {

}
function search() {

}
/*
function gain(id){
	return sys.cmData[id];
}*/
</script>
