<?php
  //命名空间
  namespace Admin\Controller;

  use Think\Controller;

  //创建当前控制器类
  class CommonController extends Controller{
    public function _initialize(){
      //登录验证 可以通过 session信息判定
      if(!session('?id')){
        //跳转到登录页面
        $this->redirect('Public/login');
      }

      //权限防火墙
      //查询用户的角色id
      $role = M('manager')->field('role_id')->find(session('id'))['role_id'];
      if($role !== '1'){
        //如果是非超级管理员
        //根据角色,查询权限
        $ac = M('role')->field('role_auth_ac')->find($role)["role_auth_ac"];

        //为了避免大小写的问题 统一全小写 添加首页默认权限
        $ac = strtolower($ac).',index-index,index-left,index-main,index-top';

        //把权限字符串分隔成数组
        $ac = explode(',',$ac);

        //获取当前用户访问的控制器和方法
        $currentAc = strtolower(CONTROLLER_NAME.'-'.ACTION_NAME);

        //查看当前请求的功能是否在权限数组中
        if(!in_array($currentAc,$ac)){
          //禁止执行
          //因为请求项目的,除了普通请求,还有异步请求
          if(!IS_AJAX){
            //没有权限 默认跳转到首页
            // $this->redirect('index/index');

            //对自身进行XSS攻击
            echo "<script>top.location='".U('index/index')."'</script>";
          }//ajax请求,不给出任何响应
          exit;
        }
      }
      //如果是超级管理员 默认具备所有权限
    }
  }
