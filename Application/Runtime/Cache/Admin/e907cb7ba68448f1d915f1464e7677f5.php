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
        <div class="formtitle"><span>商品相册</span></div>
        <li style="border: 1px solid grey;margin-bottom: 20px;">
          
          <?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><span>
              <img src="<?php echo (ltrim($pic["pics_mid"],'.')); ?>" width="200"/>
              
              <a href="javascript:;" data="<?php echo ($pic["pics_id"]); ?>" class="delete">[－]</a>
            </span><?php endforeach; endif; else: echo "" ;endif; ?>
        </li>
        <form action="<?php echo U('photos');?>" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品图片[<a href="javascript:;" class="add">＋</a>]</label>
                    <input name="photos[]" type="file" />
                </li>

                <li>
                    <label>&nbsp;</label>
                    <input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>">
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
$(function(){
    $('#btnSubmit').on('click',function(){
        $('form').submit();
    });

    $(".add").click(function(){
      $(this).parent().parent().clone()//克隆出一个副本
      .find('a').html('－').click(function(){
        //根据a标签,把它的爷爷 li 整个删掉
        $(this).parent().parent().remove();
      }).parent().parent()//把这个副本中的a标签内容改为减号 再次找到副本的li标签
      .insertAfter($(this).parent().parent());//执行DOM对象的插入操作
    });

    $(".delete").click(function(){
      //获取要删除图片的主键信息
      var id = $(this).attr('data');
      var obj = $(this);
      //异步删除
      $.get("<?php echo U('Goods/deletePic');?>",'id='+id,function(msg){
        //true '1' false ''
        if(msg){
          //根据点击的按钮,删掉父节点
          obj.parent().remove();
        }else{
          alert('删除图片失败,请稍后再试!');
        }
      },'text')
    });
})


</script>
</html>