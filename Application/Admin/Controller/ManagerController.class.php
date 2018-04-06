<?php
  //命名空间
  namespace Admin\Controller;

  use Think\Controller;

  //创建当前控制器类
  class ManagerController extends CommonController{
    public function showList(){
      //查询管理员表数据 连接查询
      $m = M();
      $sql = "select m.mg_id,m.mg_name,m.mg_time,r.role_name from sp_manager as m left join sp_role as r on m.role_id=r.role_id";
      $users = $m->query($sql);
      // dump($users);
      //分配模板变量
      $this->assign('users',$users);
      $this->display();
    }

    public function add(){
      if(IS_POST){
        //数据接收 新增功能 为数据表新增记录
        //实例化自定义模型 写字段映射 验证规则 快速创建数据
        $m = D('manager');

        if($m->create()){
          //数据处理
          $m->mg_time = 0;
          $m->mg_pwd = getPwd($m->mg_pwd);

          //执行入库
          if($m->add()){
            $this->success('用户添加成功!',U('showlist'));
          }else{
            $this->error('用户添加失败,请稍后再试!');
          }
        }else{
          $this->error($m->getError());
        }
      }else{
        //查询所有角色信息
        $roles = M('role')->field("role_name,role_id")->select();
        //模板变量分配
        $this->assign('roles',$roles);
        $this->display();
      }
    }

    public function setPwd(){
      //接收要重置密码的用户id
      $id = I('get.id');

      //生成一个8位的 含有 数字 大小写字母 的随机密码
      //设置一个字符串 0~9a~zA~Z 随机位数
      $pwd = '';

      for($i=0;$i<8;$i++){
        //随机数字、小写、大写
        switch (mt_rand(0,2)) {
          case 0:
            # 添加一个随机数字
            $pwd .= mt_rand(1,9);
            break;
          case 1:
            # 小写字母
            $pwd .= chr(mt_rand(97,122));
            break;
          case 2:
            # 大写字母
            $pwd .= chr(mt_rand(65,90));
            break;
        }
      }

      //对新密码加密更新
      $m = M('manager');

      $result = $m->save(array('mg_id'=>$id,'mg_pwd'=>getPwd($pwd)));
      //false 更新失败 1 更新成功 0 代表记录和原来一样

      if($result){
        echo '新密码: '.$pwd;
      }else{
        //说明更新失败
        echo '重置密码失败,请稍后再试!';
      }
    }

    public function setRole(){
      if(IS_POST){
        //更新操作
        //主键信息
        $m = M('manager');
        $m->mg_id = I('post.id');
        $m->role_id = I("post.role");

        $result = $m->save();

        if($result !== false){
          if($result){
            //1
            $this->success('分配角色成功!',U('showlist'));
          }else{
            //0
            $this->error('角色未改变!');
          }
        }else{
          $this->error('分配角色失败,请稍后再试!');
        }
      }else{
        //接收要分配角色的用户id
        $id = I('get.id');
        //查询用户的角色信息和用户名和用户id
        $user = M('manager')->field('role_id,mg_name,mg_id')->find($id);
        //模板变量分配
        $this->assign('user',$user);
        //查询所有角色信息
        $roles = M('role')->field("role_name,role_id")->select();
        //模板变量分配
        $this->assign('roles',$roles);
        $this->display();
      }
    }

    public function deleteAll(){
      //接收要删除的ids
      $ids = empty(I('get.ids')) ? '0' : I('get.ids');
      //尝试删除
      $result = M('manager')->where("mg_id in ({$ids})")->delete();
      //构建响应数组
      $res = array();

      if($result !== false){
        if($result){
          //受影响行数 删除成功
          $res['result'] = 1;
          $res['error'] = '用户删除成功!';
        }else{
          //0 用户不存在
          $res['result'] = 1;
          $res['error'] = '用户不存在!';
        }
      }else{
        //删除执行sql失败
        $res['result'] = 0;
        $res['error'] = '用户删除失败,请稍后再试!';
      }

      //返回json格式响应
      echo json_encode($res);
    }

    public function changePwd(){
      if(IS_POST){
        //接收旧密码
        $oldPwd = I('post.oldPwd');
        //验证旧密码是否正确
        //实例化Public控制器,调用功能非常相近verify
        if(A('Public')->verify($oldPwd)){
          //旧密码正确,更新新密码
          //获取新密码
          $newPwd = I('post.newPwd');

          //实例化管理员表模型
          $m = M('manager');
          $m->mg_id = session('id');
          $m->mg_pwd = getPwd($newPwd);

          $result = $m->save();
          if($result !== false){
            if($result){
              //1
              $this->success('修改密码成功!',U('index/main'));
            }else{
              //0
              $this->error('新密码与旧密码相同!');
            }
          }else{
            $this->error('修改密码失败,请稍后再试!');
          }
        }else{
          //0 说明密码错误
          $this->error('旧密码不正确!');
        }
      }else{
        $this->display();
      }
    }
  }
