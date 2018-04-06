<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function register(){
      if(IS_POST){
        //注册功能 新增功能 对应 用户表的新增功能
        //实例化自定义模型 字段映射 自动验证
        $m = D('user');
        //快速创建数据 create
        if($m->create()){
          //数据处理
          $m->add_time = time();
          $m->user_pwd = getPwd($m->user_pwd);
          if($m->add()){
            $this->success('注册成功,请登录!',U('user/login'));
          }else{
            $this->error('服务器正忙,请稍后再试!');
          }
        }else{
          $this->error($m->getError());
        }
      }else{
        $this->display();
      }
    }
    public function login(){
      if(IS_POST){
        //接收用户名和密码
        $user = I('post.username');
        $pwd = getPwd(I('post.password'));

        //查询用户数据
        $data = M('user')->where("user_name = '{$user}' && user_pwd ='{$pwd}'")->find();

        if($data){
          //登录成功,往session存储一些基本信息
          session('uid',$data['user_id']);
          session('uname',$data['user_name']);

          //登录成功后跳转
          $url = empty(I('post.history')) ? 'index/index' : I('post.history');
          $this->redirect($url);
        }else{
          $this->error('登录信息有误,请重试!');
        }
      }else{
        $this->display();
      }
    }

    public function captcha(){
      //1、设置验证码配置项
      $config = array(
        'fontSize'  =>  20,              // 验证码字体大小(px)
        'useCurve'  =>  true,            // 是否画混淆曲线
        'useNoise'  =>  true,            // 是否添加杂点
        'imageH'    =>  0,               // 验证码图片高度
        'imageW'    =>  0,               // 验证码图片宽度
        'length'    =>  4,               // 验证码位数
        'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
      );
      //2、实例化验证码类
      $verify = new \Think\Verify($config);
      //3、获取验证码图片响应
      $verify->entry();
      //验证码数据加密后存储在session
    }

    public function check(){
      //1、作验证码配置项
      $config = array(
        'reset'     =>  false,           // 验证成功后是否重置
      );
      //2、实例化
      $verify = new \Think\Verify($config);
      //3、检查验证码 check
      if($verify->check(I('get.captcha'))){
        echo 1;
      }else{
        echo 0;
      }
    }

    public function logout(){
      //清除session数据
      session(null);
      //清除cookie数据 因为session PHPSESSID 保存在浏览器的cookie中
      cookie(null);
      //退出之后 跳转到登录页面
      $this->redirect('User/login');
    }
}
