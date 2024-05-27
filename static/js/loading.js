// var loader;
// function init() {

// 	loader = new createjs.LoadQueue(false);
// 	loader.addEventListener("fileload", handleFileLoad);
// 	loader.addEventListener("complete", handleComplete);
// 	loader.addEventListener("progress", handleFileProgress);
// 	loader.loadManifest(manifest);
// }

// function handleFileProgress(event) {
// 	var percent = loader.progress*100|0;
// 	// console.log(percent+'% loaded.');
// 	$('#process').text('玩命加载中...('+percent+'%)');
// }

// function handleFileLoad(evt) {
// 	//console.log(evt);
// }

// function handleComplete() {
// 	$('#mask,#process').hide();//隐藏加载层
// 	aniFunc();
// }

// $(document).ready(function(){
// 	$('#mask,#process').show();
// 	init();
// });

var manifest2 = [];
manifest.forEach(function(value, index, array) {
	manifest2.push(array[index]['src']);
});

/*! preload-image.js v1.0.0 By TAKANASHI Ginpei */
/*  https://github.com/ginpei/preload-image.js  */
function preloadImages(n){function e(e){s({event:e,files:n,
loadeds:i})}function o(o){var s=new Image;s.onload=function(){i.
push(o),r({files:n,image:s,loadeds:i,path:o}),i.length<n.length
||t({files:n,loadeds:i})},s.onerror=e,s.src=o}for(var r,t,s,i=[]
,l={files:n,loadeds:i,onprogress:function(n){return r=n,this},
onload:function(n){return t=n,this},onerror:function(n){return s
=n,this}},a=0,u=n.length;u>a;a++)o(n[a]);return l}

$(document).ready(function(){
	preloadImages(manifest2)

		.onprogress(function(data) {
			var loaded = data.loadeds.length;
			var all = data.files.length;
			var progress = parseInt(100 * loaded / all, 10);
			console.log(
				data.path, 'is loades.',
				'Status:', loaded + '/' + all, '(' + progress + '%)'
			);
			// // show image on browser
			// document.body.appendChild(data.image);
			$('#process').text('玩命加载中...('+progress+'%)');
		})
		.onload(function(data) {
			console.log('Done.');
			$('#mask,#process').hide();//隐藏加载层
			aniFunc();
		})
		.onerror(function(data) {
			console.error('ERROR!', data.event);
		});
});