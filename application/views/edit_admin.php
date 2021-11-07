<?php $this->load->view('header');?>

<div id="page-wrapper" style="min-height: 251px;">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Редактирование админа</h1>
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">

</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12">
<? foreach($admins as $admin){?>
    <form role="form" method="post" action="<?=base_url();?>index.php/dashboard/save_admin/<?=$admin->telegram_id;?>">

<div class="form-group">
<label>Telegram ID</label>
<input class="form-control" name="telegram_id" value="<?=$admin->telegram_id;?>">
</div>
    
    <div class="form-group">
    <label>Username</label>
    <input class="form-control" name="username" value="<?=$admin->username;?>">
    </div>
    
<button type="submit" class="btn btn-default">Сохранить</button>
</form>
    <?}?>
</div>
</div>
<!-- /.row (nested) -->
</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>


<?php $this->load->view('footer');?>

