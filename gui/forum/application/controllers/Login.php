<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __constuct() {
        parent::__construct();
		$this->load->model('login_model');
    }
	public function index($action='',$thread_id=''){
		if($this->session->userdata('login') == FALSE){
			$add_array = $this->input->post();
			if(!empty($add_array)){
			  $result_array =$this->common->auth_user($add_array);
			  if($result_array){
				  if($action == 'reply' && $thread_id > 0 ){
					  redirect(base_url()."reply/".$thread_id);
				  }else{
					redirect(base_url());
				  }
			  }else{
				  redirect(base_url()."login/");
			  }
			}else{
				$this->load->view('login');
			} 
		}else{
			if($action == "reply" && $thread_id > 0){
				redirect(base_url()."reply/".$thread_id);
			}
			redirect(base_url()."login/");
		}
	}
	public function forgot_password(){
		$this->load->view('forgot_password');
	}
	public function signup(){
		$add_array=$this->input->post();
		if(empty($add_array)){
			$this->load->view('signup');
		}else{
			$add_array['password'] = $this->common->encode($add_array['password']);
			$add_array['type'] =0;
			$add_array['creation_date']= date("Y-m-d H:i:s");
			$add_array['status']="1";
			$add_array['deleted']="0";
			$this->db->insert('accounts',$add_array);
			redirect(base_url()."login/");
			
		}	
	}
	public function logout(){
		$this->session->sess_destroy();
        redirect(base_url());
	}
	
}
?>