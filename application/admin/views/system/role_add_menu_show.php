<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>角色赋权</title>

        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.css" type="text/css" rel="stylesheet" />
    	
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jquery-1.8.1.min.js"></script> 
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.js"></script> 
    <script>
function delete_role(id)
{
	if(isNaN(id))
	{
		jAlert('数据类型错误', 'error');
		return false
	}
	if(confirm("你确定要删除这条数据?"))
	{
		status_flag=false;
		$.ajax({
			   type: "POST",
			   url: "<?php echo site_url("role/check_role");?>" ,
			   data: {'id':id},
			   cache:false,
			   dataType:"text",
			   async:false,
			   success: function(msg){
					if(msg == 'exists'){
						status_flag = true ;
					}
			   }
			});
		
		if(status_flag==true)
		{
			jAlert('该角色下面还有用户，请先取消用户，在删除！', 'error');
			//window.event.returnValue = false; 
			return false;
		}
		else
		{
			return true;
		}
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
                <span style="float: left;">当前位置是：后台管理-》角色赋权</span>
                
            </span>
        </div>
        <div></div>
        <a class="btn btn-primary" id="addnew" href="<?php echo site_url('role/show');?>">返回角色列表<span class="glyphicon glyphicon-plus"></span></a>
        <div style="font-size: 13px; margin: 10px 5px;">
        <form action="<?php echo site_url('role/role_add_menu_show');?>" method="post" >
        <input type="hidden" name="action" value="do_role_add_menu_show" />
        <input type="hidden" name="role_id" value="<?php echo $id;?>" />
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        
                        <td>角色名称</td>                        
                        <td>访问地址</td>
                        
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
                        <td  style="font-weight: bold;"><?php echo $val['id'];?>&nbsp;<?php echo $val['menu_name'];?>
                        <input name="menu_id[]" type="checkbox" value="<?php echo $val['id'];?>" <?php echo in_array($val['id'], $menu_to_role)?'checked':'';?> /></td>
                        <td></td>
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
                        <td><?php echo $val1['id'];?><?php echo str_repeat("&nbsp;",8); ?><?php echo $val1['menu_name'];?>
                        <input name="menu_id[]" type="checkbox" value="<?php echo $val1['id'];?>" <?php echo in_array($val1['id'], $menu_to_role)?'checked':'';?>/></td>
                        
                        <td><?php echo $val1['menu_url'];?></td>
                        
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
                        <td><?php echo $val2['id'];?><?php echo str_repeat("&nbsp;",12); ?><?php echo $val2['menu_name'];?><input name="menu_id[]" type="checkbox" value="<?php echo $val2['id'];?>" <?php echo in_array($val2['id'], $menu_to_role)?'checked':'';?>/></td>
                        
                        <td><?php echo $val2['menu_url'];?></td>
                        
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
                        <td><?php echo $val3['id'];?><?php echo str_repeat("&nbsp;",16); ?><?php echo $val3['menu_name'];?><input name="menu_id[]" type="checkbox" value="<?php echo $val3['id'];?>" <?php echo in_array($val3['id'], $menu_to_role)?'checked':'';?>/></td>
                        
                        <td><?php echo $val3['menu_url'];?></td>
                       
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
                    <tr ><td colspan=2  align="center"><input class='btn-primary btn' type="submit" value="添加"></td></tr>
                    
                </tbody>
            </table>
            </form>
        </div>

    </body>
</html>