<?php $this->load->view('header');?>

<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<h1 class="page-header"></h1>
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">


<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">
Список пользователей
</div>

<!-- /.panel-heading -->
<div class="panel-body">
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover" id="dataTables-example1">
<thead>
<tr>
<th>Telegram ID</th>
<th>Language</th>
<th>Last action</th>
<th>Email amir</th>
<th>Name</th>
<th>User ambassador</th>
<th>Status</th>
<th>Partner</th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
<? foreach($users as $user){?>
<tr class="odd gradeX">
    <td><?=$user->telegram_id;?></td>
<td><?=$user->language;?></td>
<td><?=$user->last_action;?></td>
<td><?=$user->email_amir;?></td>
<td><?=$user->name;?></td>
<td><?=$user->username_ambosador;?></td>
<td><?=$user->status;?></td>
<td><?=$user->username_partner;?></td>
    <td><a href="<?=base_url();?>index.php/dashboard/edit_user/<?=$user->telegram_id;?>">Edit</a></td>
<td><a href="<?=base_url();?>index.php/dashboard/delete_user/<?=$user->telegram_id;?>">Delete</a></td>
</tr>
    <?}?>
</tbody>
</table>
</div>
<!-- /.table-responsive -->
</div>
</div>
<!-- /.col-lg-4 (nested) -->
<div class="col-lg-8">
<div id="morris-bar-chart"></div>
</div>
<!-- /.col-lg-8 (nested) -->
</div>
<!-- /.row -->
</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->


<div class="panel panel-default">
<div class="panel-heading">
Список админов
</div>
<!-- /.panel-heading -->
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" id="dataTables-example2">
<thead>
<tr>
<th>Telegram ID</th>
<th>Username</th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
<? foreach($admins as $admin){?>
    <tr class="odd gradeX">
    <td><?=$admin->telegram_id;?></td>
    <td><?=$admin->username;?></td>
    <td><a href="<?=base_url();?>index.php/dashboard/edit_admin/<?=$admin->telegram_id;?>">Edit</a></td>
    <td><a href="<?=base_url();?>index.php/dashboard/delete_admin/<?=$admin->telegram_id;?>">Delete</a></td>
    </tr>
    <?}?>
</tbody>
</table>
</div>
<!-- /.table-responsive -->

<h2>Создать админа</h2>

<form role="form" method="post" action="<?=base_url();?>index.php/dashboard/add_admin/">

<div class="form-group">
<label>Telegram ID</label>
<input class="form-control" name="telegram_id" value="">
</div>

<div class="form-group">
<label>Username</label>
<input class="form-control" name="username" value="">
</div>

<button type="submit" class="btn btn-default">Создать</button>
</form>


<div class="panel-heading">
Список объявлений
</div>
<!-- /.panel-heading -->
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" id="dataTables-example3">
<thead>
<tr>
<th>Username</th>
<th>Amount</th>
<th>Type</th>
<th>Pay</th>
<th>Currency</th>
<th>City</th>
<th>Rates</th>
<th>Comment</th>
<th></th>
</tr>
</thead>
<tbody>
<? foreach($ads as $ad){?>
    <tr class="odd gradeX">
    <td><?=$ad->username;?></td>
    <td><?=$ad->amount;?></td>
    <td><?=$ad->type;?></td>
    <td><?=$ad->pay;?></td>
    <td><?=$ad->currency;?></td>
    <td><?=$ad->city;?></td>
    <td><?=$ad->rates;?></td>
    <td><?=$ad->comment;?></td>
    <td><a href="<?=base_url();?>index.php/dashboard/delete_ads/<?=$ad->id_ads;?>">Delete</a></td>
    </tr>
    <?}?>
</tbody>
</table>
</div>
<!-- /.table-responsive -->




<h2>Правила пользования</h2>

<form role="form" method="post" action="<?=base_url();?>index.php/dashboard/save_rules/">


<div class="form-group">
<label>Правила</label>
<textarea class="form-control" name="rules"><?=$rules?></textarea>
</div>

<button type="submit" class="btn btn-default">Обновить</button>
</form>

<h2>Отправить сообщение всем пользователям</h2>

<form role="form" method="post" action="<?=base_url();?>index.php/dashboard/send_message_to_all_users/">


<div class="form-group">
<label>Сообщение</label>
<textarea class="form-control" name="message_to_all"></textarea>
</div>

<button type="submit" class="btn btn-default">Отправить</button>
</form>

</div>
</div>
<!-- /.col-lg-4 (nested) -->
<div class="col-lg-8">
<div id="morris-bar-chart"></div>
</div>
<!-- /.col-lg-8 (nested) -->
</div>
<!-- /.row -->
</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->
<!-- /.col-lg-8 -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<?php $this->load->view('footer');?>

