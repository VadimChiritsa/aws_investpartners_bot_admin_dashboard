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
<!-- Page -->
<link rel="stylesheet" href="<?=base_url();?>template/assets/css/pages/authentication.css">
</head>

<body>
<!-- [ Preloader ] Start -->
<div class="page-loader">
<div class="bg-primary"></div>
</div>
<!-- [ Preloader ] End -->

<!-- [ content ] Start -->
<div class="authentication-wrapper authentication-1 px-4">
<div class="authentication-inner py-5">

<!-- [ Logo ] Start -->
<div class="d-flex justify-content-center align-items-center">
<div class="ui-w-60">
<div class="w-100 position-relative">

</div>
</div>
</div>
<!-- [ Logo ] End -->

<!-- [ Form ] Start -->
<form class="my-5" method="post" action="<?=base_url();?>index.php/login/auth">
<div class="form-group">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control">
<div class="clearfix"></div>
</div>
<div class="form-group">
<label class="form-label d-flex justify-content-between align-items-end">
<span>Password</span>

</label>
<input type="password" name="password" class="form-control">
<div class="clearfix"></div>
</div>
<div class="d-flex justify-content-between align-items-center m-0">
<?=$message;?>
<!--<label class="custom-control custom-checkbox m-0">
<input type="checkbox" class="custom-control-input">
<span class="custom-control-label"></span>
</label>-->
<button type="submit" class="btn btn-primary">Sign In</button>
</div>
</form>
<!-- [ Form ] End -->



</div>
</div>
<!-- [ content ] End -->

<!-- Core scripts -->
<script src="<?=base_url();?>template/assets/js/pace.js"></script>
<script src="<?=base_url();?>template/assets/js/jquery-3.3.1.min.js"></script>
<script src="<?=base_url();?>template/assets/libs/popper/popper.js"></script>
<script src="<?=base_url();?>template/assets/js/bootstrap.js"></script>
<script src="<?=base_url();?>template/assets/js/sidenav.js"></script>
<script src="<?=base_url();?>template/assets/js/layout-helpers.js"></script>
<script src="<?=base_url();?>template/assets/js/material-ripple.js"></script>

<!-- Libs -->
<script src="<?=base_url();?>template/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<!-- Demo -->
<script src="<?=base_url();?>template/assets/js/demo.js"></script><script src="<?=base_url();?>template/sassets/js/analytics.js"></script>
</body>

</html>
