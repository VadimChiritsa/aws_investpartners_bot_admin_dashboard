<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        
    }
    
    private function sendMessage($chatID, $messaggio, $token) {
        
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
                          CURLOPT_URL => $url,
                          CURLOPT_RETURNTRANSFER => true
                          );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    private function generateRandomString($length = 32) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
	
	public function index()
	{
        $session_id = @$this->session->userdata('id_user');
        if($session_id) { redirect('/index.php/dashboard'); }
        
        $data = array('message' =>'');
		$this->load->view('welcome_message',$data);
	}
    
    
    public function token()
    {
        $data = array('message' =>'');
        $this->load->view('login_token_tpl',$data);
    }
    
    
    public function auth()
    {
        
        
        $error = array();
        
        
        $session_id = @$this->session->userdata('id_user');
        if($session_id) redirect('/index.php/dashboard');
        
        $username = $this->input->post('username');
        
        if (isset($username))
            
            
        {
            
            $array = array(
                           'username' => strip_tags(trim($username))
                           );
            
            
            $auth = $this->db->get_where('admins',$array)->row('telegram_id');
            
            if (isset($auth) && !empty($auth))
            {
                $auth_token = $this->generateRandomString();
                $data = array('token' => $auth_token);
                $this->db->where('telegram_id', $auth);
                $this->db->update('admins', $data);
                
                $this->sendMessage($auth, "Ваш токен: ".$auth_token."", "2077508530:AAGeAQqLroyqwDCrmaqQrAYTrVmCIHVQOgY");
                
                redirect('/index.php/login/token');
            } else {
                
                
                $error = array('message' =>'Введенные данные не верны.');
                
                
                $this->load->view('welcome_message',$error);
            }
            
            
        } else {
            
            $error = array('message' =>'Введенные данные не верны.');
            $this->load->view('welcome_message',$error);
        }
        
    }
    
    
    public function auth_token()
    {
        
        
        $error = array();
        
        
        $session_id = @$this->session->userdata('id_user');
        if($session_id) redirect('/index.php/dashboard');
        
        $token = $this->input->post('token');
        
        if (isset($token))
            
            
        {
            
            $array = array(
                           'token' => strip_tags(trim($token))
                           );
            
            
            $auth = $this->db->get_where('admins',$array)->row('telegram_id');
            
            if (isset($auth) && !empty($auth))
            {
                $this->session->set_userdata(array('id_user'=>$auth));
                
                redirect('/index.php/dashboard');
            } else {
                
                
                $error = array('message' =>'Введенные данные не верны.');
                
                
                $this->load->view('login_token_tpl',$error);
            }
            
            
        } else {
            
            $error = array('message' =>'Введенные данные не верны.');
            $this->load->view('login_token_tpl',$error);
        }
        
    }
    
    
    function logout()
    {
        $action = "Вышел из системы";
        
        $this->session->sess_destroy();
        redirect('/');
    }
    
}


