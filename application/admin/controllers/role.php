<?php 
class Role extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
	}
	function show()
	{
		$page = $this->input->get_post("page");
		if($page <=0 ){
			$page = 1 ;
		}
		$page_num=10;
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->Common->db->dbprefix}role ";
		$total  = $this->Common->query_count($sql_count);
		$page_string=show_page($total,$page_num,$page);
		$limit = ($page-1)*$page_num;
		$limit.=",{$page_num}";
		$sql_role = "SELECT * FROM {$this->Common->db->dbprefix}role ORDER BY id DESC LIMIT  {$limit}";
		$list = $this->Common->query_array($sql_role);
		foreach($list as $k=> $row)
		{
			$list[$k]['status'] = ($row['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			
		}
		
		$config['base_url'] = site_url('role/show/');
		
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
		#$config['cur_page']= $this->uri->segment(3,0);
		$this->pagination->initialize($config);
		
		$this->load->view("system/role_show",array('data'=>$list,'page_link'=>$this->pagination->create_links()));
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
			$this->load->view("system/role_add");
		}
	}
	//添加用户
	private function do_add()
	{
		//echo "AA";exit;
		$insert_array=array(
				'role_name'=>html_escape($this->input->get_post("role_name")),
				
		);
		$query_insert=$this->Common->query_insert("{$this->Common->db->dbprefix}role",$insert_array);
		if($query_insert['affected_rows']>0)
		{
			show_message("角色添加成功","role/show",2);
		}
		else 
		{
			show_message("角色添加失败，请重新添加","role/add",1);
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
			$sql_role="SELECT * FROM {$this->Common->db->dbprefix}role WHERE id=".$id;
			$data=$this->Common->query_one($sql_role);
			if(empty($data['id']))
			{
				show_message("没有该条记录","role/show",1);
			}
			$this->load->view("system/role_edit",$data);
		}
	}
	private function do_edit()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$status = html_escape($this->input->get_post("status"));
		$role_name = html_escape($this->input->get_post("role_name"));
		$data=array(
				'status'=>$status,
				'role_name'=>$role_name
		);
		$where=array('id'=>$id);
		$query_update=$this->Common->query_update("{$this->Common->db->dbprefix}role",$data,$where);
		if($query_update['affected_rows']>0)
		{
			show_message("角色修改成功","role/show",2);
		}
		else 
		{
			show_message("角色修改失败，请重新修改","role/edit/".$id,1);
		}
	}
	/**
	 * 检查该角色下面还有没有用户
	 */
	function check_role()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$sql_admin="SELECT * FROM {$this->Common->db->dbprefix}admin WHERE role_id=".$id;
		$query_admin=$this->Common->query_one($sql_admin);
		if(!empty($query_admin['id']))
		{
			echo "exists";
		}
	}
	function do_del()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}role",array('id'=>$id));
		if($query_delete['affected_rows']>0)
		{
			show_message("角色删除成功","role/show",2);
		}
		else
		{
			show_message("角色删除失败，请重新删除","role/show",1);
		}		
	}
	/**
	 * 用户添加权限
	 */
	function role_add_menu_show($id=0)
	{
		$action=html_escape($this->input->get_post("action"));
		if($action=='do_role_add_menu_show')
		{
			$this->do_role_add_menu_show();
		}
		else
		{
			$id = verify_id($id);
			$list=array();
			$sql_menu = "SELECT * FROM {$this->Common->db->dbprefix}menu ORDER BY id DESC ";
			$list = $this->Common->query_array($sql_menu);
			$result=array();
			if($list)
			{
				foreach($list as $k=> $row)
				{
					$result[$row['id']]  = $row ;
				}
					
				$result = genTree9($result,'id','menu_pid','childs');
					
			}
			$sql_menu_to_role="SELECT * FROM {$this->Common->db->dbprefix}menu_to_role WHERE role_id=".$id;
			$list_menu_to_role = $this->Common->query_array($sql_menu_to_role);
			$menu_to_role=array();
			if($list_menu_to_role)
			{
				foreach ($list_menu_to_role as $val)
				{
					$menu_to_role[]=$val['menu_id'];
				}
			}
			//print_r($list_menu_to_role);
			
			$this->load->view("system/role_add_menu_show",array(
					'result'=>$result,
					'menu_to_role'=>$menu_to_role,
					'id'=>$id
			));
		}
	}
	function do_role_add_menu_show()
	{
		$menu_id=array();
		$role_id = verify_id(html_escape($this->input->get_post("role_id")));
		$menu_id=html_escape($this->input->get_post("menu_id"));
		
		
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}menu_to_role",array('role_id'=>$role_id));
		
		if($menu_id && is_array($menu_id) && count($menu_id))
		{
			$data=array();
			for ($i=0;$i<count($menu_id);$i++)
			{
				$data[]=array(
						'menu_id' =>  $menu_id[$i],
						'role_id' =>  $role_id,
				);
			}
			$query_batch_insert=$this->Common->query_batch_insert("{$this->Common->db->dbprefix}menu_to_role", $data);	
		}
		if($query_batch_insert['affected_rows']>0 || count($menu_id)==0)
		{
			show_message("赋权成功","role/show",2);
		}
		else
		{
			show_message("失败，请重新选择","role/show",1);
		}
	}
	
	
}