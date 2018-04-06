<?php
/* *
 * 功能：支付宝电脑支付调试入口页面
 * 修改日期：2017-03-30
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

?>
	<form action=pagepay/pagepay.php method=post>
	  <input id="WIDout_trade_no" name="WIDout_trade_no" />
	  <input id="WIDsubject" name="WIDsubject" />
	  <input id="WIDtotal_amount" name="WIDtotal_amount" />
	  <input id="WIDbody" name="WIDbody" />
	</form>
	//提交的地址 pagepay/pagepay.php
	//请求的方式 post
	//有4个请求数据
		//1、WIDout_trade_no 商户订单号
		//2、WIDsubject 订单名称
		//3、WIDtotal_amount 支付金额
		//4、WIDbody 商品描述
