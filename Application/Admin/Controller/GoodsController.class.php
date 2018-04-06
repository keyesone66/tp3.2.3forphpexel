<?php
  //命名空间
  namespace Admin\Controller;

  use Think\Controller;

  //创建当前控制器类
  class GoodsController extends CommonController{
    public function showlist(){
      //接收keyword关键词参数
      $keyword = I('get.keyword');
      //实例化这次查询的对象
      $m = M('goods');
      //搜索的核心添加一个where子句条件
      if(!empty($keyword)){
        $m->where("goods_name like '%{$keyword}%'");
      }

      //1、查询总记录数
      $count = M('goods')->count();
      //2、实例化分页类 总记录数 每页显示数
      $page = new \Think\Page($count,10);
      //3、产生页码信息 设置页码显示效果
      $page->setConfig('prev','');
      $page->setConfig('next','');
      $page->setConfig('first','首页');
      $page->lastSuffix = false;
      $page->setConfig('last','末页');
      $this->assign('pages',$page->show());
      //4、分页的核心是 得到limit子句的两大条件 offset length

      //搜索的核心添加一个where子句条件
      if(!empty($keyword)){
        $m->where("goods_name like '%{$keyword}%'");
      }

      //查询商品数据
      //select g.*,t.type_name from sp_goods as g left join sp_type as t on g.type_id = t.type_id
      //select之后 from之前的 属于 字段列表 field
      //from之后的 where之前的 属于 数据源 table
      $goods = $m->field('g.*,t.type_name')
      ->table('sp_goods as g left join sp_type as t on g.type_id = t.type_id')
      ->limit($page->firstRow,$page->listRows)
      ->select();
      //分配模板变量
      $this->assign('goods',$goods);
      //分配总记录数
      $this->assign('count',$count);
      $this->display();
    }

    public function add(){
      if(IS_POST){
        //实例化自定义模型
        $m = D('goods');
        //快速创建数据
        if($m->create()){
          //数据的处理
          //判断是否上传商品图标
          // dump($_FILES);
          if($_FILES['logo']['error'] != '4'){
            //用户上传了商品图标
            //控制器 主要负责 业务逻辑管控 显示模板 调用模型
            //模型 主要负责 复杂的数据处理
            $result = $m->saveGoodsLogo();
            if(!$result){
              //在图片上传或图形处理的过程中发生了问题
              $this->error('商品图标上传失败,请稍后再试!');
            }
            //图标上传成功,logo制作成功,图片路径已经添加到AR模式模型字段中
          }
          // dump($m->data());
          $m->add_time = time();
          $m->upd_time = time();
          $m->goods_introduce = filterXSS($_POST['introduction']);

          // dump($m->data());exit;

          $goods_id = $m->add();
          if($goods_id){
            //数据的处理复杂到一定程度时,应该让模型自定义方法来处理
            //如果新增成功的话,就会获得商品自增长id
            $result = $m->saveGoodsAttr($goods_id);
            if($result){
              //商品基本信息和属性信息都入库成功
              $this->success('商品添加成功!',U('showlist'));
            }else{
              //商品基本信息入库成功 属性信息入库失败
              $this->error('商品添加失败,请稍后再试!');
            }
          }else{
            $this->error('商品添加失败,请稍后再试!');
          }
        }else{
          $this->error($m->getError());
        }

        //采用原生post方法接收数据
        // $m = M('goods');
        // // dump($_POST);
        // $m->goods_name = $_POST['name'];
        // $m->add_time = time();
        // $m->upd_time = time();
        //
        // $m->add();
      }else{
        //查询当前可用的商品分类
        $types = M('type')->select();
        //分配
        $this->assign('types',$types);
        //显示
        $this->display();
      }
    }

    public function photos(){
      if(IS_POST){
        //接收商品id
        $id = I('post.id');
        //实例化自定义模型
        $m = D('goodspics');//Goods Goodspics
        //调用保存相册图片方法
        $result = $m->saveGoodsPics($id);
        if($result){
          $this->success('商品相册添加成功!');
        }else{
          $this->error('商品相册添加失败,请稍后再试!');
        }
      }else{
        //接收当前商品的id
        $id = I('get.id');
        //查询 goodspics表 获得该商品对应的商品图片
        $pics = M('goodspics')->field("pics_id,pics_mid")->where("goods_id = '{$id}'")->select();
        //分配模板变量
        $this->assign('pics',$pics);
        $this->display();
      }
    }

    public function deletePic(){
      //接收要删除的图片id
      $id = I('get.id');

      //尝试删除
      $result = M('goodspics')->delete($id);

      //false 1 0
      if($result !== false){
        //1 0 这个图片没有了
        echo true;
      }else{
        //删除执行失败
        echo false;
      }
    }

    public function getAttr(){
      //获取分类id,查询属性表,返回属性数据
      $type = I('get.type');

      //查询属性表,返回属性数据
      $attrs = M('attribute')->where("type_id = '{$type}'")->select();

      //返回响应 json
      echo json_encode($attrs);
    }
  }
