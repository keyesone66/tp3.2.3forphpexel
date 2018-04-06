<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _empty(){
      //进行很多种处理
      //错误提示
      //跳转到首页
      // $this->redirect('index/index');
      //404页面
      $this->display('Error/404');
    }
}
