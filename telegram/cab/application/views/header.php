<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
<title></title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
<meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
<meta name="author" content="Srthemesvilla" />
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">

<!-- Google fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

<!-- Icon fonts -->
<link rel="stylesheet" href="<?=base_url();?>template/assets/fonts/fontawesome.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/fonts/ionicons.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/fonts/linearicons.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/fonts/open-iconic.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/fonts/pe-icon-7-stroke.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/fonts/feather.css">

<!-- Core stylesheets -->
<link rel="stylesheet" href="<?=base_url();?>template/assets/css/bootstrap-material.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/css/shreerang-material.css">
<link rel="stylesheet" href="<?=base_url();?>template/assets/css/uikit.css">

<!-- Libs -->
<link rel="stylesheet" href="<?=base_url();?>template/assets/libs/perfect-scrollbar/perfect-scrollbar.css">
</head>

<body>
<!-- [ Preloader ] Start -->
<div class="page-loader">
<div class="bg-primary"></div>
</div>
<!-- [ Preloader ] Ebd -->

<!-- [ Layout wrapper ] Start -->
<div class="layout-wrapper layout-2">
<div class="layout-inner">
<!-- [ Layout sidenav ] Start -->

<!-- [ Layout sidenav ] End -->
<!-- [ Layout container ] Start -->
<div class="layout-container" style="padding-left:0px;">
<!-- [ Layout navbar ( Header ) ] Start -->
<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-dark container-p-x" id="layout-navbar">

<!-- Brand demo (see assets/css/demo/demo.css) -->
<a href="index.html" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
<span class="app-brand-logo demo">
<img src="assets/img/logo-dark.png" alt="Brand Logo" class="img-fluid">
</span>
<span class="app-brand-text demo font-weight-normal ml-2">Empire</span>
</a>

<!-- Sidenav toggle (see assets/css/demo/demo.css) -->
<div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
<a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
<i class="ion ion-md-menu text-large align-middle"></i>
</a>
</div>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
<span class="navbar-toggler-icon"></span>
</button>

<div class="navbar-collapse collapse" id="layout-navbar-collapse">
<!-- Divider -->
<hr class="d-lg-none w-100 my-2">

<div class="navbar-nav align-items-lg-center">

</div>

<div class="navbar-nav align-items-lg-center ml-auto">



<!-- Divider -->
<div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
<div class="demo-navbar-user nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
<span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
<span class="px-1 mr-lg-2 ml-2 ml-lg-0">Личный кабинет</span>
</span>
</a>
<div class="dropdown-menu dropdown-menu-right">

<a href="<?=base_url();?>index.php/login/logout/" class="dropdown-item">
<i class="feather icon-power text-danger"></i> &nbsp; Выход</a>
<!--
<a href="javascript:" class="dropdown-item">
<i class="feather icon-user text-muted"></i> &nbsp; My profile</a>
<a href="javascript:" class="dropdown-item">
<i class="feather icon-mail text-muted"></i> &nbsp; Messages</a>
<a href="javascript:" class="dropdown-item">
<i class="feather icon-settings text-muted"></i> &nbsp; Account settings</a>
<div class="dropdown-divider"></div>
<a href="javascript:" class="dropdown-item">
<i class="feather icon-power text-danger"></i> &nbsp; Log Out</a>
-->

</div>
</div>
</div>
</div>
</nav>
<!-- [ Layout navbar ( Header ) ] End -->
