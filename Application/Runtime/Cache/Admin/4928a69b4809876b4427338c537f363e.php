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

        //添加权限功能入口
        $("#add").click(function(){
          //跳转到 Auth / add方法 BOM
          window.location = "<?php echo U('Auth/add');?>";
        })

        //删除权限功能入口
        $(".delete").click(function(){
          var obj = $(this);//obj指向删除的超链接
          //获取要删除的权限id
          var id = $(this).parent().siblings().eq(1).html();
          //获取要删除的权限名称
          var name = $(this).parent().siblings().eq(2).html().replace(/&nbsp;/g,'');
          //弹窗警告
          //确定true 取消false
          if(window.confirm('确定删除 ['+name+'] 权限吗?')){
            //确实要删除
            var pwd = window.prompt('请输入密码:');
            //开始异步验证用户名密码
            $.get("<?php echo U('Public/verify');?>",'pwd='+pwd,function(msg){
              if(msg){
                //删除权限 向服务器发送要删除的id
                $.get("<?php echo U('Auth/delete');?>",'id='+id,function(msg){
                  if(msg.result){
                    //这条权限不见了 dom操作 删除功能入口所在的整行
                    obj.parent().parent().remove();
                  }
                  //显示提示信息
                  alert(msg.error);
                },'json');
              }else{
                //错误提示
                alert('密码错误!');
              }
            },'text');
          }else{
            //一开始点删除 又怂了
            alert('请谨慎操作!');
          }
        })
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
                    <th>权限名称</th>
                    <th>上级id</th>
                    <th>控制器</th>
                    <th>方法</th>
                    <th>是否显示</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
              
              <?php if(is_array($auths)): $i = 0; $__LIST__ = $auths;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$auth): $mod = ($i % 2 );++$i;?><tr>
                      <td>
                          <input name="" type="checkbox" value="<?php echo ($auth["auth_id"]); ?>" />
                      </td>
                      <td><?php echo ($auth["auth_id"]); ?></td>
                      
                      <td><?php echo (str_repeat("&nbsp;",$auth["level"]*4)); echo ($auth["auth_name"]); ?></td>
                      <td><?php echo ($auth["auth_pid"]); ?></td>
                      <td><?php echo ($auth["auth_c"]); ?></td>
                      <td><?php echo ($auth["auth_a"]); ?></td>
                      <td><?php if($auth["is_menu"] == 1 ): ?>显示<?php else: ?>不显示<?php endif; ?></td>
                      <td><a href="/index.php/Admin/Auth/edit/id/<?php echo ($auth["auth_id"]); ?>" class="tablelink">修改</a> <a href="#" class="delete tablelink"> 删除</a></td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="/Public/Admin/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>

</html>