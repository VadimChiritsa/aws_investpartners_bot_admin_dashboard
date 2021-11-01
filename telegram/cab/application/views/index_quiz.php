<!DOCTYPE html>
<html lang="ru">
<head>
<title>Квест</title>

<meta charset="utf-8">




<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700|Rubik:400,500&amp;subset=cyrillic" rel="stylesheet">

<link rel="stylesheet" href="<?=base_url();?>all.css">

<script>
window.__PATH = '<?=base_url();?>index.php/all/data/<?php echo $id; ?>/';
</script>

</head>
<body>


<div class="b-city" data-quest-city></div>

<div class="b-header">
<div class="b-header__logos">
<a class="b-header__alfabank" href="#" data-quest-action="promo" data-quest-location="header">
<img src="<?=base_url();?>secret.png" style="width:56px; height:17px;"><br/>
<img src="<?=base_url();?>GAME.png" style="width:115px; height:58px; margin-left: 55px; margin-top: -10px;">
</a>
<a class="b-header__vcru" href="/" target="_blank">
</a>
</div>
</div>

<div class="b-main">


<!---->

<?php
$get_count = $this->db->query("SELECT * FROM quiz_codes WHERE id_quiz = '".$id."'")->result();
if($get_count!=null){
?>

<div id="boxes" >
    <div id="dialog" class="window b-content" style="z-index:99999; position:absolute;margin-top:20%;">
    Введите код доступа:<br>
    <form method="post"  id="contacts">
    <input type="hidden" value="<?php echo $id; ?>"  id="id" name="id">
    <input type="text" value="" id="code" name="code"></br>
    <button type="submit">Продолжить</button>
    </form>
    <!--<a href="#" class="close"/>Закрыть его</a>-->
    </div>
    <div id="mask"></div>
</div>
<?php } ?>
<!---->

<div class="b-title">
<div class="b-title__title" style="color:#fff;">
<!--Title quiz-->
</div>
<div class="b-title__subtitle" style="color:#fff;">
<!--Slogan-->
</div>
</div>

<div class="b-status" data-quest-status style="display:none;">
<div class="b-status__progress" data-quest-progress></div>
<div class="b-status__balance">
<div data-quest-balance></div>
</div>
</div>

<div class="b-content quiz" data-quest-content>
<div class="b-task" data-quest-task></div>
<div class="b-answers" data-quest-answers></div>
<div class="b-result" data-quest-result></div>
</div>

<div class="b-content is_hidden" data-quest-promo>

<div class="b-promo">

<div class="b-promo__title">
<strong>Победа</strong>
</div>

<div class="b-promo__text">
Мы большие молодцы, мы прошли через все этапы игры. И мы с Уиллом достигли  заветной мечты 🎁 Наши цели достигнуты.
Мы и наши близкие люди могут жить той жизнью, о которой многим остаётся только мечтать😎
Нам осталось, только  раскрыть главный секрет SECRET GAME. Жми: открыть тайну и приятного просмотра.
</div>



<div class="b-promo__more">
<a class="b-promo__more__button" href="https://secret-game.info/winner" target="_blank1" data-quest-action="promo" data-quest-location="final_1">
Открыть тайну

</a>
<div class="b-promo__more__note">

</div>
</div>

</div>



</div>

</div>

<?php
$get_count = $this->db->query("SELECT * FROM quiz_codes WHERE id_quiz = '".$id."'")->result();
if($get_count!=null){
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
jQuery(function($) {
//$(document).ready(function() { alert('ad'); });

function modalWin(id){
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
     //   $('#mask').css({'width':maskWidth,'height':maskHeight});
        $('#mask').fadeIn(1000);
        $('#mask').fadeTo("slow",0.8);
        var winH = $(window).height();
        var winW = $(window).width();
        //$(id).css('top',  winH/2-$(id).height()/2);
        //$(id).css('left', winW/2-$(id).width()/2);
        $(id).fadeIn(2000);
}
$(document).ready(function() {

$('.quiz').hide();

    $('a[name=modal]').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('href');
        modalWin(id);
    });
/*
    $('.window .close').click(function (e) {
        e.preventDefault();
        $('#mask, .window').hide();
    });
    

    $('#mask').click(function () {
        $(this).hide();
        $('.window').hide();
    });
   */ 
});
modalWin('#dialog');


 $( "#contacts" ).submit(function( event ) {
                                event.preventDefault();
                         
                         
                        //var vall = $('#emailiii').val();
                        //if ($.trim(vall)) {
                           var main =  $.post( "<?=base_url();?>index.php/all/code/",  $( "#contacts" ).serialize());
                         
                          main.done(function( data ) {
                          if(data=='ok'){
                           $('.window').hide();
                          $('.quiz').show();
                          }
                                 
                            
                          });
                        //}else { alert('Заполните поле Email')}
                        
                        
                        
                         
                        });

 });

</script>
<?php } ?>
<script src="<?=base_url();?>all.js"></script>

</html>

