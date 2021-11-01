<?php $this->load->view('header');?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Создание нового опросника</h4>

                        <hr class="border-light container-m--x my-0">

                        <div class="row mt-4">
                            <div class="col-lg-4 col-xl-3">

                                <div>
                                    
                                <form method="post" action="<?=base_url();?>index.php/dashboard/new_q/">
                                    <div class="form-group">
                                        <label class="form-label">Название</label>
                                        <input type="text" name="name_quiz" class="form-control" value="" placeholder="Наименование" required>
                                        <div class="clearfix"></div>
                                    </div>
                                	<div class="form-group">
                                        <label class="form-label">Количество кодов доступа</label>
                                        <input type="number" name="count_codes" class="form-control" value="0" placeholder="0">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Количество вопросов</label>
                                        <input type="number" name="count_ques" value="2" class="form-control" placeholder="2">
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Приступить к волшебству</button>
                                </form>
                                
                                </div>

                               

                            </div>
                            <div class="col">


<!------>
<div class="card mb-4">
<h6 class="card-header"></h6>
<div class="card-body">


<form method="post" action="<?=base_url();?>index.php/dashboard/save/">

<?php foreach($qizs as $key => $qq){ $key++; ?>


<div class="form-group row">
<label class="col-form-label col-sm-2 text-sm-right">Вопрос # <?php echo $key;?></label>
<div class="col-sm-10"  id="buildyourform_<?php echo $qq->id_qq;?>">
<input type="hidden" name="id_qq[]" value="<?php echo $qq->id_qq;?>" class="form-control">
<textarea name="q_<?php echo $qq->id_qq;?>[]" class="form-control" placeholder=""><?php echo $qq->q;?></textarea>
</br>
 <input type="button" value="Добавить ответы к этому вопросу" class="add" id="add_<?php echo $qq->id_qq;?>" /> </br>
</div>
</div>




<?php } ?>


<div class="form-group row">
<div class="col-sm-10 ml-sm-auto">
<button type="submit" class="btn btn-primary">Создать</button>
</div>
</div>


</form>
</div>
</div>



<!------->



                            </div>
                        </div>

                    </div>
                    <!-- [ content ] End -->

                    <!-- [ Layout footer ] Start -->
                 <!--   <nav class="layout-footer footer bg-white">
                        <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                            <div class="pt-3">
                                <span class="footer-text font-weight-semibold">&copy; <a href="https://srthemesvilla.com" class="footer-link" target="_blank">Srthemesvilla</a></span>
                            </div>
                            <div>
                                <a href="javascript:" class="footer-link pt-3">About Us</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Help</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Contact</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </nav> -->
                    <!-- [ Layout footer ] End -->

                </div>
                <!-- [ Layout content ] Start -->

<?php $this->load->view('footer');?>

<?php foreach($qizs as $key => $qq){ $key++; ?>

<script>

$(document).ready(function() {
                  $("#add_<?php echo $qq->id_qq;?>").click(function() {
                                  var lastField = $("#buildyourform_<?php echo $qq->id_qq;?> div:last");
                                  var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
                                  var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
                                  fieldWrapper.data("idx", intId);
                                  
                                  var fName = $('<div class="form-group row"><label class="col-form-label col-sm-2 text-sm-right">Ответ</label><div class="col-sm-10"><textarea name="answer_<?php echo $qq->id_qq;?>[]" class="form-control" placeholder=""></textarea><div class="clearfix"></div></div></div><div class="form-group row"><label class="col-form-label col-sm-2 text-sm-right">Балл</label><div class="col-sm-10"><input type="text" name="price_<?php echo $qq->id_qq;?>[]" class="form-control" placeholder=""><div class="clearfix"></div></div></div><div class="form-group row"><label class="col-form-label col-sm-2 text-sm-right">Результат системы на выбранный ответ</label><div class="col-sm-10"><textarea name="resulе_<?php echo $qq->id_qq;?>[]" class="form-control" placeholder=""></textarea><div class="clearfix"></div></div></div><div class="form-group row"><label class="col-form-label col-sm-2 text-sm-right">Действие</label><div class="col-sm-10"><input type="text" name="value_<?php echo $qq->id_qq;?>[]" class="form-control" placeholder="0 -начинаем сначало, 1 - играем дальше"><div class="clearfix"></div></div></div>');
                                  
                                  var removeButton = $("<input type=\"button\" class=\"remove\" value=\"убрать\" />");
                                  removeButton.click(function() {
                                                     $(this).parent().remove();
                                                     });
                                  fieldWrapper.append(fName);
                                  fieldWrapper.append(removeButton);
                                  $("#buildyourform_<?php echo $qq->id_qq;?>").append(fieldWrapper);
                                  });
                  
                  });
</script>

<?php } ?>