<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>修改镇街</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet">
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：镇街管理-》镇街列表-》修改镇街</span>
                
            </span>
        </div>
        <div></div>
		<a class="btn btn-primary" id="addnew" href="<?php echo site_url('towns/show');?>">返回列表<span class="glyphicon glyphicon-plus"></span></a>
        
        <div style="font-size: 13px;margin: 10px 5px">
            
            <form action="<?php echo site_url('towns/edit');?>" method="post" >
            <input type="hidden" name="action" value="do_edit" />
            <input type="hidden" name="id" value="<?php echo $id;?>" />
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>显示文件名</td>
                    <td><input type="text" name="name" value="<?php echo $name;?>" /><font color=red>*不可以为空</font></td>
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