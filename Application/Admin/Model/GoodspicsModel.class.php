<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class GoodspicsModel extends Model{
    //保存商品相册图片的方法
    public function saveGoodsPics($goods_id){
      //操作步骤
      // dump($_FILES);
      //1、检查文件上传是否成功
      foreach($_FILES['photos']['error'] as $v){
        if($v != 0){
          //某个图片上传出错
          return false;
        }
      }
      //2、实例化上传类 调用批量上传方法
      $upload = new \Think\Upload(array('rootPath'=>'./Public/Uploads/'));
      //3、批量上传文件
      $result = $upload->upload($_FILES);
      // dump($result);
      if(!$result){
        //移动临时文件失败
        return false;
      }
      //实例化图形处理类
      $image = new \Think\Image();
      foreach($result as $pic){
        //得到原图的访问地址
        $this->pics_ori = './Public/Uploads/'.$pic['savepath'].$pic['savename'];
        $this->pics_big = './Public/Uploads/'.$pic['savepath'].'big_'.$pic['savename'];
        $this->pics_mid = './Public/Uploads/'.$pic['savepath'].'mid_'.$pic['savename'];
        $this->pics_sma = './Public/Uploads/'.$pic['savepath'].'sma_'.$pic['savename'];
        //根据原图地址 拼接出 大中小 三种图片的地址
        $image->open($this->pics_ori);
        //大 800
        $image->thumb(800,800);
        $image->save($this->pics_big);
        //中 350
        $image->thumb(350,350);
        $image->save($this->pics_mid);
        //小 50
        $image->thumb(50,50);
        $image->save($this->pics_sma);

        //上面的四个图片地址需要入库
        $this->goods_id = $goods_id;

        if(!$this->add()){
          return false;
        }
      }
      //说明所有的图片都处理完毕了
      return true;
    }
  }
