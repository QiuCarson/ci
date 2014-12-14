<!DOCTYPE HTML>
<html>
 <head>
  <title>失败页面</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='Refresh' content='<?php echo  $jump_time ;?>;URL=<?php echo site_url($jump_url);?>'>  
  <link rel="stylesheet" type="text/css" href="<?php echo  config_item('css_url') ;?>/css/dpl-min.css" />   
 </head>
 <body>
  
  <div class="container">
    <div class="row">
      <div class="span10">
        <div class="tips tips-large tips-warning">
          <span class="x-icon x-icon-error">×</span>
          <div class="tips-content">
            <h2><?php echo $message ;?></h2>
            <p class="auxiliary-text">
              页面将在 <span class="wait"><?php echo  $jump_time ;?></span> 秒后自动关闭，如果不想等待请点击 <a href="<?php echo site_url($jump_url);?>">这里</a> 关闭
            </p>
            <p>
			<!--
              <a class="page-action" data-type="setTitle" title="编辑用户个性化功能权限" href="userFunc.html">编辑用户个性化功能权限</a>
              <a class="page-action" data-type="setTitle" title="配置用户数据权限" href="userData.html">配置用户数据权限</a>
              <a class="page-action" data-type="setTitle" title="返回用户管理" href="userManage.html">返回用户管理</a>
            -->
			</p>
          </div>
        </div>
      </div> 
    </div>
  </div>


<body>
</html>  