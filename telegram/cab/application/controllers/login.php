<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        
    }
    
	
	public function index()
	{
        $session_id = @$this->session->userdata('id_user');
        if($session_id) redirect('/index.php/dashboard');
        
        $data = array('message' =>'');
		$this->load->view('welcome_message',$data);
	}
    
    
    public function auth()
    {
        
        
        $error = array();
        
        
        $session_id = @$this->session->userdata('id_user');
        if($session_id) redirect('/index.php/dashboard');
        
        $login = $this->input->post('email');
        $password = $this->input->post('password');
        
        if (isset($password) && isset($login))
            
            
        {
            
            $array = array(
                           'email' => strip_tags(trim($login)),
                           'password' => trim(md5($password)),
                           );
            
            
            $auth = $this->db->get_where('users_admin',$array)->row('id_user');
            
            if (isset($auth) && !empty($auth))
            {
                $this->session->set_userdata(array('id_user'=>$auth));
                
                
                redirect('/index.php/dashboard');
            } else {
                
                
                $error = array('message' =>'Введенные данные не верны.');
                
                
                $this->load->view('welcome_message',$error);
            }
            
            
        } else {
            
            $error = array('message' =>'Введенные данные не верны.');
            $this->load->view('welcome_message',$error);
        }
        
    }
    
    
    
    function logout()
    {
        $action = "Вышел из системы";
        
        $this->session->sess_destroy();
        redirect('/');
    }
    
}


