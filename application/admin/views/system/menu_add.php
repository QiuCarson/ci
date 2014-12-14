<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>添加节点</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet">
    	<style>table td{padding:4px}</style>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：后台管理-》节点管理-》添加节点</span>
                
            </span>
        </div>
        <div></div>
		<a class="btn btn-primary" id="addnew" href="<?php echo site_url('menu/show');?>">返回节点列表<span class="glyphicon glyphicon-plus"></span></a>
        
        <div style="font-size: 13px;margin: 10px 5px">
            <form action="<?php echo site_url('menu/add');?>" method="post" >
            <input type="hidden" name="action" value="do_add" />
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>上级栏目</td>
                    <td>
                    <select name="menu_pid">
            <option value="0">一级菜单</option>
            <?php 
            	if($options){           		
            		foreach($options as $row){
            	
            ?>         		
            <option value="<?php echo $row['id'] ?>" 
            	<?php if($row['menu_pid'] == 0){echo 'style="background:lightgreen"';}?>   
            	<?php if($pid == $row['id']){echo "selected='selected'";}?>>
            	<?php echo str_pad("",$row['deep']*3, "-",STR_PAD_RIGHT); ?>
            	<?php echo $row['menu_name']; ?>
            	</option>
         <?php 
            		}
            	}         	
        ?> 
             </select>
                    </td>
                </tr>
                
                <tr>
                    <td>节点名称</td>
                    <td><input type="text" name="menu_name" /></td>
                </tr>
                <tr>
                    <td>排序</td>
                    <td><input type="text" name="menu_sort" /></td>
                </tr>
                <tr>
                    <td>url地址</td>
                    <td><input type="text" name="menu_url" />温馨提示:此处的url地址格式是:控制器/方法/ 后面不要忘记加/</td>
                </tr>
                <tr>
                    <td>状态</td>
                    <td>
                    	<input type="radio" name="menu_status" value="1" checked>启用
                    	<input type="radio" name="menu_status" value="0">禁用
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input class='btn-primary btn' type="submit" value="添加">
                    </td>
                </tr>  
            </table>
            </form>
        </div>
    </body>
</html>