<?php
  //命名空间
  namespace Admin\Controller;

  use Think\Controller;

  //创建当前控制器类
  class PublicController extends Controller{
    //创建一个形参 $password
    public function verify($password=''){
      //两种调用形式;
        //1、ajax异步请求 没有传参 但是有get数据
        //2、代码中手动调用 会有传参

      //判断当前是否传参$password 有 说明代码手动调用 没有 说明是异步请求
      $pwd = empty($password) ? getPwd(I('get.pwd')) : getPwd($password);
      //获得当前用户名
      $user = session('name');

      //查询数据库中是否有这条记录
      $count = M('manager')->where("mg_name ='{$user}' && mg_pwd = '{$pwd}'")->count();//0 1

      //echo是为ajax响应准备的
      //手动调用需要return返回值
      if(IS_AJAX){
        //异步请求
        echo $count;
      }else{
        //手动调用
        return $count;
      }
    }
    public function login(){
      //判断普通get请求和post提交登录信息
      if(IS_POST){
        //接收用户名和密码
        $user = I('post.username');
        $pwd = getPwd(I('post.password'));

        //查询管理员表中是否有这个人
        $m = M('manager');
        $result = $m->field("mg_id,mg_name,mg_time,role_id")->where("mg_name = '{$user}' && mg_pwd = '{$pwd}'")->find();

        if($result){
          //往session中写入用户信息
          //记录用户名 上次登录时间
          session('name',$result['mg_name']);
          session('id',$result['mg_id']);
          session('roleId',$result['role_id']);
          //先读取上次登录时间
          session('lastTime',$result['mg_time']);
          //更新本次登录时间
          $m->mg_time = time();

          //加载用户的权限信息:
          //1、查询该用户的角色id
          //判断当前用户是否是超管
          if($m->role_id == '1'){
            //如果是超管 默认分配所有权限
            $auths = M('auth')->select();
            session('auths',$auths);
          }else{
            //如果不是超管 查询具体权限
            //根据角色id 查询角色表 查询auth_ids
            $ids = M('role')->field('role_auth_ids')->where("role_id = '{$m->role_id}'")->find()["role_auth_ids"];
            //根据ids 查询权限表
            $auths = M('auth')->where("auth_id in ({$ids})")->select();
            session('auths',$auths);
          }

          // $m->save();//save方法要求必须有主键信息
          //save的返回值有false 0 1
          //false说明sql执行失败
          //更新这条记录,受影响行数为0 数据根本没改
          //更新这条记录,受影响行数为1 修改成功
          $result = $m->save();
          if($result!==false){
            //登录成功
            $this->redirect("index/index");
          }else{
            //登录失败 用户名密码正确 但是加载用户信息失败
            $this->error('服务器正忙,请稍后再试!');
          }
        }else{
          //登录失败 账号或密码错误
          $this->error('登录信息错误!');
        }
      }else{
        //显示登录表单
        $this->display();
      }
    }
  }
