<?
session_start();
$_SESSION['ads_limit']=$_GET['val'];
if(!isset($_SESSION['ads_limit'])){
$_SESSION['ads_limit']='10';	
}else{
	$_SESSION['ads_limit']=$_GET['val'];
}

//echo $_GET['val'];

header('location:index.php/dashboard');
?>