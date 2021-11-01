<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        
    }
    
	
	public function index()
	{
        
        $data['quizs'] = $this->db->query("SELECT * FROM quizs")->result();
		$this->load->view('dashboard',$data);
	}

   public function  new_q()
   {
   			$name_quiz = $this->input->post('name_quiz');
   			$count_codes = $this->input->post('count_codes');
   			$count_ques = $this->input->post('count_ques');
   
   			$data_quiz = array('name' => $name_quiz,'date' => strtotime(date('d.m.Y H:i:s')));
   			$this->db->insert('quizs', $data_quiz); 
   			
   			$insert_id = $this->db->insert_id();
   			
   			if($count_codes>0){
            
            for($i=0; $i<$count_codes; $i++){
            	
            	$data_codes = array('id_quiz' => $insert_id,'code' => rand(5, 999999), 'count' => 0);
   				$this->db->insert('quiz_codes', $data_codes); 
            }//for
            }//if
   			
   			for($j=0; $j<$count_ques; $j++){
           		$data_ques = array('id_q' => $insert_id,'q' => '');
   				$this->db->insert('quiz_qs', $data_ques); 
            }//for
   			
   			redirect('/index.php/dashboard/quiz/'.$insert_id.'/');
   		//redirect('/index.php/dashboard/?message=new');
   }

			public function quiz($id=0)
		{
			$data['qizs'] = $this->db->query("SELECT * FROM quiz_qs WHERE id_q = '".$id."'")->result();
            $this->load->view('add_answer',$data);
		}

			
			public function save()
            {
            
            
            for($i=0; $i<count($_POST['id_qq']); $i++){
            
            $this->db->where('id_qq', $_POST['id_qq'][$i]);
			$this->db->delete('answers'); 
            
            
            	$data = array('q' => $_POST["q_".$_POST['id_qq'][$i].""][0]);

				$this->db->where('id_qq', $_POST['id_qq'][$i]);
				$this->db->update('quiz_qs', $data);
            	
                       
            	for($a=0; $a<count($_POST["answer_".$_POST['id_qq'][$i].""]); $a++){
                
                
                
                
                $data = array(
   						'id_qq' => $_POST['id_qq'][$i] ,
   						'text' => $_POST["answer_".$_POST['id_qq'][$i].""][$a] ,
   						'price' => $_POST["price_".$_POST['id_qq'][$i].""][$a],
                		'text_result' => $_POST["resulе_".$_POST['id_qq'][$i].""][$a],
                		'value' => $_POST["value_".$_POST['id_qq'][$i].""][$a]
				);

			$this->db->insert('answers', $data); 
                
                }
            
            }
            
            redirect('/index.php/dashboard/?message=new');
            
            }
    

				public function delete($id=0)
				{
						$this->db->where('id_q', $id);
					$this->db->delete('quizs'); 
				redirect('/index.php/dashboard/?message=delete');
				}
    
}


