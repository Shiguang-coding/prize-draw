function wintipconv(tip,prizepic,prizeremark,prize){
	if(tip.indexOf('【奖品图】')!=-1){
		arr = prizepic.split('||');
		if(arr[prize-1]!=''){
			tip = tip.replace(/【奖品图】/g,'<img height="120" style="display:block;height:120; margin:5px auto" src="'+(arr[prize-1].indexOf("http")===-1?('../../ht/'+arr[prize-1]):arr[prize-1])+'" />');
		}else{
			tip = tip.replace(/【奖品图】/g,'');
		}
	}
	if(tip.indexOf('【提示语】')!=-1){
		arr = prizeremark.split('||');
		if(arr[prize-1]!=''){
			tip = tip.replace(/【提示语】/g,arr[prize-1]);
		}else{
			tip = tip.replace(/【提示语】/g,'');
		}
	}
	return tip;
}

$.fn.ImgZoomIn = function() {
    bgstr = '<div id="ImgZoomInBG" style=" background:#000000; filter:Alpha(Opacity=70); opacity:0.7; position:fixed; left:0; top:0; z-index:10000; width:100%; height:100%; display:none;"><iframe src="about:blank" frameborder="5px" scrolling="yes" style="width:100%; height:100%;"></iframe></div>';
    //alert($(this).attr('src'));
    divStr = '<div id="ImgZoomInDiv" style="cursor:pointer; display:none; position:absolute; z-index:10001; text-align:center; width:80%;"><img style="width:100%" id="ImgZoomInImage" src="' + $(this).attr('src') + '" onclick=$(\'#ImgZoomInDiv\').hide();$(\'#ImgZoomInBG\').hide(); /><br /><span id="ImgZoomInText" style="color:#fff">' + $(this).attr('text') + '</span></div>';
    if ($('#ImgZoomInBG').length < 1) {
        $('body').append(bgstr);
    }
    if ($('#ImgZoomInDiv').length < 1) {
        $('body').append(divStr);
    } else {
        $('#ImgZoomInImage').attr('src', $(this).attr('src'));
        $('#ImgZoomInText').text($(this).attr('text'));
    }
    //alert($(window).scrollLeft());
    //alert( $(window).scrollTop());
    $('#ImgZoomInDiv').css('left', $(window).scrollLeft() + ($(window).width() - $('#ImgZoomInDiv').width()) / 2);
    $('#ImgZoomInDiv').css('top', $(window).scrollTop() + ($(window).height() - $('#ImgZoomInDiv').height()) / 8);
    $('#ImgZoomInBG').show();
    $('#ImgZoomInDiv').show();
};

function getRandNum(m,n){//[m，n)
　　return Math.floor(Math.random()*(m - n) + n);
}

//中奖信息滚动
function showwin(text) {
    var $winli = $('.scroll li');
    //最新中奖信息
    $winli.eq(2).html(text);
    $winli.css("top", "-" + 45 / 75 + "rem");//滚动
    //滚动之后的处理
    setTimeout(function () {
        $winli.css({
            "top": "0",
            "transition": "all 0s ease-in-out"
        });
        //更新中奖信息
        $winli.eq(0).html($winli.eq(1).html());
        $winli.eq(1).html($winli.eq(2).html());
    }, 500);
    $winli.css("transition", "all 0.5s ease-in-out");
}
function showwin2(text) {
    var $winli = $('.info li');
    //最新中奖信息
    $winli.eq(1).html(text);
    $winli.css("top", "-" + 35 / 75 + "rem");//滚动
    //滚动之后的处理
    setTimeout(function () {
        $winli.css({
            "top": "0",
            "transition": "all 0s ease-in-out"
        });
        //更新中奖信息
        $winli.eq(0).html($winli.eq(1).html());
    }, 500);
    $winli.css("transition", "all 0.5s ease-in-out");
}
//获取经纬度坐标
function getPosition (callback) {
    if ("geolocation" in navigator) {
        var geo_options = {
          enableHighAccuracy: true,
          maximumAge: 0,
          timeout : 6000
        };
        navigator.geolocation.getCurrentPosition(function(pos) {
            // 获取到当前位置经纬度
            var lng = pos.coords.longitude;
            var lat = pos.coords.latitude;
            callback(lng,lat);
        }, function(err){
            console.log(err.message);
        }, geo_options);
    } else {
         console.log("Browser didnt support geolocation");
    }
}
//根据经纬度计算地球上两点之间的距离
var EARTH_RADIUS = 6378137.0;//单位M
var PI = Math.PI;
function getRad(d){
    return d*PI/180.0;
}
function getGreatCircleDistance(lat1,lng1,lat2,lng2){//令地球为正圆
    var radLat1 = getRad(lat1);
    var radLat2 = getRad(lat2);
    
    var a = radLat1 - radLat2;
    var b = getRad(lng1) - getRad(lng2);
    
    var s = 2*Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) + Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2)));
    s = s*EARTH_RADIUS;
    s = Math.round(s*10000)/10000.0;
            
    return s;
}
function getFlatternDistance(lat1,lng1,lat2,lng2){//令地球为椭圆
    var f = getRad((lat1 + lat2)/2);
    var g = getRad((lat1 - lat2)/2);
    var l = getRad((lng1 - lng2)/2);
    
    var sg = Math.sin(g);
    var sl = Math.sin(l);
    var sf = Math.sin(f);
    
    var s,c,w,r,d,h1,h2;
    var a = EARTH_RADIUS;
    var fl = 1/298.257;
    
    sg = sg*sg;
    sl = sl*sl;
    sf = sf*sf;
    
    s = sg*(1-sl) + (1-sf)*sl;
    c = (1-sg)*(1-sl) + sf*sl;
    
    w = Math.atan(Math.sqrt(s/c));
    r = Math.sqrt(s*c)/w;
    d = 2*w*a;
    h1 = (3*r -1)/2/c;
    h2 = (3*r +1)/2/s;
    
    return d*(1 + fl*(h1*sf*(1-sg) - h2*(1-sf)*sg));
}

function initBubbles(float,r=1.5,d1=2000,d2=20000) {
  // var float = '<?=htmlspecialchars($turntable['float'], ENT_QUOTES) ?>';
  if (float == '') return false;
  $('.bg-bubbles img').attr('src', float);
  $('.bg-bubbles').show();
  //漂浮物设置
  $('.bg-bubbles li').each(function (k, v) {
    var i = k + 1;
    var delayMin = 200;
    var delayMax = 10000;
    var leftMin = 0;
    var leftMax = 90;
    var durationMin = d1;
    var durationMax = d2;
    var widthMin = 3;
    var widthMax = 6;
    var delay = Math.floor(delayMin + Math.random() * (delayMax - delayMin)) + Math.floor(200 + Math.random() * (200 - 50));
    var left = Math.floor(leftMin + Math.random() * (leftMax - leftMin));
    var duration = Math.floor(durationMin + Math.random() * (durationMax - durationMin)) + Math.floor(1000 + Math.random() * (1000 - 200));
    var width = Math.floor(widthMin + Math.random() * (widthMax - widthMin));
    $('.bg-bubbles li:nth-child(' + i + ')').css({
      "left": left + "%",
      "animation-delay": delay + "ms",
      "animation-duration": duration + "ms",
    });
    $('.bg-bubbles li:nth-child(' + i + ') img').css({
      "width": width / r + 'rem',
    })
  })
}