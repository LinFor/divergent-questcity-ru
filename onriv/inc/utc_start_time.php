<?php
// формирование даты и времени по шаблону: 2009-01-01T12:30:01+00:00
$GMT = '+00:00'; // часовой пояс

$start_time = '';
if (!isset($b_day)) {$b_day = '';}
if (!isset($b_month)) {$b_month = '';}
if (!isset($b_year)) {$b_year = '';}

$start_time_arr = array();
if (!isset($start_time_str)) {$start_time_str = '';} 
$start_time_arr = explode('||', $start_time_str);
array_pop($start_time_arr);
if (isset($start_time_arr[0])) {$start_time = $start_time_arr[0];}

$UTC = $b_year.'-'.$b_month.'-'.$b_day.'T'.$start_time.':00'.$GMT;

if (empty($start_time)) {$UTC = '';}
//После нажатия кнопки "Заказать/Забронировать" в переменной $UTC появляется дата и время начала в формате ГГГГ-ММ-ДДTЧЧ:ММ:СС+00:00 

//echo '<h1>'.$UTC.'</h1>'; 
?>