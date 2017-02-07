<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('user_model');
		$accountinfo = $this->session->userdata('accountinfo');
		if (($this->session->userdata('login') == FALSE ) || (isset($accountinfo) && !empty($accountinfo) && $accountinfo['type'] != '-1')){
            show_404();
		}	
    }
	public function index(){
		$data['page_title'] = "Users";
		$this->load->view('header',$data);
		$this->load->view('users',$data);
	}
	public function users_json(){
		$accountinfo = $this->session->userdata('accountinfo');
		$aColumns = array('username','first_name','last_name','email','status','creation_date');
		$sIndexColumn = "id";
		$sTable = "accounts";
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
			$sLimit = "LIMIT ".$this->db->escape_str($_GET['iDisplayStart'] ).", ".
			$this->db->escape_str( $_GET['iDisplayLength'] );
		}
		if( isset( $_GET['iSortCol_0'] ) ){
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
					$variable =$aColumns[intval( $_GET['iSortCol_'.$i] )] ;
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
				$variable = $aColumns[$i];
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
		if($sWhere){
			$sWhere = $sWhere." AND type =0 AND deleted =0";
		}else{
			$sWhere =" where type =0 AND deleted =0";
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
					if($i ==4){
						$current_row = $this->common->get_status($aRow[ $aColumns[$i] ]);
					}
					else if($i ==6){
						$edit_str='<a href="#user_edit_modal" class="btn btn-primary" id="thread_id" data-toggle="modal" data-edit_id="'.$aRow['id'].'">Edit</a>&nbsp;&nbsp;&nbsp;';
						$delete_str="<a class='btn btn-danger delete_user' $confirm_str id = 'delete_user'  href ='".base_url()."user_delete/".$aRow['id']."'>DELETE</a></div>";
						$current_row =$edit_str.$delete_str;
					}else{
							$current_row =$aRow[ $aColumns[$i] ];	
					}
					$row[] = $current_row;
				}
				
			}
			$output['aaData'][] = $row;
		}
		 echo json_encode( $output );
	}
	
	public function user_add(){
			$add_array=$this->input->post();
			if(!empty($add_array)){
				$add_array['creation_date']=date("Y-m-d H:i:s");
				$add_array['password']= $this->common->encode($add_array['password']);
				unset($add_array['add_submit']);
				$this->db->insert('accounts',$add_array);
				echo TRUE;
			}
	}

	

	public function user_delete($id){
		$this->db->where('id',$id);
		$this->db->update('accounts',array("deleted"=>1));
		redirect(base_url()."users/");
	}
	
	
}
?>
