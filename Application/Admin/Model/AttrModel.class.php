<?php
  //命名空间
  namespace Admin\Model;
  use Think\Model;

  //声明当前模型类
  class AttrModel extends Model{
    //表映射 让当前模型强制对应 sp_attribute表
    protected $trueTableName = 'sp_attribute';
    //字段映射
    protected $_map = array(
      // 先写name属性 然后写对应的字段
      'name'        => 'attr_name',
      'type'        => 'type_id',
      'sel'         => 'attr_sel',
      'write'       => 'attr_write',
      'vals'        => 'attr_vals',
    );
    //自动验证
    protected $_validate = array(
      //权限名称必须 唯一
      array('attr_name','require','属性名不能为空!'),
      array('type_id','number','非法请求!'),
      array('attr_sel','number','非法请求!'),
      array('attr_write','number','非法请求!'),
    );
  }
