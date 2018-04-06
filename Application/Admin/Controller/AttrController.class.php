<?php
  //命名空间
  namespace Admin\Controller;


  //创建当前控制器类
  class AttrController extends CommonController{
    public function add(){
      if(IS_POST){
        //实例化自定义模型
        $m = D('attr');
        if($m->create()){
          if($m->add()){
            $this->success('属性添加成功!',U('showlist'));
          }else{
            $this->error('属性添加失败,请稍后再试!');
          }
        }else{
          $this->error($m->getError());
        }
      }else{
        //查询当前可用的分类,产生分类选项
        $types=M('type')->select();
        //分配
        $this->assign('types',$types);
        //显示
        $this->display();
      }
    }

    public function showlist(){
      //查询所有属性
      $attrs = M()->query("select a.*,t.type_name from sp_attribute as a left join sp_type as t on a.type_id = t.type_id");
      //分配
      $this->assign('attrs',$attrs);
      //显示
      $this->display();
    }
  }
