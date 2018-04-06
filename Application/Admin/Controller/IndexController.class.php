<?php
  //命名空间
  namespace Admin\Controller;

  use Think\Controller;

  //创建当前控制器类
  class IndexController extends CommonController{
    public function index(){
      $this->display();
    }
  }
