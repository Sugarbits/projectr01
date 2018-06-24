<!DOCTYPE html>
<html>
<head>
<!-- Load icon library -->
<meta charset='UTF-8'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="entrance/plugin/jquery.min.js"></script>
<style>
body{
	background-color:transparent;
}
div.n1 {
  -webkit-border-radius: 10px;
   -moz-border-radius: 10px;
   border-radius: 10px;
  height: 250px;
  width: 450px;
  //background: linear-gradient(to bottom right, #000066 30%, #3366cc 100%);
  background: linear-gradient(to bottom right, rgba(0,0,0,0.3) 30%, rgba(51,102,204,0.3) 100%);
 // border-style: groove;
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
  padding-left:20px;
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

#myUL li div{
  clear:both;
  position:inherit;
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
   background-color:transparent;
  padding: 12px;
  text-decoration: none;
  color: white;
  //display: block;
}

#myUL li div div{
	  position:relative;
	float:left;
  padding-left: 5px; /* Prevent double borders */
  // background-color:transparent;
  padding: 12px;
  text-decoration: none;
  font-size: 16px;
  text-align: right;

}
.target-lat{
	width:30%;
	background-color:red;
}
.target-lon{
	width:30%;
	background-color:blue;
}
.target-name{
	width:20%;
	background-color:green;
}

#myUL li div:hover:not(.header) {
  background-color:  rgba(100,100,100,0.2);
  color: grey;
}

#myUL li div:active:not(.header) {
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
      <div class="container">
        <select id='myselect'>
        <option value='0'>類別</option>
        <option value='1'>Airport</option>
        <option  value='2'>RadarStation</option>
        </select>
      <input id='myInput' type='text' />
	  &nbsp;
       <button id='search_btn' type="button"><i class="fa fa-search"></i></button>
        </div>
		<div class="scrollbar" id="style-8">
	      <div class="force-overflow">
		  	<div id='list' class='list'>
				<!--<ul id="myUL">
					
					<li data-id='1'><a href="#"><span class='target-type'>1</span><span class='target-name'>龍田機場</span><span>23.256&#176;N</span><span>117.89&#176;E</span></a></li>
					<li data-id='2'><a href="#"><span class='target-type'>1</span><span class='target-name'>長樂國際機場</span><span>23.256&#176;N</span><span>117.89&#176;E</span></a></li>
					<li data-id='3'><a href="#"><span class='target-type'>1</span><span class='target-name'>松山國際機場</span><span>24.256&#176;N</span><span>116.159&#176;E</span></a></li>
					<li data-id='4'><a href="#"><span class='target-type'>2</span><span class='target-name'>樂山雷達站</span><span>24.256&#176;N</span><span>116.159&#176;E</span></a></li>
					<li data-id='5'><a href="#"><span class='target-type'>2</span><span class='target-name'>花蓮氣象雷達站</span><span>24.256&#176;N</span><span>116.159&#176;E</span></a></li>
					
				</ul>-->
			</div>
		  </div>
	    </div>
    </div>
  </body>

</html>
<script>
var url = "entrance/output/link.php";
var sys = {cmData:[]};

	var jqxhr = $.getJSON(url , function( data,jqXHR) {
			
		});
	jqxhr.done(function(json) {
		//內部網頁傳送，一般而言都會正常；須透過crul返回結果判斷
		//需要再做一次判斷
		console.log("jqXHR.done()：");
		//console.log(json);
		console.log(json);
		var data = json;
		var createModel2 = [];
		var createModel={
			name:[],
			url:[],
			lon:[],
			lat:[],
			type:[],
		}
		//var cMs=[];//for search.php creating list
		var createModelLonarr=[];
		var createModelLatarr=[];
		//
		var createModeltext=[];
		var createModelurlarr=[];
		var createModelurlswitch=[];
		//var API = "include/Data.php?mode=1&t=0&now="+now(new Date())+"";
		var cnt = 0;
		var element_col = 6;
		for(var key in data){
			if(cnt%element_col==0){//name
				if(cnt !== 0){
					(sys.cmData).push(cMs_object);
				}
				var cMs_object = {};
				createModel.name.push(data[key]);
				cMs_object.name = data[key];
			}else if(cnt%element_col==2){//lon
				createModel.lon.push(data[key]);
				cMs_object.lon = data[key];
							//$('#container').append("<input type='button' value='刪除' class='del' id='del_"+cnt+"' />");
			}else if(cnt%element_col==3){//lon
				createModel.lat.push(data[key]);
				cMs_object.lat = data[key];
			}else if(cnt%element_col==4){//type
				createModel.type.push(data[key]);
				cMs_object.type = data[key];
				
			}else if(cnt%element_col==5){//enable
				
			}
			else if(cnt%element_col==1){//url
				createModel.url.push(data[key]);
				cMs_object.url = data[key];
				
			}else{
				alert('err');
			}
			cnt++;
		}
	//console.log(createModel);
	//console.log(sys.cmData);
	
	//REF:https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_filter_list
var ul =  $("<ul>").attr('id','myUL').appendTo("#list");
	/*
	var li_data = [
		{id : 0, text: '龍田機場',lon:123,lat:23,type: 1},
		{id : 1, text: '長樂國際機場',lon:123,lat:23,type: 1},
		{id : 2, text: '樂山雷達站',lon:123,lat:23,type: 2}
		];
	*/
	var li_data = sys.cmData;
	console.log('li_data');
	console.log(li_data);
	console.log(123);
	 $(li_data).each(function(idx/*, elem*/) {
		console.log(idx);
		var li = $("<li>").attr('data-id',idx).appendTo(ul);
		li.append("<div><div class='inner target-type'>"+this.type+"</div><div class='inner target-name'>"+this.name+"</div><div class='inner target-lon'>"+this.lon+"&#176;N</div><div class='inner target-lat'>"+this.lat+"&#176;E</div></div>");
	});
	initail_clear();
		}).fail(function(jqXHR){
			//when it happens ,means the inner web goes wrong or error parmeter be delivered
			console.log("jqXHR.fail()：");
			console.log(jqXHR.fail()['responseText']);
		});

var search_btn = document.getElementById("search_btn");
search_btn.addEventListener("click", function(){
	search();
});

function initail_clear() {
	ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
		var display_style='none';
		li[i].style.display = display_style;  
    }
}
function search() {
    var input, filter, filter2, ul, li, a, i;
	//filter is for target-type
	//filter2 is for target-name
	
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
	var e = document.getElementById("myselect");
	var filter2 = e.options[e.selectedIndex].value;
	if(filter == '' && filter2 == '0')return false;
	//filter2 =<selected option value>
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("div")[0];
		div = a.getElementsByTagName("div");
		var search_content;
		var search_type;
		var display_style='none';
		for (j = 0; j < div.length; j++) {
			if(div[j].className == "target-type"){
				//console.log("類型:"+div[j].innerHTML);
				search_type = div[j].innerHTML;
				//console.log(filter2 +";"+ search_type);
			}else if(div[j].className == "target-name"){
				//console.log("名稱:"+div[j].innerHTML);
				search_content = div[j].innerHTML;
			}
		}
		
		if(filter2 == 0 || filter2 == search_type){
			if (search_content.toUpperCase().indexOf(filter) > -1) {
				display_style = '';//hide->show
			} 
		}
		li[i].style.display = display_style;  
    }
}
function gain(id){
	return sys.cmData[id];
}
</script>
<script>
$(document).on( "click","#myUL div", function() {
  event.preventDefault();
  //console.log( $( this ).parent().attr('data-id') );
  var id = $( this ).parent().attr('data-id') ;
  var data = gain(id);
  var isInIframe = (window.location != window.parent.location) ? true : false;
  if(isInIframe){
	  window.parent.draw(data);
  }else{
	  console.log('需要配合主程序執行');
	  console.log('動作取消');
  }
});

</script>
