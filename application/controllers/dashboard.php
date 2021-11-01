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
        
        $data['buy'] = $this->db->query("SELECT * FROM ads WHERE type = 'buy' and date >= '".strtotime(date('d.m.Y H:i:s'))."'")->result();
        $data['sell'] = $this->db->query("SELECT * FROM ads WHERE type = 'buy' and date >= '".strtotime(date('d.m.Y H:i:s'))."'")->result();
        $data['users'] = $this->db->query("SELECT * FROM users")->result();
        $data['admins'] = $this->db->query("SELECT * FROM admins")->result();
        $data['ads'] = $this->db->query("SELECT * FROM ads WHERE date >= '".strtotime(date('d.m.Y H:i:s'))."'")->result();

        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', '!y12aubXO7;f', 'telegram_bot_invest_partners', '3306');
        $i6 = "SELECT * FROM rules WHERE id = '1'";
        mysqli_set_charset($mysqli, "utf8mb4");
        $result_r = $mysqli->query($i6);
        mysqli_set_charset($mysqli, "utf8");

        if ($result_r->num_rows > 0) {
            while ($r_rules = $result_r->fetch_assoc()) {
                $data['rules'] = $r_rules['rules']; 
            }
        }

		$this->load->view('dashboard',$data);
	}

    public function delete_ads($id=0)
    {
        $this->db->delete('ads', array('id_ads' => $id));
        redirect('/index.php/dashboard/');
    }
    
    public function delete_admin($id=0)
    {
        $this->db->delete('admins', array('telegram_id' => $id));
        redirect('/index.php/dashboard/');
    }
    
    public function delete_user($id=0)
    {
        
        $data = array('status' => 99);
        
       // $this->db->delete('users', array('telegram_id' => $id));
        $this->db->where('telegram_id', $id);
        $this->db->update('users', $data);
        redirect('/index.php/dashboard/');
    }
    
    public function edit_admin($id=0)
    {
        $data['admins'] = $this->db->query("SELECT * FROM admins WHERE telegram_id = '".$id."'")->result();
        $this->load->view('edit_admin',$data);
    }
    
    public function edit_user($id=0)
    {
        $data['users'] = $this->db->query("SELECT * FROM users WHERE telegram_id = '".$id."'")->result();
        $this->load->view('edit_user',$data);
    }
    
    public function save_admin($id=0)
    {
        $this->db->where('telegram_id', $id);
        $this->db->update('admins', $_POST);
        redirect('/index.php/dashboard/');
    }
    
    public function save_user($id=0)
    {
        $this->db->where('telegram_id', $id);
        $this->db->update('users', $_POST);
        redirect('/index.php/dashboard/');
    }
    
    public function save_rules($id=0)
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', '!y12aubXO7;f', 'telegram_bot_invest_partners', '3306');
        $i6 = " UPDATE rules SET rules = '" . implode(" ", $_POST) . "' WHERE id = 1;";
        mysqli_set_charset($mysqli, "utf8mb4");
        $mysqli->query($i6);
        mysqli_set_charset($mysqli, "utf8");
        redirect('/index.php/dashboard/');
    }

    public function send_message_to_all_users($id=0)
    {
        $message_body = trim(implode(" ", $_POST));
        if ($message_body != "") {
            $mysqli = new mysqli('localhost', 'telegram_investpartners2021', '!y12aubXO7;f', 'telegram_bot_invest_partners', '3306');
            $query_telegram_ids = "SELECT telegram_id FROM users WHERE status = '1'";
            $all_telegram_ids = $mysqli->query($query_telegram_ids);
    
            $start_time=time();
            $start_date_time=date("m/d/Y h:i:s a", $start_time);;
            $this->sendMessage("403106838", "Sending messages started at: $start_date_time", "2077508530:AAGeAQqLroyqwDCrmaqQrAYTrVmCIHVQOgY");
    
            $count = 0;
            if ($all_telegram_ids->num_rows > 0) {
                while ($telegram_id_from_db = $all_telegram_ids->fetch_assoc()) {
                    $telegram_id = implode("", $telegram_id_from_db);
                    $this->sendMessage("$telegram_id", "$message_body", "2077508530:AAGeAQqLroyqwDCrmaqQrAYTrVmCIHVQOgY");
                    $count = $count + 1;
                }
            }
            $end_time=time();
            $start_date_time=date("m/d/Y h:i:s a", $end_time);
            $request_time=$end_time - $start_time;
            $this->sendMessage("403106838", "Sending messages ended at: $start_date_time. Duration: $request_time. Count: $count", "2077508530:AAGeAQqLroyqwDCrmaqQrAYTrVmCIHVQOgY");
        }
                        
        redirect('/index.php/dashboard/');
    }
    
    public function add_admin()
    {
        $this->db->insert('admins', $_POST);
        redirect('/index.php/dashboard/');
    }

    private function sendMessage($chatID, $messaggio, $token) {
            
            $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
            $url = $url . "&text=" . urlencode($messaggio);
            $ch = curl_init();
            $optArray = array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CONNECTTIMEOUT => 10,
                            CURLOPT_TIMEOUT => 30
                            );
            curl_setopt_array($ch, $optArray);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
}
