<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class GoodsModel extends Model{
    //字段映射
    protected $_map = array(
      // 先写name属性 然后写对应的字段
      'name'          => 'goods_name',
      'price'         => 'goods_price',
      'amount'        => 'goods_amount',
      'weight'        => 'goods_weight',
      'show'          => 'is_show',
      'type'          => 'type_id',
    );
    //自动验证
    protected $_validate = array(
      //权限名称必须 唯一
      array('goods_name','require','商品名不能为空!'),
      array('goods_name','','商品名已被占用!',0,'unique'),
      //price必须是数 可以是小数
      // array('goods_price','number','价格有误!'),//无法校验小数
      array('goods_price','is_numeric','价格有误!',0,'function'),
      //amount
      array('goods_amount','number','数量必须为整数!'),
      array('goods_weight','number','重量必须为整数!'),
      array('is_show','number','非法请求!'),
      array('type_id','number','非法请求!'),
      //商品详情没有要求
    );

    public function saveGoodsLogo(){
      //1、检查商品上传是否成功
      if($_FILES['logo']['error'] != 0){
        //上传文件失败
        return false;
      }
      //2、实例化上传类 进行文件处理
      $upload = new \Think\Upload(array('rootPath'=>'./Public/Uploads/'));
      $result = $upload->uploadOne($_FILES['logo']);
      if($result){
        //3、把图片原图地址拼接出来
        $this->origin = './Public/Uploads/'.$result['savepath'].$result['savename'];
        $this->goods_big_logo = './Public/Uploads/'.$result['savepath'].'big_logo'.$result['savename'];
        $this->goods_small_logo = './Public/Uploads/'.$result['savepath'].'small_logo'.$result['savename'];
        //4、实例化图形类 制作大小logo
        $image = new \Think\Image();
        $image->open($this->origin);
        //大logo 300 * 300
        $image->thumb(300,300);
        $image->save($this->goods_big_logo);
        //小logo 150 * 150
        $image->thumb(150,150);
        $image->save($this->goods_small_logo);

        //说明图片处理成功并且添加了图片保存路径
        return true;
      }else{
        //移动文件失败
        return false;
      }
    }

    public function saveGoodsAttr($id){
      //数据处理
      //专门处理商品的属性数据
      $attrs = I('post.attr');
      //商品的属性需要进行数据的处理
      //商品属性数据入库的时机 应该是基本信息已经进入goods表之后
      //遍历商品属性数据,并把属性值,转换成字符串
      $data = array();
      foreach($attrs as $k=>$v){
        //1、goods_id
        $data['goods_id'] = $id;
        //2、attr_id
        $data['attr_id'] = $k;
        //3、attr_value
        $data['attr_value'] = implode(',',$v);

        //入库操作
        $result = M('goodsattr')->add($data);

        if(!$result){
          //某条属性入库失败
          return false;
        }
      }
      //遍历结束 所有属性数据入库成功
      return true;
    }
  }
