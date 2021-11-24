<?
session_start();

$_SESSION['cur_page']=$_GET['page'];

header('location:index.php/dashboard');
?>