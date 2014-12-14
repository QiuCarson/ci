<?php 
class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
	}
	
	function login()
	{
	
		$this->load->view('login');
	}
	
	function index()
	{
		
		$this->load->view('index');
	}
	function left()
	{
		$list=array();
		$admin_auth=$this->input->cookie('admin_auth', TRUE);
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$data_cookie_array=unserialize($encode_string);
		
		
		
		$sql_menu = "SELECT * FROM {$this->Common->db->dbprefix}menu_to_role mtr
		JOIN {$this->Common->db->dbprefix}menu m
		ON mtr.menu_id=m.id
		WHERE m.menu_status=1 AND mtr.role_id='".$data_cookie_array['role_id']."'ORDER BY id DESC ";
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
		//print_r($result);
		$this->load->view('left',array('result'=>$result));
	}
	function right()
	{
		$admin_auth=$this->input->cookie('admin_auth', TRUE);
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$data_cookie_array=unserialize($encode_string);
		$this->load->view('right',$data_cookie_array);
	}
	function head()
	{
		$admin_auth=$this->input->cookie('admin_auth', TRUE);
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$data_cookie_array=unserialize($encode_string);
		$this->load->view('head',$data_cookie_array);
	}
}
