<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>首页显示</title>

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
        <h2>义乌市教育监察大队-安全监察情况</h2><a class="btn btn-primary" id="addnew" href="/admin.php/login">登陆<span class="glyphicon glyphicon-plus"></span></a>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%" >
                <tbody><tr style="font-weight: bold;">
                        <td>街镇</td>
                        <?php if(is_array($teach_type)){?>
                        <?php foreach ($teach_type as $val){?>
                        <td><?php echo $val;?></td>
                        <?php }?>
                        <?php }?>
                    </tr>
                    <?php 
                    if(is_array($data)){
                    foreach ($data as $towns){?>
                    <tr id="product1">
                        <td><?php echo $towns['name']['name'];?></td>
                        
                        <?php if(is_array($teach_type)){?>
                        <?php foreach ($teach_type as $teach_id=> $val){?>
                        <td>
                        	<?php if(!empty($towns[$teach_id]) && is_array($towns[$teach_id])){?>
                        	<?php foreach ($towns[$teach_id] as $user){?>
                        	<?php echo '<a href="'.$this->config->site_url('welcome/show/').'?uid='.$user['id'].'">'.$user['real_name']."</a><br/>"?>
                        	<?php }?>
                        	<?php }?>
                        </td>
                        <?php }?>
                        <?php }?>
                        
                    </tr>
                    <?php }?>
                    <?php }?>
                    
                </tbody>
            </table>
        </div>

    </body>
</html>