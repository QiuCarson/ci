<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>会员列表</title>

        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.css" type="text/css" rel="stylesheet" />
    	
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jquery-1.8.1.min.js"></script> 
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.js"></script> 
    <script>
function delete_role()
{
	if(confirm("你确定要删除这条数据?"))
	{
			return true;
	}
	else
	{
		return false;

	}
	
}
</script>
    <style>table td{padding:4px}</style>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：镇街管理-》镇街列表</span>
                
            </span>
        </div>
        <div></div>
        <a class="btn btn-primary" id="addnew" href="<?php echo site_url('towns/add');?>">添加<span class="glyphicon glyphicon-plus"></span></a>
       
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>ID</td>
                        <td>镇街名</td>
                        <td align="center" colspan=2>操作</td>
                    </tr>
                    <?php 
                    //print_r($da)
                    if(is_array($list))
                    {
                    foreach ($list as $val){?>
                    <tr id="product1">
                        <td><?php echo $val['id'];?></td>
                        <td><?php echo $val['name'];?></td>                       
                        <td><a href="<?php echo site_url('towns/edit/')."?id=".$val['id'];?>">修改</a></td>
                        <td><a href="<?php echo site_url('towns/do_del/')."?id=".$val['id'];?>" onclick="return delete_role()">删除</a></td>
                    </tr>
                    <?php }?>
                    <?php }?>
                    <tr>
                        <td colspan="20" style="text-align: center;">
                            <?php echo $page_link;?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </body>
</html>