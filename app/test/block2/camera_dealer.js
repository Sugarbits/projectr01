//catch_scene
var CameraDealer;

CameraDealer = (function(){
	// configure settings
	var all_public={
	   Cesium : null,
	   camera : null,
	   viewer : null,
	   scene : null,
	   lock : [false],
	   none : null
	};
	var _x_private = {
      x : null,// 
	  none : null
    };
	
	 var _add_label_private = {
      id_arr : [],// 
	  none : null
    };
	
	 var _release_marker_data_private = {
      id_arr : [],// 
	  none : null
    };
	
   function _computeCirclular(start ,lon, lat, radius){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  //parameter load end
      var property = new Cesium.SampledPositionProperty();
      var orientationProperty = new Cesium.SampledProperty(Cesium.Quaternion); 
      var startAngle = Cesium.Math.nextRandomNumber() * 360.0;
      var endAngle = startAngle + 360.0;
      var increment = (Cesium.Math.nextRandomNumber() * 2.0 - 1.0) * 10.0 + 45.0;
      for (var i = startAngle; i < endAngle; i += increment){
         var radians = Cesium.Math.toRadians(i);
         var timeIncrement = i - startAngle;
         var time = Cesium.JulianDate.addSeconds(start, timeIncrement, new Cesium.JulianDate());
         //var position = Cesium.Cartesian3.fromDegrees(lon + (radius * 1.5 * Math.cos(radians)), lat + (radius * Math.sin(radians)), Cesium.Math.nextRandomNumber() * 500 + 1750);
         var heading = Cesium.Math.toRadians(0+i);
         var pitch = Cesium.Math.toRadians(0);
         var roll = Cesium.Math.toRadians(0);
         var hpr = new Cesium.HeadingPitchRoll(heading, pitch, roll);
         var position = Cesium.Cartesian3.fromDegrees(lon + (radius * 1.5 * Math.cos(radians)), lat + (radius * Math.sin(radians)), 150);
         var orientation = Cesium.Transforms.headingPitchRollQuaternion(position, hpr);
         //property.addSample(time, position);
         orientationProperty.addSample(time, orientation);
      }
      return [position,orientationProperty];
   }	
   function _fix_camera_define1(camera,retry){
      //var camera = viewer.camera;
      camera.position = new Cesium.Cartesian3(0.25, 0.0, 0.0);
      camera.direction = new Cesium.Cartesian3(-1.0, 0.0, 0.0);
      camera.up = new Cesium.Cartesian3(0.0, 0.0, 1.0);
      camera.right = new Cesium.Cartesian3(1.0, 0.0, 0.0);
	  if(retry > 0){
	     setTimeout(function(){_fix_camera_define1(camera,-1);},retry);
	  }
   }

   function _set_camera_define1(lon,lat){
	  //parameter load
	  var viewer = all_public.viewer;
	  var Cesium = all_public.Cesium;
	  //parameter load end
	  var start = Cesium.JulianDate.fromDate(new Date());
	  var stop = Cesium.JulianDate.addSeconds(start, 360, new Cesium.JulianDate());
	  viewer.clock.startTime = start.clone();
	  viewer.clock.stopTime = stop.clone();
	  viewer.clock.currentTime = start.clone();
	  viewer.clock.clockRange = Cesium.ClockRange.LOOP_STOP;
	  viewer.clock.multiplier = 1.0;
	  viewer.clock.shouldAnimate = true;
	  
      //var longitude = -112.110693;
      //var latitude = 36.0994841;
      var longitude = lon;
      var latitude = lat;
      var radius = 0.00003;
      var data1 = _computeCirclular(start,longitude, latitude, radius);
      var modelURI = '../../../core/stable-plugin/Cesium-1.46/Apps/SampleData/models/CesiumBalloon/CesiumBalloon.glb';
      var entity = viewer.entities.add({
         availability : new Cesium.TimeIntervalCollection([new Cesium.TimeInterval({
            start : start,
            stop : stop
         })]),
         position : data1[0],
         orientation : data1[1],
         model : {
            uri : modelURI,
            minimumPixelSize : 64,
			color : Cesium.Color.fromAlpha(Cesium.Color.WHITE, parseFloat(0))
            //colorBlendMode : getColorBlendMode(viewModel.colorBlendMode),
            //colorBlendAmount : parseFloat(viewModel.colorBlendAmount),
            //silhouetteColor : getColor(viewModel.silhouetteColor, viewModel.silhouetteAlpha),
            //silhouetteSize : parseFloat(viewModel.silhouetteSize)
         }
      });
	  var camera = viewer.camera;
	  _fix_camera_define1(camera,3500);
	  _fix_camera_handler_define1(entity);
   }
   function _fix_camera_handler_define1(entity){
	   //parameter load
	   var viewer = all_public.viewer;
	   var Cesium = all_public.Cesium;
	   var camera = all_public.camera;
	   //parameter load end
	   viewer.scene.postUpdate.addEventListener(function(scene, time) {
	      var position = entity.position.getValue(time);
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
       });
   }
	/*
	//jQuery 相依性
	// 提示使用者這個模組跟jQuery有相依性
    if (!window.jQuery) { throw new Error("LikeButtonModule requires jQuery") }
	// 這行可以增進效能
    var $ = window.jQuery;
	*/
   //TYPE 1 ：預先設立好的綁定事件
   _handler = function(){
	  /*Event 參考：
	  https://www.w3schools.com/jsref/dom_obj_event.asp
	  元素：blur,change,click,dbclick,focus,input,keypress,load,mouseover,mouseleave,
      整體：error,offline,online
	  */
	  var ElementId = 'testId';
      document.getElementById(ElementId).addEventListener("click", function(){
         document.getElementById(ElementId).innerHTML = "Hello World";
      }); 
   }
 
   
   return {
      initialize: function(Cesium,viewer,scene,camera){
         //初始化，固定地，runtime性事項擺這裡	
		 var handler = new Cesium.ScreenSpaceEventHandler(scene.canvas);
		 all_public.Cesium = Cesium;//Cesium
	     all_public.viewer = viewer;//viewer
	     all_public.scene = scene;//scene
	     all_public.camera = camera;//camera
		 
      },
	  autoplay: function(lon,lat){
         //自動播放預設鏡頭，客製功能1
		 //_marker_add_lock(true);
        _set_camera_define1(lon,lat);
      },
	  none: function(){
         //
      }
   };
}());
