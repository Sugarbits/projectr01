//catch_scene
var HandlerDealer;

HandlerDealer = (function(){
	// configure settings
	var all_public={
	   handler : null,
	   Cesium : null,
	   viewer : null,
	   scene : null,
	   lock : [{_:false},{_:false},{_:false}],
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
	 
	var _updateListener_private = {
      timeout : 1000,// in ms
      reftime : null,// in ms
	  none : null
    };
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
	function _updateListener(){
      //parameter load
	  var timeref = _updateListener_private.reftime;
	  var timeamt = 0;
	  var viewer = all_public.viewer;
	  var mouse_activity = all_public.lock[1];
	  var autoplay_activity = all_public.lock[2];
	  //parameter load end
	  viewer.scene.preUpdate.addEventListener(function(scene, time) {
		 //console.log('_updateListener');
		 //console.log(time.toString());
		 if(autoplay_activity._ == false){
		    if(mouse_activity._ == true){
   			   //console.log('time renew!!!');
		       timeref = time;
			   mouse_activity._ = false;
		    }else{
			    timeref  = (timeref == null) ? time : timeref;
			    //console.log(timeref.toString());
			    //console.log(Cesium.JulianDate.compare(time ,timeref));
			    timeamt = Cesium.JulianDate.compare(time ,timeref);
			    if(timeamt > 10){
				   console.log('超過十秒未動作');
				   autoplay_activity._ = true;//autoplay mode on
			    }
			 //console.log(mouse_activity);
		    }
		 }else{//auto play 已開啟
			 if(mouse_activity._ == true){
			    console.log('使用者移動滑鼠,自動播放關閉');
				autoplay_activity._ = false;//autoplay mode on
			 }
		 }
      });
   }
  
   function _mouse_move_handler(){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var handler = all_public.handler;
	  var viewer = all_public.viewer;
	  var scene = all_public.scene;
	  var mouse_activity = all_public.lock[1];
	  var _la = null;
	  var _lo = null;
	  //parameter load end
      handler.setInputAction(function(movement) {
		//console.log('_mouse_move_handler');
		mouse_activity._ = true;//動過滑鼠
		console.log('move!');
        var cartesian = viewer.camera.pickEllipsoid(movement.endPosition, scene.globe.ellipsoid);
        if (cartesian) {
            var cartographic = Cesium.Cartographic.fromCartesian(cartesian);
            //var longitude_val = Cesium.Math.toDegrees(cartographic.longitude).toFixed(7);
            var longitudeString = Cesium.Math.toDegrees(cartographic.longitude);//.toFixed(7);
            //var latitude_val = Cesium.Math.toDegrees(cartographic.latitude).toFixed(7);
            var latitudeString = Cesium.Math.toDegrees(cartographic.latitude);//.toFixed(7);
			//var text = 'Lon: ' + ('   ' + longitudeString).slice(-7) + '\u00B0' + '\nLat: ' + ('   ' + latitudeString).slice(-7) + '\u00B0';
			var text = 'Lon: ' + ('   ' + longitudeString) + '\u00B0' + '\nLat: ' + ('   ' + latitudeString) + '\u00B0';
            //entity_label.label.text = text;
			//console.log(text);
			//_la = latitudeString;
			//_lo = longitudeString;
        } else {
            //entity_label.label.show = false;
			//_la = null;
			//_lo = null;
			//console.log('cartesian err');
        }
    }, Cesium.ScreenSpaceEventType.MOUSE_MOVE);
   }
  function _release_marker_data(){
      //parameter load
	  var Cesium = all_public.Cesium;
	  var markerIdArr = _add_label_private.id_arr;
	  var viewer = all_public.viewer;
	  //parameter load end 
	  var property = new Cesium.SampledPositionProperty();
	  var start = Cesium.JulianDate.fromDate(new Date());//用現在時間	 
	  //parameter save
	  
	  //parameter save end 
	 
	  var acc = 0;
		for(k in markerIdArr){
			var e = viewer.entities.getById(markerIdArr[k]);
			/*console.log(m[k]);
			console.log(viewer);
			console.log(e);
			console.log(e.data1);
			console.log(e.position);*/
			acc += e.data1;
			_sample_add(start,acc,e.position.getValue(),property);
		}
		return [property,start,acc];
		var result = _entity_prepare(start,acc,property);
		//viewer.trackedEntity = result;
   }
      function _sample_add(st,et,p,pp){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var viewer = all_public.viewer;
	  //parameter load end
      var carto  = Cesium.Ellipsoid.WGS84.cartesianToCartographic(p);     
      var lo = Cesium.Math.toDegrees(carto.longitude); 
      var la = Cesium.Math.toDegrees(carto.latitude); 
	  //var he = carto.height;
	  //var he = 50;
	  var radius = 0.03;
	  var balloonRadius = (Cesium.Math.nextRandomNumber() * 2.0 - 1.0) * 0.01 + radius;
	  var he = balloonRadius;
	  var pos = Cesium.Cartesian3.fromDegrees(lo, la, he);
	  var time = Cesium.JulianDate.addSeconds(st, et, new Cesium.JulianDate());
	   pp.addSample(time, pos);
	}
      function _entity_prepare(property,start,acc){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var viewer = all_public.viewer;
	  //parameter load end
      var stop = Cesium.JulianDate.addSeconds(start, acc, new Cesium.JulianDate());
	  //console.log(start.toString());
	  //console.log(stop.toString());
	  //console.log(property);
	  
      var entity = viewer.entities.add({
      //Set the entity availability to the same interval as the simulation time.
      availability : new Cesium.TimeIntervalCollection([new Cesium.TimeInterval({
          start : start,
          stop: stop
      })]),
     //Use our computed positions
       position : property,
     //Automatically compute orientation based on position movement.
       orientation : new Cesium.VelocityOrientationProperty(property),
     //Load the Cesium plane model to represent the entity
       model : {
       //uri : '../Apps/SampleData/models/CesiumAir/Cesium_Air.glb',
       uri : '../../../core/stable-plugin/Cesium-1.46/Apps/SampleData/models/CesiumBalloon/CesiumBalloon.glb',
       minimumPixelSize : 128,
       maximumScale : 200000
     },
	  //Show the path as a pink line sampled in 1 second increments.
	  path : {
        resolution : 1,
        material : new Cesium.PolylineGlowMaterialProperty({
        glowPower : 0.1,
        color : Cesium.Color.YELLOW
      }),
        width : 10
      }
   });
   entity.position.setInterpolationOptions({
            interpolationDegree : 5,
            interpolationAlgorithm : Cesium.LagrangePolynomialApproximation
    });
		return [start,stop,viewer,entity.id];   
   }

   function _play_route(start,stop,viewer){
      viewer.clock.startTime = start.clone();
      viewer.clock.stopTime = stop.clone();
      viewer.clock.currentTime = start.clone();
      viewer.clock.clockRange = Cesium.ClockRange.CLAMPED; //Loop at the end
      viewer.clock.multiplier = 1;
      viewer.clock.shouldAnimate = true;
   }
   function _marker_add_lock(bool){
	   //parameter load
	   var marker_play_activity = all_public.lock[0];
	   //parameter load end 
	   marker_play_activity._ = (bool !== false) ? true : false;
   }
   function _play_route_camera(entityId){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var scene = all_public.scene;
	  var viewer = all_public.viewer;
	  //parameter load end
	  var camera = viewer.camera;
	  camera.position = new Cesium.Cartesian3(0.25, 0.0, 0.0);
      camera.direction = new Cesium.Cartesian3(1.0, 0.0, 0.0);
	  camera.up = new Cesium.Cartesian3(0.0, 0.0, 1.0);
	  camera.right = new Cesium.Cartesian3(0.0, -1.0, 0.0);
	  setTimeout(function(){
	     camera.position = new Cesium.Cartesian3(0.25, 0.0, 0.0);
		 camera.direction = new Cesium.Cartesian3(1.0, 0.0, 0.0);
		 camera.up = new Cesium.Cartesian3(0.0, 0.0, 1.0);
		 camera.right = new Cesium.Cartesian3(0.0, -1.0, 0.0);
	  },2500);
	  var entity = viewer.entities.getById(entityId);
	  console.log(entity);
	  ///*
	  viewer.scene.postUpdate.addEventListener(function(scene, time) {
		 //var position = Cesium.Cartesian3.fromDegrees(121.7783134, 25.1497053, 1000);
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
	 return camera;
	// */
   }
   
   return {
      initialize: function(Cesium,viewer,scene){
         //初始化，固定地，runtime性事項擺這裡	
		 var handler = new Cesium.ScreenSpaceEventHandler(scene.canvas);
		 all_public.handler = handler;
		 all_public.Cesium = Cesium;//Cesium
	     all_public.viewer = viewer;//viewer
	     all_public.scene = scene;//scene
		 
      },
	  handlerAdd: function(){
         //場景更新觸發，客製功能2，
		 _mouse_move_handler();
		 _updateListener();
      },
	  marker_get: function(){
         //左鍵觸發，客製功能1，
		 return _add_label_private.id_arr;
      },
	  marker_play: function(){
         //播放標註，客製功能2，
		 var data = _release_marker_data();
		 console.log(data);
		 var data2 = _entity_prepare(data[0],data[1],data[2]);
		 _play_route(data2[0],data2[1],data2[2]);
		 //var camera = _play_route_camera(data2[3]);
		 return camera;
		 //_marker_add_lock(true);
      },
	  none: function(){
         //
      }
   };
}());
