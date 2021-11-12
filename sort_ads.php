<?
session_start();
$_SESSION['sort_ads']=$_GET['s'];
if(!isset($_SESSION['sort_order_ads'])){
$_SESSION['sort_order_ads']='DESC';	
}
if(isset($_SESSION['sort_order_ads']) && $_SESSION['sort_order_ads']=='DESC' ){
$_SESSION['sort_order_ads']='ASC';
}elseif(isset($_SESSION['sort_order_ads']) && $_SESSION['sort_order_ads']=='ASC' ){
$_SESSION['sort_order_ads']='DESC';
}


header('location:index.php/dashboard');
?>