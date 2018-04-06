<?php

  //命名空间
  namespace Home\Model;
  use \Think\Model;

  //声明当前模型类
  class UserModel extends Model{
    //字段映射
    public $_map = array(
      'username' => 'user_name',
      'password' => 'user_pwd',
    );
    //自动验证
    public $_validate = array(
      //用户名不为空
      //密码不为空
      //用户名不能重复
      array('user_name','require','用户名不能为空!'),
      array('user_pwd','require','密码不能为空!'),
      array('user_name','','用户名已被占用!',0,'unique'),
    );
  }
