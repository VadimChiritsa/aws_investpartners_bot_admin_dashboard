<?
session_start();

$_SESSION['cur_page2']=$_GET['page'];

header('location:index.php/dashboard');
?>