<?php 

// Standalone HTML5 player by G.DEBOST idmkr
// - Cookie usage for intelligent behavior between pages
// - No dependance except jQuery
// - Fading between pages when changing music
// - ogg and mp3 support.
//
// .ogg file must exist and have the same name as .mp3 file for Firefox compatibility
//
// One music usage : 
// just specifiy the directory and the file name below. 
//
// One music per page usage :
// Just define the $mp3 var before including this file.

$defautltSong = 'song1.mp3';
$musicDir = '../audio/';


$shutSrc = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAJCAYAAAALpr0TAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAIpJREFUeNpi+P//PwMyXrBitQEQr0cXZ2FAAgtXrkkAUvMZsAAWoKQBkA4AYn4gLkBXAJTfD6QKGYHWgBgOWAwxBOJ+IBYA4gdMDLjBA6gBIFoAn0IDKC0AdiMQTwTig+hujA8POQCkGIFu/A+kAxlBXsfma6BCRmTjUawGSi4AUolAvAHdHQABBgCc0D1eSogq/QAAAABJRU5ErkJggg%3D%3D';
$blocPlay = '<a class="play playerBtn">►</a><div class="shutUp"><img src="'.$shutSrc.'" alt="mute"/> <a href="#">play</a></div>';
$blocStop = '<a class="play playerBtn" style="padding:5px 14px 6px 16px">■</a><div class="shutUp"><img src="'.$shutSrc.'" alt="mute"/> <a href="#">mute</a></div>';
if(!isset($mp3))
	$mp3 = $defaultSong;	
			
?>
<style type="text/css">
	#player{position:relative;float:right;top:40px;/*;padding:10px 15px 5px 15px;border-radius:8px;box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,0.75), inset 0px 2px 0px 0px rgba(192,192,192,0.5), inset 0px 0px 0px 2px rgba(96,96,96,0.85), 3px 3px 3px 1px rgba(0,0,0,0.15);background:#050505;*/}
	.playerBtn{
		display: inline-block;
		background: #050505;
		color: #858585;
		text-decoration: none;
		font-size: 1.25em;
		padding:6px 9px 5px 13px;
		font-family:Arial;
		outline: 0;
		border-radius:30px;
		box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,0.75), inset 0px 2px 0px 0px rgba(192,192,192,0.5), inset 0px 0px 0px 2px rgba(96,96,96,0.85), 3px 3px 3px 1px rgba(0,0,0,0.15);
		background-image: -moz-linear-gradient(top, #222, #050505);
		background-image: -webkit-linear-gradient(top, #222, #050505);
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#222), to(#050505));
		background-image: -ms-linear-gradient(top, #222, #050505);
		background-image: -o-linear-gradient(top, #222, #050505);
		background-image: linear-gradient(top, #222, #050505);
		text-shadow: -1px -1px 1px rgba(255,255,255,0.5);
	}
	.playerBtn:hover{
		color: #858585;
		text-shadow: -1px -1px 1px rgba(255,255,255,0.5);
		background: #050505;
		box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,0.75), inset 0px 2px 0px 0px rgba(192,192,192,0.5), inset 0px 0px 0px 2px rgba(96,96,96,0.85), 3px 3px 3px 1px rgba(0,0,0,0.15);
		background-image: -moz-linear-gradient(top, #050505, #222);
		background-image: -webkit-linear-gradient(top, #050505, #222);
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#050505), to(#222));
		background-image: -ms-linear-gradient(top, #050505, #222);
		background-image: -o-linear-gradient(top, #050505, #222);
		background-image: linear-gradient(top, #050505, #222);
	}
	.playerBtn:active{
		color:#fff;
		background: #050505;
		box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,0.75), inset 0px 2px 0px 0px rgba(192,192,192,0.5), inset 0px 0px 0px 2px rgba(96,96,96,0.85), 3px 3px 3px 1px rgba(0,0,0,0.15);
		background-image: -moz-linear-gradient(top, #050505, #222);
		background-image: -webkit-linear-gradient(top, #050505, #222);
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#050505), to(#222));
		background-image: -ms-linear-gradient(top, #050505, #222);
		background-image: -o-linear-gradient(top, #050505, #222);
		background-image: linear-gradient(top, #050505, #222);
	}
	.play{}
	.stop{}
	.shutUp{margin-top:-3px;}
		.shutUp a{text-decoration:none;color:#a0a8ab;}
		.shutUp a:hover{text-decoration:none;color:#fff;}
</style>
<div id="player">
	<?=$_COOKIE['isPaused']=='true'?$blocPlay:$blocStop?>
</div>
<audio loop preload="auto">
	<source src="<?=$musicDir.$mp3?>" type='audio/mpeg; codecs="mp3"'>
	<source src="<?=$musidDir.str_replace('mp3','ogg',$mp3)?>" type='audio/ogg; codecs="vorbis"'>
</audio>
<script>
	
	// Flawless player motherfucker
	$(function(){
		$('audio')[0].volume = .5;
		
		if($.cookie('isPaused')=='false' || !$.cookie('isPaused')) {
			$('audio')[0].play();
			var done = false;
			$('audio')[0].addEventListener('canplay',function (){
				if(done) return false;
				
				done = true; 
				var audio = this;
				if($.cookie('mp3') == "<?=$mp3?>") {
					if(parseInt($.cookie('currentTime'))>0)
						this.currentTime = $.cookie('currentTime');
				}
				else {
					// Fondu quand on change de musique subitement
					audio.volume = 0; 
					var fadingInterval = setInterval(function () {
						audio.volume += .01;
						if(audio.volume>=.5)
							clearInterval(fadingInterval);
					},50);	
				}
				this.play();
			});
		}
		 
		$('#player').click(
			function (){
				if($.cookie('isPaused')=='false') {
					$('audio')[0].pause();
					$(this).html('<?=$blocPlay?>');
				}
				else {
					$('audio')[0].play();
					$(this).html('<?=$blocStop?>');
				}
				$.cookie('isPaused',$('audio')[0].paused);
			}
		);
		
		$(window).unload(function () {
			$.cookie('mp3','<?=$mp3?>');
			$.cookie('currentTime',$('audio')[0].currentTime?$('audio')[0].currentTime:false);
		});
		
	});
</script>

