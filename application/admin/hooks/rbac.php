<?php 
/**
 * rbac 角色权限控制钩子类
 * @author carson
 *
 */
class Rbac
{
	/**
	 * 检查用户登录
	 */
	function check_is_login()
	{
		//访问CodeIgniter的原始资源
		$CI = &get_instance();
		//$CI ->load->model('Common');
		//当前目录
		//$directory = substr($CI->router->fetch_directory(),0,-1);
		//当前控制器
		$controller = $CI->router->fetch_class();
		//当前方法
		$function= $CI->router->fetch_method();
		
		//获取当前的url
		$url_array = $CI->uri->segment_array() ;
		
		if($controller<>'login')
		{
			if($CI->config->item('rbac_auth_on'))//判断是否开启rbac认证
			{
				//if(!in_array($directory,$CI->config->item('rbac_no_check_url')) )//跳过不要验证的页面验证
				//{
					//这个方法里验证权限
					$this->check_permissions();
				//}
				
			}
		}
		
		
		
		//print_r($new_url);
	}
	
	private function check_permissions()
	{
		$CI = &get_instance();
		//print_r($CI->db->dbprefix);exit;
		$admin_auth=$CI->input->cookie('admin_auth', TRUE);
		//print_r($admin_auth);exit;
		if(empty($admin_auth))
		{
			show_message("请登录之后在访问","login",1);
		}
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$data_cookie_array=unserialize($encode_string);
		/*修改cookie时间*/
		
		/*超级管理员不检查权限*/
		if($data_cookie_array['admin_id']==1)
		{
			//return TRUE;
		}
		//return TRUE;
		if(config_item('rbac_auth_type')==2  )
		{
			
			//$data_cookie_array['menu_url']=$this->get_user_menu_permissions($data_cookie_array['role_id']);
			$this->check_user_by_id($data_cookie_array['admin_id']);
		}
		
	}
	/**
	 * 检查用户是不是启用，如果启用去检查角色
	 */
	function check_user_by_id($admin_id=0)
	{
		$CI = &get_instance();	
		
		$quyer_admin=$CI->Common->get_user_info($admin_id);
		if($quyer_admin)
		{
			if($quyer_admin['status']==1)
			{
				$menu=$CI->Common->get_acl($quyer_admin['role_id']);
				if(empty($menu))
				{
					show_message("该角色已经被禁用或不存在","login",1);
				}
				//print_r($menu);exit;
				#检查用户是不是有权限访问当前url
				$this->check_url_permissions($menu);
				
				$data_cookie = array(
						'username'=>$quyer_admin['username'],
						'real_name'=>$quyer_admin['real_name'],
						'client_ip'=>$CI->input->ip_address(),
						'role_id'=>$quyer_admin['role_id'],
						'admin_id'=>$quyer_admin['id'],
						//'menu_ACL'=>$menu
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
				$CI->input->set_cookie($data_cookie_array);
				
			}
			else 
			{
				show_message("该用户已经被禁用","login",1);
			}
		}
		else
		{
			show_message("该用户不存在","login",1);
		}
	}
	/**
	 * 检查用户能不能访问当前链接
	 * @param array $menu
	 */
	function check_url_permissions($menu)
	{
		
		$CI = &get_instance();
		$new_url = '';
		
		//当前控制器
		$controller = $CI->router->fetch_class();
		//当前方法
		$function= $CI->router->fetch_method();
		
		$new_url=$controller."/".$function."/";
		//echo $new_url."AA";exit;
		if(!empty($new_url) && !in_array($new_url, $menu) && !in_array($new_url, $CI->config->item('rbac_no_check_url')))
		{
			exit("该用户权限不够");
		}
	}
	
	
}