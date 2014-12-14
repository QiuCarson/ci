<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>会员列表</title>

        <link href="<?php echo config_item('css_url'); ?>/css/mine.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.css" type="text/css" rel="stylesheet" />
    	
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jquery-1.8.1.min.js"></script> 
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.js"></script> 

    <style>table td{padding:4px}</style>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
         <h2>义乌市教育监察大队-安全监察情况</h2>
       督查人<?php echo $ducha_one['author']?><br/>
   自<?php echo date("Y-m-d",strtotime($ducha_one['create_time']));?>,总上传记录数<?php echo $total;?>次
       <a class="btn btn-primary" id="addnew" href="<?php echo '/admin.php';?>">登陆<span class="glyphicon glyphicon-plus"></span></a>
       
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>日期</td>
                        <td>督促情况</td>
                        <td>整改情况</td>
                    </tr>
                    <?php 
                    //print_r($da)
                    
                    foreach ($list as $val){?>
                    <tr id="product1">
                        <td><?php echo $val['create_time'];?></td>
                        <td><a href="/<?php echo $config['upload_path'].$val['ducha_file_name'];?>" target="_blank"><?php echo $val['ducha_show_name'];?></a></td>
                        <td><a href="/<?php echo $config['upload_path'].$val['zhenggai_file_name'];?>" target="_blank"><?php echo $val['zhenggai_show_name'];?></a></td>
                        
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
        </div>

    </body>
</html>