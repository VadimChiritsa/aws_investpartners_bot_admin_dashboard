<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Admin</title>

<!-- Bootstrap Core CSS -->
<link href="<?=base_url();?>template/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="<?=base_url();?>template/css/metisMenu.min.css" rel="stylesheet">

<!-- Timeline CSS -->
<link href="<?=base_url();?>template/css/timeline.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?=base_url();?>template/css/startmin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="<?=base_url();?>template/css/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="<?=base_url();?>template/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- DataTables CSS -->
<link href="<?=base_url();?>template/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="<?=base_url();?>template/css/dataTables/dataTables.responsive.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>

<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="navbar-header">
<a class="navbar-brand" href="index.html">Admin</a>
</div>

<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>


<ul class="nav navbar-right navbar-top-links">

<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">
<i class="fa fa-user fa-fw"></i> <?=$this->session->userdata('id_user');?> <b class="caret"></b>
</a>

<ul class="dropdown-menu dropdown-user">

<li class="divider"></li>
<li><a href="<?=base_url();?>index.php/login/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
</li>
</ul>
</li>
</ul>
<!-- /.navbar-top-links -->

<div class="navbar-default sidebar" role="navigation">
<div class="sidebar-nav navbar-collapse">
<ul class="nav" id="side-menu">
<li class="sidebar-search">

<!-- /input-group -->
</li>
<li>
<a href="<?=base_url();?>index.php/dashboard" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
</li>
</ul>
</div>
</div>
</nav>
