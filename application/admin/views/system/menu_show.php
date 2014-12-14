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
                <span style="float: left;">当前位置是：后台管理-》节点列表</span>
                
            </span>
        </div>
        <div></div>
        <a class="btn btn-primary" id="addnew" href="<?php echo site_url('menu/add');?>">新增节点<span class="glyphicon glyphicon-plus"></span></a>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        
                        <td>角色名称</td>
                        <td>状态</td>
                        <td>创建时间</td>
                        <td>排序</td>
                        <td>访问地址</td>
                        <td align="center" colspan=3>操作</td>
                    </tr>
                    <?php 
                    if($result)
                    {
                    	/*第一层*/
                   		foreach ($result as $key=>$val)
                   		{
                    //print_r($da)
                   ?>
                    <tr >
                        <td  style="font-weight: bold;"><?php //echo $val['id'];?>&nbsp;<?php echo $val['menu_name'];?></td>
                        <td><?php echo $val['menu_status']== 1 ?"开启":'<font color="red">关闭</font>';?></td>
                        <td><?php echo $val['create_time'];?></td>
                        <td><?php echo $val['menu_sort'];?></td>
                        <td>不需要</td>
                         <td><a href="<?php echo site_url('menu/add/'.$val['id']);?>">添加</a></td>
                        <td><a href="<?php echo site_url('menu/edit/'.$val['id']);?>">修改</a></td>
                        <td><a href="<?php echo site_url('menu/do_del/'.$val['id']);?>" onclick="return delete_role()">删除</a></td>
                    </tr>
                    	<?php 
                    	if(empty($val['childs']))
                    	{
                    		continue;
                    	}
                    	/*第二层*/
                    	foreach ($val['childs'] as $key0=>$val1)
                    	{	
                    	?>
                    <tr >
                        <td><?php //echo $val1['id'];?><?php echo str_repeat("&nbsp;",8); ?><?php echo $val1['menu_name'];?></td>
                        <td><?php echo $val1['menu_status']== 1 ?"开启":'<font color="red">关闭</font>';?></td>
                        <td><?php echo $val1['create_time'];?></td>
                        <td><?php echo $val1['menu_sort'];?></td>
                        <td><?php echo $val1['menu_url'];?></td>
                        <td><a href="<?php echo site_url('menu/add/'.$val1['id']);?>">添加</a></td>
                        <td><a href="<?php echo site_url('menu/edit/'.$val1['id']);?>">修改</a></td>
                        <td><a href="<?php echo site_url('menu/do_del/'.$val1['id']);?>" onclick="return delete_role()">删除</a></td>
                    </tr>
                    <?php 
                    	if(empty($val1['childs']))
                    	{
                    		continue;
                    	}
                    	/*第三层*/
                    	foreach ($val1['childs'] as $key1=>$val2)
                    	{	
                    	?>
                    <tr >
                        <td><?php //echo $val2['id'];?><?php echo str_repeat("&nbsp;",12); ?><?php echo $val2['menu_name'];?></td>
                        <td><?php echo $val2['menu_status']== 1 ?"开启":'<font color="red">关闭</font>';?></td>
                        <td><?php echo $val2['create_time'];?></td>
                        <td><?php echo $val2['menu_sort'];?></td>
                        <td><?php echo $val2['menu_url'];?></td>
                        <td><a href="<?php echo site_url('menu/add/'.$val2['id']);?>">添加</a></td>
                        <td><a href="<?php echo site_url('menu/edit/'.$val2['id']);?>">修改</a></td>
                        <td><a href="<?php echo site_url('menu/do_del/'.$val2['id']);?>" onclick="return delete_role()">删除</a></td>
                    </tr>
                    <?php 
                    	if(empty($val2['childs']))
                    	{
                    		continue;
                    	}
                    	/*第四层*/
                    	foreach ($val2['childs'] as $val3)
                    	{	
                    	?>
                    <tr >
                        <td><?php echo $val3['id'];?><?php echo str_repeat("&nbsp;",16); ?><?php echo $val3['menu_name'];?></td>
                        <td><?php echo $val3['menu_status']== 1 ?"开启":'<font color="red">关闭</font>';?></td>
                        <td><?php echo $val3['create_time'];?></td>
                        <td><?php echo $val3['menu_sort'];?></td>
                        <td><?php echo $val3['menu_url'];?></td>
                        <td></td>
                        <td><a href="<?php echo site_url('menu/edit/'.$val3['id']);?>">修改</a></td>
                        <td><a href="<?php echo site_url('menu/do_del/'.$val3['id']);?>" onclick="return delete_role()">删除</a></td>
                    </tr>
                    	<?php 
                    	}?>
                    	<?php 
                    	}?>
                    	
                    	<?php 
                    	}?>
                    	
                    <?php 
                   		}
                    }
                    ?>
                    
                    
                </tbody>
            </table>
        </div>

    </body>
</html>