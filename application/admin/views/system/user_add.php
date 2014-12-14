<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>添加用户</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet">
        <script src="<?php echo config_item('js_url'); ?>/js/jquery-1.8.1.min.js"></script>
        <script src="<?php echo config_item('js_url'); ?>/js/validate/validator.js" ></script>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：后台管理-》用户配置-》添加用户</span>
                
            </span>
        </div>
        <div></div>
		<a class="btn btn-primary" id="addnew" href="<?php echo site_url('user/show');?>">返回用户列表<span class="glyphicon glyphicon-plus"></span></a>
        
        <div style="font-size: 13px;margin: 10px 5px">
            <form action="<?php echo site_url('user/add');?>" method="post" >
            <input type="hidden" name="action" value="do_add" />
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>用户名</td>
                    <td><input type="text" name="username" required="true" /></td>
                </tr>
                <tr>
                    <td>密码</td>
                    <td><input type="password" name="password"  required="true"/></td>
                </tr>
                <tr>
                    <td>状态</td>
                    <td>
                    <input type="radio" name="status" value="1" checked>启用
                    	<input type="radio" name="status" value="0" >禁用
                    </td>
                </tr>
                <tr>
                    <td>是否显示</td>
                    <td>
                    <input type="radio" name="show" value="1" checked>显示
                    	<input type="radio" name="show" value="0" >隐藏
                    </td>
                </tr>
                <tr>
                    <td>所属角色</td>
                    <td>
                    	<select name="role_id">
                    	<option>请选择</option>
                    	<?php foreach ($role as $key=>$val){?>
                    	<option value="<?php echo $key;?>"><?php echo $val;?></option>
                    	<?php }?>
                    	</select>
                    </td>
                </tr>
                
                <tr>
                    <td>镇街</td>
                    <td>
                    <?php 
                    
                    ?>
                    <select name="towns_id">
                    <?php if(is_array($towns_all)){?>
                    <?php foreach ($towns_all as $key=>$val){?>
                    <option value="<?php echo $key?>"><?php echo $val ?></option>
                    <?php }?>
                    <?php }?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>真实名字</td>
                    <td>
                    	<input type="text" name="real_name"  /><font color=red>如果填了真实名字，前台会显示用户名</font>
                    </td>
                </tr>
                <tr>
                	<td>职位</td>
                	<td>
                	<select name="teach_id">
                	<?php if(is_array($teach)){?>
                	<?php foreach ($teach as $key=>$val){?>
                	<option value="<?php echo $key;?>" ><?php echo $val;?></option>
                	<?php }?>
                	<?php }?>
                	</select>
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
        <script>
       
        </script>
    </body>
</html>