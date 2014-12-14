<?php 
class Common extends CI_Model
{
	public $db ;
	public function __construct($params = array())
	{
		$type = '' ;
		$type =( isset($params['type']) && $params['type'] )? $params['type'] : 'default' ;
		parent::__construct();
		$this->db = $this->load->database($type,TRUE);
		//print_r($this->db );exit;
	}
	
	//查询1条数据，返回结果
	function query_one($sql)
	{
		//print_r($this->db->query());exit;
		return $this->db->query($sql)->row_array();
	}
	
	//查询返回的结果
	function query_count($sql)
	{
		$query = $this->db->query($sql);
		$num_array = $query->result_array();
		$num = 0 ;
		if(isset($num_array[0]) && !empty($num_array[0]))
		{
			foreach ($num_array[0] as $k=>$v){
				$num = $v ;
				break ;
			}
		}
		return $num ;
	
	}
	
	//查询返回数组
	function query_array($sql)
	{
		$query = $this->db->query($sql);
		$query_list=array();
		foreach ($query->result_array() as $row)
		{
			$query_list[]=$row;
		}
		return $query_list;
	}
	
	
	/**
	 * 插入数据库
	 * param string $table	表名
	 * param array $array	字段名对应插入值的方法
	 * return array 
	 */
	function query_insert($table,$array)
	{
		$this->db->insert($table,$array);
		return array(
				'insert_id'=>$this->db->affected_rows(),//数据插入时的ID
				'affected_rows'=>$this->db->affected_rows(),//影响的行
				
		);
	}
	/**
	 * 批量插入数据库
	 * param string $table	表名
	 * param array $array	字段名对应插入值的方法
	 * return array
	 */
	function query_batch_insert($table,$array)
	{
		$this->db->insert_batch($table,$array);
		return array(
				'insert_id'=>$this->db->affected_rows(),//数据插入时的ID
				'affected_rows'=>$this->db->affected_rows(),//影响的行
	
		);
	}
	/**
	 * 更新数据库
	 * param string $table 表名
	 * param array $data 更新的数据
	 * param array $where 更新条件
	 * return array
	 */
	function query_update($table,$data,$where)
	{
		$this->db->update($table, $data, $where);
		return array(
				'affected_rows'=>$this->db->affected_rows(),//影响的行
		);
	}
	/**
	 * 删除数据
	 * param string $table 表名
	 * param array $where 删除条件
	 */
	function query_delete($table,$where)
	{
		$this->db->delete($table, $where);
		return array(
				'affected_rows'=>$this->db->affected_rows(),//影响的行
		);
	}
	/**
	 * 获取角色权限
	 * @param int $role_id
	 */
	public function get_acl($role_id)
	{
		
		$sql_menu_to_role="SELECT m.menu_url FROM {$this->db->dbprefix}menu_to_role mtr  
			JOIN {$this->db->dbprefix}menu m 
			ON mtr.menu_id=m.id
			WHERE m.menu_status=1 AND mtr.role_id='".$role_id."'
			";
		$query=$this->query_array($sql_menu_to_role);
		if($query)
		{
			foreach ($query as $val)
			{
				if($val['menu_url'])
				{
					if(preg_match("/\/$/", $val['menu_url']))
					{
						
					}
					else
					{
						$val['menu_url'].="/";
					}
					$menu_url[]=$val['menu_url'];
				}				
			}
			return $menu_url;
		}		
	}
	/**
	 * 获取用户信息
	 * @param array $admin_id
	 */
	function get_user_info($admin_id)
	{
		$admin_id=verify_id($admin_id);
		$sql_admin="SELECT * FROM {$this->db->dbprefix}admin WHERE id=".$admin_id;
		return $this->query_one($sql_admin);
	}
	
}