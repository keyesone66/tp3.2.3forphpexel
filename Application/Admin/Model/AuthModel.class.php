<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class AuthModel extends Model{
    //字段映射
    protected $_map = array(
      // 先写name属性 然后写对应的字段
      'name'        => 'auth_name',
      'pid'         => 'auth_pid',
      'controller'  => 'auth_c',
      'action'      => 'auth_a',
      'menu'        => 'is_menu',
    );
    //自动验证
    protected $_validate = array(
      //权限名称必须 唯一
      array('auth_name','require','权限名不能为空!'),
      array('auth_name','','权限名已重名!',0,'unique'),
      //pid必须为数字
      array('auth_pid','number','非法请求!'),
      //is_menu必须为数字
      array('is_menu','number','非法请求!'),
      //控制器名和方法名不做显示
    );
  }
