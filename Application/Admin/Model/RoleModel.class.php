<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class RoleModel extends Model{
    //字段映射
    protected $_map = array(
      // 先写name属性 然后写对应的字段
      'name'        => 'role_name',
      'ids'         => 'role_auth_ids',
    );
    //自动验证
    protected $_validate = array(
      //角色名称必须 唯一
      array('role_name','require','角色名不能为空!'),
      array('role_name','','角色名已重名!',0,'unique'),
      //ids必须为数组
      array('role_auth_ids','is_array','非法请求!',0,'function'),
    );
  }
