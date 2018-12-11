<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;}

if (!isset($_GET['day'])) {$select_day = date("d");} else {$select_day = $_GET['day'];}
if (!isset($_GET['month'])) {$select_month = date("m");} else {$select_month = $_GET['month'];}
if (!isset($_GET['year'])) {$select_year = date("Y");} else {$select_year = $_GET['year'];}
if (!isset($_GET['weekday'])) {$select_weekday = date("N")-1;} else {$select_weekday = $_GET['weekday'];}



$select_time_spots = '';
$sel_s_price = '';

//===================== READ ORDER BD
$file_name_order = $folder.$psep.'data/order.dat'; // FILE BD ORDER

//---------------- order vars ---------------
$file_order_bd = '0';

$check_order_id_str = '';
$check_id_obj_str = '';
$check_date_obj_str = '';
$check_time_obj_str = '';	


$provide_order = '';
$spots_order = '';
$spots_order_daily = '';
$hours_order_start = '';
$hours_order_end = '';
$minutes_order_start = '';
$minutes_order_end = '';

$qord = '';

$all_daily_spots = '';

$total_spots_ord = '';

$bussy_sp = '';

$sel_t = '';

$left_spots_ord = '';

$end_spots = '';

$always_free_obj = '';

//-------------------------------------------

$bd_order = '0';
if (file_exists($file_name_order)) { // keep data file 
$cmod_file = substr(sprintf('%o', fileperms($file_name_order)), -4);
if ($cmod_file !='0644') {chmod ($file_name_order, 0644);}
$bd_order = '1';
} else {
$line_data_add = '';	
$fp_create = fopen($file_name_order, "w"); // create data file
fwrite($fp_create, "$line_data_add");
fclose ($fp_create);
}





if (isset($obj)) {

//======================================READ BD OBJ
$check_filesize_serv = 0;
$file_name_obj = $folder.$psep.'data/object.dat'; 
if (file_exists($file_name_obj)) { 

$data_file_obj = fopen($file_name_obj, "rb"); 

if (filesize($file_name_obj) != 0) { $check_filesize_serv = 1;

flock($data_file_obj, LOCK_SH); 
$lines_data_services = preg_split("~\r*?\n+\r*?~", fread($data_file_obj, filesize($file_name_obj))); 
flock($data_file_obj, LOCK_UN); 
fclose($data_file_obj); 

} //empty file
}// if file exists
//---------------/read bd services


if ($check_filesize_serv == 1) {
for ($ls = 0; $ls < sizeof($lines_data_services); ++$ls) { 
if (!empty($lines_data_services[$ls])) { 

include ($folder.$psep.'inc/list_obj.php');
//-----------------/list services




if ($obj == $id_obj) {

$always_free_obj = $always_free;

if ($provide_obj == 'hourly'){	
	
$provide_order = $provide_obj;
$spots_order = $total_spots_obj;

$hours_order_start = $hours_start_obj;
$hours_order_end = $hours_end_obj;
$minutes_order_start = $minutes_start_obj;
$minutes_order_end = $minutes_end_obj;
$count_order_spots = $count_spots_obj;

$qord = $queue_obj;

} else { //========================DAILY

$provide_order = $provide_obj;	
$total_spots_ord = $daily_total_spots_obj;
$min_spots_ord = $daily_min_spots_obj;
$max_spots_ord = $daily_max_spots_obj;		
$count_spots = $daily_count_spots_obj;
$all_daily_spots = $all_spots_obj;

$qord = $queue_obj;
if ($total_spots_ord != '0' && !empty($total_spots_ord))  
{
if ($all_daily_spots == '0' || empty($all_daily_spots)) {$select_time_spots = '1'; $sel_t = '1';} 
else {$select_time_spots = '';}
}

}//provide daily


} // obj == select obj

}//!empty lines
}//count
} //ceck bd file
//-----------------/list services















define('ORDER_DATA', $file_name_order);
if (!file_get_contents(ORDER_DATA)) { //empty data file 
///////////////////////////////////////////////////////
} else {

$data_file_order = fopen($file_name_order, "rb"); 
if (filesize($file_name_order) != 0) { $file_order_bd = '1';
flock($data_file_order, LOCK_SH); 
$lines_data_order = preg_split("~\r*?\n+\r*?~", fread($data_file_order,filesize($file_name_order))); 
flock($data_file_order, LOCK_UN); 
fclose($data_file_order); 

for ($lo = 0; $lo < sizeof($lines_data_order); ++$lo) { 

if (!empty($lines_data_order[$lo])) {
$data_ord = explode('::', $lines_data_order[$lo]);	
if (isset($data_ord[0])) {$id_order_obj = $data_ord[0];} else {$id_order_obj = '';}
if (isset($data_ord[1])) {$id_obj_obj = $data_ord[1];} else {$id_obj_obj = '';}
if (isset($data_ord[2])) {$name_ord_obj = $data_ord[2];} else {$name_ord_obj = '';}
if (isset($data_ord[3])) {$date_obj = $data_ord[3];} else {$date_obj = '';}
if (isset($data_ord[4])) {$time_obj = $data_ord[4];} else {$time_obj = '';}
if (isset($data_ord[5])) {$spots_ord_obj = $data_ord[5];} else {$spots_ord_obj = '';}
if (isset($data_ord[6])) {$client_name_obj = $data_ord[6];} else {$client_name_obj = '';}
if (isset($data_ord[7])) {$phone_client_obj = $data_ord[7];} else {$phone_client_obj  = '';}
if (isset($data_ord[8])) {$mail_client_obj = $data_ord[8];} else {$mail_client_obj  = '';}
if (isset($data_ord[9])) {$comment_client_obj = $data_ord[9];} else {$comment_client_obj  = '';}
if (isset($data_ord[10])) {$add_ip_obj = $data_ord[10];} else {$add_ip_obj = '';}
if (isset($data_ord[11])) {$status_obj = $data_ord[11];} else {$status_obj = '';}	
if (isset($data_ord[12])) {$price_ord_obj = $data_ord[12];} else {$price_ord_obj = '';}	
if (isset($data_ord[13])) {$cur_obj = $data_ord[13];} else {$cur_obj = '';}	
if (isset($data_ord[14])) {$order_staff_obj = $data_ord[14];} else {$order_staff_obj = '';}
if (isset($data_ord[15])) {$discount_ord_obj = $data_ord[15];} else {$discount_ord_obj = '';}
if (isset($data_ord[16])) {$spots_edit_obj = $data_ord[16];} else {$spots_edit_obj = '';}
if (isset($data_ord[17])) {$payment_obj = $data_ord[17];} else {$payment_obj = '';}
$check_order_id_str .= '#'.$id_order_obj.'&';
$check_id_obj_str .= '#'.$id_obj_obj.'&';



if ($obj == $id_obj_obj) {


//echo $select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday.' == '.$time_obj;

//===============================================DAILY
if ($provide_order == 'daily') {
	
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $time_obj){ //day	daily
$bussy_sp += $spots_ord_obj;
$left_spots_ord = $total_spots_ord - $bussy_sp; 

}




} else { ////////// HOURLY





//----------------------------------BUSSY SPOTS
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $date_obj){ //day	
//-------------------------------------------------------------------------

if (isset($_GET['time'])) {
if(!empty($time_obj)) {$bussy_time_arr_all = explode('||', $time_obj);}



if(!empty($hours_order_start)) {
$hours_order_start_arr = explode('||', $hours_order_start); array_pop($hours_order_start_arr);
$minutes_order_start_arr = explode('||', $minutes_order_start); array_pop($minutes_order_start_arr);
$hours_order_end_arr = explode('||', $hours_order_end); array_pop($hours_order_end_arr);
$minutes_order_end_arr = explode('||', $minutes_order_end); array_pop($minutes_order_end_arr);
$count_order_spots_arr = explode('||', $count_order_spots); array_pop($count_order_spots_arr);
}






if (isset($bussy_time_arr_all)) {

foreach($bussy_time_arr_all as $kbt => $vbt) {



if ($_GET['time'] == $vbt) { // total spots obj

$sel_t = '1';

$bussy_sp += $spots_ord_obj;

for ($hst = 0; $hst < sizeof($hours_order_start_arr); ++$hst) {

$hs = $hours_order_start_arr[$hst];
$ms = $minutes_order_start_arr[$hst];
$he = $hours_order_end_arr[$hst];
$me = $minutes_order_end_arr[$hst];	

$spots_order_arr = explode('||', $spots_order); array_pop ($spots_order_arr);


if ($vbt == $hs.':'.$ms.':'.$he.':'.$me || $vbt == $hs.':'.$ms.':XX:XX') {$total_spots_ord = $spots_order_arr[$hst]; $cs = $count_order_spots_arr[$hst];}



//total spots obj


}//count time obj

}// get time = bussy time






} // count all bussy time
} //isset busy time arr
} //isset get time




//-------------------------------------------------------------------------
} //select day 

}///////////////////////////////////////////////////PROVIDE





if (!empty($bussy_sp) && !empty($total_spots_ord)) {
$left_spots_ord = $total_spots_ord - $bussy_sp; 
if ($left_spots_ord <= 0) {$end_spots = '1';}
}

//echo '<div class="log">'.$left_spots_ord.'</div>';


//----------------------------------BUSSY DATES/TIMES
if($provide_order == 'hourly') { // ======================== HOURLY
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $date_obj)
{ 
if ($sel_t == '1') {
if ($end_spots == '1') {$check_time_obj_str .= $time_obj.'||';}	
} else {$check_time_obj_str .= $time_obj.'||'; }
}


} else { //================================================= 
if ($sel_t == '1') {
if ($end_spots == '1') { 
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $time_obj){ $check_time_obj_str .= $time_obj.'||'; }
} //end spots
} else {$check_time_obj_str .= $time_obj.'||'; }
} //provide



}//get obj = order obj

//=========================================================== queue
if($provide_order == 'hourly') {
if ($qord == '1') {
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $date_obj){ $check_time_obj_str .= $time_obj.'||';} 
}
} else {
if ($qord == '1') {$check_time_obj_str .= $time_obj.'||';} // daily
} //provide
//==========================================================




} //no empty lines

}// Count lines order

} //File size != 0
} //File no empty	

if (isset($minus_time) && isset($edit_true)) { 
$check_time_obj_str = str_replace($minus_time,'',$check_time_obj_str); 
$left_spots_ord = $total_spots_ord;
$end_spots = '';
}

}//Isset get OBJ



//=====================//

if ($always_free_obj == '1') {$check_time_obj_str = '';}

//echo $check_time_obj_str;
//echo $always_free;
?>