<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

        //添加角色功能入口
        $("#add").click(function(){
          window.location = "<?php echo U('Role/add');?>"
        });

        //删除角色功能入口
        $(".delete").click(function(){
          //获得角色id
          var id = $(this).parent().siblings().eq(1).html();
          //弹窗警告 验证密码
          //异步删除
          var obj = $(this);
          $.get("<?php echo U('role/delete');?>",'id='+id,function(msg){
            if(msg.result){
              //dom操作,把这条记录从页面上删掉
              obj.parent().parent().remove();
            }
            alert(msg.error);
          },'json');
        });

    });
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li id="add"><span><img src="/Public/Admin/images/t01.png" /></span>添加</li>
                <li><span><img src="/Public/Admin/images/t02.png" /></span>修改</li>
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>用户组</th>
                    <th>权限ids</th>
                    <th>权限ac</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
              
              <?php if(is_array($roles)): $i = 0; $__LIST__ = $roles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input name="" type="checkbox" value="<?php echo ($role["role_id"]); ?>" />
                    </td>
                    <td><?php echo ($role["role_id"]); ?></td>
                    <td><?php echo ($role["role_name"]); ?></td>
                    <td><?php echo ($role["role_auth_ids"]); ?></td>
                    <td><?php echo ($role["role_auth_ac"]); ?></td>
                    <td><a href="/index.php/Admin/Role/setAuth/id/<?php echo ($role["role_id"]); ?>" class="tablelink">分配权限</a> <a href="#" class="delete tablelink"> 删除</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>

</html>