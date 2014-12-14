<?php 
class Myducha extends CI_Controller
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
		$admin_auth=$this->input->cookie('admin_auth', TRUE);
		$encode_string = auth_code($admin_auth,"DECODE",config_item("encrypt_key"));
		$data_cookie_array=unserialize($encode_string);
		$author_id=$data_cookie_array['admin_id'];
		//$config=config_item("upload");
		$this->load->library('pagination');
		#$page = $this->input->get_post("page");
		
		$ducha_type=config_item('ducha_type');
		//$page = $this->input->get_post("page");
		if($page <=0 ){
			$page = 1 ;
		}
		$page_num=30;
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->Common->db->dbprefix}ducha WHERE   author_id=".$author_id;
		$total  = $this->Common->query_count($sql_count);
		$page_string=show_page($total,$page_num,$page);
		$limit = ($page-1)*$page_num;
		$limit.=",{$page_num}";
		$sql_ducha = "SELECT * FROM {$this->Common->db->dbprefix}ducha WHERE  author_id=".$author_id." ORDER BY id DESC LIMIT  {$limit}";
		$list = $this->Common->query_array($sql_ducha);
		
		$config['base_url'] = site_url('myducha/show/');
		
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
		
		#用户名和最早上传日期
		$sql_ducha = "SELECT * FROM {$this->Common->db->dbprefix}ducha WHERE author_id=".$author_id." ORDER BY id ASC LIMIT 1";
		$ducha_one = $this->Common->query_one($sql_ducha);
		if(empty($ducha_one))
		{
			$sql_user = "SELECT * FROM {$this->Common->db->dbprefix}admin WHERE id=".$author_id." ORDER BY id ASC LIMIT 1";
			
			$user_one = $this->Common->query_one($sql_user);
			$ducha_one['author']=$user_one['real_name'];
			$ducha_one['create_time']=date('Y-m-d');
		}
		
		$this->load->view("myducha/ducha_show",array(
				'list'=>$list,
				'config'=>config_item("upload"),
				'page_link'=>$this->pagination->create_links(),
				'ducha_one'=>$ducha_one,
				'total'=>$total,
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
			$this->load->view("myducha/ducha_add",array('error_zhenggai_file_name' => ' ','error_ducha_file_name'=> ''));
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
			#print_r($ducha_file_name);
			
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
				show_message("添加成功","myducha/show",2);
			}
			else
			{
				show_message("添加失败，请重新添加","myducha/add",1);
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
			
			$this->load->view("myducha/ducha_edit",$data);
		}
	}
	private function do_edit()
	{
		
		$id = verify_id(html_escape($this->input->get_post("id")));
		$config=config_item("upload");
		$this->check_access_ducha($id);
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
			show_message("修改成功","myducha/show",2);
		}
		else 
		{
			show_message("修改失败，请重新修改","myducha/edit?id=".$id,1);
		}
	}
	
	function do_del()
	{
		$id = verify_id(html_escape($this->input->get_post("id")));
		$this->check_access_ducha($id);
		$query_delete=$this->Common->query_delete("{$this->Common->db->dbprefix}ducha",array('id'=>$id));
		if($query_delete['affected_rows']>0)
		{
			show_message("删除成功","myducha/show",2);
		}
		else
		{
			show_message("删除失败，请重新删除","myducha/show",1);
		}		
	}
	function check_access_ducha($id)
	{
		$after12hours=date("Y-m-d H:i:s",strtotime("-12 hours"));
		$id=verify_id($id);
		$sql_role="SELECT * FROM {$this->Common->db->dbprefix}ducha WHERE id=".$id." AND create_time>'".$after12hours."'";
		$data=$this->Common->query_one($sql_role);
		if(empty($data['id']))
		{
			show_message("超过12小时，不能操作这条记录","myducha/show",1);
		}
	}
	function rename_file($old_file_name,$new_file_name)
	{
		if(file_exists($new_file_name))
		{
			@unlink($new_file_name);
		}
		if(file_exists($old_file_name))
		{
			#echo $new_file_name;exit;
			$new_file_name=iconv("utf-8", "gb2312", $new_file_name);
			#$new_file_name=iconv('gbk', 'utf-8', $new_file_name);
			rename($old_file_name,$new_file_name);
		}
	}
}