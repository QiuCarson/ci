<?php 
class Ducha extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
		$this->load->helper(array('form', 'url'));
		$config=config_item("upload");
		$admin_auth=$this->input->cookie('admin_auth', TRUE);
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$this->data_cookie_admin=unserialize($encode_string);
		$filename=$config['upload_path'].$this->data_cookie_admin['username'];
		if(!file_exists($filename))
		{
			mkdir($filename);
		}
	}
	function show($page=1)
	{
		//$config=config_item("upload");
		$ducha_type=config_item('ducha_type');
		//if(empty($page)){
		$page = $this->input->get_post("per_page");
		//}
		$current_user= $this->input->get_post("option_user");
		$current_date= $this->input->get_post("date");
		
		$where=" WHERE 1=1";
		if ($current_user)
		{
			$where.=" AND author_id=".$current_user." ";
		}
		if ($current_date)
		{
			$where.=" AND create_time like '".$current_date."%'";
		}
		
		if($page <=0 ){
			$page = 1 ;
		}
		$page_num=30;
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->Common->db->dbprefix}ducha $where";
		$total  = $this->Common->query_count($sql_count);
		$page_string=show_page($total,$page_num,$page);
		$limit = ($page-1)*$page_num;
		$limit.=",{$page_num}";
		$sql_ducha = "SELECT * FROM {$this->Common->db->dbprefix}ducha $where ORDER BY id DESC LIMIT  {$limit}";
		$list = $this->Common->query_array($sql_ducha);
		
		$config['base_url'] = site_url('ducha/show/')."?option_user=".$current_user."&date=".$current_date;
		
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
		$config['page_query_string'] = TRUE;
		#$config['cur_page']= $this->uri->segment(3,0);
		$this->pagination->initialize($config);
		
		#查询所有的用户
		$sql_user="SELECT * FROM {$this->Common->db->dbprefix}admin ORDER BY id DESC";
		$list_user = $this->Common->query_array($sql_user);
		
		#查询所有的日期
		$sql_ducha="SELECT LEFT(create_time,10)as time FROM {$this->Common->db->dbprefix}ducha GROUP BY LEFT(create_time,10)";
		$list_date_ducha = $this->Common->query_array($sql_ducha);
		
		$this->load->view("ducha/ducha_show",array(
				'list'=>$list,
				'config'=>config_item("upload"),
				'page_link'=>$this->pagination->create_links(),
				'list_user'=>$list_user,
				'current_user'=>$current_user,
				'list_date_ducha'=>$list_date_ducha,
				'current_user'=>$current_user,
				'current_date'=>$current_date,
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
			$this->load->view("ducha/ducha_add",array('error_zhenggai_file_name' => ' ','error_ducha_file_name'=> ''));
		}
	}
	//添加
	private function do_add()
	{
		$config=config_item("upload");
		
		$this->load->library('upload', $config);
		if($_FILES['ducha_file_name']['name'])
		{
			if ( !$this->upload->do_upload('ducha_file_name') )
			{
				$error = array('error_ducha_file_name' => $this->upload->display_errors());
				$this->load->view('ducha/ducha_add', $error);
		
			}
			$ducha_file_name = $this->upload->data();
			$insert_array['ducha_file_name']=$this->data_cookie_admin['username']."/".date("Ymd")."督查情况".$ducha_file_name['file_ext'];
			$insert_array['ducha_show_name']=date("Ymd")."督查情况";
			
			$old_file_name=$config['upload_path'].$ducha_file_name['file_name'];
			$new_file_name=$config['upload_path'].$insert_array['ducha_file_name'];
			$this->rename_file($old_file_name,$new_file_name);
		}
		if($_FILES['zhenggai_file_name']['name'])
		{
			if(!$this->upload->do_upload('zhenggai_file_name') )
			{
				$error = array('error_zhenggai_file_name' => $this->upload->display_errors());
				$this->load->view('ducha/ducha_add', $error);
			}
			$zhenggai_file_name = $this->upload->data();
			$insert_array['zhenggai_file_name']=$this->data_cookie_admin['username']."/".date("Ymd")."整改情况".$zhenggai_file_name['file_ext'];
			$insert_array['zhenggai_show_name']=date("Ymd")."整改情况";
			
			$old_file_name=$config['upload_path'].$zhenggai_file_name['file_name'];
			$new_file_name=$config['upload_path'].$insert_array['zhenggai_file_name'];
			$this->rename_file($old_file_name,$new_file_name);
		}
			$admin_auth=$this->input->cookie('admin_auth', TRUE);
			$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
			$data_cookie_array=unserialize($encode_string);
			$insert_array['author']=$data_cookie_array['real_name'];
			$insert_array['author_id']=$data_cookie_array['admin_id'];
			
			$query_insert=$this->Common->query_insert("{$this->Common->db->dbprefix}ducha",$insert_array);
			if($query_insert['affected_rows']>0)
			{
				show_message("添加成功","ducha/show",2);
			}
			else
			{
				show_message("添加失败，请重新添加","ducha/add",1);
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
			$config=config_item("upload");
			$id = html_escape($this->input->get_post("id"));
			$id=verify_id($id);
			$sql_ducha="SELECT * FROM {$this->Common->db->dbprefix}ducha WHERE id=".$id;
			$data=$this->Common->query_one($sql_ducha);
			if(empty($data['id']))
			{
				show_message("没有该条记录","ducha/show",1);
			}
			$data['error']='';
			$data['config']=$config;
			$data['error_zhenggai_file_name']='';
			$data['error_ducha_file_name']='';
			
			$this->load->view("ducha/ducha_edit",$data);
		}
	}
	private function do_edit()
	{
		
		$id = verify_id(html_escape($this->input->get_post("id")));
		$config=config_item("upload");
		
		$this->load->library('upload', $config);
		if($_FILES['ducha_file_name']['name'])
		{
			if ( !$this->upload->do_upload('ducha_file_name') )
			{
				$error = array('error_ducha_file_name' => $this->upload->display_errors());
				$this->load->view('ducha/ducha_add', $error);
				
			} 
			$ducha_file_name = $this->upload->data();
			$data['ducha_file_name']=$this->data_cookie_admin['username']."/".date("Ymd")."督查情况".$ducha_file_name['file_ext'];
			$data['ducha_show_name']=date("Ymd")."督查情况";
			
			$old_file_name=$config['upload_path'].$ducha_file_name['file_name'];
			$new_file_name=$config['upload_path'].$data['ducha_file_name'];
			$this->rename_file($old_file_name,$new_file_name);
		}
		if($_FILES['zhenggai_file_name']['name'])
		{
			if(!$this->upload->do_upload('zhenggai_file_name') )
			{
				$error = array('error_zhenggai_file_name' => $this->upload->display_errors());
				$this->load->view('ducha/ducha_add', $error);
			}
			$zhenggai_file_name = $this->upload->data();
			$data['zhenggai_file_name']=$this->data_cookie_admin['username']."/".date("Ymd")."整改情况".$zhenggai_file_name['file_ext'];
			$data['zhenggai_show_name']=date("Ymd")."整改情况";
			
			$old_file_name=$config['upload_path'].$zhenggai_file_name['file_name'];
			$new_file_name=$config['upload_path'].$data['zhenggai_file_name'];
			$this->rename_file($old_file_name,$new_file_name);
		}
		
		$where=array('id'=>$id);
		
		$query_update=$this->Common->query_update("{$this->Common->db->dbprefix}ducha",$data,$where);
		if($query_update['affected_rows']>0)
		{
			show_message("修改成功","ducha/show",2);
		}
		else 
		{
			show_message("修改失败，请重新修改","ducha/edit?id=".$id,1);
		}
	}
	
	function do_del()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}ducha",array('id'=>$id));
		if($query_delete['affected_rows']>0)
		{
			show_message("删除成功","ducha/show",2);
		}
		else
		{
			show_message("删除失败，请重新删除","ducha/show",1);
		}		
	}
}