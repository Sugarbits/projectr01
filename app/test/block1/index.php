<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="description" content="Create 3D models using glTF.">
    <meta name="cesium-sandcastle-labels" content="Tutorials,Showcases">
    <title>Cesium Demo</title>
	<script src="../../plugin/jquery-3.3.1.min.js"></script>
	<!--jquery-->
	<!--for cesium -->
<script src="../../../core/stable-plugin/Cesium-1.46/Build/Cesium/Cesium.js"></script>
    <script type="text/javascript" src="../../../core/stable-plugin/Cesium-1.46/Apps/Sandcastle/Sandcastle-header.js"></script>
    <script type="text/javascript" src="../../../core/stable-plugin/Cesium-1.46/ThirdParty/requirejs-2.1.20/require.js"></script>

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
	cmFunc:{}
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
  
sys.cmFunc = function createModel( url, lon, lat, height) {
    viewer.entities.removeAll();
//建議到小數點第5位
	//var lon = -123.0744619;
	//var lat = 44.0503706;
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
			alpha : 1.0,
			//silhouetteColor:new Cesium.Color(255, 0, 0, 0.2),
			//color:new Cesium.Color(255, 0, 0, 0.1),
			//colorBlendModes:'Replace'
        }
    });
    //viewer.trackedEntity = entity;
	viewer.flyTo(entity);
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
</script>
</body>
</html>
