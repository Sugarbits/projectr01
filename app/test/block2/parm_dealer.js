//catch_scene
var ParmDealer;

ParmDealer = (function(){
	// configure settings
	var all_public={
	   CesiumCartesian3 : null,
	   viewer : null,
	   none : null
	};
	var _saveInfo_private ={
	   CSM : null,//Cesium.SceneMode
	   none : null
	};
	var _takePic_private = {
      targetResolutionScale : 1.0,// for screenshots with higher resolution set to 2.0 or even 3.0
      //timeout : 1000,// in ms
      timeout : 1,// in ms
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
   //TYPE 2 ：動態生成的綁定事件
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
   function _saveInfo(){//抽取(distill) setView parm
      //parameter load
	  var viewer = all_public.viewer;
	  var CesiumSceneMode = _saveInfo_private.CSM;
	  var targetResolutionScale = _takePic_private.targetResolutionScale;
	  //parameter load end
      var saveData = {};
	  var sceneMode = viewer.scene.mode;
	  //現假設只有3D模式
	  //saveData['sceneMode'] = sceneMode;
	  
	  //camera
      var options = {
         position: null,
         direction: null,
         up: null,
         frustum: null
      };
	  var stroageArr = [];
      //if(sceneMode == Cesium.SceneMode.SCENE3D){
      if(sceneMode == CesiumSceneMode.SCENE3D){
         options.position = viewer.camera.positionWC.clone();
		 var carto  = Cesium.Ellipsoid.WGS84.cartesianToCartographic(options.position);     
		 var lo = Cesium.Math.toDegrees(carto.longitude); 
		 var la = Cesium.Math.toDegrees(carto.latitude);
		 var he = Cesium.Math.toDegrees(carto.height);
		 console.log(la+','+lo+','+he);
      }else{
         //todo 非3d下的定位
		 throw new Error("CesiumSceneMode 非 3D模式");
      }
      options.up = viewer.camera.up.clone();
      options.direction = viewer.camera.direction.clone();
      //options.frustum = _saveFrustum(viewer.camera.frustum.clone());
      //saveData['camera'] = options;
	  //console.log(options.position.x y z);
	  stroageArr.push(options.position.x);
	  stroageArr.push(options.position.y);
	  stroageArr.push(options.position.z);
	  stroageArr.push(options.up.x);
	  stroageArr.push(options.up.y);
	  stroageArr.push(options.up.z);
	  stroageArr.push(options.direction.x);
	  stroageArr.push(options.direction.y);
	  stroageArr.push(options.direction.z);
	  //console.log(stroageArr.join("@"));
	  //console.log(JSON.parse(JSON.stringify(saveData)));
	  //console.log( JSON.stringify(options));
	  //return saveData;
	  //var str = stroageArr.join("@");
	  str = JSON.stringify(options)
	  return str;
   }
   function _recoverInfo(data){
	  console.log('_recoverInfo');
	  //console.log( JSON.parse(data));
	  var viewer = all_public.viewer;
	  //parameter load end
	  /*
	  //恢复Scene  
          var options={
		     position:{x:data[0]*1,y:data[1]*1,z:data[2]*1},
		     direction:{x:data[3]*1,y:data[4]*1,z:data[5]*1},
			 up:{x:data[6]*1,y:data[7]*1,z:data[8]*1}
	      };
	  */		  
         viewer.scene.morphTo3D(2.0);
		 _updateInfo(JSON.parse(data));
         viewer.scene.morphComplete.addEventListener(function(scene,time){
           // _updateInfo(options);
         });    
   }

   //function _updateCamera(camera){
   //}
   function _updateInfo(data){
       //parameter load
	   var viewer = all_public.viewer;
	   var CesiumCartesian3 = all_public.CesiumCartesian3;
	   //parameter load end
	   console.log('_updateInfo');
	   //console.log(data);
	   console.log(data.direction);
	   console.log(data.up);
	   var position = new CesiumCartesian3(data.position.x,data.position.y,data.position.z);
	   var direction = new CesiumCartesian3(data.direction.x,data.direction.y,data.direction.z);
	   var up = new CesiumCartesian3(data.up.x,data.up.y,data.up.z);
	   console.log(direction);
	   console.log(up);
       viewer.camera.setView({
         destination: position,
         orientation: {
            direction: direction,
            up:  up
         }
      });
	  /*viewer.camera.setView({
    destination : Cesium.Cartesian3.fromDegrees(-122.19, 46.25, 5000.0),
    orientation : {
        direction : new Cesium.Cartesian3(-0.04231243104240401, -0.20123236049443421, -0.97862924300734),
        up : new Cesium.Cartesian3(-0.47934589305293746, -0.8553216253114552, 0.1966022179118339)
    }
});*/
      //_loadFrustum(ViewerCamera);

   }
   function _loadFrustum(ViewerCamera){
	   var frustum = ViewerCamera.frustum;
      if(frustum.near != null){
         ViewerCamera.frustum.near = frustum.near;
      }
      if(frustum.far != null){
         ViewerCamera.frustum.far = frustum.far;
      }
      if(frustum.top != undefined){
         ViewerCamera.frustum.top = frustum.top;
	  }  
      if(frustum.bottom != undefined){
         ViewerCamera.frustum.bottom = frustum.bottom;
      }
      if(frustum.left != undefined){
        ViewerCamera.frustum.left = frustum.left;
      }
	  if(frustum.right != undefined){
         ViewerCamera.frustum.right = frustum.right;
      }
	  if(frustum.xOffset != undefined){
         ViewerCamera.frustum.xOffset = frustum.xOffset;
      }
      if(frustum.yOffset != undefined){
         ViewerCamera.frustum.yOffset = frustum.yOffset;
      }
      if(frustum.fov != undefined){
         ViewerCamera.frustum.fov = frustum.fov;
      }
      if(frustum.aspectRatio != undefined){
         ViewerCamera.frustum.aspectRatio = frustum.aspectRatio;
      }
   }
   function _saveFrustum(frustum){
      var options = {};
	  if(frustum.near != undefined){
         options['near'] = frustum.near;
      }
      if(frustum.far != undefined){
         options['far'] = frustum.far;
      }
      if(frustum.top != undefined){
         options['top'] = frustum.top;
      }
      if(frustum.bottom != undefined){
         options['bottom'] = frustum.bottom;
      }
      if(frustum.left != undefined){
         options['left'] = frustum.left;
      }
      if(frustum.right != undefined){
         options['right'] = frustum.right;
      }
      if(frustum.xOffset != undefined){
         options['xOffset'] = frustum.xOffset;
      }
      if(frustum.yOffset != undefined){
         options['yOffset'] = frustum.yOffset;
      }
      if(frustum.fov != undefined){
         options['fov'] = frustum.fov;
      }
      if(frustum.aspectRatio != undefined){
         options['aspectRatio'] = frustum.aspectRatio;
      }
      return options;
   }
  
   function _takePic(){
      console.log('_takePic');
	  //parameter load
	  var timeout = _takePic_private.timeout;
	  var viewer = all_public.viewer;
	  var targetResolutionScale = _takePic_private.targetResolutionScale;
	  //parameter load end 
      var prepareScreenshot = function(){
         console.log('prepareScreenshot');
         //var canvas = scene.canvas;    
         viewer.resolutionScale = targetResolutionScale;
	     //scene.preRender.removeEventListener(prepareScreenshot);
	     //take snapshot after defined timeout to allow scene update (ie. loading data)
	     setTimeout(function(){
            viewer.scene.postRender.addEventListener(takeScreenshot);
         }, timeout);
      }
      var takeScreenshot = function(){
	     console.log('takeScreenshot');
         viewer.scene.postRender.removeEventListener(takeScreenshot);
         var canvas = viewer.scene.canvas;
         /*canvas.toBlob(function(blob){
            var url = URL.createObjectURL(blob);
            downloadURI(url, "snapshot-" + targetResolutionScale.toString() + "x.png");
            // reset resolutionScale
            viewer.resolutionScale = 1.0;
         });*/
         canvas.toBlob(function(blob){
            var url = URL.createObjectURL(blob);
			// reset resolutionScale
            viewer.resolutionScale = 1.0;
            var newImg = document.createElement("img"),
			url = URL.createObjectURL(blob);
			newImg.onload = function() {
			   // no longer need to read the blob so it's revoked
			   URL.revokeObjectURL(url);
			};
			newImg.src = url;
			document.body.appendChild(newImg);
         },"image/jpeg", 1.0);
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
	  function thumbnailURI(uri, name) {
	     var link = document.createElement("a");
		 link.download = name;
		 link.href = uri;
		 // mimic click on "download button"
		 document.body.appendChild(link);
		 /*link.click();
		 document.body.removeChild(link);
		 delete link;*/
	 }
	  prepareScreenshot();
   }
   return {
      initialize: function(obj,obj2){
         //初始化，固定地，runtime性事項擺這裡		
		 //指定某項共用參數
		 all_public.viewer = obj;
		 all_public.CesiumCartesian3 = obj2;		 
      },
	  getSceneVal: function(obj){
         //得到場景參數的方法
         //obj = Cesium.SceneMode		 
		 if(obj == undefined || obj == null){
            throw new Error("getScene [method] requires data [parameter]");
			return -1;
		 }else if(all_public.viewer == undefined || all_public.viewer == null){
			throw new Error("getScene [method] requires finish setViewer [method]");
			return -1;
		 }else{
		    _saveInfo_private.CSM = obj;
			return _saveInfo();
		 }
		 
      },
	  setSceneVal: function(obj){
		  console.log('setSceneVal');
         //得到場景參數的方法
         //obj = viewer.camera	 
		 if(obj == undefined || obj == null){
            throw new Error("getScene [method] requires Cesium.SceneMode [parameter]");
			return -1;
		 }else{
			_recoverInfo(obj);
		 }
		 
      },
	  getScenePic_initialize : function(){
		//未測試，只知道拿掉不會影響太多 
		//(原本位置在執行前，放置於Cesium內部)
		//scene.preRender.addEventListener(prepareScreenshot);
		console.log('暫時不用');
	  },
	  getScenePic : function(){
        //得到場景影像的方法
		_takePic();
      },
	  none: function(){
         //
      }
   };
}());
