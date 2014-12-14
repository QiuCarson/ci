<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>上传附件</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet">
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：督促管理-》督促列表-》修改附件</span>
                
            </span>
        </div>
        <div></div>
		<a class="btn btn-primary" id="addnew" href="<?php echo site_url('myducha/show');?>">返回列表<span class="glyphicon glyphicon-plus"></span></a>
        
        <div style="font-size: 13px;margin: 10px 5px">
            
            <?php echo form_open_multipart('myducha/add');?>
            <input type="hidden" name="action" value="do_add" />
            <table border="1" width="100%" class="table_a">
                
                 <tr>
                    <td>督促情况上传附件</td>
                    <td><input type="file" name="ducha_file_name" size="20" /><font color=red><?php echo $error_ducha_file_name;?></font></td>
                </tr>
                <tr>
                    <td>整改情况上传附件</td>
                    <td><input type="file" name="zhenggai_file_name" size="20" /><font color=red><?php echo $error_zhenggai_file_name;?></font></td>
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