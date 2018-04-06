<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends CommonController {
    public function showlist(){
      //查询商品的基本数据 显示商品购买入口
      $goods = M('goods')->field('goods_name,goods_id,goods_price,goods_big_logo')->select();
      $this->assign('goods',$goods);
      $this->display();
    }
    public function detail(){
      //接收要浏览的商品id
      $id = I('get.id');
      //1、查询商品基本信息 字段统计 goods_id,goods_name,goods_price,add_time,goods_introduce
      $info = M('goods')
      ->field('goods_id,goods_name,goods_price,add_time,goods_introduce')
      ->where("goods_id='{$id}'")
      ->find();

      $this->assign('info',$info);
      //2、查询商品相册表 字段统计 pics_big,pics_mid,pics_sma
      $photos = M('goodspics')
      ->field('pics_big,pics_mid,pics_sma')
      ->where("goods_id = '{$id}'")
      ->select();
      $this->assign('photos',$photos);

      //3、查询商品属性表 和 属性表 字段统计
      $attrs = M()->query("select ga.attr_value,a.attr_sel,a.attr_name from sp_goodsattr as ga left join sp_attribute as a on ga.attr_id = a.attr_id where ga.goods_id = '{$id}'");
      // dump($attrs);exit;
      //数据处理,遍历$attrs,把当中的属性值以逗号分割成数组
      foreach($attrs as $k => $attr){
        $attrs[$k]['attr_value'] =  explode(',',$attr['attr_value']);
      }
      $this->assign('attrs',$attrs);
      // dump($attrs);exit;
      $this->display();
    }

}
