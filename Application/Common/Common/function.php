<?php

  //封装密码加密函数 getPwd
    //@param1 $pwd str 原始密码
    //@return str 加密后的40位密码
  function getPwd($pwd){
    //采用加盐加密
    //1、读取项目的密钥
    //2、获取密码原文
    //3、加盐加密
    return sha1(md5($pwd).md5(C('seKey')));
  }

  //封装无限极排序函数 getLevel
    //@param1 $arr    arr   原始数组
    //@param2 $pid    int   上级元素id 默认值为0
    //@param3 $level  int   当前元素的级别 默认值为0
  function getLevel($arr,$pid=0,$level=0){
    //声明静态变量,用于保存排序后的数组
    static $sort = array();
    foreach($arr as $v){
      //找顶级权限
      if($v['auth_pid'] == $pid){
        //添加一个level索引用于记录当前级别
        $v['level'] = $level;
        //找到顶级权限,把它先放进数组
        $sort[] = $v;
        //根据这个权限,找儿子 递归调用排序函数自身
        getLevel($arr,$v['auth_id'],$level+1);
      }
    }
    return $sort;
  }

  //过滤XSS 能够检查传入$string 把其中的script标签过滤掉 然后返回一个过滤后的字符串
  function filterXSS($string){
      //相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
      require_once './Public/Admin/htmlpurifier/library/HTMLPurifier.auto.php';
      // 生成配置对象
      $cfg = HTMLPurifier_Config::createDefault();
      // 以下就是配置：
      $cfg -> set('Core.Encoding', 'UTF-8');
      // 设置允许使用的HTML标签  不允许出现script
      $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
      // 设置允许出现的CSS样式属性
      $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
      // 设置a标签上是否允许使用target="_blank"
      $cfg -> set('HTML.TargetBlank', TRUE);
      // 使用配置生成过滤用的对象
      $obj = new HTMLPurifier($cfg);
      // 过滤字符串
      return $obj -> purify($string);
  }
