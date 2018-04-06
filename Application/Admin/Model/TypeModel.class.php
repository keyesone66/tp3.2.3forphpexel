<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class TypeModel extends Model{
    //字段映射
    protected $_map = array(
      // 先写name属性 然后写对应的字段
      'name'        => 'type_name',
    );
    //自动验证
    protected $_validate = array(
      //权限名称必须 唯一
      array('type_name','require','分类名不能为空!'),
      array('type_name','','分类名已重名!',0,'unique'),
    );
  }
