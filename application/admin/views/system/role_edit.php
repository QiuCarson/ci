<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>修改角色</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet">
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：后台管理-》角色配置-》修改角色</span>
                
            </span>
        </div>
        <div></div>
		<a class="btn btn-primary" id="addnew" href="<?php echo site_url('role/show');?>">返回角色列表<span class="glyphicon glyphicon-plus"></span></a>
        
        <div style="font-size: 13px;margin: 10px 5px">
            <form action="<?php echo site_url('role/edit');?>" method="post" >
            <input type="hidden" name="action" value="do_edit" />
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>角色名称</td>
                    <td><input type="hidden" name="id" value="<?php echo $id;?>" /><input type="text" name="role_name" value="<?php echo $role_name;?>" /></td>
                </tr>
                 <tr>
                    <td>状态</td>
                    <td>
                    	<?php if($status==1){?>
                    	<input type="radio" name="status" value="1" checked>启用
                    	<input type="radio" name="status" value="0">禁用
                    	<?php }else{?>
                    	<input type="radio" name="status" value="1" >启用
                    	<input type="radio" name="status" value="0" checked>禁用
                    	<?php }?>
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2" align="center">
                        <input class='btn-primary btn' type="submit" value="修改">
                    </td>
                </tr>  
            </table>
            </form>
        </div>
    </body>
</html>