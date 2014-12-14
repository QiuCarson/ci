<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content="MSHTML 6.00.6000.16674" name="GENERATOR" />

        <title>用户登录</title>

        <link href="<?php echo config_item('css_url'); ?>/css/User_Login.css" type="text/css" rel="stylesheet" />
    	
    	<link href="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.css" type="text/css" rel="stylesheet" />
    	
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jquery-1.8.1.min.js"></script> 
    	<script type="text/javascript" src="<?php echo config_item('js_url'); ?>/js/jQueryAlert/jquery.alerts.js"></script> 
    </head><body id="userlogin_body">
        <div></div>
        <div id="user_login">
            <dl>
                <dd id="user_top">
                    <ul>
                        <li class="user_top_l"></li>
                        <li class="user_top_c"></li>
                        <li class="user_top_r"></li></ul>
                </dd><dd id="user_main">
                    <?php echo form_open('login/do_login','method="post" id="login_from"'); ?>
                        <ul>
                            <li class="user_main_l"></li>
                            <li class="user_main_c">
                                <div class="user_main_box">
                                    <ul>
                                        <li class="user_main_text">用户名： </li>
                                        <li class="user_main_input">
                                            <input value="<?php echo set_value('username'); ?>" class="TxtUserNameCssClass" id="username" maxlength="20" name="username" > </li></ul>
                                    <ul>
                                        <li class="user_main_text">密&nbsp;&nbsp;&nbsp;&nbsp;码： </li>
                                        <li class="user_main_input">
                                            <input class="TxtPasswordCssClass" id="password" name="password" type="password">
                                        </li>
                                    </ul>
                                   <?php if(config_item('login_check_code')){?>
                                    <ul>
                                        <li class="user_main_text">验证码： </li>
                                        <li class="user_main_input">
                                            <input class="TxtValidateCodeCssClass" id="code" name="code" type="text">
                                            <img onclick="javascript:this.src='<?php echo site_url("login/code");?>?'+Math.random()" src="<?php echo site_url("login/code");?>"  alt="" title="点击更换验证码" alt="点击更换验证码" style="cursor:pointer" onClick="change_code()" />
                                        </li>
                                    </ul>
                                    <?php }?>
                                </div>
                            </li>
                            <li class="user_main_r">

                                <input onClick="check_form()" style="border: medium none; background: url('<?php echo config_item('img_url'); ?>/img/user_botton.gif') repeat-x scroll left top transparent; height: 122px; width: 111px; display: block; cursor: pointer;" value="" type=button id="submit_login">
                            </li>
                        </ul>
                    </form>
                </dd><dd id="user_bottom">
                    <ul>
                        <li class="user_bottom_l"></li>
                        <li class="user_bottom_c"><span style="margin-top: 40px;"></span> </li>
                        <li class="user_bottom_r"></li></ul></dd></dl></div><span id="ValrUserName" style="display: none; color: red;"></span><span id="ValrPassword" style="display: none; color: red;"></span><span id="ValrValidateCode" style="display: none; color: red;"></span>
        <div id="ValidationSummary1" style="display: none; color: red;"></div>
<script>

/*检查表单数据是否为空*/
function check_form()
{
	/*
	if($("#username").val() == '')
	{
		jAlert('用户名不能为空','error');
		return false ;
	}
	else if($("#code").val() == '')
	{
		jAlert('验证码不能为空','error');
		return false ;
	}
	else if($("#password").val() == '')
	{
		jAlert('密码不能为空','error');
		return false ;
	}
	else if(!check_code())
	{
		jAlert('验证码输入错误','error');
		return false ;
	}*/
	$("#login_from").submit();
}
//校验验证码，返回true 或者false
function check_code(){
	var status = false ;
	$.ajax({
		   type: "POST",
		   url: "<?php echo site_url("login/check_code");?>" ,
		   data: {'code':$("#code").val()},
		   cache:false,
		   dataType:"text",
		   async:false,
		   success: function(msg){
				if(msg == 'success'){
					status = true ;
				}
		   }
		});	
		return status ;
}
$(function () { 
	jQuery("#code").blur(function(){
		if(!check_code())
		{	jAlert('验证码输入错误','error');
			/*if(!jAlert('验证码输入错误','error'))
			{
				//jQuery("#code").focus();
			}*/
			
		}
	});
})

</script>

    </body>
</html>