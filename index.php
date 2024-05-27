<?php 
require('core.php');
C(require('config.php'));
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo C('webname')?></title>
    
    <script>
/*localStorage*/
(function(window,localStorage,undefined){
var LS = {
    set : function(key, value){
        //在iPhone/iPad上有时设置setItem()时会出现诡异的QUOTA_EXCEEDED_ERR错误
        //这时一般在setItem之前，先removeItem()就ok了
        if( this.get(key) !== null )
            this.remove(key);
        localStorage.setItem(key, value);
    },
    //查询不存在的key时，有的浏览器返回undefined，这里统一返回null
    get : function(key){
        var v = localStorage.getItem(key);
        return v === undefined ? null : v;
    },
    remove : function(key){ localStorage.removeItem(key); },
    clear : function(){ localStorage.clear(); },
    each : function(fn){
        var n = localStorage.length, i = 0, fn = fn || function(){}, key;
        for(; i<n; i++){
            key = localStorage.key(i);
            if( fn.call(this, key, this.get(key)) === false )
                break;
            //如果内容被删除，则总长度和索引都同步减少
            if( localStorage.length < n ){
                n --;
                i --;
            }
        }
    }
},
j = window.jQuery, c = window.Core;
//扩展到相应的对象上
window.LS = window.LS || LS;
//扩展到其他主要对象上
if(j) j.LS = j.LS || LS;
if(c) c.LS = c.LS || LS;
})(window,window.localStorage);
</script>
		 
    <link rel="stylesheet" href="static/css/swiper.min.css">
    <link rel="stylesheet" href="static/css/common_mobile-1.0.0.css">
    <link rel="stylesheet" href="static/css/index-1.0.0.css">
    <link href="static/css/common.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        html{ overflow-y:scroll}
        #box{width:100%; position: relative; margin: 10px auto;}
        a{ text-decoration:none}
        p{ margin:0px; padding:0px;}
        ul,li{
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .Detail ul li {
            display: inline-block;
            background-color: rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            width: 27%;
            padding: 2%;
            text-align: center;
            margin: 0 0 2% 1%;
        }
        #roll {
            overflow: hidden;
            position: relative;
            width: 100%;
            height: 16.01333333rem
        }
        #mask{
            opacity: 1;
        }
        .scroll ul li {
          position: relative;
          height: 26px;
          top: 0;
          text-align: center;
          font-size: 0.29333333rem;
          line-height: 0.53333333rem;
          color: #fff;
          text-shadow: none;
          -o-transition: all 0.5s ease-in-out;
          -ms-transition: all 0.5s ease-in-out;
          -moz-transition: all 0.5s ease-in-out;
          -webkit-transition: all 0.5s ease-in-out;
          transition: all 0.5s ease-in-out;
        }
    </style>
    <!-- 移动端适配 -->
    <script>
        var html = document.querySelector('html');
        changeRem();
        window.addEventListener('resize', changeRem);

        function changeRem() {
            var width = html.getBoundingClientRect().width;
            html.style.fontSize = width / 10 + 'px';
        }
    </script>
    <script src="static/js/sweetalert.min.js"></script>
    <script src="static/js/jquery.min.js"></script>
    <script>
        var manifest = [
            {id:"myPath", src:"static/image/choujiang.png"},
            {id:"myPath", src:"static/image/coin.png"},
            {id:"myPath", src:"static/image/dark.png"},
            {id:"myPath", src:"static/image/light.png"},
            {id:"myPath", src:"static/image/normal.png"},
            {id:"myPath", src:"static/image/select.png"},
            {id:"myPath", src:"static/image/start.png"},
            {id:"myPath", src:"static/image/rule.png"},
            {id:"myPath", src:"static/image/my.png"},
            {id:"myPath", src:"static/image/redPack/bottom.png"},
            {id:"myPath", src:"static/image/redPack/button.png"},
            {id:"myPath", src:"static/image/redPack/close.png"},
            {id:"myPath", src:"static/image/redPack/dianzhui.png"},
            {id:"myPath", src:"static/image/redPack/gold.png"},
            {id:"myPath", src:"static/image/middle.png"},
            {id:"myPath", src:"static/image/top.png"},
            {id:"myPath", src:"static/image/star1.png"},
            {id:"myPath", src:"static/image/star2.png"},
            {id:"myPath", src:"static/image/close.png"},
            {id:"myPath", src:"static/image/drag_box.png"},
        ];
    </script>
    <script src="static/js/loading.js"></script>
    <link href="static/css/animate.min.css" rel="stylesheet">
    <script src="static/js/animo.min.js"></script>
    <script src="static/js/common.js"></script>
    <script>
    var aniFunc=function(){
        $('.boxx').animo( { animation: 'zoomIn', duration: 0.8 }, function() {
            $('#btn').animo( { animation: 'tada' } );
        });
    }
    var isfan = 0;
    var loclottery = 1;
    var loclottery2 = 1;
    var loclottery3 = 1;
    $(document).ready(function(){
                                    });
    window.onload = function(){
        var minImgHeight = 0;
        var maxImgHeight = 0;
        $('.imgCont').each(function(index, val) {
            var curHeight = $(this).height();
            if(index==0)maxImgHeight = minImgHeight = curHeight;
            if(curHeight<minImgHeight)minImgHeight=curHeight;
            if(curHeight>maxImgHeight)maxImgHeight=curHeight;
        });
        $('.imgCont').height(maxImgHeight);
        $(".swiper-slide img").bind("click", function () {
            $(this).ImgZoomIn();
        });
    }
    </script>
</head>

<body>
    <ul class="bg-bubbles" style="display:none">
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
        <li><img src=""></li>
    </ul>
    <script>
        </script>
    <div id="roll" style="display:block">
        <!-- <p class="time">3.10-3.25</p> -->
        <!--星星-->
        <div class="stars-box">
            <span class="stars"></span>
            <span class="stars"></span>
            <span class="stars"></span>
            <span class="stars"></span>
            <span class="stars"></span>
            <span class="stars"></span>
            <span class="stars"></span>
        </div>
        <!--主体-->
        <div class="main">
            <p class="rule" style="display:block"></p>
            <p class="my" style="display:block"></p>
            <!--游戏区域-->
            <div class="boxx">
                <span class="coin"></span>
                                <h2>已有 <span><?php echo (int)C('cjrs')+D('lottory','',3)?></span> 人参与</h2>
                                <ul class="light clearfix">
                    <li class="fl">
                        <p></p>
                        <p class="blin"></p>
                        <p></p>
                        <p class="blin"></p>
                    </li>
                    <li class="fr">
                        <p class="blin"></p>
                        <p></p>
                        <p class="blin"></p>
                        <p></p>
                    </li>
                </ul>
				
<?php 
$l = D('award',array('order'=>'rotate'));
?>
                <!--九宫格-->
                                <ul class="play clearfix">
								
                    <li class="prize select">
                        <div>
                            <img src="<?php echo $l[0]['pic']?>">
                            <p></p>
                        </div>
                    </li>
					
                    <li class="prize">
                        <div>
                            <img src="<?php echo $l[1]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                    <li class="prize">
                        <div>
                            <img src="<?php echo $l[2]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="<?php echo $l[3]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                    <!--开始按钮-->
                    <li id="btn"></li>
                    <!--开始按钮-->
                    <li class="prize">
                        <div>
                            <img src="<?php echo $l[4]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                    <li class="prize">
                        <div>
                            <img src="<?php echo $l[5]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="<?php echo $l[6]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                    <li class="prize">
                        <div>
                            <img src="<?php echo $l[7]['pic']?>">
                            <p></p>
                        </div>
                    </li>
                </ul>
            </div>
            <!--奖品展示-->
                        <div class="awards">
                <div class="swiper-container">
                    <ul class="swiper-wrapper">
					     <?php foreach(D('award',array('order'=>'id','limit1'=>0,'limit2'=>12)) as $k=>$v){?>
                        <li class='swiper-slide'><img text='<?php echo $v['name']?>' src='<?php echo $v['pic']?>'></li><?php }?></ul>
                </div>
            </div>
                    </div>
        <!--游戏规则弹窗-->
        <div id="mask-rule">
            <div class="box-rule">
                <span class="star"></span>
                <h2>活动说明</h2>
                <span id="close-rule"></span>
                <div class="con">
                    <div class="text">
                        <?php echo str_htmldecode(C('info'))?>                       <br>
                                                <div id="times">
                            <div style="display:none">
                                今日还有 <span id="curtimes7">999999</span> 次抽奖机会<br>
                            </div>
                            <div style="display:none">
                                剩余总抽奖次数：<span id="curtimes5">999999</span><br>
                            </div>
                                                                                    <div style=" display:none">
                                每天可抽奖次数：999999次，您今天已抽奖<span id="curtimes2">0</span>次
                            </div>
                            <div style=" display:none">
                                总共可抽奖次数：999999，您总共已抽奖<span id="curtimes4">0</span>次
                            </div>
                        </div>
                                                                        <hr class="hr0">
                        活动时间：<br>2018-08-08 08:00至2088-08-08 08:00                        <br><br>
                                            </div>
                </div>
            </div>
        </div>
        <!--中奖记录弹窗-->
        <div id="mask-my">
            <div class="box-my">
                <span class="star"></span>
                <h2>中奖记录</h2>
                <span id="close-my"></span>
                <div class="con">
                    <div class="text">
					 <?php 
						$l = D('lottory',array('ip'=>sys_ip(),'order'=>'id desc','limit1'=>0,'limit2'=>20));
						if(count($l)>0){?> 
						<div class="boxcontent boxwhite" style="margin:0">
                        <div class="box">
						    <?php 
							 
							foreach($l as $k=>$v){?>
                            <div class="Detail">
                                 
                                <b style='color:#000'>奖品：<?php echo $v['award_name']?></b> <span style='color:gray; white-space:nowrap'>[<?php echo $v['adddate']?>]</span><br> <hr>                          
						    </div>
							<?php }?>
                        </div>
                        </div>
						<?php }?>
                                            </div>
                </div>
            </div>
        </div>
        <!--中奖提示-->
        <div id="mask">
            <div class="blin"></div>
            <div class="caidai"></div>
            <div class="winning">
                <div class="red-head"></div>
                <div class="red-body"></div>
                <div id="card">
                    <a href="" target="_self" class="win"></a>
                </div>
                <div class="btn"></div>
                <span id="close"></span>
            </div>
        </div>
    </div>
        <audio style="display:none; height: 0" id="bg-music" preload="auto" src="<?php echo C('bjyy')?C('bjyy'):'static/bg.mp3'?>" loop></audio>
    <div id="musicBtn"></div>
        
    <script type="text/javascript">
                document.body.style.cssText = "background: url(<?php echo C('bjt')?C('bjt'):'static/image/bg.png'?>) #ffca00 no-repeat;background-size: 100% auto; backoverflow-x: hidden; margin:0; padding:0;";
        $(document).ready(function(){
        $("#share").click(function(){
            $("#mask").show();
            $("#tip").show();
            scroll(0,0);
            return false;
        });
        $("#mask").click(function(){
            return;
            if($("#mask").is(":visible")){
                $("#mask").hide();
                $("#tip").hide();
            }
            return false;
        });
        $("#mask2").click(function(){
            $("#mask2").hide();
            $(".mask-poptip").hide();
        });
    });
    </script>

    <div id="mask"></div>
    <div id="mask2"></div>
        <div id="process">玩命加载中...(1%)</div>

    <div id="tip" style="display: none;">
        <img src="static/picture/tip-share.jpg" style="width:100%">
    </div>

    <div class="mask-poptip" style="display:none">
        <div>长按识别二维码<br>关注开始抽奖哦~<br><br></div><img src="static/picture/picture.jpg">    </div>

    <div id="box">
    
    
    <input type="hidden" id="curtimes1" value="0">
    <input type="hidden" id="curtimes3" value="0">
    <div class="boxcontent boxwhite" id="verify_form" style="display:none">
        <div class="box">
            <div class="title-red">验证抽奖</div>
        <div class="Detail">
        请输入抽奖码        <input type="text" class="px" placeholder="" id="verify_code" value="<?php echo I('cjm')?>">
        <input class="pxbtn" id="verify" type="button" value="确定">
        </div>
        </div>
    </div>
                    <div id="win" style="display:none">
            <div class="boxcontent boxwhite">
                <div class="box">
                    <div class="title-red">您中奖啦</div>
                <div class="Detail">
                <div id="winprize"></div><!--中奖时填充信息-->
                <div id="userinfo">
                  <input type="text" class="px" placeholder="请输入姓名" name="field1" id="field1" value="" style="display:"><input type="text" class="px" placeholder="请输入手机" name="field2" id="field2" value="" style="display:"><input type="text" class="px" placeholder="请输入地址" name="field3" id="field3" value="" style="display:"><input type="text" class="px" placeholder="请输入" name="field4" id="field4" value="" style="display:none"><input type="text" class="px" placeholder="请输入" name="field5" id="field5" value="" style="display:none">                  <input class="pxbtn" id="submitinfo" type="button" value="确定">
                  <input class="pxbtn" id="share" type="button" value="分享活动" style="display:none">
                </div>
                </div>
                </div>
            </div>
        </div>
        
    
    <div class="boxcontent boxwhite" style="display:none">
    <div class="box">
        <div class="title-red">我的积分：</div>
        <div class="Detail">
                        抽奖一次所需积分：0<br>
            您当前积分：<span id="curtimes6">0</span><br><br>                    </div>
    </div>
    </div>

    <div class="scroll">
                <p></p>
                <div>
                    <ul>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div>
			<?php 
			$arr = array();
			$l = D('lottory',array('order'=>'id desc','limit1'=>0,'limit2'=>20));
			foreach($l as $k=>$v){ 
			    $arr[] = '恭喜 '.substr_replace($v['tel'],'*****', 3, 4).' 获得 '.$v['award_name'];
			}?>
			<script> var winArr=<?php echo json_encode($arr);?>;</script> 
			<script>
			 
        console.log(winArr);
        var curwincnt=0;
        if(winArr.length===1){
            $('.scroll li').eq(0).html(winArr[0]);
        }else if(winArr.length===2){
            $('.scroll li').eq(0).html(winArr[0]);
            $('.scroll li').eq(1).html(winArr[1]);
        }else{
            $('.scroll li').eq(0).html(winArr[0]);
            $('.scroll li').eq(1).html(winArr[1]);
            curwincnt=1;
            setInterval(function(){
                curwincnt++;
                if(curwincnt==winArr.length){
                    curwincnt=0;
                }
                showwin(winArr[curwincnt]);
            },2000);
        }
    </script>
    
    
    
    </div>
    <script src="static/js/swiper.jquery.min.js"></script>
    <script src="static/js/h5_game_common-1.0.0.js"></script>
    <script src="static/js/cj.js"></script>
    <script src="static/js/jweixin-1.0.0.js"></script>
    <script>
      wx.config({
        debug: false,
        appId: 'wx442c962c66376ee7',
        timestamp: '1604984452',
        nonceStr: '3CahelTuL0JkfHpT',
        signature: '2f5f4270bdade99698622bb6cb3bb9c3a77770b8',
          jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
            'hideOptionMenu',
            'showOptionMenu',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'closeWindow',
            'openLocation',
            'getLocation'
          ]
      });

      wx.ready(function () {
        wx.hideMenuItems({
            menuList: ["menuItem:favorite","menuItem:editTag","menuItem:delete","menuItem:originPage","menuItem:readMode","menuItem:openWithQQBrowser","menuItem:openWithSafari","menuItem:share:email"]
        });
                var shareData = {
            title: '',
            desc: '',
            link: 'https://wechat.huangxf.com/lottery/lottery/ninegrid/index.php?lid=96',//u=nobody
            imgUrl: '/picture/share.jpg'
        };
        wx.onMenuShareAppMessage({
          title: shareData.title,
          desc: shareData.desc,
          link: shareData.link,
          imgUrl: shareData.imgUrl,
          trigger: function (res) {
          },
          success: function (res) {
                      },
          cancel: function (res) {
          },
          fail: function (res) {
            //alert(JSON.stringify(res));
          }
        });
        wx.onMenuShareTimeline({
          title: shareData.title,
          link: shareData.link,
          imgUrl: shareData.imgUrl,
          trigger: function (res) {
          },
          success: function (res) {
                      },
          cancel: function (res) {
          },
          fail: function (res) {
            //alert(JSON.stringify(res));
          }
        });
        //背景音乐（放在这里苹果设备才能自动播放）
        function playMusic(play){
            var bgMusic = document.getElementById("bg-music");
            if(play==1){
                bgMusic.play();
                if (typeof WeixinJSBridge == "object" && typeof WeixinJSBridge.invoke == "function") {
                    WeixinJSBridge.invoke('getNetworkType', {}, function (res) {
                        bgMusic.play();
                    });
                }
            }else{
                bgMusic.pause();
            }
        }
                $('#musicBtn').addClass('rotate360');
        playMusic(1);
                $('#musicBtn').on('click',function(){
            if($('#musicBtn').hasClass('rotate360')){
                playMusic(0);
                $('#musicBtn').removeClass('rotate360');
                $('#musicBtn').css('background-image','url(static/image/musicOff.png)');
            }else{
                playMusic(1);
                $('#musicBtn').addClass('rotate360');
                $('#musicBtn').css('background-image','url(static/image/musicOn.png)');
            }
        })
      });
    if(window.navigator.userAgent.toLowerCase().indexOf("micromessenger")===-1)
    {
        function playMusic(play){
            var bgMusic = document.getElementById("bg-music");
            if(play==1){
                bgMusic.play();
            }else{
                bgMusic.pause();
            }
        }
                $('#musicBtn').addClass('rotate360');
        playMusic(1);
                $('#musicBtn').on('click',function(){
            if($('#musicBtn').hasClass('rotate360')){
                playMusic(0);
                $('#musicBtn').removeClass('rotate360');
                $('#musicBtn').css('background-image','url(static/image/musicOff.png)');
            }else{
                playMusic(1);
                $('#musicBtn').addClass('rotate360');
                $('#musicBtn').css('background-image','url(static/image/musicOn.png)');
            }
        })
    }
    </script>
    <div style="text-align:center; color:#000;">
更多好东西：<a href="http://www.shiguang666.eu.org/" target="_blank">時光主页</a> </div>
        
        
        
        
        
        
        
        
        
        
        
        
        
</body>
</html>