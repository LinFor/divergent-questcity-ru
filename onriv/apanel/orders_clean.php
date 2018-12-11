<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)

$file_name_data_orders = '../data/order.dat'; 

$file_name_history = '../data/history.dat'; 

$actual_cl = '1';

$data_check = '0';

$lndel = '';
$lncat = '';

$crlf = "\n"; 

$y_cl = date('Y');

$m_cl = date('n');

$day_cl = date('j') - 2;


//CHECK ID
$str_check_id = '';
if (file_exists($file_name_history)) { 
$arr_check = fopen($file_name_history, "rb"); 
if (filesize($file_name_history) != 0) {
flock($arr_check, LOCK_SH); 
$lines_check = preg_split("~\r*?\n+\r*?~", fread($arr_check,filesize($file_name_history))); 
flock($arr_check, LOCK_UN); 
fclose($arr_check); 

for ($lch = 0; $lch < sizeof($lines_check); ++$lch) { 

if (!empty($lines_check[$lch])) {
$arr_order_check = explode('::', $lines_check[$lch]);	
if (isset($arr_order_check[0])) {$id_order_check = $arr_order_check[0];} else {$id_order_check = '';}

$str_check_id .= $id_order_check.'&&';

} //!emply line
} //count line
} //!=0
} //file_exists file_name_history
//----------/check id








if (date('d') == '01' && date('n') != '3') {$day_cl = '30'; $m_cl = date('n')-1;} else {$day_cl = date('j') - 2; $m_cl = date('n');}
if (date('d') == '02' && date('n') != '3') {$day_cl = '30'; $m_cl = date('n')-1;} else {$day_cl = date('j') - 2; $m_cl = date('n');}
 
if (date('n') == '3' && date('d') == '01') {$day_cl = '30';} else {$day_cl = date('j') - 2; $m_cl = date('n');}
if (date('n') == '3' && date('d') == '02') {$day_cl = '30';} else {$day_cl = date('j') - 2; $m_cl = date('n');}

if (date('n') == '1' && date('d') == '01') {$day_cl = '30'; $m_cl = '12'; $y_cl = date('Y') - 1;} else {$day_cl = date('j') - 2; $m_cl = date('n'); $y_cl = date('Y');}
if (date('n') == '1' && date('d') == '02') {$day_cl = '30'; $m_cl = '12'; $y_cl = date('Y') - 1;} else {$day_cl = date('j') - 2; $m_cl = date('n'); $y_cl = date('Y');}  


if (strlen($day_cl) == 1) {$day_cl = '0'.$day_cl;}
if (strlen($m_cl) == 1) {$m_cl = '0'.$m_cl;}

if (file_exists($file_name_data_orders)) { // keep data file 

$cmod_file = substr(sprintf('%o', fileperms($file_name_data_orders)), -4);
if ($cmod_file !='0644') {chmod ($file_name_data_orders, 0644);}
} 



define('DATAORDERSCL', $file_name_data_orders);

if (file_exists($file_name_data_orders)) {

if (!file_get_contents(DATAORDERSCL)) { } else { //empty data file 

$data_check = '1';

$arr_orderers_cl = fopen($file_name_data_orders, "rb"); 
if (filesize($file_name_data_orders) != 0) {
flock($arr_orderers_cl, LOCK_SH); 
$lines_orders_cl = preg_split("~\r*?\n+\r*?~", fread($arr_orderers_cl,filesize($file_name_data_orders))); 
flock($arr_orderers_cl, LOCK_UN); 
fclose($arr_orderers_cl); 

for ($ls_cl = 0; $ls_cl < sizeof($lines_orders_cl); ++$ls_cl) { 

if (!empty($lines_orders_cl[$ls_cl])) {
$arr_order = explode('::', $lines_orders_cl[$ls_cl]);	
if (isset($arr_order[0])) {$id_order_obj_cl = $arr_order[0];} else {$id_order_obj_cl = '';}
if (isset($arr_order[1])) {$id_obj_obj_cl = $arr_order[1];} else {$id_obj_obj_cl = '';}
if (isset($arr_order[2])) {$name_ord_obj_cl = $arr_order[2];} else {$name_ord_obj_cl = '';}
if (isset($arr_order[3])) {$date_obj_cl = $arr_order[3];} else {$date_obj_cl = '';}
if (isset($arr_order[4])) {$time_obj_cl = $arr_order[4];} else {$time_obj_cl = '';}
if (isset($arr_order[5])) {$spots_ord_obj_cl = $arr_order[5];} else {$spots_ord_obj_cl = '';}
if (isset($arr_order[6])) {$client_name_ord_obj_cl = $arr_order[6];} else {$client_name_ord_obj_cl = '';}
if (isset($arr_order[7])) {$phone_client_obj_cl = $arr_order[7];} else {$phone_client_obj  = '';}
if (isset($arr_order[8])) {$mail_client_obj_cl = $arr_order[8];} else {$mail_client_obj  = '';}
if (isset($arr_order[9])) {$comment_client_obj_cl = $arr_order[9];} else {$comment_client_obj  = '';}
if (isset($arr_order[10])) {$add_ip_obj_cl = $arr_order[10];} else {$add_ip_obj_cl = '';}
if (isset($arr_order[11])) {$status_obj_cl = $arr_order[11];} else {$status_obj_cl = '';}	
if (isset($arr_order[12])) {$price_ord_obj_cl = $arr_order[12];} else {$price_ord_obj_cl = '';}	
if (isset($arr_order[13])) {$cur_obj_cl = $arr_order[13];} else {$cur_obj_cl = '';}	
if (isset($arr_order[14])) {$order_staff_obj_cl = $arr_order[14];} else {$order_staff_obj_cl = '';}
if (isset($arr_order[15])) {$discount_ord_obj_cl = $arr_order[15];} else {$discount_ord_obj_cl = '';}
if (isset($arr_order[16])) {$spots_edit_obj_cl = $arr_order[16];} else {$spots_edit_obj_cl = '';}
if (isset($arr_order[17])) {$payment_sys = $arr_order[17];} else {$payment_sys = '';}


//------------ACTUAL DATES 

if ($date_obj_cl != '0') {
$a_date_arr_cl = explode ('.', $date_obj_cl);
if (isset($a_date_arr_cl[0])) {$a_day_cl = $a_date_arr_cl[0];} else {$a_day_cl = '';}	
if (isset($a_date_arr_cl[1])) {$a_month_cl = $a_date_arr_cl[1];} else {$a_month_cl = '';}	
if (isset($a_date_arr_cl[2])) {$a_year_cl = $a_date_arr_cl[2];} else {$a_year_cl = '';}	

if ($a_day_cl >= $day_cl && $a_month_cl == $m_cl && $a_year_cl == $y_cl || $a_month_cl > $m_cl && $a_year_cl == $y_cl || $a_year_cl > $y_cl) 
{$actual_cl = '1';} else {$actual_cl = '0';}


} else {
	
	
	
$a_time_arr_cl = explode ('||', $time_obj_cl);
foreach ($a_time_arr_cl as $atk_cl => $atv_cl){
$a_date_arr_cl = explode ('.', $atv_cl);
if (isset($a_date_arr_cl[0])) {$a_day_cl = $a_date_arr_cl[0];} else {$a_day_cl = '';}	
if (isset($a_date_arr_cl[1])) {$a_month_cl = $a_date_arr_cl[1];} else {$a_month_cl = '';}	
if (isset($a_date_arr_cl[2])) {$a_year_cl = $a_date_arr_cl[2];} else {$a_year_cl = '';}	

if ($a_day_cl >= $day_cl && $a_month_cl == $m_cl && $a_year_cl == $y_cl || $a_month_cl > $m_cl && $a_year_cl == $y_cl || $a_year_cl > $y_cl) 
{$actual_cl = '1';} else {$actual_cl = '0';}

} //count time	
}// date 0



//-----------/actual dates



//==================================================== COPY TO HISTORY ORDERS


//if ($status_obj_cl == '2' && $actual_cl == '0' || $status_obj_cl == '3') { // === Copy to history

if ($status_obj_cl == '2' && $actual_cl == '0') { // === Copy to history

//echo '<b>'.($ls_cl).'</b>) '.$a_day_cl.'-'.$a_month_cl.'-'.$a_year_cl.' ('.$actual_cl.') - CAT<br />';	
	

$line_data_cl = $id_order_obj_cl.'::'.$id_obj_obj_cl.'::'.$name_ord_obj_cl.'::'.$date_obj_cl.'::'.$time_obj_cl.'::'.$spots_ord_obj_cl.'::'.$client_name_ord_obj_cl.'::'.$phone_client_obj_cl.'::'.$mail_client_obj_cl.'::'.$comment_client_obj_cl.'::'.$add_ip_obj_cl.'::'.$status_obj_cl.'::'.$price_ord_obj_cl.'::'.$cur_obj_cl.'::'.$order_staff_obj_cl.'::'.$discount_ord_obj_cl.'::'.$spots_edit_obj_cl.'::'.$payment_sys.'::';	



///////////////////////ADD


if (!file_get_contents($file_name_history)) {

$fp=fopen($file_name_history, "a+"); 
fputs
($fp, "$line_data_cl"); 
fclose($fp); 

} else {
	
if (!preg_match('/'.$id_order_obj_cl.'&&/i', $str_check_id)) { //CHECK ID
	
$file_cl_add = fopen($file_name_history,"rb") ; 
flock($file_cl_add,LOCK_SH) ; 
flock($file_cl_add,LOCK_UN) ; 
fclose($file_cl_add) ; 

$fp=fopen($file_name_history, "a+"); 
fputs
($fp, "\n$line_data_cl"); 
fclose($fp); 

} //CECK ID
}

$lncat .= $ls_cl.'||';

}  // status actual
//----------------------------------------------------/ copy to history orders














//==================================================== DELETE OLD ORDERS

else if ($status_obj_cl == '0' && $actual_cl == '0' || $status_obj_cl == '1' && $actual_cl == '0') {

//echo '<b>'.($ls_cl).'</b>) '.$a_day_cl.'-'.$a_month_cl.'-'.$a_year_cl.' ('.$actual_cl.') - DELETE<br />';
	
$lndel .= $ls_cl.'||';	
	
	
}// status actual


//----------------------------------------------------/ clean old orders


else { 
//echo '<b>'.($ls_cl).'</b>) '.$a_day_cl.'-'.$a_month_cl.'-'.$a_year_cl.' ('.$actual_cl.') - NO<br />'; 
}


}//count lines
} //file size !=0
//==========================================================================================================



//echo $lndel;
//echo '<br />'.$lncat;

$file_cl_dl = fopen($file_name_data_orders,"r+") ; 
flock($file_cl_dl,LOCK_EX) ; 
$lines_cl_dl = preg_split("~\r*?\n+\r*?~",fread($file_cl_dl,filesize($file_name_data_orders))) ;
	
$all_del_lines = $lndel.$lncat;
	
$delete_ord_lines_arr = explode('||', $all_del_lines); array_pop($delete_ord_lines_arr);

foreach ($delete_ord_lines_arr as $knd => $vnd) {

	
if (isSet($lines_cl_dl[(integer) $vnd]) == true) 
	
    {   unset($lines_cl_dl[(integer) $vnd]); 
        fseek($file_cl_dl,0) ; 
        $data_size = 0 ; 
        ftruncate($file_cl_dl,fwrite($file_cl_dl,implode($crlf,$lines_cl_dl))) ; 
        fflush($file_cl_dl) ; 
    } 	
}

flock($file_cl_dl,LOCK_UN) ; 
fclose($file_cl_dl) ; 
	









} //empty data file 

} ////empty data file

}//data file exists

?>