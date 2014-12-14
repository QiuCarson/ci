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
                <span style="float: left;">当前位置是：督促管理-》督促列表</span>
                
            </span>
        </div>
        <div></div>
        <?php  $after12hours=date("Y-m-d H:i:s",strtotime("-12 hours"));?>
              督查人<?php echo $ducha_one['author']?$ducha_one['author']:'*';?><br/>
   自<?php echo date("Y-m-d",strtotime($ducha_one['create_time']));?>,总上传记录数<?php echo $total;?>次
  <?php if($after12hours>$list[0]['create_time']){?>
        <a class="btn btn-primary" id="addnew" href="<?php echo site_url('myducha/add');?>">上传附件<span class="glyphicon glyphicon-plus"></span></a>
     <?php }?>
     <a class="btn btn-primary" id="addnew" href="<?php echo site_url('login/do_login_out');?>">退出<span class="glyphicon glyphicon-plus"></span></a>
     
       <font color=red>上传12小时之后不能修改</font>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>日期</td>
                        <td>督促情况</td>
                        <td>整改情况</td>
                        <td align="center" colspan=1>操作</td>
                    </tr>
                    <?php 
                    //print_r($da)
                   
                    foreach ($list as $val){?>
                    <tr id="product1">
                        <td><?php echo $val['create_time'];?></td>
                        <td><a href="/<?php echo $config['upload_path'].$val['ducha_file_name'];?>" target="_blank"><?php echo $val['ducha_show_name'];?></a></td>
                        <td><a href="/<?php echo $config['upload_path'].$val['zhenggai_file_name'];?>" target="_blank"><?php echo $val['zhenggai_show_name'];?></a></td>
                        <td>
                        	<?php if($after12hours<$val['create_time']){?>
                        <a href="<?php echo site_url('myducha/edit/')."?id=".$val['id'];?>">修改</a></td>
                      	<?php }?>
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