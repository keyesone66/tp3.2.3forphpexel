<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class ManagerModel extends Model{
    //字段映射
    protected $_map = array(
      // 先写name属性 然后写对应的字段
      'username'        => 'mg_name',
      'password'        => 'mg_pwd',
      'role'            => 'role_id',
    );
    //自动验证
    protected $_validate = array(
      //用户名称必须 唯一
      array('mg_name','require','用户名不能为空!'),
      array('mg_name','','用户名已重名!',0,'unique'),
      array('mg_pwd','require','密码不能为空!'),
      //role_id必须为数字
      array('role_id','number','非法请求!'),
    );
  }
