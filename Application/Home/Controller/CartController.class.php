<?php
namespace Home\Controller;
use Think\Controller;
use Tools\Cart;

class CartController extends CommonController {
  //利用tp中构造方法的替代品
   public function _initialize(){
     //登录验证
     if(!session('?uid')){
       //让用户先登录
       $this->redirect('user/login');
     }
   }

   public function test(){
     dump(session());
   }

   public function add(){
     // dump(I('get.'););
     $data = I('get.');
     //可以接受商品的id 商品购买的数量
     //但是其他数据,应该从数据库中去查询
     $goods_id = $data['id'];
     $goods_buy_number = $data['amount'];
     //统计需要字段 goods_name goods_total_price
     $result = M('goods')->field('goods_name,goods_price')->find($goods_id);
     $goods_price = $result['goods_price'];
     $goods_name = $result['goods_name'];
     $goods_total_price = $goods_price*$goods_buy_number;

     //实例化购物车类
     $cart = new Cart();
     $cart->add(array('goods_id'=>$goods_id,'goods_name'=>$goods_name,'goods_price'=>$goods_price,'goods_buy_number'=>$goods_buy_number,'goods_total_price'=>$goods_total_price));

     //从购物车类中,取出已选购商品的数据
     echo json_encode($cart->getNumberPrice());
   }

   public function flow1(){
     //实例化购物车类
     $cart = new Cart();

     //从购物车中取出信息
     $goods =$cart->cartInfo;
     //实例化商品表模型
     $m = M('goods');

     //遍历购物车数据
     foreach($goods as $k => $v){
       //为购物车中的商品添加一条商品图标数据
       $goods[$k]['goods_small_logo'] = $m->field('goods_small_logo')->find($k)['goods_small_logo'];
     }
     $this->assign('goods',$goods);

     dump($goods);
     $this->display();
   }

   public function delete(){
     //接收商品id
     $goods_id = I('get.id');

     //实例化购物车类
     $cart = new Cart();

     $cart->del($goods_id);
   }

   public function change(){
     //接收数据
     $goods_id = I('get.id');
     $goods_buy_number = I('get.amount');

     //实例化购物车类
     $cart = new Cart();

     $cart->changeNumber($goods_buy_number,$goods_id);
   }

   public function flow2(){
     //实例化购物车类
     $cart = new Cart();
     // dump($cart->getCartInfo());
     $goods = $cart->getCartInfo();
     //遍历购物车商品信息,为每条商品都补充一些数据 商品smalllogo 对应的商品详情跳转路径
     $m = M('goods');
     foreach($goods as $k => $v){
       $goods[$k]['goods_small_logo'] = $m->field('goods_small_logo')->find($k)['goods_small_logo'];
       $goods[$k]['detail_url'] = U('goods/detail',"id={$k}");
       // $goods[$k]['detail_url'] = U('goods/detail',array('id'=>$k));
     }

     //需要选购商品的总价
     $total = $cart->getNumberPrice();
     $this->assign('total',$total);

     //模拟快递费用
     $this->assign('express','18.00');

     $this->assign('goods',$goods);
     $this->display();
   }

   public function flow3(){
     $this->display();
   }
}
