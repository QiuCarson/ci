<?php 
class Menu extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
	}
	function show()
	{
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
		$this->load->view("system/menu_show",array('result'=>$result));
	}
	function add($id=0)
	{
		$action=html_escape($this->input->get_post("action"));
		if($action=='do_add')
		{
			 $this->do_add();
		}
		else 
		{
			$id=verify_id($id);
			$sql_menu = "SELECT * FROM {$this->Common->db->dbprefix}menu ORDER BY menu_sort DESC,id DESC ";
			$list = $this->Common->query_array($sql_menu);
			$result=array();
			if($list)
			{
				foreach($list as $k=> $row)
				{
					$result[$row['id']]  = $row ;
				}
			}
			$data['options'] = getChildren(genTree9($result,'id','menu_pid','childs'));
			$data['pid']=$id;
			
			$this->load->view("system/menu_add",$data);
		}
		
	}
	private function do_add()
	{
		$insert_array=array(
				'menu_pid'=>verify_id(html_escape($this->input->get_post("menu_pid"))),
				'menu_name'=>html_escape($this->input->get_post("menu_name")),
				'menu_sort'=>html_escape($this->input->get_post("menu_sort")),
				'menu_url'=>html_escape($this->input->get_post("menu_url")),
				'menu_status'=>html_escape($this->input->get_post("menu_status"))
		
		);
		$query_insert=$this->Common->query_insert("{$this->Common->db->dbprefix}menu",$insert_array);
		if($query_insert['affected_rows']>0)
		{
			show_message("节点添加成功","menu/show",2);
		}
		else
		{
			show_message("节点添加失败，请重新添加","menu/add",1);
		}
	}
	function edit($id=0)
	{
		$action=html_escape($this->input->get_post("action"));
		if($action=='do_edit')
		{
			$this->do_edit();
		}
		else
		{
			$id=verify_id($id);
			$info = $this->Common->query_one("SELECT * FROM {$this->Common->db->dbprefix}menu WHERE id = '{$id}' ORDER BY menu_sort DESC,id DESC");
			if(empty($info)){
				show_message("请传递正确的参数","menu/show",1);			
			}
			$sql_menu = "SELECT * FROM {$this->Common->db->dbprefix}menu order by id desc ";
			$list = $this->Common->query_array($sql_menu);
			$result=array();
			if($list)
			{
				foreach($list as $k=> $row)
				{
					$result[$row['id']]  = $row ;
				}
			}
			$data['options'] = getChildren(genTree9($result,'id','menu_pid','childs'));
			$data['pid']=$id;
			$data['info']=$info;
			//print_r($data);
			$this->load->view("system/menu_edit",$data);							
		}
	}
	private function do_edit()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$menu_status = html_escape($this->input->get_post("menu_status"));
		$menu_name = html_escape($this->input->get_post("menu_name"));
		$menu_pid = html_escape($this->input->get_post("menu_pid"));
		$menu_sort = html_escape($this->input->get_post("menu_sort"));
		$menu_url = html_escape($this->input->get_post("menu_url"));
		$data=array(
				'menu_status'=>$menu_status,
				'menu_name'=>$menu_name,
				'menu_pid'=>$menu_pid,
				'menu_sort'=>$menu_sort,
				'menu_url'=>$menu_url,
		);
		$where=array('id'=>$id);
		$query_update=$this->Common->query_update("{$this->Common->db->dbprefix}menu",$data,$where);
		if($query_update['affected_rows']>0)
		{
			show_message("修改成功","menu/show",2);
		}
		else
		{
			show_message("修改失败，请重新修改","menu/edit/".$id,1);
		}
	}
	function do_del($id=0)
	{
		$id = verify_id(html_escape($id));
		
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}menu",array('id'=>$id));
		if($query_delete['affected_rows']>0)
		{
			show_message("节点删除成功","menu/show",2);
		}
		else
		{
			show_message("节点删除失败，请重新删除","menu/show",1);
		}
	}
}
?>