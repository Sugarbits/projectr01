//catch_scene
var TraceDealer;

TraceDealer = (function(){
	// configure settings
	var all_public={
	   handler : null,
	   Cesium : null,
	   viewer : null,
	   scene : null,
	   lock : [{_:false}],
	   trace_index: {_:0},
	   trace_id : [],
	   trace_color : [],
	   savejson : {
		   model: null,
		   data: []
	   },
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
	/*
	 var _release_marker_data_private = {
      id_arr : [],// 
	  none : null
    };*/
	
	 var _entity_prepare_private = {
      modelurl : null,// 
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
	function _addslashes(str) {//todo string dealer
		return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
	}
   function _left_click_handler(){
      //parameter load
	  var Cesium = all_public.Cesium;
	  var handler = all_public.handler;
	  var viewer = all_public.viewer;
	  var scene = all_public.scene;
	  var marker_play_activity = all_public.lock[0];
	  //parameter load end
      // Mouse over the globe to see the cartographic position
	  //Cesium.ScreenSpaceEventType.LEFT_CLICK = 2(const)
      handler.setInputAction(function(movement) {
	     if(marker_play_activity._){
			console.log('tarce is playing marker adder cancel');
		 }else{
            //console.log(movement.position);
		    //console.log(scene.globe.ellipsoid);
		    var cartesian = viewer.camera.pickEllipsoid(movement.position, scene.globe.ellipsoid);
			if (cartesian) {
               var cartographic = Cesium.Cartographic.fromCartesian(cartesian);
               var lon = Cesium.Math.toDegrees(cartographic.longitude);
               //var longitudeString = Cesium.Math.toDegrees(cartographic.longitude).toFixed(2);
               var lat = Cesium.Math.toDegrees(cartographic.latitude);
               //var latitudeString = Cesium.Math.toDegrees(cartographic.latitude).toFixed(2);
               //entity.position = cartesian;
               //entity.label.show = true;
			   _add_label(lon,lat,150,20);
			   //get_height(sys.position.lon,sys.position.lat);
		    }
		  }
	  }, 2);	
   }
   function _add_trace(){
	  console.log('_add_trace');
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var marker_arr = _add_label_private.id_arr;
	  var trace_arr = all_public.trace_id;
	  var trace_color_arr = all_public.trace_color;
	  var trace_index = all_public.trace_index;
	  //parameter load end
	  console.log(marker_arr);
	  var _marker_arr = marker_arr.slice();
      trace_arr.push(_marker_arr);
	  console.log(trace_arr);
	  marker_arr = [];//todo,沒有效果的，代表array是傳值
	  _add_label_private.id_arr = [];//todo，找出 marker_arr = []的取代方法
	  console.log('_add_trace end');
	  if(trace_arr.length == 1){
		 trace_color_arr.push(Cesium.Color.BLACK); 
	  }else{
	     trace_color_arr.push(Cesium.Color.fromRandom({alpha : 1.0}));  
	  }
   }
   function _focus_trace(index){
	   console.log('_focus_trace');
	   //parameter load
	  var marker_arr = _add_label_private.id_arr;
	  var trace_arr = all_public.trace_id;
	  var trace_index = all_public.trace_index;
	  var trace_color_arr = all_public.trace_color;
	  //parameter load end
	   if(index > 0){
	      trace_index._ = index;
	   }else{//最新一條軌跡
   	      trace_index._ = trace_arr.length-1;
	   }
   }
   function _add_label(lon,lat,he,acc){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var viewer = all_public.viewer;
	  var marker_arr = _add_label_private.id_arr;
	  var trace_color_arr = all_public.trace_color;
	  var trace_index = all_public.trace_index;
	  //var trace_index = all_public.trace_index;
	  console.log('_add_label');
	  console.log(trace_color_arr);
	  console.log(trace_color_arr[(trace_index._)]);
	  console.log('_add_label end ');
	  //parameter load end
	   //console.log(Cesium.HeightReference);
	   var pinBuilder = new Cesium.PinBuilder();
	   var marker = viewer.entities.add({
           name : 'mark',
           position : Cesium.Cartesian3.fromDegrees(lon, lat),
           data1 : he,
           data2 : acc,
           billboard : { 
		   //image : pinBuilder.fromText((marker_arr.length)+1, Cesium.Color.BLACK, 48).toDataURL(),
           image : pinBuilder.fromText((marker_arr.length)+1, trace_color_arr[(trace_index._)], 48).toDataURL(),
           verticalOrigin : Cesium.VerticalOrigin.BOTTOM,//TOP,CENTER,BASELINE,BOTTOM
		   heightReference: Cesium.HeightReference.CLAMP_TO_GROUND
          }
	   });
	   //console.log(marker);
	   marker_arr.push(marker.id);
   }
   function _load_json_file(datajson){
      var data = JSON.parse(datajson);
	  if((data.data.length % 4) !== 0){
		  throw new Error('軌跡資料有誤，應為4的倍數');
	  }else{
		  var cnt = data.data.length / 4;
		  for(var i=0;i< cnt;i++){
			  var lon = data.data[i*4+0];
			  var lat = data.data[i*4+1];
			  var height = data.data[i*4+2];
			  var time_acc = data.data[i*4+3];
			  _add_label(lon,lat,height,time_acc);
			  
		  }
	  }
	  console.log(data); 
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
			_sample_add(start,e.data1,acc,e.position.getValue(),property);
			acc += e.data2;
		}
		return [property,start,acc];
		var result = _entity_prepare(start,acc,property);
		//viewer.trackedEntity = result;
   }
      function _sample_add(st,he,et,p,pp){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var viewer = all_public.viewer;
	  var Saver = all_public.savejson;
	  //parameter load end
      var carto  = Cesium.Ellipsoid.WGS84.cartesianToCartographic(p);     
      var lo = Cesium.Math.toDegrees(carto.longitude); 
      var la = Cesium.Math.toDegrees(carto.latitude); 
	  var he = he;
	  Saver.data.push(lo);
	  Saver.data.push(la);
	  Saver.data.push(he);
	  Saver.data.push(et);
	  //var he = carto.height;
	  //var radius = 0.03;
	  //var balloonRadius = (Cesium.Math.nextRandomNumber() * 2.0 - 1.0) * 0.01 + radius;
	  //var he = balloonRadius;
	  var pos = Cesium.Cartesian3.fromDegrees(lo, la, he);
	  var time = Cesium.JulianDate.addSeconds(st, et, new Cesium.JulianDate());
	   pp.addSample(time, pos);
	}
      function _entity_prepare(property,start,acc){
	  //parameter load
	  var Cesium = all_public.Cesium;
	  var viewer = all_public.viewer;
	  var Modelurl = _entity_prepare_private.modelurl;
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
       uri : Modelurl,
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
 
   return {
      initialize: function(Cesium,viewer,scene){
         //初始化，固定地，runtime性事項擺這裡	
		 var handler = new Cesium.ScreenSpaceEventHandler(scene.canvas);
		 all_public.handler = handler;
		 all_public.Cesium = Cesium;//Cesium
	     all_public.viewer = viewer;//viewer
	     all_public.scene = scene;//scene
		 
      },
	  handlerAdd: function(modelurl){
         //left click觸發，客製功能，
		 _left_click_handler();
		 _entity_prepare_private.modelurl = modelurl;
		 all_public.savejson.model = modelurl;//default model
		 _add_trace();
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
		 _add_trace();
		 _focus_trace(0);
		 var str = JSON.stringify(all_public.savejson);
		 console.log(_addslashes(str));
		 //data2[3] 給 entity.id
      },
	  show_trace_data: function(){
	     console.log(all_public.trace_id);
	     console.log(all_public.trace_index);
	     console.log(all_public.trace_color);
	     console.log(_add_label_private.id_arr);
	  },
      load_file: function(datajson){
         //播放標註，客製功能2，
		 _add_trace();
		 _focus_trace(0);
		 _load_json_file(datajson);
	     
      },
	  none: function(){
         //
      }
   };
}());
