<?php

header('Powered: test'); 
header('Content-Type: text/html; charset=utf-8');
echo 'hello';
$url = "http://proverkacheka.nalog.ru:8888/v1/inns/7814148471/kkts/0000064141029420/fss/8710000100093296/tickets/8524?fiscalSign=0471917437&sendToEmail=no";  
  
$ch = curl_init();  
  
curl_setopt($ch, CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
  
// указываем имя и пароль  
curl_setopt($ch, CURLOPT_USERPWD, "+79169759799:688107");  
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  //  "Authorization: Basic +79169759799:688107",
"Device-Id: none", 
"Device-OS: Adnroid 6.0.1", 
"Version: 2",
"ClientVersion: 1.4.2",
"Host: proverkacheka.nalog.ru:8888",
"Connection: Keep-Alive",
"Accept-Encoding: gzip",
"User-Agent: {$browser['user_agent']}",

//Device-Id: noneOrRealId

//User-Agent: okhttp/3.0.1

));
curl_setopt($ch, CURLOPT_HEADER,1); 
// если перенаправление разрешено   
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
// то сохраним наши данные в cURL  
curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);  
  
$output = curl_exec($ch); 
$info = curl_getinfo($ch);  
  
// А вдруг ошибочка?   
if ($output === FALSE) {  
    //Тут-то мы о ней и скажем  
    echo "cURL Error: " . curl_error($ch);  
    return;  
}  

 
  
curl_close($ch);  
  
echo $output; 


?>