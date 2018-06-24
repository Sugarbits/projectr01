<?php  
if(!isset($_GET['video_url'])){
	die('lack parameter <video_url>');
}//?video_url=S3uU8VDlhyU
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<!--<script src='tubeplayer.min.js'></script>-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-tubeplayer/2.1.0/jquery.tubeplayer.min.js"></script>
<!--<div id='youtube-video-player'></div>-->
<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/segment7" type="text/css"/>
	<style>
	body{
		padding:0px;
		margin:0px;
		background-color:white;
		overflow:hidden;
	}
    </style>
	<style>
	.video-wrapper{
		position: relative;
		padding-bottom: 56.25%; /* 16:9 */ 
		padding-top: 25px;
	}
	.video-wrapper iframe{
		position: absolute;
		top: 0;
		left: 0;
		width: 100vw;
		height: 100vh;
	}
    </style>
</head>
	<div class='video-wrapper'>
	<!--width="854" height="480"-->
		<iframe id='youtube-video-player' width="854" height="480" src="https://www.youtube.com/embed/S3uU8VDlhyU" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	</div>
</html>
<script>
window.addEventListener("load", function(event) {
    jQuery("#youtube-video-player").tubeplayer({
        //initialVideo: "S3uU8VDlhyU",//kOkQ4T5WO9E
        initialVideo: "<?php echo $_GET['video_url']; ?>",
		preferredQuality: "large", 
		controls: 0,
		autoPlay: true,
		annotations: false, 
		modestbranding: false, 
		showinfo: false,
		loop: 0, 
        onPlayerLoaded: function(){
			jQuery("#player").tubeplayer("mute");
            console.log(this.tubeplayer("data"));
        },
		onPlayerEnded: function(){
			jQuery("#youtube-video-player").tubeplayer("seek", "0:0");
		},
    });
    console.log("All resources finished loading!");
  });
</script>