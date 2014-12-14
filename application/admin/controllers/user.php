<?php 
class User extends CI_Controller
{
	public $role=array();
	public $towns=array();
	public $teach_type=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
		
		$sql_role="SELECT * FROM {$this->Common->db->dbprefix}role ";
		$query_role=$this->Common->query_array($sql_role);
		
		if($query_role)
		{
			foreach ($query_role as $key =>$val)
			{
				$this->role[$val['id']]=$val['role_name'];
			}
		}
		$sql_towns="SELECT * FROM {$this->Common->db->dbprefix}towns ";
		$query_towns=$this->Common->query_array($sql_towns);
	
		if($query_towns)
		{
			foreach ($query_towns as $key =>$val)
			{
				$this->towns[$val['id']]=$val['name'];
			}
		}
		
		$this->teach_type=config_item('teach_type');
	}
	function show($page=1)
	{
		
		
		#$page = $this->input->get_post("page");
		if($page <=0 ){
			$page = 1 ;
		}
		$page_num=30;
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->Common->db->dbprefix}admin ";
		$total  = $this->Common->query_count($sql_count);
		$page_string=show_page($total,$page_num,$page);
		$limit = ($page-1)*$page_num;
		$limit.=",{$page_num}";
		$sql_admin = "SELECT * FROM {$this->Common->db->dbprefix}admin order by id desc limit  {$limit}";
		$list = $this->Common->query_array($sql_admin);
		foreach($list as $k=> $row)
		{
			$list[$k]['status'] = ($row['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['teach'] = ($row['teach_id'] > 0 )?$this->teach_type[$row['teach_id']]:'<font color="red">无</font>';
			$list[$k]['towns'] = ($row['towns_id'] > 0 )?$this->towns[$row['towns_id']]:'<font color="red">无</font>';
				
		}
		$config['base_url'] = site_url('user/show/');
		
		//几行可选设置
		$config['full_tag_open'] = '<div class="pagination">'; // 分页开始样式
		$config['full_tag_close'] = '</div>'; // 分页结束样式
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示
		$config['next_link'] = '下一页 >'; // 下一页显示
		$config['prev_link'] = '< 上一页'; // 上一页显示
		$config['cur_tag_open'] = ' <a class="current">'; // 当前页开始样式
		$config['cur_tag_close'] = '</a>'; // 当前页结束样式
		$config['num_links'] = 2;// 当前连接前后显示页码个数
		$config['total_rows']=$total;
		$config['per_page']=$page_num;
		$config['uri_segment'] = 3;
		$config['cur_page']= $this->uri->segment(3,0);
		$this->pagination->initialize($config);
		$this->load->view("system/user_show",array(
				'data'=>$list,
				'page_link'=>$this->pagination->create_links(),
				'role'=>$this->role,
				
		));
	}
	function add()
	{
		$action=html_escape($this->input->get_post("action"));
		if($action=='do_add')
		{
			 $this->do_add();
		}
		else
		{
			$this->load->view("system/user_add",array('role'=>$this->role,'towns_all'=>$this->towns,'teach'=>$this->teach_type));
		}
	}
	//添加用户
	private function do_add()
	{
		$this->check_user();
		$insert_array=array(
				'username'=>html_escape($this->input->get_post("username")),
				'password'=>md5(html_escape($this->input->get_post("password"))),
				'status'=>html_escape($this->input->get_post("status")),
				'role_id'=>html_escape($this->input->get_post("role_id")),
				'teach_id'=>html_escape($this->input->get_post("teach_id")),
				'towns_id'=>html_escape($this->input->get_post("towns_id")),
				'show'=>html_escape($this->input->get_post("show")),
				'real_name' => html_escape($this->input->get_post("real_name"))
		);
		$query_insert=$this->Common->query_insert("{$this->Common->db->dbprefix}admin",$insert_array);
		if($query_insert['affected_rows']>0)
		{
			show_message("用户添加成功","user/show",2);
		}
		else 
		{
			show_message("用户添加失败，请重新添加","user/add",1);
		}
		
		
	}
	function edit()
	{
		$action=html_escape($this->input->get_post("action"));
		if($action=='do_edit')
		{
			$this->do_edit();
		}
		else 
		{
			$id = html_escape($this->input->get_post("id"));
			$id=verify_id($id);
			$sql_role="SELECT * FROM {$this->Common->db->dbprefix}admin WHERE id=".$id;
			$data=$this->Common->query_one($sql_role);
			$data['role']=$this->role;
			$data['towns_all']=$this->towns;
			$data['teach']=$this->teach_type;
			if(empty($data['id']))
			{
				show_message("没有该条记录","user/show",1);
			}
			$this->load->view("system/user_edit",$data);
		}
	}
	private function do_edit()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$status = html_escape($this->input->get_post("status"));
		$password = html_escape($this->input->get_post("password"));
		$real_name = html_escape($this->input->get_post("real_name"));
		$role_id = verify_id(html_escape($this->input->get_post("role_id")));
		$teach_id = verify_id(html_escape($this->input->get_post("teach_id")));
		$towns_id = verify_id(html_escape($this->input->get_post("towns_id")));
		$show = verify_id(html_escape($this->input->get_post("show")));
		$data=array(
				'status'=>$status,
				'role_id'=>$role_id,
				'teach_id'=>$teach_id,
				'towns_id'=>$towns_id,
				'teach_id'=>$teach_id,
				'show'=>$show,
				'real_name'=>$real_name,
		);
		if($password)
		{
			$data['password']=md5($password);
		}
		$where=array('id'=>$id);
		$query_update=$this->Common->query_update("{$this->Common->db->dbprefix}admin",$data,$where);
		if($query_update['affected_rows']>0)
		{
			show_message("用户修改成功","user/show",2);
		}
		else 
		{
			show_message("用户修改失败，请重新修改","user/edit/".$id,1);
		}
	}
	/**
	 * 检查用户名是不存在
	 */
	function check_user()
	{
		$username = html_escape($this->input->get_post("username"));
		$sql_admin="SELECT * FROM {$this->Common->db->dbprefix}admin WHERE username='".$username."'";
		$query_admin=$this->Common->query_one($sql_admin);
		if(!empty($query_admin['id']))
		{
			show_message("用户已经存在","user/show",2);
		}
	}
	function do_del()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}admin",array('id'=>$id));
		if($query_delete['affected_rows']>0)
		{
			show_message("用户删除成功","user/show",2);
		}
		else
		{
			show_message("用户删除失败，请重新删除","user/show",1);
		}		
	}
	
	
}