<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	function __constuct(){
		parent::__construct();
	}
	function select_forum_details($flag=false,$start=false,$limit=false){
		if($flag){
			$this->db->select("topic_id,account_id,subject,CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END as date",false);
		    $this->db->limit($start,$limit);
	    }else{
			$this->db->select('count(topic_id) as count');
		}
		$result = $this->db->get('topics');
		return $result;
	}
	function accounts_info($account_ids =""){
		if(!empty($account_ids)){
			$where ="id IN (".$account_ids.")";
		}else{
			$where=array();
		}
		$this->db->select('id,first_name,last_name,creation_date');
		$result=(array)$this->db->get_where('accounts',$where)->result_array();
		return $result;
	}
	function disinct_accounts($thread_id){
		$this->db->where('thread_id',$thread_id);
		$this->db->select('group_concat(distinct(account_id)) as account_ids');
		$distinct_acc_result=(array)$this->db->get('thread_details')->first_row();
		if(!empty($distinct_acc_result)){
			return $distinct_acc_result['account_ids'];
		}else{
			return false;
		}
	}
	
}
?>