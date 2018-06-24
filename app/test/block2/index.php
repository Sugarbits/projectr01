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

<div id="cesiumContainer" class="fullSize"></div>
<div id="loadingOverlay"><h1>Loading...</h1></div>
<div id="toolbar"></div>
<!--<video id="trailer" style="display: none;" autoplay="" loop="" crossorigin="" controls="">
    <source src="../../../data/block2_test/video/SampleVideo_1280x720_2mb.mp4" type="video/mp4">
    Your browser does not support the <code>video</code> element.
</video>-->

<style>
#toolbar{
	//position:absolute;
	top:0px;
}
body{
	padding:0px;
	margin:0px;
	overflow: hidden;
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
	func:{_1:null},
	enable:[false],
	camera:null
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
	imageryProvider : new Cesium.ArcGisMapServerImageryProvider({
        url : 'https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer'
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
viewer._cesiumWidget._creditContainer.style.display="none";
var scene = viewer.scene;

// Get a reference to the ellipsoid, with terrain on it.  (This API may change soon)
var ellipsoid = viewer.scene.globe.ellipsoid;

var entity_label = viewer.entities.add({
    label : {
        show : false,
        showBackground : true,
        font : '14px monospace',
        horizontalOrigin : Cesium.HorizontalOrigin.LEFT,
        verticalOrigin : Cesium.VerticalOrigin.TOP,
        pixelOffset : new Cesium.Cartesian2(15, 0)
        }
    });
/*
var handler = new Cesium.ScreenSpaceEventHandler(scene.canvas);
 handler.setInputAction(function(movement) {
        var cartesian = viewer.camera.pickEllipsoid(movement.endPosition, scene.globe.ellipsoid);
        if (cartesian) {
            var cartographic = Cesium.Cartographic.fromCartesian(cartesian);
            var longitude_val = Cesium.Math.toDegrees(cartographic.longitude).toFixed(7);
            var longitudeString = Cesium.Math.toDegrees(cartographic.longitude).toFixed(3);
            var latitude_val = Cesium.Math.toDegrees(cartographic.latitude).toFixed(7);
            var latitudeString = Cesium.Math.toDegrees(cartographic.latitude).toFixed(3);
			//sys.position.lon = longitude_val;
			//sys.position.lat = latitude_val;
            entity_label.position = cartesian;
            entity_label.label.show = true;
            entity_label.label.text =
                'Lon: ' + ('   ' + longitudeString).slice(-7) + '\u00B0' +
                '\nLat: ' + ('   ' + latitudeString).slice(-7) + '\u00B0';
        } else {
            entity_label.label.show = false;
        }
    }, Cesium.ScreenSpaceEventType.MOUSE_MOVE);
*/
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
viewer.scene.fog.enabled = false;


// Follow the path of a plane. See the interpolation Sandcastle example.
Cesium.Math.setRandomNumberSeed(3);

var start = Cesium.JulianDate.fromDate(new Date(2015, 2, 25, 20));
var stop = Cesium.JulianDate.addSeconds(start, 360, new Cesium.JulianDate());

viewer.clock.startTime = start.clone();
viewer.clock.stopTime = stop.clone();
viewer.clock.currentTime = start.clone();
viewer.clock.clockRange = Cesium.ClockRange.LOOP_STOP;
viewer.clock.multiplier = 1.0;
viewer.clock.shouldAnimate = true;


//entity in sample

function computeCirclularFlight(lon, lat, radius) {
    var property = new Cesium.SampledPositionProperty();
    var startAngle = Cesium.Math.nextRandomNumber() * 360.0;
    var endAngle = startAngle + 360.0;

    var increment = (Cesium.Math.nextRandomNumber() * 2.0 - 1.0) * 10.0 + 45.0;
    for (var i = startAngle; i < endAngle; i += increment) {
        var radians = Cesium.Math.toRadians(i);
        var timeIncrement = i - startAngle;
        var time = Cesium.JulianDate.addSeconds(start, timeIncrement, new Cesium.JulianDate());
        //var position = Cesium.Cartesian3.fromDegrees(lon + (radius * 1.5 * Math.cos(radians)), lat + (radius * Math.sin(radians)), Cesium.Math.nextRandomNumber() * 500 + 1750);
        var position = Cesium.Cartesian3.fromDegrees(lon + (radius * 1.5 * Math.cos(radians)), lat + (radius * Math.sin(radians)), 20);
        property.addSample(time, position);
    }
    return property;
}

//var longitude = -112.110693;
//var latitude = 36.0994841;
/*
var longitude = 121.7653048;
var latitude = 25.1499496;*/
var longitude = 121.777728;
var latitude = 25.149260;

var radius = 0.03;

//var modelURI = '../../../core/stable-plugin/Cesium-1.46/Apps/SampleData/models/CesiumBalloon/CesiumBalloon.glb';
//var modelURI = '../../../data/block2_test/models/la_nina/untitled.glb';
var modelURI = '../../../data/block2_test/models/la_nina/scene.gltf';



var entity = viewer.entities.add({
    availability : new Cesium.TimeIntervalCollection([new Cesium.TimeInterval({
        start : start,
        stop : stop
    })]),
    position : computeCirclularFlight(longitude, latitude, radius),
    model : {
        uri : modelURI,
        minimumPixelSize : 64
    }
});

entity.position.setInterpolationOptions({
    interpolationDegree : 2,
    interpolationAlgorithm : Cesium.HermitePolynomialApproximation
});
/*
var star_pos = new Cesium.Cartesian3.fromDegrees(121.777728+3, 25.149260);
for (i = 0; i < 5; ++i) {
    var he = 2000.0 * i;
    viewer.entities.add({
        position : star_pos,
        ellipse : {
            semiMinorAxis : 20000.0,
            semiMajorAxis : 20000.0,
            height : he,
            material : Cesium.Color.fromRandom({alpha : 1.0})
        }
    });
}
*/
/*
var videoElement = document.getElementById('trailer');
	var sky_pos = new Cesium.Cartesian3.fromDegrees(121.7653048, 25.1499496,10000);
	var sphere = viewer.entities.add({
    position :sky_pos,
    ellipsoid : {
        radii : new Cesium.Cartesian3(100000, 100000, 100000),
        material : videoElement
    }
	});
*/ 
var text_arr = ['天蠍座','白羊座','','',''];
var height_arr = [1,1,1,1,1];
var scale_arr = [180,480,1,1,1];
var lat_arr = [5,5.5,25,35,35];
var lon_arr = [9,5,6,7,9];
var lat_orgin = 25.150543;
//var lat_orgin = 25.1499496;
var lon_orgin = 121.777984;
//var lon_orgin = 121.7653048;
var height_muti = 1000;
var height_basic = 100000;
var lat_muti = 0.8;
var lon_muti = 0.8;
//var modelURI_arr = ['../../../data/block2_test/models/NTOU/sagittarius.glb'];
//var modelURI_arr = ['../../../data/block2_test/models/NTOU/virgo.glb'];
//var modelURI_arr = ['../../../data/block2_test/models/NTOU/Leo.gltf'];
var modelURI_arr = ['../../../data/block2_test/models/NTOU/Cancer.glb','../../../data/block2_test/models/NTOU/Aries.glb'];

for (i = 0; i < 2; ++i) {
	var star2_pos = new Cesium.Cartesian3.fromDegrees((lon_arr[i]*lon_muti)+lon_orgin, (lat_arr[i]*lat_muti)+lat_orgin,height_basic+height_arr[i]*height_muti);
	var heading = Cesium.Math.toRadians(180);
    var pitch = 0;
    var roll = 0;
    var hpr = new Cesium.HeadingPitchRoll(heading, pitch, roll);
    var orientation = Cesium.Transforms.headingPitchRollQuaternion(star2_pos, hpr);

	/*var sphere = viewer.entities.add({
    position :star2_pos,
    ellipsoid : {
        radii : new Cesium.Cartesian3(5000, 5000, 5000),
        material : Cesium.Color.fromRandom({alpha : 1.0})
    }
	});*/
	var entity_stars = viewer.entities.add({
    position :star2_pos,
	orientation:orientation,
	model : {
        uri : modelURI_arr[i],
        minimumPixelSize : scale_arr[i]
    },
	label : {
		text : text_arr[i],
        show : true,
        showBackground : false,
		fillColor : Cesium.Color.SKYBLUE,
        font : '25px monospace',
        horizontalOrigin : Cesium.HorizontalOrigin.LEFT,
        verticalOrigin : Cesium.VerticalOrigin.TOP,
		outlineColor : Cesium.Color.WHITE,
        outlineWidth : 4,
        pixelOffset : new Cesium.Cartesian2(15, 0),
		style : Cesium.LabelStyle.FILL_AND_OUTLINE
        }
	});
}  
//viewer.trackedEntity = entity_stars;
   //https://www.youtube.com/watch?v=kw88V7tVSaw

/*
var longitude = 121.7653048;
var latitude = 25.1499496;

var pointOfInterest = Cesium.Cartographic.fromDegrees(longitude,latitude, 0, new Cesium.Cartographic());
var promise = Cesium.sampleTerrain(viewer.terrainProvider, 9, [ pointOfInterest ]).then(function(samples) {
		console.log('Height in meters is: ' + samples[0].height);
	});

var position = Cesium.Cartesian3.fromDegrees(longitude, latitude,height);

	var heading = Cesium.Math.toRadians(0);
    var pitch = 0;
    var roll = 0;
    var hpr = new Cesium.HeadingPitchRoll(heading, pitch, roll);
    var orientation = Cesium.Transforms.headingPitchRollQuaternion(position, hpr);


var modelURI2 = '../../../data/block2_test/models/student/scene.gltf';
var modelURI3 = '../../../data/block2_test/models/student/head.glb';

var man = viewer.entities.add({
	viewFrom : new Cesium.Cartesian3(-1000, -8000, -10000),
    availability : new Cesium.TimeIntervalCollection([new Cesium.TimeInterval({
        start : start,
        stop : stop
    })]),
    position : position,
    orientation : orientation,
    model : {
        uri : modelURI2,
        minimumPixelSize : 64
    }
});

var box = viewer.entities.add({
        //viewFrom : new Cesium.Cartesian3(0.5, 0.1, 0.1),
		position : position,
		orientation : orientation,
        box : {
            dimensions : new Cesium.Cartesian3(1, 1, 1),
            material : Cesium.Color.WHITE.withAlpha(0.3),
            outline : true,
            outlineColor : Cesium.Color.WHITE
        }
    });

viewer.camera.lookAt(position, new Cesium.HeadingPitchRange(heading, pitch, range));
viewer.trackedEntity = box;
*/

///camera 設定
// Set initial camera position and orientation to be when in the model's reference frame.
var camera = viewer.camera;
viewer.camera.setView({
    destination : Cesium.Cartesian3.fromDegrees(121.777984, 25.150543, 50.0),
    orientation : {
             heading : Cesium.Math.toRadians(0.0),
            pitch : Cesium.Math.toRadians(4.0),
            roll : 0.0
    }
});

var modelURI_NTOU = '../../../data/block2_test/models/NTOU/NTOUS.gltf';
var position_NTOU = Cesium.Cartesian3.fromDegrees(121.777728, 25.149260, 50.0);
add_model(modelURI_NTOU , position_NTOU,'延平大樓');
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
function add_model(url,position,text){
	var add = viewer.entities.add({
        //viewFrom : new Cesium.Cartesian3(0.5, 0.1, 0.1),
		model : {
			uri : url,
			shadows: true
			},
		label : {
			text : text,
			show : true,
			showBackground : false,
			fillColor : Cesium.Color.RED,
			font : '25px monospace',
			horizontalOrigin : Cesium.HorizontalOrigin.LEFT,
			verticalOrigin : Cesium.VerticalOrigin.TOP,
			outlineColor : Cesium.Color.WHITE,
			outlineWidth : 4,
			pixelOffset : new Cesium.Cartesian2(15.0, 0.0),
			eyeOffset : new Cesium.Cartesian3(10.0, 80.0, 10.0),
			style : Cesium.LabelStyle.FILL_AND_OUTLINE
        },
		position : position/*,
		orientation : orientation,
        box : {
            dimensions : new Cesium.Cartesian3(1, 1, 1),
            material : Cesium.Color.WHITE.withAlpha(0.3),
            outline : true,
            outlineColor : Cesium.Color.WHITE
        }*/
    });
	return add;
}
/*
var camera = viewer.camera;
camera.position = new Cesium.Cartesian3(0.25, 0.0, 0.0);
camera.direction = new Cesium.Cartesian3(1.0, 0.0, 0.0);
camera.up = new Cesium.Cartesian3(0.0, 0.0, 1.0);
camera.right = new Cesium.Cartesian3(0.0, -1.0, 0.0);
var _position = null;
//var _position = position_NTOU;
//sys.enable[0] = true;
viewer.scene.postUpdate.addEventListener(function(scene, time) {
    if(sys.enable[0] == true){
		if(_position == null){
			var position = entity.position.getValue(time);
			_position = position;
		}else{
			position = _position;
		}
	}else{
		var position = entity.position.getValue(time);
	}
    if (!Cesium.defined(position)) {
        return;
    }

    var transform;
    if (!Cesium.defined(entity.orientation)) {
        transform = Cesium.Transforms.eastNorthUpToFixedFrame(position);
    } else {
        var orientation = entity.orientation.getValue(time);
        if (!Cesium.defined(orientation)) {
            return;
        }

        transform = Cesium.Matrix4.fromRotationTranslation(Cesium.Matrix3.fromQuaternion(orientation), position);
    }

    // Save camera state
    var offset = Cesium.Cartesian3.clone(camera.position);
    var direction = Cesium.Cartesian3.clone(camera.direction);
    var up = Cesium.Cartesian3.clone(camera.up);

    // Set camera to be in model's reference frame.
    camera.lookAtTransform(transform);

    // Reset the camera state to the saved state so it appears fixed in the model's frame.
    Cesium.Cartesian3.clone(offset, camera.position);
    Cesium.Cartesian3.clone(direction, camera.direction);
    Cesium.Cartesian3.clone(up, camera.up);
    Cesium.Cartesian3.cross(direction, up, camera.right);
	
});*/
/*
var handler = new Cesium.ScreenSpaceEventHandler(scene.canvas);
	handler.setInputAction(function(movement) {
        var cartesian = viewer.camera.pickEllipsoid(movement.endPosition, scene.globe.ellipsoid);
        if (cartesian) {
            var cartographic = Cesium.Cartographic.fromCartesian(cartesian);
            var longitude_val = Cesium.Math.toDegrees(cartographic.longitude).toFixed(7);
            var longitudeString = Cesium.Math.toDegrees(cartographic.longitude).toFixed(3);
            var latitude_val = Cesium.Math.toDegrees(cartographic.latitude).toFixed(7);
            var latitudeString = Cesium.Math.toDegrees(cartographic.latitude).toFixed(3);
			//sys.position.lon = longitude_val;
			//sys.position.lat = latitude_val;
			//console.log(cartesian);
           //entity_label.position = cartesian;
            //entity_label.label.show = true;
			var text = 'Lon: ' + ('   ' + longitudeString).slice(-7) + '\u00B0' + '\nLat: ' + ('   ' + latitudeString).slice(-7) + '\u00B0';
            //entity_label.label.text = text;
			console.log(text);
        } else {
            entity_label.label.show = false;
        }
    }, Cesium.ScreenSpaceEventType.MOUSE_MOVE);
*/
var numBalloons = 12;
for (var i = 0; i < numBalloons; ++i) {
    var balloonRadius = (Cesium.Math.nextRandomNumber() * 2.0 - 1.0) * 0.01 + radius;
    var balloon = viewer.entities.add({
        availability : new Cesium.TimeIntervalCollection([new Cesium.TimeInterval({
            start : start,
            stop : stop
        })]),
        position : computeCirclularFlight(longitude, latitude, balloonRadius),
        model : {
            uri : modelURI,
            minimumPixelSize : 64
        }
    });

    balloon.position.setInterpolationOptions({
        interpolationDegree : 2,
        interpolationAlgorithm : Cesium.HermitePolynomialApproximation
    });
	
}
sys.func._1 = function (){
	var camera = viewer.camera;
    console.log(viewer.camera.positionWC.clone());
    console.log(viewer.camera.up.clone());
    console.log(viewer.camera.direction.clone());
}
sys.camera = viewer.camera;

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
function snap_sence(){
	sys.func._1();
}
</script>
</body>
</html>
