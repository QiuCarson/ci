<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$sql_towns= "SELECT * FROM {$this->Common->db->dbprefix}towns ORDER BY orderby DESC,id DESC";
		$list_towns = $this->Common->query_array($sql_towns);
		
		$sql_admin= "SELECT * FROM {$this->Common->db->dbprefix}admin WHERE status=1 AND `show`=1 ORDER BY id DESC";
		$list_admin = $this->Common->query_array($sql_admin);
		
		$teach_type=config_item('teach_type');
		
		foreach ($list_admin as $k=>$val)
		{
			$data[$val['towns_id']][$val['teach_id']][$k]=$val;
		}
		foreach($list_towns as $k=> $row)
		{
			$data[$row['id']]['name']=$row;
		}
		#echo $this->config->site_url('wlecom/show');
		#echo "<pre>";
		#print_r($data);
		$this->load->view('welcome_message',array('data'=>$data,'teach_type'=>$teach_type));
	}
	public function show($page =1)
	{
		$uid=html_escape($this->input->get_post("uid"));
		#$config=config_item("upload");
		#$ducha_type=config_item('ducha_type');
		$this->load->library('pagination');
		#$page = $this->input->get_post("page");
		if($page <=0 ){
			$page = 1 ;
		}
		$page_num=30;
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->Common->db->dbprefix}ducha WHERE author_id=".$uid;
		$total  = $this->Common->query_count($sql_count);
		
		$limit = ($page-1)*$page_num;
		$limit.=",{$page_num}";
		$sql_ducha = "SELECT * FROM {$this->Common->db->dbprefix}ducha WHERE author_id=".$uid." ORDER BY id DESC LIMIT  {$limit}";
		$list = $this->Common->query_array($sql_ducha);
		#$page_string=show_page($total,$page_num,$page);
		$config['base_url'] = $this->config->site_url('welcome/show');
		
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
		$this->pagination->cur_page = $page ;
		#$config['cur_page']= $this->uri->segment(3,0);
		$this->pagination->initialize($config);
		
		
		#用户名和最早上传日期
		$sql_ducha = "SELECT * FROM {$this->Common->db->dbprefix}ducha WHERE author_id=".$uid." ORDER BY id ASC LIMIT 1";
		$ducha_one = $this->Common->query_one($sql_ducha);
		if(empty($ducha_one))
		{
			$sql_user = "SELECT * FROM {$this->Common->db->dbprefix}admin WHERE id=".$uid." ORDER BY id ASC LIMIT 1";
			$user_one = $this->Common->query_one($sql_user);
			$ducha_one['author']=$user_one['real_name'];
			$ducha_one['create_time']=date('Y-m-d');
		}
		$this->load->view("index_show",array(
				'list'=>$list,
				'config'=>config_item("upload"),
				'page_link'=>$this->pagination->create_links(),
				'ducha_one'=>$ducha_one,
				'total'=>$total,
		));
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */