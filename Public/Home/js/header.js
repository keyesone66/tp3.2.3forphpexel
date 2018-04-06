/*
@功能：头部js
@作者：diamondwang
@时间：2013年11月13日
*/
/* 注意，要在页面中先引入jquery*/
$(function(){
	//搜索框，注意此处，获取文本框的默认值使用defaultValue属性，但是只能通过this.defaultValue，不能使用$(this).defalutValue。
	$(".search_form .txt").focus(function(){
		if ($(this).val() == this.defaultValue){
			$(this).val("").css({color:"#333"});
		}
	}).blur(function(){
		if ($(this).val() == ""){
			$(this).val(this.defaultValue).css({color:"#999"});
		}
	});
	//头部用户
	$(".user").mouseover(function(){
		$(this).find("dd").show();
		$(this).find("dt").addClass("on");
	}).mouseout(function(){
		$(this).find("dd").hide();
		$(this).find("dt").removeClass("on");
	});

	//购物车
	$(".cart").mouseover(function(){
		$(this).find("dd").show();
		$(this).find("dt").addClass("on");
	}).mouseout(function(){
		$(this).find("dd").hide();
		$(this).find("dt").removeClass("on");
	});

	//导航菜单效果
	$(".cat").hover(function(){
		$(this).find(".cat_detail").show();
		$(this).find("h3").addClass("on");
	},function(){
		$(this).find(".cat_detail").hide();
		$(this).find("h3").removeClass("on");
	});

	//非首页，导航菜单显隐效果
	$(".cat1").hover(function(){
		//给cat_hd添加on 移除off
		$(".cat1 .cat_hd").addClass("on").removeClass("off");
		//把cat_bd 显示出来
		$(".cat1 .cat_bd").show();
	},function(){
		//给cat_hd添加off 移除on
		$(".cat1 .cat_hd").addClass("off").removeClass("on");
		//把cat_bd 隐藏起来
		$(".cat1 .cat_bd").hide();
	});

	//如果cat_hd 有off类 默认把cat_bd隐藏起来
	//在页面载入时,判断cat_hd是否有off类,如果有,直接把cat_bd隐藏起来
	if($(".cat1 .cat_hd").hasClass('off')){
		//把cat_bd 隐藏起来
		$(".cat1 .cat_bd").hide();
	}


});
