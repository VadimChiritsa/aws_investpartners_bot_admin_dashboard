<?      
        $param_term = $_GET["search"];
	$mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
	$mysqli->set_charset("utf8");
	
	$res2 = $mysqli->query("SELECT COUNT(*) FROM ads  WHERE username LIKE '%$param_term%' || amount LIKE '%$param_term%' || type LIKE '%$param_term%' || pay LIKE '%$param_term%' || currency LIKE '%$param_term%' || city LIKE '%$param_term%' || rates LIKE '%$param_term%' || comment LIKE '%$param_term%' ");
	$num_rows = mysqli_fetch_row($res2)[0];
//echo $num_rows;

if($num_rows>0){
	echo(1);
}else{
	echo(0);
}

	


?>