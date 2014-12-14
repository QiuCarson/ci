<?php 

$config['rbac_auth_on']  = TRUE; //是否开启认证

//不需要认证的页面，最后要带上/
$config['rbac_no_check_url']=array('admin/index/','admin/left/','admin/right/','admin/head/');

//css 样式连接，最后没有"/"
$config['css_url']='';
//img 样式连接，最后没有"/"
$config['img_url']='';
//js 样式连接，最后没有"/"
$config['js_url']='';

//验证码开关 TURE 开启 FALSE 关闭
$config['login_check_code']=TRUE;

//登录之后存的session的数组
$config['login_session_key']='login_session'; #没有在用

//记录操作日志到数据库
$config['is_write_log_to_database']=TRUE;

//加密key,后台登录
$config['encrypt_key']='cci';

//后台登录cookie的时间,已秒计算
$config['login_limit_time']=24*60*60;

/*rbac 类型
 * 数值2		为实时认证
 * 
 */
$config['rbac_auth_type']=2;

/**
 * 上传配置
 */
$config['upload']=[
		'upload_path'=>'./uploads/',
		'allowed_types'=>'*',//gif|jpg|png 允许的类型
		'max_size'=>100,//最大大小
		'encrypt_name'=>TRUE,//是否重命名文件
		'remove_spaces'=>TRUE,//参数为TRUE时，文件名中的空格将被替换为下划线。推荐使用。
		
];



/**
 * 教育类型
 */
$config['teach_type']=[
		1=>'幼教',
		2=>'成教',
];


