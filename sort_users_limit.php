<?
session_start();
$_SESSION['user_limit']=$_GET['val'];
if(!isset($_SESSION['user_limit'])){
$_SESSION['user_limit']='10';	
}else{
	$_SESSION['user_limit']=$_GET['val'];
}



header('location:index.php/dashboard');
?>