<?php $this->load->view('header');?>

<div id="page-wrapper" style="min-height: 251px;">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Редактирование пользователя</h1>
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
<? foreach($users as $user){?>
    <form role="form" action="<?=base_url();?>index.php/dashboard/save_user/<?=$user->telegram_id;?>" method="post">
    
<div class="form-group">
<label>Telegram ID</label>
<input class="form-control" value="<?=$user->telegram_id;?>" name="telegram_id">
</div>
    
    
    <div class="form-group">
    <label>Status</label>
    <select class="form-control" name="status">
    <option value="1" <? if($user->status==1){ echo "selected "; }?> >Active</option>
    <option value="0" <? if($user->status==0){ echo "selected "; }?> >Deactive</option>
    </select>
    </div>
    
    <div class="form-group">
    <label>Language</label>
    <select class="form-control" name="language">
    <option value="rus" <? if($user->language=="rus"){ echo "selected "; }?> >Rus</option>
    <option value="eng" <? if($user->language=="eng"){ echo "selected "; }?> >Eng</option>
    </select>
    </div>
    
    
    <div class="form-group">
    <label>Email amir</label>
    <input class="form-control" value="<?=$user->email_amir;?>" name="email_amir">
    </div>
    
    <div class="form-group">
    <label>Name</label>
    <input class="form-control" value="<?=$user->name;?>" name="name">
    </div>
    
    <div class="form-group">
    <label>User ambassador</label>
    <input class="form-control" value="<?=$user->username_ambosador;?>" name="username_ambosador">
    </div>
    
    <div class="form-group">
    <label>Partner</label>
    <input class="form-control" value="<?=$user->username_partner;?>" name="username_partner">
    </div>
    
<button type="submit" class="btn btn-default">Save</button>
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

