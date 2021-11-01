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
<?php
                            if(isset($_GET['message']))
                            {
                            	if($_GET['message']=='new'){
                                ?>
                            <div class="alert alert-dark-success alert-dismissible fade show">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    Опросник сформирован!
                                                </div>
                             <?php } 
                            
                            if($_GET['message']=='delete'){
                                ?>
                            <div class="alert alert-dark-danger alert-dismissible fade show">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    Опросник удален!
                                                </div>
                             <?php } ?>
                            
                          <?php  }
                            ?>
                            <div class="card">
                            <div class="card-header">Список моих опросников</div>
                            <table class="table card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Наименование опросника</th>
                                        <th>Дата создания</th>
                                        <th>Количество кодов доступа</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php  foreach($quizs as $q_as){ ?>
                                    <tr>
                                        <th scope="row"><?php echo $q_as->id_q; ?></th>
                                        <td><a href="<?=base_url();?>index.php/all/index/<?php echo $q_as->id_q; ?>/" target="_blank"><?php echo $q_as->name; ?></a></td>
                                        <td><?php echo date('d.m.Y H:i:s',$q_as->date);?></td>
                                        <td>
                                    <?php
                                       $get_count = $this->db->query("SELECT count(*) as ccount FROM quiz_codes WHERE id_quiz = '".$q_as->id_q."'")->result();
                                                               
                                        ?>
                                        Кодов: <?php echo $get_count[0]->ccount;?>
                                        <a href="#" data-toggle="modal" data-target="#exampleModal_<?php echo $q_as->id_q; ?>">Статистика входов по кодам</a>
                                        
                                        
                                        
<!-- Modal -->
<div class="modal fade" id="exampleModal_<?php echo $q_as->id_q; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Статистика входов по кодам</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <!------>
      
      <table class="table card-table">
                                
                                <tbody>
                                
                                <?php $codes = $this->db->query("SELECT * FROM quiz_codes WHERE id_quiz = '".$q_as->id_q."'")->result(); foreach($codes as $code){ ?>
                                    <tr>
                                        <td><?php echo $code->code;?></td>
                                        <td><?php echo $code->count;?></td>
                                    </tr>
                                  <?php } ?>  
                                </tbody>
                            </table>
      
      <!------>
      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ага, понятно!</button>
      </div>
    </div>
  </div>
</div>
                                        
                                    	</td>
                                    <td><a href="<?=base_url();?>index.php/dashboard/delete/<?php echo $q_as->id_q; ?>/">Удалить</a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
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

<script>

$(document).ready(function() {
                  $("#add").click(function() {
                                  var lastField = $("#buildyourform div:last");
                                  var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
                                  var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
                                  fieldWrapper.data("idx", intId);
                                  
                                  var fName = $('<input type="file" name="image_item[]" class="form-control">');
                                  
                                  var removeButton = $("<input type=\"button\" class=\"remove\" value=\"убрать\" />");
                                  removeButton.click(function() {
                                                     $(this).parent().remove();
                                                     });
                                  fieldWrapper.append(fName);
                                  fieldWrapper.append(removeButton);
                                  $("#buildyourform").append(fieldWrapper);
                                  });
                  
                  });
</script>
