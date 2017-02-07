<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('forum_model');
    }
	public function index(){
		$data['page_title'] = "Forum";
		$this->load->view('header',$data);
		$this->load->view('threads',$data);
	}
	public function user_edit(){
		$user_id = $this->input->post('user_id',true);
		if($user_id){
			$user_result =(array)$this->db->get_where("accounts",array("id"=>$user_id))->first_row();
			$user_result['password'] = $this->common->decode($user_result['password']);
			echo json_encode($user_result);
	    }else{
			show_404();
		}
	}
	public function user_save(){
		$add_array=$this->input->post();
		$accountinfo = $this->session->userdata('accountinfo');
		if(!empty($add_array) && ($accountinfo['type'] == -1 || $add_array['id'] == $accountinfo['id'])){
			$acc_id = $add_array['id'];
			$this->db->where("id", $acc_id);
			unset($add_array['id'],$add_array['edit_submit']);
			$add_array['password'] = $this->common->encode($add_array['password']);
			$this->db->update("accounts", $add_array);
			if(!empty($accountinfo) && $acc_id ==$accountinfo['id']){
				$acc_result =(array)$this->db->get_where('accounts',array("id"=>$accountinfo['id']))->first_row();
				$this->session->set_userdata('accountinfo',$acc_result);
			}
			echo TRUE;
		}else{
			show_404();
		}
		
	}
	public function update_profile(){
		$this->user_save();
	}
	public function thread(){
		$accountinfo = $this->session->userdata('accountinfo');
		$account_result=$this->forum_model->accounts_info();
		$acc_arr=array();
		foreach($account_result  as $acc_key=>$row){
			$acc_arr[$row['id']] = $row['first_name']." ".$row['last_name'];
		}
		$str = "CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END as date";
		$aColumns = array('subject','account_id',$str);
		$sIndexColumn = "thread_id";
		$sTable = "threads";
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
			$sLimit = "LIMIT ".$this->db->escape_str($_GET['iDisplayStart'] ).", ".
			$this->db->escape_str( $_GET['iDisplayLength'] );
		}
		if( isset( $_GET['iSortCol_0'] ) ){
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
					$variable =$aColumns[intval( $_GET['iSortCol_'.$i] )] == $str ? "CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END" : $aColumns[intval( $_GET['iSortCol_'.$i] )] ;
					$sOrder .= $variable." ".$this->db->escape_str( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		$sWhere = "";
		if ( $_GET['sSearch'] != "" ){
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$variable = $aColumns[$i] == $str ? "CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END" : $aColumns[$i];
				$sWhere .= $variable." LIKE '%".$this->db->escape_str( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ){
					$sWhere = "WHERE ";
				}else{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".$this->db->escape_str($_GET['sSearch_'.$i])."%' ";
			}
		}
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns)).", $sIndexColumn FROM   $sTable $sWhere $sOrder $sLimit ";
		$rResult = (array)$this->db->query( $sQuery)->result_array();
		$sQuery = "SELECT FOUND_ROWS() as rows";
		$rResultFilterTotal = (array)$this->db->query($sQuery)->first_row();
		$iFilteredTotal = $rResultFilterTotal['rows'];
		$sQuery = "SELECT COUNT(".$sIndexColumn.") as rows FROM   $sTable";
		$rResultFilterTotal = (array)$this->db->query($sQuery)->first_row();
		$iTotal = $rResultFilterTotal['rows'];
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		$modal_Str="$('#thread_edit_modal').modal('show')";
		$confirm_str = 'onclick="'."return confirm('Are you sure you want to delete?'".')"';
		foreach($rResult as $aRow){
			$row = array();
			$count =count($aColumns);
			if($accountinfo['type'] == -1){
				$total_count =$count+1;
			}else{
				$total_count = $count;
			}
			for ( $i=0 ; $i<$total_count; $i++ ){
				if ( isset($aColumns[$i]) &&$aColumns[$i] != ' ' || $i == $count ){
					if(isset($aColumns[$i]) && $aColumns[$i] == $str){
						$aColumns[$i] ="date";
					}
					if($accountinfo['type'] == -1 && $i ==3){
						$edit_str='<a href="#thread_edit_modal" class="btn btn-primary" id="thread_id" data-toggle="modal" data-edit_id="'.$aRow['thread_id'].'">Edit</a>&nbsp;&nbsp;&nbsp;';
						$delete_str="<a class='btn btn-danger' $confirm_str href ='".base_url()."thread_delete/".$aRow['thread_id']."'>DELETE</a></div>";
						$current_row =$edit_str.$delete_str;
					}else{
						if($i==1){
							$current_row =isset($acc_arr[$aRow[$aColumns[$i]]]) ? $acc_arr[$aRow[$aColumns[$i]]] : 'Anonymous' ;
						}
						else if($i ==0 ){
							$current_row ="<a href = '".base_url()."thread_details/".$aRow[$sIndexColumn]."'>".$aRow[$aColumns[$i]]."</a>";
						}else{
							$current_row =$aRow[ $aColumns[$i] ];
						}	
					}
					$row[] = $current_row;
				}
			}
			$output['aaData'][] = $row;
		}
		 echo json_encode( $output );
	}
	
	public function thread_add(){
		$accountinfo=$this->session->userdata('accountinfo');
		if(empty($accountinfo)){
			redirect(base_url()."login/");
		}else{
			$add_array=$this->input->post();
			if(!empty($add_array)){
				$add_array['creation_date']=date("Y-m-d H:i:s");
				$add_array['account_id']=$accountinfo['id'];
				$add_array['subject']=$add_array['add_subject'];
				$thread_detail_array['thread_details']=$add_array['information'];
				unset($add_array['add_submit'],$add_array['add_subject'],$add_array['information']);
				$this->db->insert('threads',$add_array);
				$thread_detail_array['thread_id']=$this->db->insert_id();
				$thread_detail_array['account_id']= $accountinfo['id'];
				$thread_detail_array['creation_date'] = date("Y-m-d H:i:s");
				$this->db->insert('thread_details',$thread_detail_array);
				echo TRUE;
			}
		}
	}
	public function thread_edit(){
		$thread_id = $this->input->post('thread_id',true);
		echo json_encode((array)$this->db->get_where("threads",array("thread_id"=>$thread_id))->first_row());
		
	}
	public function thread_save(){
		$add_array=$this->input->post();
		if(!empty($add_array)){
			$add_array["last_modified_date"] = date("Y-m-d H:i:s");
			$this->db->where("thread_id", $add_array['id']);
			unset($add_array['id'],$add_array['edit_submit']);
			$this->db->update("threads", $add_array);
		}
		echo TRUE;
	}
	public function thread_delete($thread_id){
		$accountinfo = $this->session->userdata('accountinfo');
		if($accountinfo['type'] == -1){
			$this->db->delete('threads',array("thread_id"=>$thread_id));
			$this->db->delete('thread_details',array('thread_id'=>$thread_id));
			redirect(base_url());
		}else{
			show_404();
		}
	}
	public function thread_details($thread_id){
		$this->db->select('subject');
		$thread_result =(array)$this->db->get_where('threads',array('thread_id' =>$thread_id))->first_row();
		 $data['thread_id'] = $thread_id;
		 $data['page_title'] =$thread_result['subject'];
		 $this->load->view('header',$data);
		 $this->load->view('thread_details',$data);
	}
	public function thread_details_json($thread_id){
		if($this->session->userdata('login')){
			$accountinfo = $this->session->userdata('accountinfo');
		}
		$account_ids=$this->forum_model->disinct_accounts($thread_id);
		$account_result=$this->forum_model->accounts_info($account_ids);
		$acc_arr=array();
		foreach($account_result  as $acc_key=>$row){
			$count_query = "select count(thread_id) as count from threads where account_id = '".$row['id']."'";
			$count_result = (array)$this->db->query($count_query)->first_row(); 
			$row['total_post']=$count_result['count'];
			$acc_arr[$row['id']]=$row;
		}
		$str = "CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END as date";
		$aColumns = array('account_id','thread_details',$str);
		$sIndexColumn = "id";
		$sTable = "thread_details";
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
			$sLimit = "LIMIT ".$this->db->escape_str( $_GET['iDisplayStart'] ).", ".
			$this->db->escape_str( $_GET['iDisplayLength'] );
		}
		if ( isset( $_GET['iSortCol_0'] ) ){
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
					$variable =$aColumns[intval( $_GET['iSortCol_'.$i] )] == $str ? "CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END" : $aColumns[intval( $_GET['iSortCol_'.$i] )] ;
					$sOrder .= $variable."
						".$this->db->escape_str( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
		
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		$sWhere = "";
		if ( $_GET['sSearch'] != "" ){
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$variable = $aColumns[$i] == $str ? "CASE when last_modified_date != '0000-00-00 00:00:00' then last_modified_date else creation_date END" : $aColumns[$i];
				$sWhere .= $variable." LIKE '%".$this->db->escape_str( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ){
					$sWhere = "WHERE ";
				}else{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".$this->db->escape_str($_GET['sSearch_'.$i])."%' ";
			}
		}
		if(!empty($swhere))
		 $sWhere = $sWhere." AND thread_id = '".$thread_id."'";
		else
		 $sWhere = " where thread_id = '".$thread_id."'";
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns)).", $sIndexColumn
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
		";
		$rResult = (array)$this->db->query( $sQuery)->result_array();
		$sQuery = "SELECT FOUND_ROWS() as rows";
		$rResultFilterTotal = (array)$this->db->query($sQuery)->first_row();
		$iFilteredTotal = $rResultFilterTotal['rows'];
		$sQuery = "SELECT COUNT(".$sIndexColumn.") as rows FROM   $sTable";
		$rResultFilterTotal = (array)$this->db->query($sQuery)->first_row();
		$iTotal = $rResultFilterTotal['rows'];
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		foreach($rResult as $aRow){
			$row = array();
			$edit_str=null;
			$delete_str=null;
			if(isset($accountinfo) && $accountinfo['id'] == $aRow['account_id'] || isset($accountinfo) && $accountinfo['type'] == -1){
				$edit_str='<div class="fa-hover col-md-2 col-sm-2" style="float:right;margin-right:20px;width :100 px !important;"><a href="#thread_detail_edit_modal" id="thread_detail_id" data-toggle="modal" data-edit_id="'.$aRow['id'].'">Edit</a></div>';
				if($accountinfo['type'] == -1){
				 $delete_str="<div class='fa-hover col-md-2 col-sm-2' style='float:right;margin-right:20px;width :100 px !important;'><a href ='".base_url()."thread_details_delete/".$aRow['id']."/$thread_id/'>DELETE</a></div>";
				}
			}
			$acc_name =  $acc_arr[$aRow['account_id']]['first_name']." ".$acc_arr[$aRow['account_id']]['last_name']."<br/>
					 Registered :".$acc_arr[$aRow['account_id']]['creation_date'].$edit_str."<br/>Total Post : ".$acc_arr[$aRow['account_id']]['total_post'].$delete_str;
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$time_str = $this->time_posted_before(strtotime($aRow['date']));
				if($aColumns[$i] == $str){
						$aColumns[$i] ="date";
				}
				if ( $aColumns[$i] == "version" ){
					/* Special output formatting for 'version' column */
					$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				}else if ( $aColumns[$i] != ' ' ){
					if($i ==0){
						$aRow[$aColumns[$i]] = isset($acc_name) ? $acc_name : 'Anonymous' ;
					}
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
			$output['aaData'][] = $row;
		}
		echo json_encode( $output );
	}
	
	function reply_thread($thread_id){
		$this->db->where('thread_id',$thread_id);
		$this->db->select('*');
	    $info =(array)$this->db->get('thread_details')->result_array();
		if(!empty($info)){
			$this->db->select('subject');
			$page_result=(array)$this->db->get_where('threads',array('thread_id' =>$thread_id))->first_row();
			$data['page_title'] = $page_result['subject'];
			$this->load->view('reply_thread');
		}else{
			redirect(base_url());
		}
		
	}
	function time_posted_before ($time){
		$time = time() - $time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}

	}
	public function thread_details_edit(){
		$add_array=$this->input->post();
		$id = $add_array['thread_id'];
		if($this->session->userdata('login')){
			$accountinfo= $this->session->userdata('accountinfo');
			$where['id']= $id;
			if($accountinfo['type'] != -1){
				$where["account_id"]= $accountinfo['id'];
			}
			$thread_detail_result =(array)$this->db->get_where("thread_details",$where)->first_row();
			if($thread_detail_result){
				echo json_encode($thread_detail_result);
			}else{
				$this->session->set_userdata('error','Please contact to administrator to edit this post.');
				echo FALSE;
			}
		}else{
			redirect(base_url."login/");
		}
		
	}
	function thread_details_save(){
		$add_array=$this->input->post();
		$accountinfo=$this->session->userdata('accountinfo');
		if(!empty($add_array) && !empty($accountinfo)){
			$data['thread_details']=$add_array['edit_information'];
			$data['last_modified_date']= date("Y-m-d H:i:s");
			$this->db->where('id',$add_array['id']);
			$this->db->update('thread_details',$data);
			echo TRUE;
		}else{
			redirect(base_url()."login/");
		}
	}
	function thread_details_add(){
		$accountinfo = $this->session->userdata('accountinfo');
		if(!empty($accountinfo)){
			$add_array= $this->input->post();
			$add_array['thread_details']=$add_array['information'];
			$add_array['account_id']=$accountinfo['id'];
			$add_array['thread_id']=$add_array['thread_id'];
			$add_array['creation_date']= date("Y-m-d H:i:s");
			unset($add_array['information']);
			$this->db->insert('thread_details',$add_array);
			echo TRUE;
		}else{
			redirect(base_url()."login/");
		}
	}
	public function thread_details_delete($id,$thread_id){
		$accountinfo = $this->session->userdata('accountinfo');
		if($accountinfo['type'] == -1){
			$this->db->delete('thread_details',array("id"=>$id));
			redirect(base_url()."thread_details/".$thread_id);
		}else{
			show_404();
		}
	}
	
	
}
?>
