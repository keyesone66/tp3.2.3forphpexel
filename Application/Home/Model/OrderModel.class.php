<?php

  //命名空间
  namespace Home\Model;
  use \Think\Model;
  use \Tools\Cart;

  //声明当前模型类
  class OrderModel extends Model{
    public function saveOrderInfo(){
      //观察订单基本数据表 查看必要字段 不允许为空 没有默认值
      //user_id order_number order_price cgn_id add_time upd_time
      //AR模式数据操作
      $this->user_id = session('uid');
      $this->order_number = "szphp8".time();
      //从购物车类
      $cart = new Cart();
      $this->order_price = $cart->getNumberPrice()['price'];
      //模拟收件地址主键
      $this->cgn_id = 1;

      $this->add_time = time();
      $this->upd_time = time();
      //成功 自增长id 失败 false
      return $this->add();
    }

    public function saveGoodsInfo($order_id){
      //从购物车类
      $cart = new Cart();
      $goods = $cart->getCartInfo();
      // dump($goods);
      //遍历购物车数据,每个商品新增一条记录
      //把商品数据 写入 order_goods
      $m = M('order_goods');
      //准备一个信息数据,用于新增记录
      $data = array();
      foreach($goods as $k=>$v){
        //观察数据表,找出必要字段
        //order_id goods_id goods_price goods_number goods_total_price
        $data['order_id'] = $order_id;
        $data['goods_id'] = $k;
        $data['goods_price'] = $v['goods_price'];
        $data['goods_number'] = $v['goods_buy_number'];
        $data['goods_total_price'] = $v['goods_total_price'];
        //失败 false 成功 自增长id
        if(!$m->add($data)){
          //新增记录失败,执行return关键字,函数执行结束了
          return false;
        }
        //新增记录成功,继续循环往下做
      }
      //所有记录新增成功,返回true
      return true;
    }
  }
