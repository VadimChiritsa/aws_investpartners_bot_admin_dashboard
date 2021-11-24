<?php $this->load->view('header');?>

<? $session_id = @$this->session->userdata('id_user');
        if(!$session_id) redirect('/');?>

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


                        | выводить по <select id="sort_user">
                            <option value="3" <? if(isset($_SESSION['user_limit']) && $_SESSION['user_limit']==3):?>
                                selected
                                <? endif ?> >3</option>
                            <option value="20" <? if(isset($_SESSION['user_limit']) && $_SESSION['user_limit']==20):?>
                                selected
                                <? endif ?>>20</option>
                            <option value="30" <? if(isset($_SESSION['user_limit']) && $_SESSION['user_limit']==30):?>
                                selected
                                <? endif ?>>30</option>
                            <option value="50" <? if(isset($_SESSION['user_limit']) && $_SESSION['user_limit']==50):?>
                                selected
                                <? endif ?>>50</option>
                            <option value="5000000" <? if(isset($_SESSION['user_limit']) &&
                                $_SESSION['user_limit']==5000000):?> selected
                                <? endif ?>>Все</option>
                        </select>
                        <style>
                            .search-box {
                                width: 300px;
                                position: relative;

                                font-size: 14px;
                            }

                            .search-box input[type="text"] {
                                height: 28px;
                                padding: 5px 10px;
                                width: 80%;
                                font-size: 12px;
                            }

                            .result {
                                position: absolute;
                                z-index: 999;
                                top: 100%;
                                left: 0;
                                background-color: #fff;
                                color: #333;
                            }

                            .search-box input[type="text"],
                            .result {
                                width: 100%;
                                box-sizing: border-box;
                            }

                            /* Formatting result items */
                            .result p {
                                margin: 0;
                                padding: 7px 10px;
                                border: 1px solid #CCCCCC;
                                border-top: none;
                                cursor: pointer;
                            }

                            .result p:hover {
                                background: #f2f2f2;
                            }
                        </style>
                        <div class="search-box" style="float: right; margin-left: 25px;">
                            <input type="text" id="search" autocomplete="off" placeholder="Поиск..." />
                            <div id="display" class="result"></div>
                        </div>
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive" id="load_users">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                <thead>
                                    <tr>
                                        <th><a href="/sort_users.php?s=telegram_id">telegram_id</a></th>
                                        <th><a href="/sort_users.php?s=language">Language</a></th>
                                        <th><a href="/sort_users.php?s=last_action">Last action</a></th>
                                        <th><a href="/sort_users.php?s=email_amir">Email amir</a></th>
                                        <th><a href="/sort_users.php?s=name">Name</a></th>
                                        <th><a href="/sort_users.php?s=username_ambosador">User ambassador</a></th>
                                        <th><a href="/sort_users.php?s=status">Status</a></th>
                                        <th><a href="/sort_users.php?s=username_partner">Partner</a></th>
                                        <th>Date Banned</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? //echo $_SESSION['cur_page']; ?>
                                    <? foreach($users as $user){?>
                                    <tr class="odd gradeX">
                                        <td><?=$user->telegram_id;?></td>
                                        <td><?=$user->language;?></td>
                                        <td><?=$user->last_action;?></td>
                                        <td><?=$user->email_amir;?></td>
                                        <td><?=$user->name;?></td>
                                        <td><?=$user->username_ambosador;?></td>
                                        <td><?if($user->status==1){ echo "Active"; } elseif ($user->status==0) { echo "Waiting activation"; } else { echo "BANNED"; }  ?> </td>
                                        <td><?=$user->username_partner;?></td>
                                        <td><?if($user->data_banned!=null){ echo date("m/d/Y h:i:s a", $user->data_banned); }?></td>
                                        <td><a
                                                href="<?=base_url();?>index.php/dashboard/edit_user/<?=$user->telegram_id;?>">Edit</a>
                                        </td>
                                        <td><a
                                                href="<?=base_url();?>index.php/dashboard/delete_user/<?=$user->telegram_id;?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?}?>




                                </tbody>
                            </table>

                            <!-- PAGINATION -->
                            <style>
                                .pagin {
                                    margin: 5px;
                                }
                            </style>
                            <?
	$pervpage='';
	$nextpage='';
	$page2left='';
	$page1left='';
	$page2right='';
	$page1right='';
						  
	
if ($_SESSION['cur_page'] != 1) $pervpage = '<a class="pagin" href="/page_user.php?page=1"><<</a>
                               <a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] - 1) .'"><</a> ';

if ($_SESSION['cur_page'] != $_SESSION['total_pages']) $nextpage = ' <a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] + 1) .'">></a>
                                   <a class="pagin" href= "/page_user.php?page=' .$_SESSION['total_pages'].'">>></a>';


if($_SESSION['cur_page'] - 2 > 0) $page2left = ' <a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] - 2) .'">'. ($_SESSION['cur_page'] - 2) .'</a>';
if($_SESSION['cur_page'] - 1 > 0) $page1left = '<a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] - 1) .'">'. ($_SESSION['cur_page'] - 1) .'</a>';
if($_SESSION['cur_page'] + 2 <= $_SESSION['total_pages']) $page2right = '<a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] + 2) .'">'. ($_SESSION['cur_page'] + 2) .'</a>';
if($_SESSION['cur_page'] + 1 <= $_SESSION['total_pages']) $page1right = '<a class="pagin" href= "/page_user.php?page='. ($_SESSION['cur_page'] + 1) .'">'. ($_SESSION['cur_page'] + 1) .'</a>';


		  if($_SESSION['total_pages']>1){
echo $pervpage.$page2left.$page1left.'<span class="pagin active" style="text-decoration:none">'.$_SESSION['cur_page'].'</span>'.$page1right.$page2right.$nextpage;
		  }
						  ?>


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
                            <td><a
                                    href="<?=base_url();?>index.php/dashboard/edit_admin/<?=$admin->telegram_id;?>">Edit</a>
                            </td>
                            <td><a
                                    href="<?=base_url();?>index.php/dashboard/delete_admin/<?=$admin->telegram_id;?>">Delete</a>
                            </td>
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

            <? //echo $_SESSION['ads_limit']; ?>
            <div class="panel-heading">
                Список объявлений | выводить по <select id="sort_ads">
                    <option value="3" <? if(isset($_SESSION['ads_limit']) && $_SESSION['ads_limit']==3):?> selected
                        <? endif ?> >3</option>
                    <option value="20" <? if(isset($_SESSION['ads_limit']) && $_SESSION['ads_limit']==20):?> selected
                        <? endif ?>>20</option>
                    <option value="30" <? if(isset($_SESSION['ads_limit']) && $_SESSION['ads_limit']==30):?> selected
                        <? endif ?>>30</option>
                    <option value="50" <? if(isset($_SESSION['ads_limit']) && $_SESSION['ads_limit']==50):?> selected
                        <? endif ?>>50</option>
                    <option value="5000000" <? if(isset($_SESSION['ads_limit']) && $_SESSION['ads_limit']==5000000):?>
                        selected
                        <? endif ?>>Все</option>
                </select>
                <div class="search-box" style="float: right; margin-left: 25px;">
                    <input type="text" id="search_ads" autocomplete="off" placeholder="Поиск..." />
                    <div id="display" class="result"></div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive" id="load_ads">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example3">
                        <thead>
                            <tr>
                                <th><a href="/sort_ads.php?s=username">Username</a></th>
                                <th><a href="/sort_ads.php?s=amount">Amount</a></th>
                                <th><a href="/sort_ads.php?s=type">Type</a></th>
                                <th><a href="/sort_ads.php?s=pay">Pay</a></th>
                                <th><a href="/sort_ads.php?s=currency">Currency</a></th>
                                <th><a href="/sort_ads.php?s=city">City</a></th>
                                <th><a href="/sort_ads.php?s=rates">Rates</a></th>
                                <th><a href="/sort_ads.php?s=comment">Comment</a></th>
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
                                <td><a
                                        href="<?=base_url();?>index.php/dashboard/delete_ads/<?=$ad->id_ads;?>">Delete</a>
                                </td>
                            </tr>
                            <?}?>
                        </tbody>
                    </table>

                    <!-- PAGINATION ADS -->
                    <style>
                        .pagin {
                            margin: 5px;
                        }
                    </style>
                    <?
	$pervpage2='';
	$nextpage2='';
	$page2left2='';
	$page1left2='';
	$page2right2='';
	$page1right2='';
						  
	
if ($_SESSION['cur_page2'] != 1) $pervpage2 = '<a class="pagin" href="/page_ads.php?page=1"><<</a>
                               <a class="pagin" href= "/page_ads.php?page='. ($_SESSION['cur_page2'] - 1) .'"><</a> ';

if ($_SESSION['cur_page2'] != $_SESSION['total_pages2']) $nextpage2 = ' <a class="pagin" href= "/page_ads.php?page='. ($_SESSION['cur_page2'] + 1) .'">></a>
                                   <a class="pagin" href= "/page_ads.php?page=' .$_SESSION['total_pages2'].'">>></a>';


if($_SESSION['cur_page2'] - 2 > 0) $page2left2 = ' <a class="pagin" href= "/page_ads.php?page='. ($_SESSION['cur_page2'] - 2) .'">'. ($_SESSION['cur_page2'] - 2) .'</a>';
if($_SESSION['cur_page2'] - 1 > 0) $page1left2 = '<a class="pagin" href= "/page_ads.php?page='. ($_SESSION['cur_page2'] - 1) .'">'. ($_SESSION['cur_page2'] - 1) .'</a>';
if($_SESSION['cur_page2'] + 2 <= $_SESSION['total_pages2']) $page2right2 = '<a class="pagin" href= "/page_ads.php?page='. ($_SESSION['cur_page2'] + 2) .'">'. ($_SESSION['cur_page2'] + 2) .'</a>';
if($_SESSION['cur_page2'] + 1 <= $_SESSION['total_pages2']) $page1right = '<a class="pagin" href= "/page_ads.php?page='. ($_SESSION['cur_page2'] + 1) .'">'. ($_SESSION['cur_page2'] + 1) .'</a>';


		  if($_SESSION['total_pages2']>1){
echo $pervpage2.$page2left2.$page1left2.'<span class="pagin active" style="text-decoration:none">'.$_SESSION['cur_page2'].'</span>'.$page1right2.$page2right2.$nextpage2;
		  }
						  ?>


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
<script>
    // SORT USER
    $(document).on('change', '#sort_user', function () {
        var count = $('#sort_user').val();
        //alert(count);
        window.location.href = '/sort_users_limit.php?val=' + count;
    });
    /// SORT ADS
    $(document).on('change', '#sort_ads', function () {
        var count2 = $('#sort_ads').val();
        //alert(count2);
        window.location.href = '/sort_ads_limit.php?val=' + count2;
    });


    /// SEARCH
    function fill(Value) {



        $('#search').val(Value);



        $('#display').hide();

    }





    $(document).on('keyup change', '#search', function () {


        //alert(3);
        var mes = $('#search').val();



        if (mes == "") {



            $("#display").html("");

        } else if (mes.length >= 1) {



            $.ajax({



                type: "POST",



                url: "/search_user_detect.php?search=" + mes,



                data: {



                    search: mes

                },



                success: function (html) {


                    if (html == 1) {
                        //alert(1);
                        // $("#display").html(html).show();
                        $('#load_users').load('/search_user.php?search=' + mes);
                    } else {
                        // Ничего не делаем
                    }
                }
            });
        }
    });
    /// SORT ADS
    /// SEARCH
    function fill(Value) {
        $('#search_ads').val(Value);
        $('#display').hide();
    }

    $(document).on('keyup change', '#search_ads', function () {
        //alert(3);
        var mes_ads = $('#search_ads').val();
        if (mes_ads == "") {
            $("#display_ads").html("");
        } else if (mes_ads.length >= 1) {
            $.ajax({
                type: "POST",
                url: "/search_ads_detect.php?search=" + mes_ads,
                data: {
                    search: mes_ads
                },
                success: function (html) {


                    if (html == 1) {
                        //alert(1);
                        // $("#display").html(html).show();
                        $('#load_ads').load('/search_ads.php?search=' + mes_ads);
                    } else {
                        // Ничего не делаем
                    }

                }

            });

        }

    });
</script>