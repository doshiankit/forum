<?php
class Common {
	 protected $CI; // codeigniter
	 function __construct($library_name = '') {
        $this->CI = & get_instance();
	 }	
    function auth_user($add_array){
		$query= "select * from accounts where username = '".$add_array['username']."' AND password = '".$this->encode($add_array['password'])."' and deleted =0 and status =0 limit 1";
		
        $result_array =(array)$this->CI->db->query($query)->first_row();
		if(!empty($result_array)){
			$this->CI->session->set_userdata('login',true);
			$this->CI->session->set_userdata('login_type',$result_array['type']);
			$this->CI->session->set_userdata('accountinfo',$result_array);
			return $result_array;
		}else{
			$this->CI->session->set_userdata('login',false);
			return false;
		}
    }
	function encode_params($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '$', ''), $data);
        return $data;
    }

    function encode($value) {
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->CI->config->item('private_key'), $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->encode_params($crypttext));
    }

    function decode_params($string) {
        $data = str_replace(array('-', '$'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    function decode($value) {
        $crypttext = $this->decode_params($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->CI->config->item('private_key'), $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
	function get_status($status){
		
		$status_array=array("0"=>"Active",
							"1"=>"Inactive");
		return $status_array[$status];
	}
}
?>