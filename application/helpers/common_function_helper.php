<?php 

/**

* 处理form 提交的参数过滤
* $string	string  需要处理的字符串或者数组
* $force	boolean  强制进行处理
* @return	string 返回处理之后的字符串或者数组
*/
if(!function_exists("daddslashes")){
	function daddslashes($string, $force = 1) {
		if(is_array($string)) {
			$keys = array_keys($string);
			foreach($keys as $key) {
				$val = $string[$key];
				unset($string[$key]);
				$string[addslashes($key)] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}
}
/**
 * 显示错误或成功信息
 * $message	string	显示提示文字
 * $flag	int	选择模版，目前两块模版 1=错误模版
 * $jump_url	string	跳转路径
 * $jump_time	int	页面停留时间
 */
if(!function_exists("show_message"))
{
	function show_message($message='',$jump_url,$flag=1,$jump_time=3)
	{
		if($flag==1)
		{
			include APPPATH.'/errors/show_message_error.php';
		}
		else 
		{
			include APPPATH.'/errors/show_message_success.php';
		}
		exit;
	}
}


/**
 *记录系统操作日志文件到数据库里面 
 **sql 是要插入数据库中的 log_sql的值 
 *$action 动作
 *$person 操作人
 *$ip ip地址
 *status 操作是否成功 1成功 0失败
 *message 失败信息
 *groupname_ 定义数据库连接信息的时候的 groupname
 */
if(!function_exists("write_action_log") ){
	function write_action_log($sql,$url = '' ,$person = '' ,$ip = '',$status = '1' ,$message = '' , $groupname_ = "real_data"){
		if(!config_item('is_write_log_to_database')){//是否记录日志文件到数据表中
			return false ;
		}
		
		$sql = str_replace("\\", "", $sql); // 把\进行过滤掉
		$sql = str_replace("%", "\%", $sql); // 把 '%'前面加上\
		$sql = str_replace("'", "\'", $sql); // 把 ''过滤掉
		$message = daddslashes($message ) ;
		$time = date("Y-m-d H:i:s",time());
		$time_table = date("Ym",time());
		

		$table_pre = table_pre($groupname_) ;
		
	$sql_table = <<<EOT
CREATE TABLE IF NOT EXISTS `{$table_pre}common_log_{$time_table}` (
  `log_id` mediumint(8) NOT NULL auto_increment,
  `log_url` varchar(50) NOT NULL,
  `log_person` varchar(16) NOT NULL,
  `log_time` datetime NOT NULL,
  `log_ip` char(15) NOT NULL,
  `log_sql` text NOT NULL,
  `log_status` tinyint(1) NOT NULL default '1',
  `log_message` varchar(255) NOT NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;		
EOT;
		$ci = &get_instance(); //初始化 为了用方法
		$d = $ci->load->database($groupname_,true);
		$d->query($sql_table);
		$sql_log = "INSERT INTO `{$table_pre}common_log_{$time_table}`(`log_url`,`log_person`,`log_time`,`log_ip`,`log_sql`,`log_status`,`log_message`)VALUES('{$url}','{$person}','{$time}','{$ip}','{$sql}','{$status}','{$message}')" ;
		$d->query($sql_log);
		
	}
}

/**  摘自 discuz
 * $string 明文或密文
 * $operation 加密ENCODE或解密DECODE
 * $key 密钥
 * $expiry 密钥有效期 ， 默认是一直有效
 */
if(!function_exists("auth_code")){
	function auth_code($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		/*
		 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
		 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
		 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
		 当此值为 0 时，则不产生随机密钥
		 */
		$ckey_length = 4;
		$key = md5($key != '' ? $key : "fdsfdf43535svxfsdfdsfs"); // 此处的key可以自己进行定义，写到配置文件也可以
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
}
/**

* 处理form 提交的参数过滤
* $string	string  需要处理的字符串
* @return	string 返回处理之后的字符串或者数组
*/
if(!function_exists("dowith_sql")){
	function dowith_sql($str)
	{
		$str = str_replace("and","",$str);
		$str = str_replace("execute","",$str);
		$str = str_replace("update","",$str);
		$str = str_replace("count","",$str);
		$str = str_replace("chr","",$str);
		$str = str_replace("mid","",$str);
		$str = str_replace("master","",$str);
		$str = str_replace("truncate","",$str);
		$str = str_replace("char","",$str);
		$str = str_replace("declare","",$str);
		$str = str_replace("select","",$str);
		$str = str_replace("create","",$str);
		$str = str_replace("delete","",$str);
		$str = str_replace("insert","",$str);
		// $str = str_replace("'","",$str);
		// $str = str_replace('"',"",$str);
		// $str = str_replace(" ","",$str);
		$str = str_replace("or","",$str);
		$str = str_replace("=","",$str);
		$str = str_replace("%20","",$str);
		//echo $str;
		return $str;
	}
}
/**
 *分页显示的方法
 *params $total 总数
 *params $page_num 每一页显示的条数
 *params $page 当前第几页
 *params $ajax_function ajax方法名字
 */
if(!function_exists("show_page")){
	function show_page($total,$page_num,$page,$ajax_function = 'ajax_data')
	{
		$CI =& get_instance();
		$page_string = '' ;
		$CI->load->library('pagination');//加载分页类
		$config['total_rows'] = $total;
		$config['use_page_numbers'] =true; // 当前页结束样式
		$config['per_page'] = $page_num; // 每页显示数量，为了能有更好的显示效果，我将该数值设置得较小
		$config['full_tag_open'] = '<ul class="pagination">'; // 分页开始样式
		$config['full_tag_close'] = '</ul>'; // 分页结束样式
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示
		$config['next_link'] = '下一页 >'; // 下一页显示
		$config['prev_link'] = '< 上一页'; // 上一页显示
		$config['cur_tag_open'] = ' <li><a class="disabled ">'; // 当前页开始样式
		$config['cur_tag_close'] = '</a></li>'; // 当前页结束样式
		$config['uri_segment'] = 6;
		$config['anchor_class']='class="ajax_page" ';
		$CI->pagination->cur_page = $page ;
		$CI->pagination->initialize($config); // 配置分页
		$page_string =  $CI->pagination->create_links(true,$ajax_function);
		return $page_string ;
	}
}
/**
 * 校验id
 */
if( !function_exists("verify_id") ){
	function verify_id($id=null) {
		if (!$id) {
			return 0;
		} // 是否为空判断
		elseif (inject_check($id)) {
			return 0;
		} // 注射判断
		elseif (!is_numeric($id)) {
			return 0 ;
		} // 数字判断
		$id = intval($id); // 整型化
		return $id;
	}
}
/**
 *检测提交的值是不是含有SQL注射的字符，防止注射，保护服务器安全
 *参　　数：$sql_str: 提交的变量
 *返 回 值：返回检测结果，ture or false
 */

if( !function_exists("inject_check") ){
	function inject_check($sql_str) {
		return @eregi('select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str); // 进行过滤
	}
}

/**
 * 将数据格式化成树形结构
 * @param array $items
 * @return array
 */
if(!function_exists("genTree9")){
	function genTree9($items,$id = 'id' ,$pid = 'pid' ,$child = 'children' ) {
		$tree = array(); //格式化好的树
		foreach ($items as $item)
			if (isset($items[$item[$pid]]))
				$items[$item[$pid]][$child][] = &$items[$item[$id]];
			else
				$tree[] = &$items[$item[$id]];
			return $tree;
	}
}

/**
 * 格式化select
 * @author 王建
 * @param array $parent
 * @deep int 层级关系
 * @return array
 */
function getChildren($parent,$deep=0) {
	
	foreach($parent as $row) {
		$data[] = array("id"=>$row['id'], "menu_name"=>$row['menu_name'],"menu_pid"=>$row['menu_pid'],'deep'=>$deep,'url'=>$row['menu_url'],'menu_status'=>$row['menu_status'],'menu_sort'=>$row['menu_sort']);
		if (isset($row['childs']) && !empty($row['childs'])) {
			$data = array_merge($data, getChildren($row['childs'], $deep+1));
		}
	}
	
	return $data;
}
/**
 * 
 */
/*
if(!function_exists("get_tree"))
{
	function get_tree($tree)
	{
		$array=array();
		foreach ($tree as $key0=>$val0)
		{
			$temp['']=
			foreach ($val0['childs'] as $key1=>$val1)
			{
				foreach ($val1['childs'] as $key2=>$val2)
				{
					
				}
			}
		}
	}
}
*/