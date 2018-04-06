<?php
  //命名空间
  namespace Admin\Controller;


  //创建当前控制器类
  class AuthController extends CommonController{
    //添加析构方法
    public function __destruct(){
      //当权限管理结束以后执行的代码
      //由于对权限进行了操作,更新session中的权限信息
      //加载用户的权限信息:
      //1、查询该用户的角色id
      //判断当前用户是否是超管
      if(session('roleId') == '1'){
        //如果是超管 默认分配所有权限
        $auths = M('auth')->select();
        session('auths',$auths);
      }else{
        //如果不是超管 查询具体权限
        //根据角色id 查询角色表 查询auth_ids
        $ids = M('role')->field('role_auth_ids')->where("role_id = '".session('roleId')."'")->find()["role_auth_ids"];
        //根据ids 查询权限表
        $auths = M('auth')->where("auth_id in ({$ids})")->select();
        session('auths',$auths);
      }
      //要让左侧的页窗刷新一次
      //对自己 进行一次 XSS攻击
      if(!IS_AJAX){
        echo "<script>window.parent[1].location='".U('index/left')."'</script>";
      }
      // dump(session());
    }
    public function showlist(){
      //查询所有权限数据
      $auths = M('auth')->select();
      //无限极分类排序权限数组
      // dump($auths);
      // dump(getLevel($auths));
      //分配模板变量
      $this->assign('auths',getLevel($auths));
      $this->display();
    }

    public function add(){
      if(IS_POST){
        //快速数据创建
        $m = D('auth');

        //字段映射 自动验证 自定义模型
        if($m->create()){
          //数据入库
          if($m->add()){
            //自增长id
            $this->success('权限添加成功!',U('Auth/showlist'));
          }else{
            //false sql执行失败
            $this->error('权限添加失败,请稍后再试!');
          }
        }else{
          //报错跳转
          $this->error($m->getError());
        }
      }else{
        //查询顶级权限,作为父级权限选项
        $tops = M('auth')->field("auth_id,auth_name")->where("auth_pid = 0")->select();
        //分配模板变量
        $this->assign('tops',$tops);
        //显示模板
        $this->display();
      }
    }

    public function edit(){
      if(IS_POST){

        //更新判断当前权限是否含有子权限,如果有,只能作为顶级权限
        //根据当前的权限id,查询权限表,统计字权限的条数
        //接收要修改的权限id
        $id = I('post.id');

        //根据当前的权限id,查询权限表,统计子权限的条数
        $count = M('auth')->where("auth_pid = '{$id}'")->count();
        //本身如果含有孩子 并且 pid又不为0
        if($count != 0 && I('post.pid') !=0 ){
          //说明当前权限含有自权限 而且不作顶级权限
          $this->error('请先处理子权限!');
          return false;
        }

        //实例化自定义模型
        $m = M('auth');
        $m->auth_name = I('post.name');
        $m->auth_pid = I('post.pid');
        $m->auth_c = I('post.controller');
        $m->auth_a = I('post.action');
        $m->auth_id = I('post.id');
        $m->is_menu = I('post.menu');

        //执行更新 save
        $result = $m->save();
        //返回值 false 受影响行数1 0
        if($result !== false){
          if($result){
            //1 修改成功
            $this->success('权限修改成功',U('showlist'));
          }else{
            //0 执行成功,但是没有修改
            $this->error('权限未改变!');
          }
        }else{
          //sql执行失败 false
          $this->error('权限修改失败,请稍后再试!');
        }
      }else{
        //获取要修改的权限id
        $id = I('get.id');
        //根据id查询旧数据
        $auth = M('auth')->where("auth_id = '{$id}'")->find();
        //分配模板变量
        $this->assign('auth',$auth);
        //查询顶级权限,作为父级权限选项
        $tops = M('auth')->field("auth_id,auth_name")->where("auth_pid = 0")->select();
        //分配模板变量
        $this->assign('tops',$tops);
        //显示一个修改表单
        $this->display();
      }
    }

    public function delete(){
      //接收要删除的权限id
      $id = I('get.id');

      //判断当前权限是否含有子权限,如果有,禁止删除
      //统计当前权限的子权限个数
      $count = M('auth')->where("auth_pid = '{$id}'")->count();
      //设立响应数组
      $response = array();
      //$response['result'] 用于保存执行的结果
      //$response['error'] 用于保存提示信息
      if($count==0){
        //该权限没有子权限,可以删除
        $result = M('auth')->delete($id);
        //false 1 0
        if($result !==false){
          if($result){
            //1 确实删除了一条权限
            $response['result'] = 1;
            $response['error'] = '权限删除成功!';
          }else{
            //0 找不到这样的一条权限
            $response['result'] = 1;
            $response['error'] = '权限不存在!';
          }
        }else{
          //false 说明sql语句执行失败了
          $response['result'] = 0;
          $response['error'] = '权限删除失败,请稍后再试!';
        }
      }else{
        //改权限还有子权限,不能删除
        $response['result'] = 0;
        $response['error'] = '请先处理子权限!';
      }

      //返回响应 json
      echo json_encode($response);
    }
  }
