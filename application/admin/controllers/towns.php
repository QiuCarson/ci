<?php 
class Towns extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
	}
	function show($page=1)
	{
		$this->load->library('pagination');
		//$page = $this->input->get_post("page");
		if($page <=0 ){
			$page = 1 ;
		}
		$page_num=30;
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->Common->db->dbprefix}towns ";
		$total  = $this->Common->query_count($sql_count);
		$page_string=show_page($total,$page_num,$page);
		$limit = ($page-1)*$page_num;
		$limit.=",{$page_num}";
		$sql_towns = "SELECT * FROM {$this->Common->db->dbprefix}towns order by id desc limit  {$limit}";
		$list = $this->Common->query_array($sql_towns);
		
		$config['base_url'] = site_url('towns/show/');
		
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
		
		$this->load->view("towns/towns_show",array(
				'list'=>$list,
				'page_link'=>$this->pagination->create_links(),
				
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
			$this->load->view("towns/towns_add");
		}
	}
	//towns
	private function do_add()
	{
		
		$insert_array=array(
				'name'=>html_escape($this->input->get_post("name")),
				
		);
		if(empty($insert_array['name']))
		{
			show_message("镇街名不能为空","towns/add",1);
		}
		$query_insert=$this->Common->query_insert("{$this->Common->db->dbprefix}towns",$insert_array);
		if($query_insert['affected_rows']>0)
		{
			show_message("添加成功","towns/show",2);
		}
		else 
		{
			show_message("添加失败，请重新添加","towns/add",1);
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
			$sql_role="SELECT * FROM {$this->Common->db->dbprefix}towns WHERE id=".$id;
			$data=$this->Common->query_one($sql_role);
			if(empty($data['id']))
			{
				show_message("没有该条记录","towns/show",1);
			}
			$this->load->view("towns/towns_edit",$data);
		}
	}
	private function do_edit()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$name = html_escape($this->input->get_post("name"));
		if(empty($name))
		{
			show_message("镇街名不能为空","towns/edit/".$id,1);
		}
		$data=array(
				'name'=>$name,
				
		);
		
		$where=array('id'=>$id);
		$query_update=$this->Common->query_update("{$this->Common->db->dbprefix}towns",$data,$where);
		if($query_update['affected_rows']>0)
		{
			show_message("用户修改成功","towns/show",2);
		}
		else 
		{
			show_message("用户修改失败，请重新修改","towns/edit/".$id,1);
		}
	}
	
	function do_del()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}towns",array('id'=>$id));
		if($query_delete['affected_rows']>0)
		{
			show_message("删除成功","towns/show",2);
		}
		else
		{
			show_message("删除失败，请重新删除","towns/show",1);
		}		
	}
	
}
