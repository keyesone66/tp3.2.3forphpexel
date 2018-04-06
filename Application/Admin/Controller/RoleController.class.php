<?php
  //命名空间
  namespace Admin\Controller;

  use Think\Controller;

  //创建当前控制器类
  class RoleController extends CommonController{
    public function showList(){
      //查询所有角色信息
      $roles = M('role')->select();
      //分配模板变量
      $this->assign('roles',$roles);
      $this->display();
    }

    public function add(){
      if(IS_POST){
        //实例化自定义模型 写字段映射 验证规则 快速创建数据
        $m = D('role');

        if($m->create()){
          //数据的处理和入库
          $m->role_auth_ids = implode(',',$m->role_auth_ids);
          //根据ids 查询权限表 取出权限表中的控制器名和方法名
          $ac = M('auth')->field('auth_c,auth_a')->where("auth_id in ({$m->role_auth_ids})")->select();

          //遍历$ac数组,进行拼接工作
          //为$m添加新字段 role_auth_ac
          $m->role_auth_ac = '';

          foreach($ac as $v){
            //控制器名不为空 并且方法名也不为空 作拼接
            if(!empty($v['auth_c']) && !empty($v['auth_a'])){
              $m->role_auth_ac .= $v['auth_c'].'-'.$v['auth_a'].',';
            }
          }
          $m->role_auth_ac = rtrim($m->role_auth_ac,',');

          if($m->add()){
            $this->success('角色添加成功!',U('showlist'));
          }else{
            $this->error('角色添加失败,请稍后再试!');
          }

        }else{
          $this->error($m->getError());
        }
      }else{
        //查询所有权限
        $auths = M('auth')->field('auth_name,auth_id,auth_pid')->select();
        //分配模板变量
        $this->assign('auths',$auths);
        //显示模板
        $this->display();
      }
    }

    public function setAuth(){
      if(IS_POST){
        //接收2个数据 要修改的角色id 权限ids
        $m = M('role');
        $m->role_id = I('post.id');
        $m->role_auth_ids = I('post.ids');

        //数据的处理和入库
        $m->role_auth_ids = implode(',',$m->role_auth_ids);
        //根据ids 查询权限表 取出权限表中的控制器名和方法名
        $ac = M('auth')->field('auth_c,auth_a')->where("auth_id in ({$m->role_auth_ids})")->select();

        //遍历$ac数组,进行拼接工作
        //为$m添加新字段 role_auth_ac
        $m->role_auth_ac = '';

        foreach($ac as $v){
          //控制器名不为空 并且方法名也不为空 作拼接
          if(!empty($v['auth_c']) && !empty($v['auth_a'])){
            $m->role_auth_ac .= $v['auth_c'].'-'.$v['auth_a'].',';
          }
        }
        $m->role_auth_ac = rtrim($m->role_auth_ac,',');

        $result = $m->save();

        if($result !== false){
          if($result){
            $this->success('权限分配成功!',U('showlist'));
          }else{
            $this->error('权限未改变');
          }
        }else{
          $this->error('权限分配失败,请稍后再试!');
        }
      }else{
        //接收要修改的角色id
        $id = I('get.id');
        //根据要修改的角色id 查询角色名称 角色的权限
        $role = M('role')->field('role_id,role_name,role_auth_ids')->find($id);
        //分配模板变量
        $this->assign('role',$role);
        //查询所有权限
        $auths = M('auth')->field('auth_name,auth_id,auth_pid')->select();
        //分配模板变量
        $this->assign('auths',$auths);
        $this->display();
      }
    }

    public function delete(){
      //接收要删除的角色id
      $id = I('get.id');

      //根据角色id,对管理员表进行岗位重置
      $m = M('manager');
      $m->role_id = 0;
      $result = $m->where("role_id = '{$id}'")->save();
      //构建响应数组
      $response = array();

      if($result !== false){
        //岗位重置成功,才能删除角色表记录
        $result = M('role')->delete($id);
        if($result !== false){
          if($result){
            //返回值1 删除角色成功
            $response['result'] = 1;//true 代表符合操作者的意愿
            $response['error'] = '角色删除成功!';
          }else{
            //返回值0 角色未找到
            $response['result'] = 1;//true 代表符合操作者的意愿
            $response['error'] = '角色不存在!';
          }
        }else{
          //岗位重置成功,但是删除角色失败
          $response['result'] = 0;//最终角色还是留在了数据库里
          $response['error'] = '角色删除失败,请稍后再试!';
        }
      }else{
        //岗位重置失败
        $response['result'] = 0;//最终角色还是留在了数据库里
        $response['error'] = '岗位重置失败,请稍后再试!';
      }
      //返回json格式响应
      echo json_encode($response);
    }


  }
