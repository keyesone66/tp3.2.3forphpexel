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

        //添加用户功能入口
        $("#add").click(function(){
          window.location = "<?php echo U('Manager/add');?>"
        });

        //重置密码功能入口
        $(".setPwd").click(function(){
          //获得用户id
          var id = $(this).parent().siblings().eq(1).html();

          //发起异步请求
          $.get("<?php echo U('manager/setPwd');?>",'id='+id,function(msg){
            alert(msg);
          },'text')
        })

        //编写全选全不选功能
        $("#checkAll").click(function(){
          if($(this).data('check')){
            //当前是全选,改为全不选
            $(":checkbox").attr('checked',false);
            $(this).data('check',false);//用于记录全选还是全不选
          }else{
            //当前是全不选,改为全选
            $(":checkbox").attr('checked','checked');
            $(this).data('check',true);//用于记录全选还是全不选
          }
        })

        //批量删除用户功能入口
        $("#delete").click(function(){
          var ids = '';
          $(".check:checked").each(function(){
            //获取被选中的用户id
            ids += $(this).parent().siblings().eq(0).html()+',';
          });
          ids = ids.substr(0,ids.length-1);
          //把发起请求之前,哪些被勾选了保存起来
          var checked = $(".check:checked");
          //异步删除
          $.get("<?php echo U('manager/deleteAll');?>",'ids='+ids,function(msg){
            if(msg.result){
              //DOM操作,把对应行删除
              checked.parent().parent().remove();
            }
            alert(msg.error);
          },'json')
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
                <li id="delete"><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
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
                    <th>用户名</th>
                    <th>最近登录时间</th>
                    <th>角色</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
              
              <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
                      <td>
                          <input name="" class="check" type="checkbox" value=""/>
                      </td>
                      <td><?php echo ($user["mg_id"]); ?></td>
                      <td><?php echo ($user["mg_name"]); ?></td>
                      
                      <td>
                        <?php if($user["mg_time"] == 0 ): ?>新用户
                          <?php else: echo (date('Y-m-d H:i',$user["mg_time"])); endif; ?>
                      </td>
                      <td><?php echo ((isset($user["role_name"]) && ($user["role_name"] !== ""))?($user["role_name"]):'空闲'); ?></td>
                      <td><a href="#" class="setPwd tablelink">重置密码</a> <a href="/index.php/Admin/Manager/setRole/id/<?php echo ($user["mg_id"]); ?>" class="setPwd tablelink">分配角色</a></td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
    </script>
</body>

</html>