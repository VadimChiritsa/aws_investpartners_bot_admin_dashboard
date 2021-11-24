<?      
        $param_term = $_GET["search"];
	$mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
	$mysqli->set_charset("utf8");
	
	$res2 = $mysqli->query("SELECT COUNT(*) FROM users  WHERE telegram_id LIKE '%$param_term%' || language LIKE '%$param_term%' || last_action LIKE '%$param_term%' || email_amir LIKE '%$param_term%' || name LIKE '%$param_term%' || username_ambosador LIKE '%$param_term%' || status LIKE '%$param_term%' || username_partner LIKE '%$param_term%' ");
	$num_rows = mysqli_fetch_row($res2)[0];
//echo $num_rows;

if($num_rows>0){
	echo(1);
}else{
	echo(0);
}

	


?>