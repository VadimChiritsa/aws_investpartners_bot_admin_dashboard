
<?php

require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';
require './phpmailer/Exception.php';

class Bot
{
    // Токен бота
    private $token = "2077508530:AAGeAQqLroyqwDCrmaqQrAYTrVmCIHVQOgY";
    // id пользователя которому бот будет отправлять примеры
    // укажите ваш id - узнать можно @myidbot



    private $userId;
    // свойство в котором будем хранить переданные данные из Телеграм Бот АПИ
    private $data;

    /**
     * Bot constructor.
     */
    public function __construct()
    {
        // сохраняем данные из Телеграм Бот АПИ в свойство
        $this->data = json_decode(file_get_contents('php://input'), true);
        // запускаем роутер

        $this->router();
    }

    /** Роутер - определяет куда направлять запрос от Телеграм Бот АПИ
     * @return bool
     */
    private function router()
    {

        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');

        mysqli_set_charset($mysqli, "utf8");

        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
            $username = $this->data['message']['from']['username'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
            $username = $this->data['callback_query']['from']['username'];
        }

        // проверяем на объект Message https://core.telegram.org/bots/api#message
        if (array_key_exists("message", $this->data)) {
            // если это текстовое сообщение объекта Message
            if (array_key_exists("text", $this->data['message'])) {




                $users = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
                $result2 = $mysqli->query($users);
                if ($result2->num_rows > 0) {

                    while ($row = $result2->fetch_assoc()) {

                        $last_action = $row['last_action'];
                        $language = $row['language'];

                        if ($row['status'] == 99) {
                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "Ваш профиль находится в черном списке. За подробностями обратитесь к администратору."
                            ]);
                            die();
                        }

                        if ($last_action == "search_user") {

                            if ($language == "rus") {
                                $success_message = "Данный пользователь существует.";
                                $failure_message = "Данный пользователь НЕ существует.";
                            }

                            if ($language == "eng") {
                                $success_message = "User exists.";
                                $failure_message = "User DOESN'T exist.";
                            }

                            $user_input_username_for_search = $this->data['message']['text'];

                            if(!empty($user_input_username_for_search) && $user_input_username_for_search[0] == '@') {
                                $user_input_username_for_search = substr($user_input_username_for_search, 1, strlen($user_input_username_for_search));
                            }

                            $i6 = "SELECT * FROM users WHERE username = '" . $user_input_username_for_search . "' and status = '1'";

                            $entitySelectByUsername = $mysqli->query($i6);

                            if ($entitySelectByUsername->num_rows > 0) {
                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $success_message . ""
                                ]);
                            } else {
                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $failure_message . ""
                                ]);
                            }

                            $this->mainmenu();
                        }

                        if ($last_action == "enter_email_amir") {

                            $sanitized_email = filter_var($this->data['message']['text'], FILTER_SANITIZE_EMAIL);

                            if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {


                                $i6 = "UPDATE users SET last_action = 'enter_name', email_amir = '" . $this->data['message']['text'] . "', username = '" . $username . "' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);


                                if ($language == "rus") {
                                    $message = "Отлично, теперь введите свои Имя и Фамилию";
                                }
                                if ($language == "eng") {
                                    $message = "Ok, now enter your first and last name";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                            } else {


                                if ($language == "rus") {
                                    $message = "E-mail адрес " . $this->data['message']['text'] . " указан неверно. Введите верный email.";
                                }
                                if ($language == "eng") {
                                    $message = "E-mail address " . $this->data['message']['text'] . " specified incorrectly. Please enter a valid email address.";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                            }
                        }


                        if ($last_action == "enter_name") {


                            $i6 = "UPDATE users SET last_action = 'enter_username_ambosador', name = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "'";
                            $mysqli->query($i6);

                            if ($language == "rus") {
                                $message = "Отлично. Теперь необходимо ввести Telegram username Вашего амбассадора (Пример: @durov)";
                            }
                            if ($language == "eng") {
                                $message = "Great, now you need to enter the username of the ambassador's telegrams. (Example: @durov)";
                            }


                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "" . $message . ""
                            ]);
                        }

                        if ($last_action == "enter_username_ambosador") {


                            $i6 = "UPDATE users SET last_action = 'enter_username_partner', username_ambosador = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "'";
                            $mysqli->query($i6);

                            if ($language == "rus") {
                                $message = "Отлично. Теперь необходимо ввести Telegram username Вашего вышестоящего партнера. (Пример: @durov)";
                            }
                            if ($language == "eng") {
                                $message = "Great, now you need to enter the username telegram upstream partner. (Example: @durov)";
                            }

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "" . $message . ""
                            ]);
                        }

                        if ($last_action == "enter_username_partner") {


                            $i6 = "UPDATE users SET last_action = 'done_registration', username_partner = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "'";
                            $mysqli->query($i6);

                            if ($language == "rus") {
                                $message = "Отлично, регистрация закончена. Теперь Ваш аккаунт будет верефицирован нашими администраторами. После верификации Вы получите уведомление в боте.";
                                $buttons = json_encode([
                                    "keyboard" => [
                                        [["text" => "Вход",]]
                                    ],
                                    'one_time_keyboard' => false,
                                    'resize_keyboard' => true,
                                    'selective' => true,
                                ], true);
                            }
                            if ($language == "eng") {
                                $message = "Great, registration is over. Now your account will be verified by our administrators. After verification, you will receive a notification.";
                                $buttons = json_encode([
                                    "keyboard" => [
                                        [["text" => "Enter",]]
                                    ],
                                    'one_time_keyboard' => false,
                                    'resize_keyboard' => true,
                                    'selective' => true,
                                ], true);
                            }

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "" . $message . "",
                                "reply_markup" => $buttons
                            ]);
                        }


                        ///addbuy
                        if ($last_action == "i_buy") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $date = date('d.m.Y H:i:s');
                                $tomorrow = date('d.m.Y H:i:s', strtotime($date . "+1 days"));

                                $i6 = "INSERT INTO ads (telegram_id, date, amount, status, type, username) VALUES ('" . $userId . "', '" . strtotime($tomorrow) . "', '" . $this->data['message']['text'] . "', 0, 'buy', '" . $username . "');";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_buy_add_rates' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);

                                if ($language == "rus") {
                                    $message = "Отлично! Введите желаемый курс (пример: 1:1)";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter the desired rate (example: 1: 1)";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                            } else {
                                $this->exit();
                            }
                        }


                        if ($last_action == "i_buy_add_rates") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET rates = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'buy'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_buy_add_pay' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Введите способ оплаты (пример: наличные)";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter your payment method (example: cash)";
                                }
                                /*
                                     $this->botApiQuery("sendMessage", [
                                                        "chat_id" => $userId,
                                                        "text" => "".$message.""
                                                        ]);
                                     
                                     */
                                $buttons = json_encode([
                                    'inline_keyboard' => [
                                        [
                                            [
                                                "text" => "Наличные",
                                                "callback_data" => "actionInlineButton_paybuy-nal"
                                            ],
                                            [
                                                "text" => "Карта",
                                                "callback_data" => "actionInlineButton_paybuy-card"
                                            ]
                                        ]
                                    ],
                                ], true);

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . "",
                                    "reply_markup" => $buttons
                                ]);
                            } else {
                                $this->exit();
                            }
                        }


                        if ($last_action == "i_buy_add_pay") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET pay = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'buy'";
                                $mysqli->query($i6);


                                $i6 = "UPDATE users SET last_action = 'i_buy_add_city' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Введите город (пример: Минск)";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter city (example: Minsk)";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);

                                /*
                                     
                                     $i6 = "UPDATE users SET last_action = 'i_buy_add_currency' WHERE telegram_id = '".$userId."'";
                                     $mysqli->query($i6);
                                     if($language=="rus")
                                     {
                                         $message = "Отлично! Введите валюту (пример: доллары)";
                                     }
                                     if($language=="eng")
                                     {
                                         $message = "Excellent! Enter currency (example: dollars)";
                                     }
                                     
                                     $this->botApiQuery("sendMessage", [
                                                        "chat_id" => $userId,
                                                        "text" => "".$message.""
                                                        ]);
                                     */
                            } else {
                                $this->exit();
                            }
                        }

                        /*
                             
                             if($last_action == "i_buy_add_currency"){
                                 
                                 if($row['status']==1 && $row['enter_key']!=""){
                                     
                                     $i6 = "UPDATE ads SET currency = '".$this->data['message']['text']."' WHERE telegram_id = '".$userId."' and status = '0' and type = 'buy'";
                                     $mysqli->query($i6);
                                     
                                     $i6 = "UPDATE users SET last_action = 'i_buy_add_city' WHERE telegram_id = '".$userId."'";
                                     $mysqli->query($i6);
                                     if($language=="rus")
                                     {
                                         $message = "Отлично! Введите город (пример: Минск)";
                                     }
                                     if($language=="eng")
                                     {
                                         $message = "Excellent! Enter city (example: Minsk)";
                                     }
                                     
                                     $this->botApiQuery("sendMessage", [
                                                        "chat_id" => $userId,
                                                        "text" => "".$message.""
                                                        ]);
                                 }else{
                                     $this->exit();
                                 }
                                 
                             }
                             */
                        if ($last_action == "i_buy_add_city") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET city = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'buy'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_buy_add_comment' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Введите комментарий";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter comment";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                            } else {
                                $this->exit();
                            }
                        }


                        if ($last_action == "i_buy_add_comment") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET comment = '" . $this->data['message']['text'] . "', status = '1' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'buy'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_buy_add_done' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Объявление опубликовано!";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Announcement published!";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                                $this->mainmenu();
                            } else {
                                $this->exit();
                            }
                        }

                        ///addbuy


                        ///addsell
                        if ($last_action == "i_sell") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $date = date('d.m.Y H:i:s');
                                $tomorrow = date('d.m.Y H:i:s', strtotime($date . "+1 days"));

                                $i6 = "INSERT INTO ads (telegram_id, date, amount, status, type, username) VALUES ('" . $userId . "', '" . strtotime($tomorrow) . "', '" . $this->data['message']['text'] . "', 0, 'sell', '" . $username . "');";
                                $mysqli->query($i6);


                                $i6 = "UPDATE users SET last_action = 'i_sell_add_rates' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);

                                if ($language == "rus") {
                                    $message = "Отлично! Введите желаемый курс (пример: 1:1)";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter the desired rate (example: 1: 1)";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                            } else {
                                $this->exit();
                            }
                        }


                        if ($last_action == "i_sell_add_rates") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET rates = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'sell'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_sell_add_pay' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Введите способ оплаты (пример: наличные)";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter your payment method (example: cash)";
                                }
                                /*
                                     $this->botApiQuery("sendMessage", [
                                                        "chat_id" => $userId,
                                                        "text" => "".$message.""
                                                        ]);
                                     */

                                $buttons = json_encode([
                                    'inline_keyboard' => [
                                        [
                                            [
                                                "text" => "Наличные",
                                                "callback_data" => "actionInlineButton_paysell-nal"
                                            ],
                                            [
                                                "text" => "Карта",
                                                "callback_data" => "actionInlineButton_paysell-card"
                                            ]
                                        ]
                                    ],
                                ], true);

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . "",
                                    "reply_markup" => $buttons
                                ]);
                            } else {
                                $this->exit();
                            }
                        }


                        if ($last_action == "i_sell_add_pay") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET pay = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'sell'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_sell_add_city' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Введите город (пример: Минск)";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter city (example: Minsk)";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                                /*
                                     $i6 = "UPDATE users SET last_action = 'i_sell_add_currency' WHERE telegram_id = '".$userId."'";
                                     $mysqli->query($i6);
                                     if($language=="rus")
                                     {
                                         $message = "Отлично! Введите валюту (пример: доллары)";
                                     }
                                     if($language=="eng")
                                     {
                                         $message = "Excellent! Enter currency (example: dollars)";
                                     }
                                     
                                     $this->botApiQuery("sendMessage", [
                                                        "chat_id" => $userId,
                                                        "text" => "".$message.""
                                                        ]);
                                     */
                            } else {
                                $this->exit();
                            }
                        }


                        /*
                             if($last_action == "i_sell_add_currency"){
                                 
                                 if($row['status']==1 && $row['enter_key']!=""){
                                     
                                     $i6 = "UPDATE ads SET currency = '".$this->data['message']['text']."' WHERE telegram_id = '".$userId."' and status = '0' and type = 'sell'";
                                     $mysqli->query($i6);
                                     
                                     $i6 = "UPDATE users SET last_action = 'i_sell_add_city' WHERE telegram_id = '".$userId."'";
                                     $mysqli->query($i6);
                                     if($language=="rus")
                                     {
                                         $message = "Отлично! Введите город (пример: Минск)";
                                     }
                                     if($language=="eng")
                                     {
                                         $message = "Excellent! Enter city (example: Minsk)";
                                     }
                                     
                                     $this->botApiQuery("sendMessage", [
                                                        "chat_id" => $userId,
                                                        "text" => "".$message.""
                                                        ]);
                                 }else{
                                     $this->exit();
                                 }
                                 
                             }
                             */

                        if ($last_action == "i_sell_add_city") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET city = '" . $this->data['message']['text'] . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'sell'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_sell_add_comment' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Введите комментарий";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Enter comment";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                            } else {
                                $this->exit();
                            }
                        }


                        if ($last_action == "i_sell_add_comment") {

                            if ($row['status'] == 1 && $row['enter_key'] != "") {

                                $i6 = "UPDATE ads SET comment = '" . $this->data['message']['text'] . "', status = '1' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'sell'";
                                $mysqli->query($i6);

                                $i6 = "UPDATE users SET last_action = 'i_sell_add_done' WHERE telegram_id = '" . $userId . "'";
                                $mysqli->query($i6);
                                if ($language == "rus") {
                                    $message = "Отлично! Объявление опубликовано!";
                                }
                                if ($language == "eng") {
                                    $message = "Excellent! Announcement published!";
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . ""
                                ]);
                                $this->mainmenu();
                            } else {
                                $this->exit();
                            }
                        }

                        ///addsell


                        if ($last_action == "generation_key") {


                            if ($row['status'] == 0) {

                                if ($row['language'] == "rus") {
                                    $message = 'Ваш аккаунт еще не верифицирован администрацией. Ожидайте уведомления.';
                                }

                                if ($row['language'] == "eng") {
                                    $message = 'Your account has not yet been verified by the administration. Wait for notification.';
                                }

                                $this->botApiQuery("sendMessage", [
                                    "chat_id" => $userId,
                                    "text" => "" . $message . "",
                                ]);
                            }

                            if ($row['status'] == 1) {

                                $enter_key = "SELECT * FROM users WHERE telegram_id = '" . $userId . "' and enter_key = '" . $this->data['message']['text'] . "'";
                                $result2 = $mysqli->query($enter_key);
                                if ($result2->num_rows > 0) {

                                    if ($language == "rus") {
                                        $message = "Добро пожаловать в invest_partners_bot🤖";
                                        $buttons = json_encode([
                                            "keyboard" => [
                                                [["text" => "Купить/Продать"]],
                                                [["text" => "Профиль"], ["text" => "Поиск пользователя"], ["text" => "Правила",]]
                                            ],
                                            'one_time_keyboard' => false,
                                            'resize_keyboard' => true,
                                            'selective' => true,
                                        ], true);
                                    }

                                    if ($language == "eng") {
                                        $message = "Welcome to the system.";
                                        $buttons = json_encode([
                                            "keyboard" => [
                                                [["text" => "Buy/Sell"]],
                                                [["text" => "Profile"], ["text" => "Rules",]]
                                            ],
                                            'one_time_keyboard' => false,
                                            'resize_keyboard' => true,
                                            'selective' => true,
                                        ], true);
                                    }

                                    $this->botApiQuery("sendMessage", [
                                        "chat_id" => $userId,
                                        "text" => "" . $message . "",
                                        "reply_markup" => $buttons
                                    ]);



                                    $i6 = "UPDATE users SET last_action = 'in_system' WHERE telegram_id = '" . $userId . "'";
                                    $mysqli->query($i6);

                                    die();
                                } else {

                                    if ($language == "rus") {
                                        $message = "Введенный Вами ключ доступа является недействительным. Введите актуальный ключ доступа:";
                                    }
                                    if ($language == "eng") {
                                        $message = "The access key you entered is invalid. Enter the current access key:";
                                    }

                                    $this->botApiQuery("sendMessage", [
                                        "chat_id" => $userId,
                                        "text" => "" . $message . ""
                                    ]);
                                }
                            }
                        }
                    }
                }



                // если это команда /start
                if ($this->data['message']['text'] == "/start") {
                    // вызываем метод обработки команды /start
                    $this->start();
                    // Можно отдельную кнопку клавиатуры обработать
                } elseif ($this->data['message']['text'] == "Button 1_1") {
                    $this->actionKeyboardButton();
                    // можно по регулярке проверять - сюда попадут все другие кнопки клавиатуры
                } elseif (preg_match("~^Button~", $this->data['message']['text'])) {
                    $this->actionKeyboardButton();
                } elseif ($this->data['message']['text'] == "🇷🇺 Русский язык") {
                    $this->editLang('rus');
                } elseif ($this->data['message']['text'] == "🇬🇧 English language") {
                    $this->editLang('eng');
                } elseif ($this->data['message']['text'] == "Регистрация") {
                    $this->registration();
                } elseif ($this->data['message']['text'] == "Registration") {
                    $this->registration();
                } elseif ($this->data['message']['text'] == "Вход") {
                    $this->login();
                } elseif ($this->data['message']['text'] == "Enter") {
                    $this->login();
                } elseif ($this->data['message']['text'] == "Купить/Продать") {
                    $this->buy_sell();
                } elseif ($this->data['message']['text'] == "Buy/Sell") {
                    $this->buy_sell();
                } elseif ($this->data['message']['text'] == "Поиск пользователя") {
                    $this->search();
                } elseif ($this->data['message']['text'] == "User search") {
                    $this->search();
                } elseif ($this->data['message']['text'] == "Я ознакомился с правилами.") {
                    $this->iagreerules();
                } elseif ($this->data['message']['text'] == "Профиль") {
                    $this->prof();
                } elseif ($this->data['message']['text'] == "Profile") {
                    $this->prof();
                } elseif ($this->data['message']['text'] == "Правила") {
                    $this->rules();
                } elseif ($this->data['message']['text'] == "Rules") {
                    $this->rules();
                } elseif ($this->data['message']['text'] == "Выйти") {
                    $this->exit();
                } elseif ($this->data['message']['text'] == "Выход") {
                    $this->exit();
                } elseif ($this->data['message']['text'] == "Exit") {
                    $this->exit();
                } elseif ($this->data['message']['text'] == "Редактировать профиль") {
                    $this->edit_profile();
                } elseif ($this->data['message']['text'] == "Edit profile (new verification required)") {
                    $this->edit_profile();
                } elseif ($this->data['message']['text'] == "Купить") {
                    $this->sell("0,10");
                } elseif ($this->data['message']['text'] == "Buy") {
                    $this->sell("0,10");
                } elseif ($this->data['message']['text'] == "Продать") {
                    $this->buy("0,10");
                } elseif ($this->data['message']['text'] == "Sell") {
                    $this->buy("0,10");
                } elseif ($this->data['message']['text'] == "Мои объявления") {
                    $this->my_ads();
                } elseif ($this->data['message']['text'] == "My announcements") {
                    $this->my_ads();
                } elseif ($this->data['message']['text'] == "Я хочу купить") {
                    $this->i_buy();
                } elseif ($this->data['message']['text'] == "Я хочу продать") {
                    $this->i_sell();
                } elseif ($this->data['message']['text'] == "I want to buy") {
                    $this->i_buy();
                } elseif ($this->data['message']['text'] == "I want to sell") {
                    $this->i_sell();
                } elseif ($this->data['message']['text'] == "Создать объявление") {
                    $this->add_ads();
                } elseif ($this->data['message']['text'] == "Add announcements") {
                    $this->add_ads();
                } elseif ($this->data['message']['text'] == "Основное меню") {
                    $this->mainmenu();
                } elseif ($this->data['message']['text'] == "Main Menu") {
                    $this->mainmenu();
                } else {
                    return false;
                }
            } else {
                return false;
            }
            // если это объект СallbackQuery https://core.telegram.org/bots/api#callbackquery
        } elseif (array_key_exists("callback_query", $this->data)) {
            // получаем значение (название метода) под ключем 0 из callback_data кнопки inline
            $method = current(explode("_", $this->data['callback_query']['data']));
            // вызываем переданный метод и передаем в него весь объект callback_query
            $this->$method($this->data['callback_query']);
        } else {
            return false;
        }
    }

    /**
     * Старт бота
     */
    private function start()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');

        mysqli_set_charset($mysqli, "utf8");



        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }



        $users = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($users);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {

                if ($row['language'] == "rus") {
                    $buttons = json_encode([
                        "keyboard" => [
                            [["text" => "Вход",]]
                        ],
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true,
                        'selective' => true,
                    ], true);

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "Войдите в систему под своими данными.",
                        "reply_markup" => $buttons
                    ]);
                }


                if ($row['language'] == "eng") {
                    $buttons = json_encode([
                        "keyboard" => [
                            [["text" => "Enter",]]
                        ],
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true,
                        'selective' => true,
                    ], true);

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "Log in with your data.",
                        "reply_markup" => $buttons
                    ]);
                }
            } //while

        } else {

            $buttons = json_encode([
                "keyboard" => [
                    [
                        ["text" => "🇷🇺 Русский язык",],
                        ["text" => "🇬🇧 English language",]
                    ]
                ],
                'one_time_keyboard' => false,
                'resize_keyboard' => true,
                'selective' => true,
            ], true);

            $this->botApiQuery("sendMessage", [
                "chat_id" => $userId,
                "text" => "Выбрать язык интерфейса. (Select interface language.)",
                "reply_markup" => $buttons
            ]);

            $i6 = "INSERT INTO users (telegram_id, last_action) VALUES ('" . $userId . "', 'enter');";
            $mysqli->query($i6);
        }
    }

    /** Обработка Inline кнопки
     * @param $callback_data
     */
    private function actionInlineButton($callback_data)
    {

        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');

        mysqli_set_charset($mysqli, "utf8");

        $params = explode("_", $callback_data["data"]);

        // отправляем Уведомление
        /*
            $this->botApiQuery("answerCallbackQuery", [
                               "callback_query_id" => $callback_data["id"],
                               "text" => "Событие inline получено",
                               "alert" => false
                               ]);
            */

        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }

        $commands_params = explode("-", $params['1']);



        if ($commands_params['0'] == "paysell") {

            if ($commands_params['1'] == "nal") {
                $pppay = 'Наличные';
            }

            if ($commands_params['1'] == "card") {
                $pppay = 'Карта';
            }

            $i6 = "UPDATE ads SET pay = '" . $pppay . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'sell'";
            $mysqli->query($i6);

            $i6 = "UPDATE users SET last_action = 'i_sell_add_city' WHERE telegram_id = '" . $userId . "'";
            $mysqli->query($i6);

            $message = "Отлично! Введите город (пример: Минск)";


            $this->botApiQuery("sendMessage", [
                "chat_id" => $userId,
                "text" => "" . $message . ""
            ]);
        }

        if ($commands_params['0'] == "paybuy") {

            if ($commands_params['1'] == "nal") {
                $pppay = 'Наличные';
            }

            if ($commands_params['1'] == "card") {
                $pppay = 'Карта';
            }

            $i6 = "UPDATE ads SET pay = '" . $pppay . "' WHERE telegram_id = '" . $userId . "' and status = '0' and type = 'buy'";
            $mysqli->query($i6);

            $i6 = "UPDATE users SET last_action = 'i_buy_add_city' WHERE telegram_id = '" . $userId . "'";
            $mysqli->query($i6);

            $message = "Отлично! Введите город (пример: Минск)";


            $this->botApiQuery("sendMessage", [
                "chat_id" => $userId,
                "text" => "" . $message . ""
            ]);
        }

        if ($commands_params['0'] == "myadsdelete") {

            $i6 = "DELETE FROM ads WHERE id_ads = '" . $commands_params['1'] . "'";
            $mysqli->query($i6);


            $this->botApiQuery("sendMessage", [
                "chat_id" => $userId,
                "text" => "Выбранное Вами объявление удалено"
            ]);

            $this->my_ads();
        }


        if ($commands_params['0'] == "sellnext") {
            $this->sell($commands_params['1']);
        }

        if ($commands_params['0'] == "buynext") {
            $this->buy($commands_params['1']);
        }
    }

    /**
     * Обработка KeyBoard кнопки
     */
    private function actionKeyboardButton()
    {

        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        // отправляем текстовое сообщение
        /*
            $this->botApiQuery("sendMessage", [
                               "chat_id" => $userId,
                               "text" => "Обработана кнопка " . $this->data['message']['text'],
                               ]);
             */
    }



    private function editLang($lang)
    {

        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }

        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');

        mysqli_set_charset($mysqli, "utf8");

        $i6 = " UPDATE users SET language = '" . $lang . "' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {


                $b_enter = '';
                $b_reg = '';
                $message = '';

                if ($row['language'] == "rus") {
                    $b_enter = 'Вход';
                    $b_reg = 'Регистрация';
                    $message = 'Если у Вас уже есть учетная запись в системе, то нажмите "Войти". Если Вы тут впервые, пройдите регистрацию';
                }

                if ($row['language'] == "eng") {
                    $b_enter = 'Login';
                    $b_reg = 'Registration';
                    $message = 'If you already have an account in the system, then click "Login". If you are here, go through the registration steps.';
                }


                if ($row['last_action'] == "enter") {



                    $buttons = json_encode([
                        "keyboard" => [
                            [
                                ["text" => "" . $b_enter . "",],
                                ["text" => "" . $b_reg . "",]
                            ]
                        ],
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true,
                        'selective' => true,
                    ], true);

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);
                }
            }
        }
    }


    private function registration()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");

        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }

        $i6 = " UPDATE users SET last_action = 'enter_email_amir' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {


                if ($row['language'] == "rus") {
                    $message = 'Введите email, на который зарегистрирован ваш личный кабинет в Amir Capital Group.';
                }

                if ($row['language'] == "eng") {
                    $message = 'Enter your email in amir';
                }

                $this->botApiQuery("sendMessage", [
                    "chat_id" => $userId,
                    "text" => "" . $message . "",
                ]);
            }
        }
    }


    private function generateRandomString($length = 32)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    private function mainmenu()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'main_menu' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {

                    if ($row['language'] == "rus") {
                        $message = "Выбрано: основное меню";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "Купить/Продать"]],
                                [["text" => "Профиль"], ["text" => "Поиск пользователя"], ["text" => "Правила"]]
                            ],

                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }
                    if ($row['language'] == "eng") {
                        $message = "Select: main menu";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "Buy/Sell"]],
                                [["text" => "Profile"], ["text" => "Rules",]]
                            ],
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);
                }
            }
        }
    } //function




    private function buy_sell()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'buy_sell' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['rules'] == 0) {

                    $rules = "SELECT * FROM rules WHERE id = '1'";
                    $result_r = $mysqli->query($rules);
                    if ($result_r->num_rows > 0) {
                        while ($r_rules = $result_r->fetch_assoc()) {



                            $message = "" . $r_rules['rules'] . "";
                            $buttons = json_encode([
                                "keyboard" => [
                                    [["text" => "Я ознакомился с правилами."]]
                                ],

                                'one_time_keyboard' => false,
                                'resize_keyboard' => true,
                                'selective' => true,
                            ], true);

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "" . $message . "",
                                "reply_markup" => $buttons
                            ]);
                        }
                    }
                }


                if ($row['status'] == 1 && $row['enter_key'] != "" && $row['rules'] == 1) {

                    if ($row['language'] == "rus") {
                        $message = "Выбрано: Купить/Продать";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "Мои объявления"]],
                                [["text" => "Купить"], ["text" => "Продать"]],
                                [["text" => "Основное меню"]]
                            ],

                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }
                    if ($row['language'] == "eng") {
                        $message = "Select: Buy/Sell";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "My announcements"]],
                                [["text" => "Buy"], ["text" => "Sell",]],
                                [["text" => "Main menu"]]
                            ],
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);
                }
            }
        }
    } //function

    private function iagreerules()
    {

        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET rules = '1' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $this->buy_sell();
    } //function


    private function add_ads()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'add_ads' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {


                    if ($row['language'] == "rus") {
                        $message = "Выбрано: Создать объявления";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "Я хочу продать"], ["text" => "Я хочу купить"]],
                                [["text" => "Основное меню"]]
                            ],

                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }
                    if ($row['language'] == "eng") {
                        $message = "Select: Create announcements";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "I want to buy"], ["text" => "I want to sell"]],
                                [["text" => "Main menu"]]
                            ],
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);
                }
            }
        }
    } //function


    private function i_buy()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'i_buy' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {


                    if ($row['language'] == "rus") {
                        $message = "Введите количество (пример: 1000 USDT)";
                    }
                    if ($row['language'] == "eng") {
                        $message = "Enter the amount (example: 1000 USDT)";
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . ""
                    ]);
                }
            }
        }
    } //function


    private function i_sell()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'i_sell' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {


                    if ($row['language'] == "rus") {
                        $message = "Введите количество (пример: 1000 USDT)";
                    }
                    if ($row['language'] == "eng") {
                        $message = "Enter the amount (example: 1000 USDT)";
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . ""
                    ]);
                }
            }
        }
    } //function

    private function buy($step)
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }

        $st = explode(',', $step);

        $i6 = " UPDATE users SET last_action = 'buy' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {
                    $buy = "SELECT * FROM ads WHERE status='1' and date >= '" . strtotime(date('d.m.Y H:i:s')) . "' and type='buy' LIMIT  " . $st[0] . "," . $st[1] . "";
                    $result2z = $mysqli->query($buy);
                    if ($result2z->num_rows > 0) {

                        while ($rowz = $result2z->fetch_assoc()) {



                            $d_date = date('d.m.Y H:i:s', $rowz['date']);

                            $type = '';

                            if ($rowz['type'] == "buy") {
                                $type = 'Покупаю';
                            }

                            if ($rowz['type'] == "sell") {
                                $type = 'Продаю';
                            }

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "Тип: " . $type . "\nКоличество: " . $rowz['amount'] . "\nКурс: " . $rowz['rates'] . "\nСпособ оплаты: " . $rowz['pay'] . "\nГород: " . $rowz['city'] . "\nКомментарий: " . $rowz['comment'] . "\nДействует до: " . $d_date . "\nКонтакт: @" . $rowz['username'] . "
                                                   "
                            ]);
                        }

                        if ($row['language'] == "eng") {
                            $b_ads_next = "Next";
                            $b_view_next = "Show more";
                        }

                        if ($row['language'] == "rus") {
                            $b_ads_next = "Далее";
                            $b_view_next = "Показать еще";
                        }

                        if ($st[0] == 0) {
                            $stepp = 10;
                        } else {
                            $stepp = $st[0] * 2;
                        }

                        $step = $stepp . ',10';


                        $buttons = json_encode([
                            'inline_keyboard' => [
                                [
                                    [
                                        "text" => "" . $b_ads_next . "",
                                        "callback_data" => "actionInlineButton_buynext-" . $step . ""
                                    ]
                                ]
                            ],
                        ], true);

                        $this->botApiQuery("sendMessage", [
                            "chat_id" => $userId,
                            "text" => "" . $b_view_next . "",
                            "reply_markup" => $buttons
                        ]);
                    } else {

                        if ($row['language'] == "eng") {
                            $b_none = "Not have any created ads.";
                        }

                        if ($row['language'] == "rus") {
                            $b_none = "Нет ни одного созданного объявления.";
                        }

                        $this->botApiQuery("sendMessage", [
                            "chat_id" => $userId,
                            "text" => "" . $b_none . ""
                        ]);
                    }
                    ////
                }
            }
        }
    } //function


    private function sell($step)
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }

        $st = explode(',', $step);

        $i6 = " UPDATE users SET last_action = 'sell' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {



                    ////

                    $buy = "SELECT * FROM ads WHERE status='1' and date >= '" . strtotime(date('d.m.Y H:i:s')) . "' and type='sell' LIMIT " . $st[0] . "," . $st[1] . "";

                    $result2z = $mysqli->query($buy);
                    if ($result2z->num_rows > 0) {

                        while ($rowz = $result2z->fetch_assoc()) {
                            $d_date = date('d.m.Y H:i:s', $rowz['date']);

                            $type = '';

                            if ($rowz['type'] == "buy") {
                                $type = 'Покупаю';
                            }

                            if ($rowz['type'] == "sell") {
                                $type = 'Продаю';
                            }

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "Тип: " . $type . "\nКоличество: " . $rowz['amount'] . "\nКурс: " . $rowz['rates'] . "\nСпособ оплаты: " . $rowz['pay'] . "\nГород: " . $rowz['city'] . "\nКомментарий: " . $rowz['comment'] . "\nДействует до: " . $d_date . "\nКонтакт: @" . $rowz['username'] . "
                                                   "
                            ]);
                        }

                        if ($row['language'] == "eng") {
                            $b_ads_next = "Next";
                            $b_view_next = "Show more";
                        }

                        if ($row['language'] == "rus") {
                            $b_ads_next = "Далее";
                            $b_view_next = "Показать еще";
                        }

                        if ($st[0] == 0) {
                            $stepp = 10;
                        } else {
                            $stepp = $st[0] * 2;
                        }

                        $step = $stepp . ',10';

                        $buttons = json_encode([
                            'inline_keyboard' => [
                                [
                                    [
                                        "text" => "" . $b_ads_next . "",
                                        "callback_data" => "actionInlineButton_sellnext-" . $step . ""
                                    ]
                                ]
                            ],
                        ], true);

                        $this->botApiQuery("sendMessage", [
                            "chat_id" => $userId,
                            "text" => "" . $b_view_next . "",
                            "reply_markup" => $buttons
                        ]);
                    } else {

                        if ($row['language'] == "eng") {
                            $b_none = "Not have any created ads.";
                        }

                        if ($row['language'] == "rus") {
                            $b_none = "Нет ни одного созданного объявления.";
                        }

                        $this->botApiQuery("sendMessage", [
                            "chat_id" => $userId,
                            "text" => "" . $b_none . ""
                        ]);
                    }
                    ////


                }
            }
        }
    } //function


    private function my_ads()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'my_ads' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {

                    if ($row['language'] == "rus") {
                        $message = "Выбрано: Мои объявления";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "Создать объявление"]],
                                [["text" => "Основное меню"]]
                            ],

                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }
                    if ($row['language'] == "eng") {
                        $message = "Select: My announcements";
                        $buttons = json_encode([
                            "keyboard" => [
                                [["text" => "Add announcements"]],
                                [["text" => "Main menu"]]
                            ],
                            'one_time_keyboard' => false,
                            'resize_keyboard' => true,
                            'selective' => true,
                        ], true);
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);

                    ////

                    $addressz = "SELECT * FROM ads WHERE status='1' and telegram_id = '" . $userId . "' and date >= '" . strtotime(date('d.m.Y H:i:s')) . "'";
                    $result2z = $mysqli->query($addressz);
                    if ($result2z->num_rows > 0) {

                        while ($rowz = $result2z->fetch_assoc()) {

                            if ($row['language'] == "eng") {
                                $b_ads_del = "Delete";
                            }

                            if ($row['language'] == "rus") {
                                $b_ads_del = "Удалить";
                            }

                            $buttons = json_encode([
                                'inline_keyboard' => [
                                    [
                                        [
                                            "text" => "" . $b_ads_del . "",
                                            "callback_data" => "actionInlineButton_myadsdelete-" . $rowz['id_ads'] . ""
                                        ]
                                    ]
                                ],
                            ], true);

                            $d_date = date('d.m.Y H:i:s', $rowz['date']);

                            $type = '';

                            if ($rowz['type'] == "buy") {
                                $type = 'Покупаю';
                            }

                            if ($rowz['type'] == "sell") {
                                $type = 'Продаю';
                            }

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "Тип: " . $type . "\nКоличество: " . $rowz['amount'] . "\nКурс: " . $rowz['rates'] . "\nСпособ оплаты: " . $rowz['pay'] . "\nГород: " . $rowz['city'] . "\nКомментарий: " . $rowz['comment'] . "\nДействует до: " . $d_date . "
                                                   ",
                                "reply_markup" => $buttons
                            ]);
                        }
                    } else {

                        if ($row['language'] == "eng") {
                            $b_none = "You do not have any created ads.";
                        }

                        if ($row['language'] == "rus") {
                            $b_none = "У Вас нет ни одного созданного объявления.";
                        }

                        $this->botApiQuery("sendMessage", [
                            "chat_id" => $userId,
                            "text" => "" . $b_none . ""
                        ]);
                    }
                    ////


                }
            }
        }
    } //function


    private function edit_profile()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }




        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {

                    if ($row['language'] == "rus") {
                        $message = "Введите новый email профиля:";
                    }
                    if ($row['language'] == "eng") {
                        $message = "Enter your new profile email:";
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . ""
                    ]);
                }
            }
        }

        $i6 = " UPDATE users SET last_action = 'enter_email_amir', status = '0', enter_key = ''  WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);
    } //function

    private function rules()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'rules' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {

                    /*
                        if($row['language']=="rus")
                        {
                            $message = "Текст правил бла бла бла";
                        }
                        if($row['language']=="eng")
                        {
                            $message = "rules bla bla bla";
                            
                        }
                        */

                    mysqli_set_charset($mysqli, "utf8mb4");
                    $rules = "SELECT * FROM rules WHERE id = '1'";
                    $result_r = $mysqli->query($rules);
                    mysqli_set_charset($mysqli, "utf8");
                    if ($result_r->num_rows > 0) {
                        while ($r_rules = $result_r->fetch_assoc()) {



                            $message = "" . $r_rules['rules'] . "";

                            $this->botApiQuery("sendMessage", [
                                "chat_id" => $userId,
                                "text" => "" . $message . ""
                            ]);
                        }
                    }
                }
            }
        }
    } //function

    private function exit()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {

                    if ($row['language'] == "rus") {
                        $b_enter = 'Вход';
                        $b_reg = 'Регистрация';
                        $message = 'Вы вышли из профиля';
                    }

                    if ($row['language'] == "eng") {
                        $b_enter = 'Enter';
                        $b_reg = 'Registration';
                        $message = 'You are logged out of your profile';
                    }

                    $buttons = json_encode([
                        "keyboard" => [
                            [
                                ["text" => "" . $b_enter . "",],
                                ["text" => "" . $b_reg . "",]
                            ]
                        ],
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true,
                        'selective' => true,
                    ], true);

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);
                }
            }
        }

        $i6 = " UPDATE users SET last_action = 'exit', enter_key = '' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);
    } //function

    private function prof()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'open_profile' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {


                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "Email: " . $row['email_amir'] . "\nИмя: " . $row['name'] . "\nАмбассадор: " . $row['username_ambosador'] . "\nВыше стоящий партнер: " . $row['username_partner'] . "
                                           "
                    ]);

                    if ($row['language'] == "rus") {
                        $b_edit = 'Редактировать профиль';
                        $b_exit = 'Выход';
                        $b_mainmenu = 'Основное меню';
                        $message = 'Выбрано: профиль';
                    }

                    if ($row['language'] == "eng") {
                        $b_edit = 'Edit profile (new verification required)';
                        $b_exit = 'Exit';
                        $b_mainmenu = 'Main Menu';
                        $message = 'Select: profile';
                    }

                    $buttons = json_encode([
                        "keyboard" => [
                            [
                                ["text" => "" . $b_edit . "",],
                                ["text" => "" . $b_exit . "",]
                            ], [["text" => "" . $b_mainmenu . ""]],
                        ],
                        'one_time_keyboard' => false,
                        'resize_keyboard' => true,
                        'selective' => true,
                    ], true);

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                        "reply_markup" => $buttons
                    ]);
                }
            }
        }
    } //function

    private function search()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }


        $i6 = " UPDATE users SET last_action = 'search_user' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1 && $row['enter_key'] != "") {
                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "Введите telegram username пользователя, которого хотите найти в списке верифицированных пользователей:"
                    ]);
                }
            }
        }
    } //function

    private function login()
    {
        $mysqli = new mysqli('localhost', 'telegram_investpartners2021', 'investpartners2021', 'telegram_bot_invest_partners', '3306');
        mysqli_set_charset($mysqli, "utf8");
        $this->data = json_decode(file_get_contents('php://input'), true);
        if (array_key_exists("message", $this->data)) {
            $userId = $this->data['message']['from']['id'];
        }
        if (array_key_exists("callback_query", $this->data)) {
            $userId = $this->data['callback_query']['from']['id'];
        }

        $i6 = " UPDATE users SET last_action = 'generation_key' WHERE telegram_id = '" . $userId . "';";
        $mysqli->query($i6);

        $user = "SELECT * FROM users WHERE telegram_id = '" . $userId . "'";
        $result2 = $mysqli->query($user);
        if ($result2->num_rows > 0) {

            while ($row = $result2->fetch_assoc()) {

                if ($row['status'] == 1) {
                    $key = $this->generateRandomString();
                    $i6 = " UPDATE users SET enter_key = '" . $key . "' WHERE telegram_id = '" . $userId . "';";
                    $mysqli->query($i6);




                    if ($row['language'] == "rus") {
                        $message = 'Введите ключ доступа, который только что был выслан Вам на e-mail. Просим обратить внимание, что письмо приходит в течении 5 минут.';
                        $subject = 'Ключ авторизации';
                        $email_message = 'Ваш ключ авторизации ' . $key . '';
                    }

                    if ($row['language'] == "eng") {
                        $message = 'Enter the access key that was just sent to you by email.';
                        $subject = 'Authorization key';
                        $email_message = 'Your authorization key ' . $key . '';
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                    ]);


                    $m = "" . $email_message . "";
                    $m = wordwrap($m, 70, "\r\n");
                    // mail('' . $row['email_amir'] . '', '' . $subject . '', $m);
                    
                    $this->sendEmail($row['email_amir'], $key);
                }

                if ($row['status'] == 0) {

                    if ($row['language'] == "rus") {
                        $message = 'Ваш аккаунт еще не верифицирован администрацией. Ожидайте уведомления в боте.';
                    }

                    if ($row['language'] == "eng") {
                        $message = 'Your account has not yet been verified by the administration. Wait for notification.';
                    }

                    $this->botApiQuery("sendMessage", [
                        "chat_id" => $userId,
                        "text" => "" . $message . "",
                    ]);
                }
            }
        }
    }



    /** Запрос к Телеграм Bot Api
     * @param $method
     * @param array $fields
     * @return mixed
     */
    private function botApiQuery($method, $fields = array())
    {
        $ch = curl_init("https://api.telegram.org/bot" . $this->token . "/" . $method);
        curl_setopt_array($ch, array(
            CURLOPT_POST => count($fields),
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 10
        ));
        $r = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $r;
    }

    private function sendEmail($user_email, $code)
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();  
            $mail->CharSet = "UTF-8";
            $mail->SMTPAuth   = true;
        
            // Настройки вашей почты
            $mail->Host       = 'email-smtp.eu-central-1.amazonaws.com'; // SMTP сервера вашей почты
            $mail->Username   = 'AKIAW2B7LDW45IIRPKSH'; // Логин на почте
            $mail->Password   = 'BGMH8QpdDT67znUBHTJ/b2uVg32alemTL8DAqjtYnumy'; // Пароль на почте
            $mail->Port       = 2587;
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('info@info.investpartners.link', 'InvestPartners_Bot'); // Адрес самой почты и имя отправителя
        
            // Получатель письма
            $mail->addAddress($user_email);  
          
            $mail->Subject = 'Ключ авторизации';
            $mail->Body = $code;    

            // Проверяем отравленность сообщения
            $mail->send();
        } catch (Exception $e) {
            echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
        }

    }
}

// Вызываем класс создания объекта Бота
new Bot();
