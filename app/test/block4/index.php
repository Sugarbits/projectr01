<?php
if(isset($_GET['test'])){
	$testmode = true;
}else{
	//die('set id');
	$testmode = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="description" content="Create 3D models using glTF.">
    <meta name="cesium-sandcastle-labels" content="Tutorials,Showcases">
    <title>Cesium Demo</title>
	<!--jquery-->
	<script src="../../plugin/jquery-3.3.1.min.js"></script>
	<!--for cesium -->
	<script src="../../../core/stable-plugin/Cesium-1.46/Build/Cesium/Cesium.js"></script>
    <script type="text/javascript" src="../../../core/stable-plugin/Cesium-1.46/Apps/Sandcastle/Sandcastle-header.js"></script>
    <script type="text/javascript" src="../../../core/stable-plugin/Cesium-1.46/ThirdParty/requirejs-2.1.20/require.js"></script>
	<!--for cesium  end -->
	<script type="text/javascript" src="handler_dealer.js"></script>
	<script type="text/javascript" src="trace_dealer.js"></script>
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
    @import url(../../../core/stable-plugin/Cesium-1.46/Build/Cesium/Widgets/widgets.css);
</style>
<iframe style='overflow: visible;left:1px; width: 470px; height: 270px; display: block; position: absolute; visibility: visible; z-index: 1; top: -0.5em; right: -0.5em;' scrolling="no" src="panel.php"  frameBorder="0">
	<p>Your browser does not support iframes.</p>
</iframe>
<div id="cesiumContainer" class="fullSize"></div>
<!--<div id="loadingOverlay"><h1>Loading...</h1></div>-->
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
var sys={
	marker_arr:[],
	property:{_1:null},
	control:{_1:false},
	func:{_1:null},
	position:{log:null,lat:null},
	clock:null,
	test:null
};
function startup(Cesium) {
//'use strict';
//ref:https://stackoverflow.com/questions/28291013/get-ground-altitude-cesiumjs
// Construct the default list of terrain sources.
var terrainModels = Cesium.createDefaultTerrainProviderViewModels();


  var viewer = new Cesium.Viewer('cesiumContainer',{
     imageryProvider : new Cesium.ArcGisMapServerImageryProvider({
        url : 'https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer'
		//url : Cesium.buildModuleUrl('Assets/Textures/NaturalEarthII')
     }),
	 selectedTerrainProviderViewModel: terrainModels[1],  // Select STK High-res terrain
	 terrainProviderViewModels: terrainModels,
	 timeline:false,//是否顯示時間軸
	 animation:false,//是否啟動動畫工具，左下角儀錶
	 baseLayerPicker:true,//是否顯示圖層控制選擇器
	 fullscreenButton:true,//是否顯示全屏按鈕
	 geocoder:false,//是否顯示geocoder工具，右上角地名查詢按鈕
     homeButton:false,//是否顯示Home按鈕
     infoBox:false,//是否顯示資訊框
     sceneModePicker:false,//是否顯示3D/2D選擇器
     selectionIndicator:false,//是否顯示選取指示器元件
     navigationHelpButton:false,//是否顯示右上角的説明按鈕
     scene3DOnly:true,//投影方式，如果設置為true，則所有幾何圖形以3D模式繪製節約GPU資源
     vrButton: true,
	 shadows : true,
     shouldAnimate : true
     });
     viewer._cesiumWidget._creditContainer.style.display="none";//
	 var scene = viewer.scene;
<?php 
;
?>
//	
//self-defined
$(document).ready(function(){
	//$('#loadingOverlay').hide();
	//load();
	//var HandlerDealer = HandlerDealer;
	//console.log(HandlerDealer);
	var trace_modelurl = '../../../core/stable-plugin/Cesium-1.46/Apps/SampleData/models/CesiumBalloon/CesiumBalloon.glb';
	TraceDealer.initialize(Cesium,viewer,scene);
	HandlerDealer.initialize(Cesium,viewer,scene);
	HandlerDealer.handlerAdd();
	TraceDealer.handlerAdd(trace_modelurl);
	
});

   function add_marker(lon,lat){
	   console.log(Cesium.HeightReference);
	   var pinBuilder = new Cesium.PinBuilder();
	   var marker = viewer.entities.add({
           name : 'mark',
           position : Cesium.Cartesian3.fromDegrees(lon, lat),
           data1 : 10,
           billboard : {
           image : pinBuilder.fromText((sys.marker_arr.length)+1, Cesium.Color.BLACK, 48).toDataURL(),
           verticalOrigin : Cesium.VerticalOrigin.BOTTOM,//TOP,CENTER,BASELINE,BOTTOM
		   heightReference: Cesium.HeightReference.CLAMP_TO_GROUND
          }
	   });
	   sys.test = marker;
	   sys.marker_arr.push(marker.id);
   }
  /* function load2(){
   var property = new Cesium.SampledPositionProperty();
   sys.property._2 = property;
   }*/
   function load(){
   
	function get_height(lon,lat){//輸入經緯度，得到高度
	   //console.log(lon+''+lat);
	   var pointOfInterest = Cesium.Cartographic.fromDegrees(lon,lat, 0, new Cesium.Cartographic());
	   var promise = Cesium.sampleTerrain(viewer.terrainProvider, 9, [ pointOfInterest ]).then(function(samples) {
	      //console.log('Height in meters is: ' + samples[0].height);
		  
	   });
	   function add_label(he){
		 
	      var entity = viewer.entities.add({
             label : {
                show : false,
                showBackground : true,
                font : '14px monospace',
                horizontalOrigin : Cesium.HorizontalOrigin.LEFT,
                verticalOrigin : Cesium.VerticalOrigin.BOTTOM,//TOP,CENTER,BASELINE,BOTTOM
                //pixelOffset : new Cesium.Cartesian2(15, 0),
				heightReference: Cesium.HeightReference.CLAMP_TO_GROUND
             }
          });
	   }
	   
	}
	/*
    handler.setInputAction(function(movement) {
        var cartesian = viewer.camera.pickEllipsoid(movement.endPosition, scene.globe.ellipsoid);
        if (cartesian) {
            var cartographic = Cesium.Cartographic.fromCartesian(cartesian);
            var longitude_val = Cesium.Math.toDegrees(cartographic.longitude).toFixed(7);
            var longitudeString = Cesium.Math.toDegrees(cartographic.longitude).toFixed(2);
            var latitude_val = Cesium.Math.toDegrees(cartographic.latitude).toFixed(7);
            var latitudeString = Cesium.Math.toDegrees(cartographic.latitude).toFixed(2);
			sys.position.lon = longitude_val;
			sys.position.lat = latitude_val;
            entity.position = cartesian;
            entity.label.show = true;
            entity.label.text =
                'Lon: ' + ('   ' + longitudeString).slice(-7) + '\u00B0' +
                '\nLat: ' + ('   ' + latitudeString).slice(-7) + '\u00B0';
        } else {
            entity.label.show = false;
        }
    }, Cesium.ScreenSpaceEventType.MOUSE_MOVE);
	*/
}


	sys.func._1 = function (){
		sys.test = TraceDealer.marker_play();
	}

Sandcastle.reset = function() {
    viewer.entities.removeAll();
};
    Sandcastle.finishedLoading();
}

if (typeof Cesium !== "undefined") {
    startup(Cesium);
} else if (typeof require === "function") {
    require(["Cesium"], startup);
}

function fly(){
	sys.control._1 = true;
	sys.func._1();
}
function load(datajson){
	TraceDealer.load_file(datajson);
	//sys.func._1();
}
function see(){
	TraceDealer.show_trace_data();
	//sys.func._1();
}
</script>
</body>
</html>
