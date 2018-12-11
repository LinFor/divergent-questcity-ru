<?php
header("Content-Type: text/html; charset=utf-8");
define('BOT_TOKEN', '448238188:AAEGPErccerOduHiDhK61MNTYJu8-FbFCyY');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}

function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}

function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = API_URL.$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);

  return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $handle = curl_init(API_URL);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

  return exec_curl_request($handle);
}



function processMessage($message) {
  // process incoming message
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  
  
  
  if (isset($message['text'])) 
  {
    // incoming text message
    $text = $message['text'];
         
    $host = 'localhost'; // адрес сервера 
    $database = 'artprostoru_qherobot'; // имя базы данных
    $user = '031818010_manage'; // имя пользователя
    $password = 'actionmanager'; // пароль
    $link = mysql_connect($host, $user, $password) or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
    mysql_query('SET NAMES utf8');
    mysql_select_db($database,$link);
    $sql0=mysql_query("Select * from `stata` where manager_id='".$chat_id."'")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link)))); // форрмируем запрос к таблице

    while($row=mysql_fetch_array($sql0))
    
    {
    $status=$row['status'];
    
        
    $menu=$row['menu_id'];
    }
    if($status==1)
    {
        if(!preg_match( "[^а-яёА-ЯЁ ]/u",$text))
        {
        $quest=$text;
        $sql3 = mysql_query("UPDATE `stata` SET status='2', menu_id='0', quest_name='' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Добро пожаловать в акцию! Нажмите на три точки(вверху, справа) и "Clear History" для работы с ботом.'));
        
        }
    }
    else if($status==2)
    {
        if(strpos($text, "/start") === 0 and $menu==0)
        {
        apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array(
        'keyboard' => array(array('Добавить команду', 'Просмотр команд')),
        'one_time_keyboard' => true,
        'resize_keyboard' => true)));   
        }
        else if ($text === "Добавить команду") 
        {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите телефон новой команды'));
        $sql3 = mysql_query("UPDATE `stata` SET menu_id='10' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        }
        else if(preg_match("/[+][7][0-9]{10}$/i",$text) and $menu==10)
        {
        $phone=$text;
        $sql6=mysql_query("Select * from `users` where phone='".$phone."'")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link)))); // форрмируем запрос к таблице
        while($row=mysql_fetch_array($sql6))
        // последовательно складываем в переменную $row которая является массивом строки результата запроса
        {
        $us_name=$row['user_name'];
        $us_manager=$row['manager'];
        $us_tel=$row['phone'];
        }
        $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        
            if($phone==$us_tel && $us_manager==$chat_id)
            {
            $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Команда с данным номером уже играла на вашем квесте'));
            }
            else if($phone==$us_tel && $us_manager!=$chat_id)
            {
            
            $sql = mysql_query("INSERT INTO `users` (`id`, `phone`, `user_name`, `manager`, `quest_dt`, `status`) 
            VALUES ('1','".$phone."','".$us_name."','".$chat_id."',CURRENT_TIMESTAMP(),'old')") or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
            $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Команда с этим телефоном уже учавствует в акции. Имя подставлено автоматически.'));
            }
            else if($phone!=$us_tel)
            {
            $sql = mysql_query("INSERT INTO `users` (`id`, `phone`, `manager`, `quest_dt`, `status`) 
            VALUES ('1','".$phone."','".$chat_id."',CURRENT_TIMESTAMP(),'new')") or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
            $sql1 = mysql_query("UPDATE `stata` SET menu_id='11' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Номер введён Введите имя'));
            }
            
        }
        else if(!preg_match( "[^а-яёА-ЯЁ ]/u",$text) and $menu==11)
        {
        //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите имя'));
        $name=$text;
        $sql = mysql_query("UPDATE `users` SET user_name='".$name."', status='old' WHERE manager='".$chat_id."' AND status='new' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Имя введено'));
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Команда введена'));     
        }
        else if($menu==11)
        {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите имя')); 
        }
        else if ($text === "Просмотр команд") 
        {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите телефон для просмотра'));
        $sql = mysql_query("UPDATE `stata` SET menu_id='21' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        }  
        else if (preg_match("/[+][7][0-9]{10}$/i",$text) and $menu==21) 
        {
        $phone=$text;
        $sql5=mysql_query("Select Count(manager) as kol1 from `users` where phone='".$phone."'")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link)))); // форрмируем запрос к таблице
        
        $sql4=mysql_query("Select * from `users` where phone='".$phone."'")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link)))); // форрмируем запрос к таблице
        
        while($row=mysql_fetch_array($sql4))
        // последовательно складываем в переменную $row которая является массивом строки результата запроса
        {
        $us_name=$row['user_name'];
        $us_tel=$row['phone'];
        }
        $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        }
        
        while($row=mysql_fetch_array($sql5))
        // последовательно складываем в переменную $row которая является массивом строки результата запроса
        {
        $kol1=$row['kol1'];
        if($kol1==0)
        {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Телефон не найден в базе данных игроков'));
        $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        }
        else
        {
        if ($kol1==1 or$kol1==2)
        {
        $skidka='5%';    
        }
        else if ($kol1>2)
        {
        $skidka='10%';    
        }
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Телефон: '.$us_tel. "\nКапитан: ".$us_name. "\nСкидка: ".$skidka));
        $sql1 = mysql_query("UPDATE `stata` SET menu_id='0' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        }
        }

    }
    else if($status==0)
    {
        if(strpos($text, "/start") === 0)
        {
        apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array(
        'keyboard' => array(array('Идентификация менеджера')),
        'one_time_keyboard' => true,
        'resize_keyboard' => true)));
        }
        else if ($text === "Идентификация менеджера") 
        {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите пароль'));
        //$sql = mysql_query("UPDATE `stata` SET menu_id='30' WHERE manager_id='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        }
        else if(preg_match("/^kod[0-9]{5}/i",$text)) 
        {
        
        $passmng=$text;
            if($passmng=='kod33333')
            {
            $sql = mysql_query("INSERT INTO `stata` (`manager_id`, `status`, `menu_id`, `quest_name`) 
            VALUES ('".$chat_id."','1','0','')") or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
        
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите название квеста'));    
            }
        }
  
    }
    mysql_close($link);
 } }  

  /*      
        else if ($text === "Просмотр команд") 
        {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите телефон'));
        $sql = mysql_query("UPDATE `stata` menu='20' WHERE manager='".$chat_id."' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link2))));

        }

    if (strpos($text, "/start") === 0) 
    {
      apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array(
        'keyboard' => array(array('Добавить команду', 'Просмотр команд')),
        'one_time_keyboard' => true,
        'resize_keyboard' => true)));
    } 
    else if ($text === "Добавить пользователя") 
    {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите пароль'));
 
    } 
    else if ($text === "Добавить команду") 
    {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Введите телефон'));
    } 
    
        else if ($text === "Просмотр команд") 
    {
        
        
    $host = 'localhost'; // адрес сервера 
    $database1 = 'artprostoru_qherobot'; // имя базы данных
    $user = '031818010_manage'; // имя пользователя
    $password = 'actionmanager'; // пароль
    $link1 = mysql_connect($host, $user, $password) or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link1))));
    mysql_query('SET NAMES utf8');
    mysql_select_db($database1,$link1);

        
        
    $sql1=mysql_query("Select * from `users`")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link1)))); // форрмируем запрос к таблице

  
while($row=mysql_fetch_array($sql1))
// последовательно складываем в переменную $row которая является массивом строки результата запроса
{
    $backtext=$backtext."Тел:".$row['phone']."Имя:<b>".$row['user_name']."</b>\r\n";


// выводим строку на страницу + перенос строки
}
 
apiRequest("sendMessage", array('chat_id' => $chat_id, 'parse_mode'=> 'HTML', "text" => $backtext));
mysql_close($link1);    
}
    else if (strpos($text, "/stop") === 0) 
    {
      // stop now
    } 
    else if (preg_match("/[+][7][0-9]{10}$/i",$text))
    {
        $phone=$text;

    $host = 'localhost'; // адрес сервера 
    $database = 'artprostoru_qherobot'; // имя базы данных
    $user = '031818010_manage'; // имя пользователя
    $password = 'actionmanager'; // пароль
    $link = mysql_connect($host, $user, $password) or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
    mysql_query('SET NAMES utf8');
    mysql_select_db($database,$link);
   
    $sql = mysql_query("INSERT INTO `users` (`id`, `phone`, `manager`, `quest_dt`, `status`) 
                        VALUES ('1','".$phone."','".$chat_id."',CURRENT_TIMESTAMP(),'new')") or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link))));
    mysql_close($link);
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Номер введён. Введите имя'));     
    }
    else 
    {
           

      $name=$text;
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Имя введено'));

    $host = 'localhost'; // адрес сервера 
    $database2 = 'artprostoru_qherobot'; // имя базы данных
    $user = '031818010_manage'; // имя пользователя
    $password = 'actionmanager'; // пароль
    $link2 = mysql_connect($host, $user, $password) or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link2))));
    mysql_query('SET NAMES utf8');
    mysql_select_db($database2,$link2);
    
    $sql = mysql_query("UPDATE `users` SET user_name='".$name."', status='old' WHERE manager='".$chat_id."' AND status='new' ")or die(apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Ошибка ' . mysql_error($link2))));
    mysql_close($link2);
    
    //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Команда введена'));     
    }
  } 
  else 
  {
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
  }
}
*/
define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

if (php_sapi_name() == 'cli') {
  // if run from console, set or delete webhook
  apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
  exit;
}


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
  // receive wrong update, must not happen
  exit;
}

if (isset($update["message"])) {
  processMessage($update["message"]);
}
