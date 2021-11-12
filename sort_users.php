<?
session_start();
$_SESSION['sort_user']=$_GET['s'];
if(!isset($_SESSION['sort_order'])){
$_SESSION['sort_order']='DESC';	
}
if(isset($_SESSION['sort_order']) && $_SESSION['sort_order']=='DESC' ){
$_SESSION['sort_order']='ASC';
}elseif(isset($_SESSION['sort_order']) && $_SESSION['sort_order']=='ASC' ){
$_SESSION['sort_order']='DESC';
}


header('location:index.php/dashboard');
?>