<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="description" content="Create 3D models using glTF.">
    <meta name="cesium-sandcastle-labels" content="Tutorials,Showcases">
    <title>Cesium Demo</title>
	<script src="../ThirdParty/jquery.min.js"></script>
	<!--jquery-->
	<!--for cesium -->
<script src="../Build/Cesium/Cesium.js"></script>
    <script type="text/javascript" src="../Apps/Sandcastle/Sandcastle-header.js"></script>
    <script type="text/javascript" src="../ThirdParty/requirejs-2.1.20/require.js"></script>

    <script type="text/javascript">
        if(typeof require === "function") {
            require.config({
                baseUrl : '../Source',
                waitSeconds : 120
            });
        }
    </script>
</head>
<body class="sandcastle-loading" data-sandcastle-bucket="bucket-requirejs.html">
<style>
    @import url(../Build/Cesium/Widgets/widgets.css);
</style>
<div id="cesiumContainer" class="fullSize"></div>
<div id="loadingOverlay"><h1>Loading...</h1></div>
<div id="toolbar"></div>

<style>
#toolbar{
	position:absolute;
	top:0px;
}
body{
	padding:0px;
	margin:0px;
}
canvas {
    width: 100vw !important;
    height: 100vh !important;
    touch-action: none;
}
</style>
<script id="cesium_sandcastle_script">
function startup(Cesium) {
    'use strict';
//Sandcastle_Begin
//include php file 後台 .txt

var viewer = new Cesium.Viewer('cesiumContainer', {
    infoBox : false,
    selectionIndicator : false,
    shadows : true,
    shouldAnimate : true
});
  
function createModel(url, height) {
    viewer.entities.removeAll();

    var position = Cesium.Cartesian3.fromDegrees(-123.0744619, 44.0503706, height);
    var heading = Cesium.Math.toRadians(135);
    var pitch = 0;
    var roll = 0;
    var hpr = new Cesium.HeadingPitchRoll(heading, pitch, roll);
    var orientation = Cesium.Transforms.headingPitchRollQuaternion(position, hpr);

    var entity = viewer.entities.add({
        name : url,
        position : position,
        orientation : orientation,
        model : {
            uri : url,
            minimumPixelSize : 128,
            maximumScale : 20000
        }
    });
    viewer.trackedEntity = entity;
}

//self-defined
$(document).ready(function(){
	$('#loadingOverlay').hide();
	var url = "entrance/output/link.php";
	var jqxhr = $.getJSON(url , function( data,jqXHR) {
			
		});
	jqxhr.done(function(json) {
		//內部網頁傳送，一般而言都會正常；須透過crul返回結果判斷
		//需要再做一次判斷
		console.log("jqXHR.done()：");
		//console.log(json);
		console.log(json);
		var dataJSON = json;
		var createModeltext=[];
		var createModelurlarr=[];
		var createModelurlswitch=[];
		//var API = "include/Data.php?mode=1&t=0&now="+now(new Date())+"";
		var cnt = 0;
		for(var key in dataJSON){
			//console.log(data["0"][key]); 
			if(cnt % 3 == 0){
				createModeltext.push(dataJSON[key]);//name
			}else if(cnt % 3 == 1){
				//var createModel = "'"+(dataJSON[key]).slice(0)+"'";
				createModelurlarr.push( dataJSON[key]);//GLTF url
			}else if(cnt % 3 == 2){
				createModelurlswitch.push(dataJSON[key]);//open
			}
			console.log(dataJSON[key]); 
			
			//data["0"][key]["d"]; 
			//data["0"][key]["v"]; 
			//var height = mk_piece(dataJSON[key]["lng"],dataJSON[key]["lat"],dataJSON[key]["SiteName"],dataJSON[key]["AQI"],dataJSON[key]["PM25"],dataJSON[key]["PM10"],dataJSON[key]["SO2"],dataJSON[key]["O3"],dataJSON[key]["Time"]);
			//label_fadeByDistance(dataJSON[key]["lng"],dataJSON[key]["lat"],dataJSON[key]["SiteName"],height);
			cnt++;
		}
		//produce the select
		var options = [];
		//var createModeltext=['Aircraft','Ground vehicle','Hot Air Balloon','Milk truck','Skinned character'];
		//var createModelurlarr=['../Apps/SampleData/models/CesiumAir/Cesium_Air.glb','../Apps/SampleData/models/CesiumGround/Cesium_Ground.glb','../Apps/SampleData/models/CesiumBalloon/CesiumBalloon.glb','../Apps/SampleData/models/CesiumMilkTruck/CesiumMilkTruck-kmc.glb','../Apps/SampleData/models/CesiumMan/Cesium_Man.glb'];
		for(var key in createModeltext){
				var obj = {
				text : createModeltext[key],
				onselect : function() {
				createModel(createModelurlarr[key],0)
				}};
			options.push(obj);
		}
		
		var options2 = [{
				text : createModeltext[0],
				onselect : function() {
				createModel(createModelurlarr[0], 5000.0);
			}
			}, {
				text : createModeltext[1],
				onselect : function() {
				createModel(createModelurlarr[1], 0);
			}
			}, {
				text : createModeltext[2],
				onselect : function() {
				createModel(createModelurlarr[2], 1000.0);
			}
			}, {
				text : createModeltext[3],
				onselect : function() {
				createModel(createModelurlarr[3], 0);
			}
			}, {
				text : createModeltext[4],
				onselect : function() {
				createModel(createModelurlarr[4], 0);
			}
		}];
		
		console.log(options);
		console.log(options2);
		Sandcastle.addToolbarMenu(options2);
		//produce the select END
			//$('#time_display').html(dataJSON[1]["Time"]);//!!可能出錯，建議用理想值
		}).fail(function(jqXHR){
			//when it happens ,means the inner web goes wrong or error parmeter be delivered
			console.log("jqXHR.fail()：");
			console.log(jqXHR.fail()['responseText']);
		});

});
//self-defined end


//Sandcastle_End
    Sandcastle.finishedLoading();
}
if (typeof Cesium !== "undefined") {
    startup(Cesium);
} else if (typeof require === "function") {
    require(["Cesium"], startup);
}
</script>
</body>
</html>
