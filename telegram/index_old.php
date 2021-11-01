<?php
    
    include_once('vendor/autoload.php');
  
    
    $server = 'localhost';
    $username = 'wormby_admin';
    $password = 'TcjSm7QdiR64_15*F!t';
    $db_name = 'wormby_telegram';
    
    
    
    
    
$token = "1664306230:AAELUeuQ0kSMcAuMllr_U4bddFbd-ftxq9I";
$bot = new \TelegramBot\Api\Client($token);
    
    
    
        
    
// команда для start
    /*
$bot->command('startaa', function ($message) use ($bot) {
              $mysqli = new mysqli('localhost', 'wormby_admin', 'TcjSm7QdiR64_15*F!t', 'wormby_telegram');
              
              $items = "SELECT * FROM users WHERE telegram_id = '".$message->getChat()->getId()."'";
              $result2 = $mysqli->query($items);
              if ($result2->num_rows > 0) {
                $answer = 'Вы уже являетесь участником';
              }else{
                $answer = 'Здравствуйте. текст, текст, текст. Давайте зарегистрируемся.
                Пришлите номер телефона в формате +375-**-***-**-**';
              
              $i6 = "INSERT INTO users (telegram_id, last_active) VALUES ('".$message->getChat()->getId()."', '');";
              $mysqli->query($i6);
              
              }
              
              
              
    $bot->sendMessage($message->getChat()->getId(), $answer);
              
              
              
});
    */

    // команда для помощи
    /*
    $bot->command('cab', function ($message) use ($bot) {
                  $answer = 'Команды:
                  /help - вывод справки';
                  $bot->sendMessage($message->getChat()->getId(), $answer);
                  
                  
                  $messageText = '123';
                  
                  $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("one", "two", "three")), true); // true for one-time keyboard
                  
                  
                  
                  $bot->sendMessage($message->getChat()->getId(), $messageText, null, false, null, $keyboard);
                  
                  
                  
                  });
    */
// команда для помощи
    /*
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - вывод справки';
    $bot->sendMessage($message->getChat()->getId(), $answer);
              
              
              $messageText = '123';
              
              $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("one", "two", "three")), true); // true for one-time keyboard
              
              $bot->sendMessage($message->getChat()->getId(), $messageText, null, false, null, $keyboard);
});
    
    */
    
    
    function start($id)
    {
        $mysqli = new mysqli('localhost', 'wormby_admin', 'TcjSm7QdiR64_15*F!t', 'wormby_telegram');
        $items = "SELECT * FROM users WHERE telegram_id = '".$id."'";
        $result2 = $mysqli->query($items);
        if ($result2->num_rows > 0) {
            $answer = 'Вы уже являетесь участником';
        }else{
            $answer = 'Здравствуйте. текст, текст, текст. Давайте зарегистрируемся.
            Пришлите номер телефона в формате +375-**-***-**-**';
            
            $i6 = "INSERT INTO users (telegram_id, last_active) VALUES ('".$id."', '');";
            $mysqli->query($i6);
            
        }
        
        return $answer;
        
    }
    
    function add_phone($id=0)
    {
        $answer = 'add_phone';
        return $answer;
    }
    
    
    $content=( file_get_contents('php://input') );
    
    $file = fopen("etlLOG.txt","w+");
    echo fwrite($file,$content);
    fclose($file);
    
    
    //Handle text messages
    $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
             
             
             //$mysqli = new mysqli('localhost', 'wormby_admin', 'TcjSm7QdiR64_15*F!t', 'wormby_telegram');
             
             
             $message = $update->getMessage();
             $id = $message->getChat()->getId();
             $input = $message->getText();
             $request = json_decode(file_get_contents('php://input'),true);
            
             
             
             
             
             $answer = add_phone($id);
             $bot->sendMessage($id, $answer);
             
            
             ///start
             if ($input === "/start") {
               $answer = start($id);
             
             $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                                                                                [
                                                                                [
                                                                                ['text' => 'forward me to groups', 'callback_data' => 'actionInlineButton_1234']
                                                                                ]
                                                                                ]
                                                                                );
             
             $bot->sendMessage($id, $answer, null, false, null, $keyboard);
             }
             
             if ($input === "/add_phone") {
                $answer = add_phone($id);
                $bot->sendMessage($id, $answer);
             }
             
             ///start
         ///add_phone
             /*
             if(stristr($message->getText(), '+375') === FALSE) {
             $answer = 'Неверный формат номера. Введите номер вида: +375-**-***-**-**';
             }else{
                $mysqli = new mysqli('localhost', 'wormby_admin', 'TcjSm7QdiR64_15*F!t', 'wormby_telegram');
             
                     $items = "SELECT * FROM telephons WHERE telegram_id = '".$message->getChat()->getId()."'";
                     $result2 = $mysqli->query($items);
                     if ($result2->num_rows > 0) {
                     $answer = 'Номер '.$message->getText().' уже зарегистрирован в системе.';
                     }else{
                     $answer = 'Спасибо, Ваш номер принят.
             Пришлите адрес на русском языке (улица ****, номер дома *****)';
             
                     $i6 = "INSERT INTO telephons (telegram_id, phone) VALUES ('".$message->getChat()->getId()."', '".$message->getText()."');";
                     $mysqli->query($i6);
             
                     }

             }
              */
          ///add_phone
             
             
             
             }, function () {
             return true;
             });

$bot->run();
        
        
    
?>
