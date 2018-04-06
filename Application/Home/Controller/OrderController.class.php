<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends CommonController {
    public function add(){
      //由于要处理的字段较多,处理的步骤有一定的复杂度,用自定义模型方法
      //实例化订单模型
      $m = D('order');
      $order_id = $m->saveOrderInfo();

      if($order_id){
        //说明订单基本信息入库了
        //保存订单相关的商品信息
        $result = $m->saveGoodsInfo($order_id);
        if($result){
          //订单基本数据新增成功 商品信息保存成功了
          //订单提价希望用户尽快支付
          $this->pay($order_id);
        }else{
          $this->error('服务器正忙,请稍后再试!');
        }
      }else{
        //基本信息入库失败
        $this->error('服务器正忙,请稍后再试!');
      }
    }

    public function pay($order_id){
      //提交的地址 pagepay/pagepay.php
      //请求的方式 post
      //有4个请求数据
      //获取要请求的数据
        //1、WIDout_trade_no 商户订单号 要根据order_id查出订单号order_number
        $WIDout_trade_no = M('order')->field('order_number')->find($order_id)['order_number'];
        //2、WIDsubject 订单名称
        $WIDsubject = "黑马电商购物";
        //3、WIDtotal_amount 支付金额
        // $WIDtotal_amount = M('order')->field('order_price')->find($order_id)['order_price'];
        $WIDtotal_amount = 1.00;
        //4、WIDbody 商品描述
        $WIDbody = '接口测试';
      //发送到 pagepay/pagepay.php post请求
        //发起post请求 在浏览器上显示一个表单,并自动提交,就相当于强制发起了post请求
        echo "
          <form style='display:none;' id='pay' action='/Application/Tools/alipay/pagepay/pagepay.php' method='post'>
            <input name='WIDout_trade_no' value='{$WIDout_trade_no}'/>
            <input name='WIDsubject' value='{$WIDsubject}'/>
            <input name='WIDtotal_amount' value='{$WIDtotal_amount}'/>
            <input name='WIDbody' value='{$WIDbody}'/>
          </form>
          <script>
            document.getElementById('pay').submit();
          </script>
        ";
    }

    public function check(){
      $order_number = I('post.out_trade_no');
      $order_price = I('post.receipt_amount');

      //根据支付宝平台提供的订单号 和支付金额,验证用户的支付是否完成
      //查询订单基本信息表 sp_order 根据订单号 把支付金额查出来
      $m = M('order');
      $price = $m->field('order_price')->find($order_number)['order_price'];

      if($price == $order_price){
        //支付是成功的 把订单表订单状态改为1
        $m->order_status = '1';
        $m->order_number = $order_number;
        //受影响行数 false
        if(!$m->save()){
          //写警告日志 把事务摆放到待办队列中,在服务器中后续重做。
        }
      }else{
        //支付是有问题的 也许支付通信过程中发生数据非法修改
        //写下一些警告日志 通知客服
      }
    }
}
