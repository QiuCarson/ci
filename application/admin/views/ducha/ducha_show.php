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
function onchange_user(val)
{
	location.href=val;

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
                <span style="float: left;">当前位置是：督促管理-》督促列表</span>
                
            </span>
        </div>
        <div></div>
        <a class="btn btn-primary" id="addnew" href="<?php echo site_url('ducha/add');?>">上传附件<span class="glyphicon glyphicon-plus"></span></a>
       根据用户查找
       <select name="option_user" onchange="onchange_user(this.value)">
       <option value="<?php echo site_url('ducha/show');?>?date=<?php echo $current_date;?>">请选择</option>
       <?php foreach ($list_user as $val){?>
	       <option value="<?php echo site_url('ducha/show');?>?option_user=<?php echo $val['id']?>&date=<?php echo $current_date;?>" <?php echo $current_user==$val['id']?"selected":"";?>>
	       <?php echo $val['real_name']?>
	       </option>
	       <?php }?>
       </select>
       根据日期查找
       <select name="option_day" onchange="onchange_user(this.value)">
       <option value="<?php echo site_url('ducha/show');?>?option_user=<?php echo $current_user;?>">请选择</option>
       <?php foreach ($list_date_ducha as $val){?>
       <option value="<?php echo site_url('ducha/show');?>?date=<?php echo $val['time']?>&option_user=<?php echo $current_user;?>" <?php echo $current_date==$val['time']?"selected":"";?>><?php echo $val['time'];?></option>
       <?php }?>
       </select>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>日期</td>
                        <td>督促情况</td>
                        <td>整改情况</td>
                        <td>上传人</td>
                        <td align="center" colspan=2>操作</td>
                    </tr>
                    <?php 
                    //print_r($da)
                    
                    foreach ($list as $val){?>
                    <tr id="product1">
                        <td><?php echo $val['create_time'];?></td>
                        <td><a href="/<?php echo $config['upload_path'].$val['ducha_file_name'];?>" target="_blank"><?php echo $val['ducha_show_name'];?></a></td>
                        <td><a href="/<?php echo $config['upload_path'].$val['zhenggai_file_name'];?>" target="_blank"><?php echo $val['zhenggai_show_name'];?></a></td>
                       <td><?php echo $val['author'];?></td>
                        
                        <td><a href="<?php echo site_url('ducha/edit/')."?id=".$val['id'];?>">修改</a></td>
                        <td><a href="<?php echo site_url('ducha/do_del/')."?id=".$val['id'];?>" onclick="return delete_role()">删除</a></td>
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