<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息</span></div>
        <form action="<?php echo U('Auth/edit');?>" method="post">
            <ul class="forminfo">
                <li>
                    <label>权限名称</label>
                    <input name="name" placeholder="请输入权限名称" type="text" class="dfinput" value="<?php echo ($auth["auth_name"]); ?>"/>
                    <input type="hidden" name="id" value="<?php echo ($auth["auth_id"]); ?>">
                </li>
                
                <li><label>是否显示</label><cite>
                  <input name="menu" type="radio" value="1" <?php if( $auth["is_menu"] == 1 ): ?>checked="checked"<?php endif; ?> />是&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="menu" type="radio" value="0" <?php if( $auth["is_menu"] == 0 ): ?>checked="checked"<?php endif; ?> />否</cite></li>

                <li>
                    <label>父级权限</label>
                    <select name="pid" class="dfinput">
                      
                        <option value="0"
                          <?php if($auth["auth_pid"] == 0 ): ?>selected="selected"<?php endif; ?>
                        >作为顶级</option>
                      
                      <?php if(is_array($tops)): $i = 0; $__LIST__ = $tops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($i % 2 );++$i;?><option value="<?php echo ($top["auth_id"]); ?>"
                          <?php if($auth["auth_pid"] == $top["auth_id"] ): ?>selected="selected"<?php endif; ?>
                        ><?php echo ($top["auth_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <i></i></li>
                <li>
                    <label>控制器名</label>
                    <input name="controller" placeholder="请输入控制器名称" type="text" class="dfinput" value="<?php echo ($auth["auth_c"]); ?>"/>
                </li>
                <li>
                    <label>方法名称</label>
                    <input name="action" placeholder="请输入方法名称" type="text" class="dfinput" value="<?php echo ($auth["auth_a"]); ?>"/>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    })

    //当下拉选框选项改变时,判断是否作为顶级
    $("[name=pid]").change(function(){
      //表单填写的值都是字符串 '0'
      if($(this).val() != '0'){
        //不作为顶级,把它展开
        $(this).parent().next().show(100).next().show(100);
      }else{
        //如果用户选择作为顶级权限 应该把控制器和方法的表单域收起来
        $(this).parent().next().hide(100).next().hide(100);
        $("[name=controller]").val('');
        $("[name=action]").val('');
      }
    });
});
</script>
</html>