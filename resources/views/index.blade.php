@extends('master')
@section('title')
	乐美
@endsection
@section('content')
	<div class="marginB" id="loadingPicBlock">
	<input type="hidden" id="_token" value="{{csrf_token()}}">
		<!--首页头部-->
		<div class="m-block-header" style="display: none">
			<div class="search"></div>
			<a href="/" class="m-public-icon m-1yyg-icon"></a>
		</div>
		<!--首页头部 end-->

		<!-- 关注微信 -->
		<div id="div_subscribe" class="app-icon-wrapper" style="display: none;">
			<div class="app-icon">
				<a href="javascript:;" class="close-icon"><i class="set-icon"></i></a>
				<a href="javascript:;" class="info-icon">
					<i class="set-icon"></i>
					<div class="info">
						<p>点击关注666潮人购官方微信^_^</p>
					</div>
				</a>
			</div>
		</div>

		<!-- 焦点图 -->
		<div class="hotimg-wrapper">
			<div class="hotimg-top"></div>
			<section id="sliderBox" class="hotimg">
				<ul class="slides" style="width: 600%; transition-duration: 0.4s; transform: translate3d(-828px, 0px, 0px);">
					@foreach($data as $v)
					<li style="width: 414px; float: left; display: block;" class="clone">
						<a href="javascript:;">
							<img src="{{url('images/goodsLogo/'.$v->goods_img)}}" alt="">
						</a>
					</li>
					@endforeach
				</ul>
			</section>
		</div>

		<!--分类-->
		<div class="index-menu thin-bor-top thin-bor-bottom">
			<ul class="menu-list">
				@foreach($cateInfo as $k=>$v)
				<li>
					<a href="{{url('indexshop')}}/{{$v->cate_id}}" id="btnNew">
						<i class="xinpin"></i>
						<span class="title">{{$v->cate_name}}</span>
					</a>
				</li>
				@endforeach
			</ul>
		</div>
		<!--导航-->
		<div class="success-tip">
			<div class="left-icon"></div>
			<ul class="right-con">
				<li>
				<span style="color: #4E555E;">
					<a href="./index.php?i=107&amp;c=entry&amp;id=10&amp;do=notice&amp;m=weliam_indiana" style="color: #4E555E;">恭喜<span class="username">啊啊啊</span>获得了<span>iphone7 红色 128G 闪耀你的眼</span></a>
				</span>
				</li>
				<li>
				<span style="color: #4E555E;">
					<a href="./index.php?i=107&amp;c=entry&amp;id=10&amp;do=notice&amp;m=weliam_indiana" style="color: #4E555E;">恭喜<span class="username">啊啊啊</span>获得了<span>iphone7 红色 128G 闪耀你的眼</span></a>
				</span>
				</li>
				<li>
				<span style="color: #4E555E;">
					<a href="./index.php?i=107&amp;c=entry&amp;id=10&amp;do=notice&amp;m=weliam_indiana" style="color: #4E555E;">恭喜<span class="username">啊啊啊</span>获得了<span>iphone7 红色 128G 闪耀你的眼</span></a>
				</span>
				</li>
			</ul>
		</div>
		<!-- 热门推荐 -->
		<div class="line hot">
			<div class="hot-content">
				<i></i>
				<span>最热商品</span>
				<div class="l-left"></div>
				<div class="l-right"></div>
			</div>
		</div>
		<div class="hot-wrapper">
			<ul class="clearfix">
				@foreach($goodshost as $k=>$v)
				<li style="border-right:1px solid #e4e4e4; ">
					<a href="{{url('shopcontent')}}/{{$v->goods_id}}">
						<p class="title">{{$v->goods_name}}</p>
						<p class="subtitle">{{$v->goods_desc}}</p>
						<img src="{{url('images/goodsLogo/'.$v->goods_img)}}" alt="">
					</a>
				</li>
					@endforeach
			</ul>
		</div>
		<!-- 猜你喜欢 -->
		<div class="line guess">
			<div class="hot-content">
				<i></i>
				<span>猜你喜欢</span>
				<div class="l-left"></div>
				<div class="l-right"></div>
			</div>
		</div>
		<!--商品列表-->
		<div class="goods-wrap marginB">
			<ul id="ulGoodsList" class="goods-list clearfix">
				@foreach($goodsinfo as $k=>$v)
				<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
					<a href="{{url('shopcontent')}}/{{$v->goods_id}}" class="g-pic">
						<img class="lazy" name="goodsImg" data-original="{{url('images/goodsLogo/'.$v->goods_img)}}" width="136" height="136">
					</a>
					<p class="g-name">{{$v->goods_name}}</p>
					<ins class="gray9">价值：￥{{$v->self_price}}</ins>
					<div class="Progress-bar">
						<p class="u-progress">
						<span class="pgbar" style="width: 96.43076923076923%;">
							<span class="pging"></span>
						</span>
						</p>

					</div>
					<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
						<a href="javascript:;" class="buy-btn" codeid="12751965">立即潮购</a>
						<div class="gRate Addcar" codeid="12751965"  canbuy="58" goods_id="{{$v->goods_id}}">
							<a href="javascript:;"></a>
						</div>
					</div>
				</li>
					@endforeach
			</ul>
			<div class="loading clearfix"><b></b>正在加载</div>
		</div>
		<!--底部-->
		<div class="footer clearfix">
			<ul>
				<li class="f_home"><a href="{{url('../')}}" class="hover"><i></i>潮购</a></li>
				<li class="f_announced"><a href="{{url('allshops')}}" ><i></i>所有商品</a></li>
				<li class="f_single"><a href="javacsript:;" ><i></i>晒单</a></li>
				<li class="f_car"><a id="btnCart" href="{{url('shopcart')}}" ><i></i>购物车</a></li>
				<li class="f_personal"><a href="{{url('userpage')}}" ><i></i>我的潮购</a></li>
			</ul>
		</div>
		<div id="div_fastnav" class="fast-nav-wrapper">
			<ul class="fast-nav">
				<li id="li_menu" isshow="0">
					<a href="javascript:;"><i class="nav-menu"></i></a>
				</li>
				<li id="li_top" style="display: none;">
					<a href="javascript:;"><i class="nav-top"></i></a>
				</li>
			</ul>
			<div class="sub-nav four" style="display: none;">
				<a href="#"><i class="announced"></i>最新揭晓</a>
				<a href="#"><i class="single"></i>晒单</a>
				<a href="{{url('userpage')}}"><i class="personal"></i>我的潮购</a>
				<a href="{{url('shopcart')}}"><i class="shopcar"></i>购物车</a>
			</div>
		</div>
	</div>
@endsection

@section('my-js')
	<script>
		$(document).on('click','.Addcar',function(){
       var _this=$(this);
       var goods_id=_this.attr('goods_id');
       var _token=$("#_token").val();
       $.ajax({
        type:"post",
        url:"{{url('addCart')}}",
        data:{_token:_token,goods_id:goods_id},
        dataType:'json',
    }).done(function (res) {
        if(res.code==3){
            layer.msg(res.font,{icon:res.code,time:2000},function () {
                location.href="{{url('login')}}"
            });
        }
        layer.msg(res.font,{icon:res.code});
       })
    })

		$(function () {
			$('.hotimg').flexslider({
				directionNav: false,   //是否显示左右控制按钮
				controlNav: true,   //是否显示底部切换按钮
				pauseOnAction: false,  //手动切换后是否继续自动轮播,继续(false),停止(true),默认true
				animation: 'slide',   //淡入淡出(fade)或滑动(slide),默认fade
				slideshowSpeed: 3000,  //自动轮播间隔时间(毫秒),默认5000ms
				animationSpeed: 150,   //轮播效果切换时间,默认600ms
				direction: 'horizontal',  //设置滑动方向:左右horizontal或者上下vertical,需设置animation: "slide",默认horizontal
				randomize: false,   //是否随机幻切换
				animationLoop: true   //是否循环滚动
			});
			setTimeout($('.flexslider img').fadeIn());
		});

		jQuery(document).ready(function() {
			$("img.lazy").lazyload({
				placeholder : "images/loading2.gif",
				effect: "fadeIn",
			});

			// 返回顶部点击事件
			$('#div_fastnav #li_menu').click(
					function(){
						if($('.sub-nav').css('display')=='none'){
							$('.sub-nav').css('display','block');
						}else{
							$('.sub-nav').css('display','none');
						}

					}
			)
			$("#li_top").click(function(){
				$('html,body').animate({scrollTop:0},300);
				return false;
			});

			$(window).scroll(function(){
				if($(window).scrollTop()>200){
					$('#li_top').css('display','block');
				}else{
					$('#li_top').css('display','none');
				}

			})


		});

	</script>
	<!-- <script type="text/javascript">
		$("#div-header").attr('style'.'display:none');
	</script> -->
	@endsection