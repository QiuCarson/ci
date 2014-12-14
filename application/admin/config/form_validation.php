<?php 
$config = array(
		'login/do_login' => array(
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required'
				),
				array(
						'field' => 'code',
						'label' => 'code',
						'rules' => 'required'
				)
				
		)
);
?>