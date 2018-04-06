<?php
  //命名空间
  namespace Admin\Controller;


  //创建当前控制器类
  class TypeController extends CommonController{
    public function add(){
      if(IS_POST){
        $m = D('type');
        if($m->create()){
          if($m->add()){
            $this->success('分类添加成功!',U('showlist'));
          }else{
            $this->error('分类添加失败,请稍后再试!');
          }
        }else{
          $this->error($m->getError());
        }
      }else{
        $this->display();
      }
    }

    public function showlist(){
      $types = M('type')->select();
      //分配
      $this->assign('types',$types);
      //显示
      $this->display();
    }
  }










  
