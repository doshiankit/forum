<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	function __constuct(){
		parent::__construct();
	}
	function auth_user($add_array){
		$this->db->get_where('accounts',array)
		return $result;
	}
	function accounts_info(){
		$this->db->select('id,first_name,last_name,creation_date');
		$result=(array)$this->db->get_where('accounts',array('type'=>0))->result_array();
		return $result;
	}
	
}
?>