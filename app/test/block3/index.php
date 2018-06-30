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
	#viewChanged, #cameraChanged {
        display: none;
        background-color: red;
        color: white;
    }
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
var sys={
	Func:{_1:null}
};
function startup(Cesium) {
    'use strict';
//Sandcastle_Begin
//include php file 後台 .txt

//ref:https://stackoverflow.com/questions/28291013/get-ground-altitude-cesiumjs
// Construct the default list of terrain sources.
var terrainModels = Cesium.createDefaultTerrainProviderViewModels();

// Construct the viewer, with a high-res terrain source pre-selected.
var viewer = new Cesium.Viewer('cesiumContainer', {
	infoBox : false,
	selectionIndicator : false,
    vrButton: true,
	shadows : true,
    shouldAnimate : true,
	terrainProviderViewModels: terrainModels,
    selectedTerrainProviderViewModel: terrainModels[1]  // Select STK High-res terrain
});

// Get a reference to the ellipsoid, with terrain on it.  (This API may change soon)
var ellipsoid = viewer.scene.globe.ellipsoid;

function terrain_height(lat,lon){
	var pointOfInterest = Cesium.Cartographic.fromDegrees(lon, lat, 0, new Cesium.Cartographic());
	// [OPTIONAL] Fly the camera there, to see if we got the right point.
	//viewer.camera.flyTo({    destination: ellipsoid.cartographicToCartesian(pointOfInterest,new Cesium.Cartesian3())});
	
	// Sample the terrain (async) and write the answer to the console.
	var promise = Cesium.sampleTerrain(viewer.terrainProvider, 9, [ pointOfInterest ]).then(function(samples) {
		//console.log('Height in meters is: ' + samples[0].height);
		return samples[0].height;//in meter
	});
	return promise;
}

viewer.scene.globe.enableLighting = true;
viewer.scene.globe.depthTestAgainstTerrain = true;

var removeStart;
var removeEnd;
var camera = viewer.camera;
    removeStart = camera.moveStart.addEventListener(function() {
        console.log(viewer.camera.positionWC.clone());
        console.log(viewer.camera.up.clone());
        console.log(viewer.camera.direction.clone());
        //viewChanged.style.display = 'block';
    });
    removeEnd = camera.moveEnd.addEventListener(function() {
        //viewChanged.style.display = 'none';
    });

// configure settings
var targetResolutionScale = 1.0; // for screenshots with higher resolution set to 2.0 or even 3.0
var timeout = 1000; // in ms
  
var scene = viewer.scene;
if (!scene) {
    console.error("No scene");
}


//scene.preRender.addEventListener(prepareScreenshot);
//
sys.Func._1 = function(){
	console.log('_1 inner [func]');
   //scene.preRender.addEventListener(prepareScreenshot);
   prepareScreenshot();
   
}
// define callback functions
var prepareScreenshot = function(){
	console.log('prepareScreenshot');
    var canvas = scene.canvas;    
    viewer.resolutionScale = targetResolutionScale;
    scene.preRender.removeEventListener(prepareScreenshot);
    // take snapshot after defined timeout to allow scene update (ie. loading data)
    setTimeout(function(){
        scene.postRender.addEventListener(takeScreenshot);
    }, timeout);
}

var takeScreenshot = function(){
	console.log('takeScreenshot');
    scene.postRender.removeEventListener(takeScreenshot);
    var canvas = scene.canvas;
    canvas.toBlob(function(blob){
        var url = URL.createObjectURL(blob);
        downloadURI(url, "snapshot-" + targetResolutionScale.toString() + "x.png");
        // reset resolutionScale
        viewer.resolutionScale = 1.0;
    });
}



function downloadURI(uri, name) {
    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    // mimic click on "download button"
    document.body.appendChild(link);
    /*link.click();
    document.body.removeChild(link);
    delete link;*/
}


///camera 設定
// Set initial camera position and orientation to be when in the model's reference frame.
var camera = viewer.camera;
//camera.position = new Cesium.Cartesian3(0.25, 0.0, 0.0);
//camera.position = new Cesium.Cartesian3.fromDegrees(121.7653048, 25.1499496, 0);
viewer.camera.setView({
    destination : Cesium.Cartesian3.fromDegrees(121.7653048, 25.1499496, 0.0),
    orientation : {
             heading : Cesium.Math.toRadians(0.0),
            pitch : Cesium.Math.toRadians(4.0),
            roll : 0.0
    }
});


///camera 設定 end

/*
// disable the default event handlers
viewer.scene.screenSpaceCameraController.enableTranslate = false;
viewer.scene.screenSpaceCameraController.enableRotate = true;
viewer.scene.screenSpaceCameraController.enableTranslate = false;
viewer.scene.screenSpaceCameraController.enableZoom = false;
viewer.scene.screenSpaceCameraController.enableTilt = true;
viewer.scene.screenSpaceCameraController.enableLook = false;
*/

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
//parent's function call here
function tp(){
	sys.Func._1();
	console.log('_1');
}
</script>
</body>
</html>
