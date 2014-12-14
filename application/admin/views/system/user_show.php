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
                <span style="float: left;">当前位置是：后台管理-》用户列表</span>
                
            </span>
        </div>
        <div></div>
        <a class="btn btn-primary" id="addnew" href="<?php echo site_url('user/add');?>">新增用户<span class="glyphicon glyphicon-plus"></span></a>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>ID</td>
                        <td>用户名</td>
                        <td>真实名</td>
                        <td>状态</td>
                        <td>创建时间</td>
                        <td>所属角色</td>
                        <td>职位</td>
                        <td>镇街</td>
                         
                        <td align="center" colspan=2>操作</td>
                    </tr>
                    <?php 
                    
                    foreach ($data as $val){?>
                    <tr id="product1">
                        <td><?php echo $val['id'];?></td>
                        <td><?php echo $val['username'];?></td>
                        <td><?php echo $val['real_name'];?></td>
                        <td><?php echo $val['status'];?></td>
                        <td><?php echo $val['create_time'];?></td>
                        <td><?php echo $role[$val['role_id']];?></td>
                        <td><?php echo $val['teach'];?></td>
                        <td><?php echo $val['towns'];?></td>
                        <td><a href="<?php echo site_url('user/edit/')."?id=".$val['id'];?>">修改</a></td>
                        <td><a href="<?php echo site_url('user/do_del/')."?id=".$val['id'];?>" onclick="return delete_role(<?php echo $val['id'];?>)">删除</a></td>
                    </tr>
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