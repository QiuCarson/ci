<?php
/**
 * 登录类
 * @author carson
 *
 */ 
class Login extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
	}
	
	/*
	 * 如果没有登录显示登录页面，如果登录跳转 admin/index
	 */
	function index()
	{
		//@ob_clean() ;
		//@session_start();
		$admin_auth=$this->input->cookie('admin_auth', TRUE);
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$data_cookie_array=unserialize($encode_string);
		if($data_cookie_array['admin_id'])
		{
			if($data_cookie_array['username']=='admin')
			{
				redirect('admin/index');
			}
			else 
			{
				redirect('myducha/show');
			}
		}
		$this->load->helper('form');
		$this->load->view('login');
	}
	
	/*
	 * 处理登录程序
	 */
	function do_login()
	{
		@ob_clean() ;
		@session_start() ;
		$code = daddslashes(html_escape(strip_tags($this->input->get_post("code"))));//code
		
		
		$this->load->library('form_validation');
				
		if ($this->form_validation->run() == FALSE)
		{
			show_message("用户名或者密码不可以为空","login",1);
		}
		elseif(strtolower($_SESSION['code']) != strtolower($code) && config_item('login_check_code'))
		{
			
			show_message("验证码错误","login",1);
		}
		
		$username = dowith_sql(daddslashes(html_escape(strip_tags(trim($this->input->get_post("username"))))));//name
		$password = (daddslashes(html_escape(strip_tags(trim($this->input->get_post("password"))))));//passwd
		$password = md5($password);
		$sql_admin="SELECT * FROM {$this->Common->db->dbprefix}admin WHERE username='{$username}' AND password='{$password}' AND status=1";
		//echo $sql_admin;exit;
		$admin_info = $this->Common->query_one($sql_admin);
		//print_r($password);exit();
		if (empty($admin_info))
		{
			show_message("用户不存在或者已经被禁用","login",1);
		}
		
		if($admin_info['role_id']<1)
		{
			show_message("用户 没有分配用户组","login",1);
		}
		
		$admin_role_id=$admin_info['role_id'];
		$sql_role="SELECT * FROM {$this->Common->db->dbprefix}role WHERE id={$admin_role_id} AND status=1";
		$role_info = $this->Common->query_one($sql_role);
		if(empty($role_info))
		{
			show_message("你所在的用户组已经禁用或者你所在的用户组已经删除","login",1);
		}

		//登录成功了
		$data_cookie = array() ;
		$data_string = '' ;
		$data_cookie = array(
				'username'=>$admin_info['username'],
				'real_name'=>$admin_info['real_name'],
				'client_ip'=>$this->input->ip_address(),
				//'group_name'=>$role_info['role_name'] ,
				'role_id'=>$role_info['id'],
				'admin_id'=>$admin_info['id']
		) ;
		$data_string = serialize($data_cookie) ;
		$data_string = auth_code($data_string , "ENCODE" , config_item("encrypt_key"));
		$data_cookie_array=array(
			 	'name'   => 'admin_auth',
			    'value'  => $data_string,
			    'expire' => config_item('login_limit_time'),
			    'domain' => config_item("cookie_domain"),
			    'path'   => config_item("cookie_path"),
			    'prefix' => config_item('cookie_prefix'),
			    'secure' => FALSE	
		);
		/*
		set_cookie('admin_auth',
			$data_string,config_item("cookie_domain"),
			config_item('login_limit_time'),
			config_item("cookie_domain"),
			config_item("cookie_path"),
			config_item('cookie_prefix'),
			TRUE
		);*/
		//print_r($data_cookie);
		//print_r($data_cookie_array);
		$this->input->set_cookie($data_cookie_array);
		
		//$admin_auth=$this->input->cookie('admin_auth', TRUE);
		//print_r($admin_auth);
		//exit;
		//登录cookie记录
		//$this->input->set_cookie($data_cookie_array);
		//写入日志文件
		//write_action_log("login_sql",$this->uri->uri_string(),$username,$this->input->ip_address(),1,"用户{$admin_info['username']}登录成功");
		//show_message("你所在的用户组已经禁用或者你所在的用户组已经删除","login",1);
		if($admin_info['username']=='admin'){
			redirect('admin/index');
		}
		else 
		{
			redirect('myducha/show');
		}
		
	}
	/*
	 * 处理登出方法
	 */
	function do_login_out()
	{
		$this->load->helper('cookie');
		delete_cookie("admin_auth");
		redirect('login/index');
	}
	/*
	 * 生成验证码
	 */
	function code(){
		$this->load->library("code",array(
			'width'=>80,
			'height'=>25,
			'fontSize'=>14,
			'font'=>APPPATH."/fonts/font.ttf"
		));
		
		$this->code->show();		
	}
	/*
	 * 检查验证码
	 */
	function check_code(){
		@ob_clean() ;
	    @session_start() ;
		$code = daddslashes(html_escape(strip_tags($this->input->get_post("code"))));//code
		if(strtolower($_SESSION['code']) != strtolower($code) ){
			//showmessage("验证码错误","login",3,0);
			exit('验证码不正确');
		}
		exit('success');
	}
}