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
<iframe id='UI_load_csv' style='overflow: visible;left:1px; width: 470px; height: 270px; display: block; position: absolute; visibility: visible; z-index: 1; top: -0.5em; right: -0.5em;' scrolling="no" src="search.php"  frameBorder="0">
	<p>Your browser does not support iframes.</p>
</iframe>
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
var sys={
	cmFunc:{},
	mmFunc:{},
	mmFunc2:{},
	mhFunc:{},
	entity:'',
	mProp:{lon:0,lat:0,height:0,heading:0,pitch:0,roll:0}
};
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
 sys.mmFunc = function rotationModel(mode,val){
	 //mode/1,2,3,4,5=(lon,lat),height,heading,pitch,roll
	console.log('導入數值');
	var lon = sys.mProp.lon// the updated lon
	var lat = sys.mProp.lat// updated lat
	var height = sys.mProp.height// updated lat
	var heading = sys.mProp.heading;
	var pitch = sys.mProp.pitch;
	var roll = sys.mProp.roll;
	switch(mode){
		/*case 1:
		sys.mProp.lon += val;
		break;
		case 2:
		sys.mProp.lat += val;
		break;
		case 3:
		sys.mProp.height += val;
		break;*/
		case 4:
		sys.mProp.heading += val;
		break;
		case 5:
		sys.mProp.pitch += val;
		break;
		case 6:
		sys.mProp.roll += val;
		break;
	 }
	console.log('產生座標');
	var position = Cesium.Cartesian3.fromDegrees(lon, lat, height);
	console.log('產生姿態');
	var hpr = new Cesium.HeadingPitchRoll(heading, pitch, roll);
	console.log('將姿態+座標導入產生偏移參數');
	var orientation = Cesium.Transforms.headingPitchRollQuaternion(position,hpr);
	console.log('導入偏移參數');
	sys.entity.orientation = orientation;
  }
 sys.mmFunc2 = function moveModel(mode,val){
	 //mode/1,2,3,4,5=(lon,lat),height,heading,pitch,roll
	console.log('導入數值');
	var pos = sys.entity.position.getValue();
	var carto  = Cesium.Ellipsoid.WGS84.cartesianToCartographic(pos);     
	var lon = Cesium.Math.toDegrees(carto.longitude); 
	var lat = Cesium.Math.toDegrees(carto.latitude); 
	var height = carto.height;
	//var lon = sys.mProp.lon// the updated lon
	//var lat = sys.mProp.lat// updated lat
	//var height = sys.mProp.height// updated lat
	//var heading = sys.mProp.heading;
	//var pitch = sys.mProp.pitch;
	//var roll = sys.mProp.roll;
	switch(mode){
		case 1:
		lon += val;
		sys.mProp.lon = lon
		break;
		case 2:
		lat += val;
		sys.mProp.lat = lat
		break;
		case 3:
		height += val;
		sys.mProp.height = height;
		break;
		/*case 4:
		sys.mProp.heading += val;
		break;
		case 5:
		sys.mProp.pitch += val;
		break;
		case 6:
		sys.mProp.roll += val;
		break;*/
	 }
	console.log('產生座標');
	var new_pos = Cesium.Cartesian3.fromDegrees(lon, lat, height);
	console.log('導入偏移參數');
	sys.entity.position = new_pos;
	
  }
sys.cmFunc = function createModel( url, lon, lat, height) {
    viewer.entities.removeAll();
//建議到小數點第5位
	//var lon = -123.0744619;
	//var lat = 44.0503706;
	sys.mProp.lon = lon;
	sys.mProp.lat = lat;
	sys.mProp.height = height;
	sys.mProp.heading = 0;
	sys.mProp.pitch = 0;
	sys.mProp.height = 0;
    var position = Cesium.Cartesian3.fromDegrees(lon, lat, height);
    var heading = Cesium.Math.toRadians(0);
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
            //minimumPixelSize : 128,
			asynchronous: true,
            //maximumScale : 20000
			scale:1.0,
			alpha : 1.0,
			silhouetteColor:new Cesium.Color(255, 0, 0, 0.2),
			color:new Cesium.Color(255, 0, 0, 0.1),
			colorBlendModes:'Replace'
        }
    });
    //viewer.trackedEntity = entity;
	sys.entity = entity;
	viewer.flyTo(entity);
	//console.log(sys.entity.position);
}
sys.mhFunc = function ModelHome(){
	viewer.flyTo(sys.entity);	
}
//self-defined
$(document).ready(function(){
	$('#loadingOverlay').hide();
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

function draw(data){
	console.log(data);
	//sys.cmFunc('../Apps/SampleData/models/CesiumAir/Cesium_Air.glb',121,23, 5000.0);
	sys.cmFunc(data.url,data.lon,data.lat,0);
	//console.log(sys);
}
function rotate(mode,value){
	if(sys.entity==''){
		console.log('請選擇目標');
		console.log('動作取消');
	}else{
		sys.mmFunc(mode,value);	//4,5,6
	}
}
function move(mode,value){
	if(sys.entity==''){
		console.log('請選擇目標');
		console.log('動作取消');
	}else{
		sys.mmFunc2(mode,value);	//1,2,3
	}
}
function home(){
	if(sys.entity==''){
		console.log('請選擇目標');
		console.log('動作取消');
	}else{
		sys.mhFunc();
	}
}
function getentity(){
console.log(computeModelMatrix(sys.entity, Cesium.JulianDate.now()));

}
function computeModelMatrix(entity, time) {
   //Cesium.Property（）获取随时间变化的属性值  
    //position位置  
    var position = Cesium.Property.getValueOrUndefined(entity.position, time, new Cesium.Cartesian3());  
	
    if (!Cesium.defined(position)) {  
        return undefined;  
    }  
    //orientation方向  
    var orientation = Cesium.Property.getValueOrUndefined(entity.orientation, time, new Cesium.Quaternion());  
    if (!Cesium.defined(orientation)) {  
        var modelMatrix = Cesium.Transforms.eastNorthUpToFixedFrame(position, undefined, new Cesium.Matrix4());  
    } else {  
        //Cesium.Matrix3.fromQuaternion(orientation, new Cesium.Matrix3())由方向生成三阶矩阵  
        //由旋转和转换生成四阶矩阵  
        modelMatrix = Cesium.Matrix4.fromRotationTranslation(Cesium.Matrix3.fromQuaternion(orientation, new Cesium.Matrix3()), position, new Cesium.Matrix4());  
    }  
    return modelMatrix;  
}
</script>
</body>
</html>
