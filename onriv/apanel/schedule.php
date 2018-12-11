<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
include ('header.php');

$num_ul = '0';

echo '<div id="main">';

if (!empty($access) && $access == 'yes') {

$month = date('n');
$year = date('Y');

if(isset($_GET['month'])) {$month = $_GET['month'];}
if(isset($_GET['year'])) {$year = $_GET['year'];}

//next month
if($month == 12) {$next_month = 1; $next_year = $year + 1;}
else {$next_month = $month + 1; $next_year = $year;}

//last month
if($month == 1) {$last_month = 12; $last_year = $year - 1;}
else {$last_month = $month - 1; $last_year = $year;}


$ls_day = date('j') - 2;
if (strlen($ls_day) == 1) {$ls_day = '0'.$ls_day;}

if (strlen($month) == 1) {$month = '0'.$month;}
if (strlen($next_month) == 1) {$next_month = '0'.$next_month;}
if (strlen($last_month) == 1) {$last_month = '0'.$last_month;}


$count_days = date("t", strtotime($year.'-'.$month));

//===================================top calendar
echo '<div class="top_schedule"><h4>'.$lang_monts[$month].' '.$year.'</h4>';



//=====================================================SELECT OBJ

echo '<form name="obj_schedule" action="'.$script_name.'" method="get">
<input type="hidden" name="month" value="'.$month.'" />
<input type="hidden" name="year" value="'.$year.'" />
<select name="obj" onchange="this.form.submit();">';

//=================================== READ BD SERVICES

$select_obj_str = '';
$file_name_services = '../data/object.dat'; 
if (file_exists($file_name_services)) { 

$data_file_services = fopen($file_name_services, "rb"); 

if (filesize($file_name_services) != 0) { 


flock($data_file_services, LOCK_SH); 
$lines_data_services = preg_split("~\r*?\n+\r*?~", fread($data_file_services, filesize($file_name_services))); 

for ($ls = 0; $ls < sizeof($lines_data_services); ++$ls) { 
if (!empty($lines_data_services[$ls])) { 

$data_services = explode("::", $lines_data_services[$ls]);

if (isset($data_services[0])) { $id_obj = $data_services[0]; } else {$id_obj = '';}
if (isset($data_services[1])) { $name_obj = $data_services[1]; } else {$name_obj = '';}

echo '<option value="'.$id_obj.'"'; if (isset($_GET['obj']) && $_GET['obj'] == $id_obj){echo 'selected="selected"';} echo '>'.$name_obj.'</option>';

$select_obj_str .= $id_obj.'||';
}
}

flock($data_file_services, LOCK_UN); 
fclose($data_file_services); 

} //empty file
}// if file exists
//---------------/read bd services
echo '</select></form>';




$select_obj_arr = explode('||', $select_obj_str);
if (isset($select_obj_arr[0])) {$select_obj = $select_obj_arr[0];}

if (isset($_GET['obj'])) {$select_obj = $_GET['obj'];}

//----------------------------------------------------/SELECT OBJ


if ($month >= date('m') && $year == date('Y') || $year > date('Y')) {
echo '<a href="'.$script_name.'?month='.$last_month.'&year='.$last_year.'&obj='.$select_obj.'" title="'.$lang['back_month'].'"><i class="icon-left-open"></i></a>';
} else {echo '<span><i class="icon-left-open"></i></span>';}

if ($month != date('m') || $year != date('Y')) {echo '<a href="'.$script_name.'?month='.date('m').'&year='.date('Y').'&obj='.$select_obj.'" title="'.$lang['back_to_current_month'].'"><i class="icon-history"></i></a> ';} else {echo '<span><i class="icon-history"></i></span>';}

echo '<a href="'.$script_name.'?month='.$next_month.'&year='.$next_year.'&obj='.$select_obj.'" title="'.$lang['next_month'].'"><i class="icon-right-open"></i></a>';

echo '<div class="clear"></div>';
echo '</div>'; //top_schedule









//----------------------------------------------------------

echo '<div class="scale">';
echo '<div class="date"><i class="icon-calendar"></i></div>';

echo '<div class="timeline">';

for ($s = 0; $s < 24; ++$s) {
if (strlen($s) == 1) {$s = '0'.$s;}
$class_s = 'hour_s';
if ($s == '00') {$class_s = 'first_h';} 
else if ($s == '23') {$class_s = 'last_h';} 

echo '<div class="scale_hour '.$class_s.'">
<div class="digit_h">'.$s.':00</div>
<div class="half_h"></div>
</div>';	
}

echo '<div class="clear"></div></div>';


echo '<div class="clear"></div>
</div>
<div class="clear"></div>';


//-----------------------------------/top calendar





for ($d = 0; $d < $count_days; ++$d) { //=====================COUNT DAYS
$day = $d + 1;
if (strlen($day) == 1) {$day = '0'.$day;}



$qdate = $day.'.'.$month.'.'.$year;

//date("Y-m-d w");


if ($day < $ls_day && $month == date('m') && $year == date('Y')) { $class_sdate = 'class="lost_sdate"'; } else { $class_sdate = 'class="sdate"'; }

echo '<div '.$class_sdate.'>';


//---------------SCALE
echo '<div class="body_sch">';
for ($s = 0; $s < 24; ++$s) {
if (strlen($s) == 1) {$s = '0'.$s;}
$class_s = 'hour_s';
if ($s == '00') {$class_s = 'first_h';} 
else if ($s == '23') {$class_s = 'last_h';} 

echo '<div class="scale_body '.$class_s.'">
<div class="scale_body_half_h"></div>
</div>';	
}
echo '</div>';
//--------------/scale



if ($day == date('d') && $month == date('m') && $year == date('Y')) { $class_line = 'date_today'; } 

else if ($day < date('d') && $month == date('m') && $year == date('Y') || $month < date('m') && $year == date('Y') || $year < date('Y')) {$class_line = 'lost_date';}

else { $class_line = 'date'; } 

echo '<div class="'.$class_line.'">'.$day.'</div>';



//=========================================================================BD

$file_name = '../data/order.dat'; 

if (file_exists($file_name)) { 

$data_file = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file, LOCK_SH); 
$lines_data = preg_split("~\r*?\n+\r*?~", fread($data_file,filesize($file_name))); 
flock($data_file, LOCK_UN); 
fclose($data_file); 



//for ($ls = 0; $ls < sizeof($lines_data); ++$ls) { 
for ($ls = count($lines_data) - 1; $ls >=0 ; $ls--)  {
	
	
if (!empty($lines_data[$ls])) {
	
$data_ord = explode('::', $lines_data[$ls]);	
if (isset($data_ord[0])) {$id_order_obj = $data_ord[0];} else {$id_order_obj = '';}
if (isset($data_ord[1])) {$id_obj_obj = $data_ord[1];} else {$id_obj_obj = '';}
if (isset($data_ord[2])) {$name_ord_obj = $data_ord[2];} else {$name_ord_obj = '';}
if (isset($data_ord[3])) {$date_obj = $data_ord[3];} else {$date_obj = '';}
if (isset($data_ord[4])) {$time_obj = $data_ord[4];} else {$time_obj = '';}
if (isset($data_ord[5])) {$spots_ord_obj = $data_ord[5];} else {$spots_ord_obj = '';}
if (isset($data_ord[6])) {$client_name_ord_obj = $data_ord[6];} else {$client_name_ord_obj = '';}
if (isset($data_ord[7])) {$phone_client_obj = $data_ord[7];} else {$phone_client_obj  = '';}
if (isset($data_ord[8])) {$mail_client_obj = $data_ord[8];} else {$mail_client_obj  = '';}
if (isset($data_ord[9])) {$comment_client_obj = $data_ord[9];} else {$comment_client_obj  = '';}
if (isset($data_ord[10])) {$add_ip_obj = $data_ord[10];} else {$add_ip_obj = '';}
if (isset($data_ord[11])) {$status_obj = $data_ord[11];} else {$status_obj = '';}	
if (isset($data_ord[12])) {$price_ord_obj = $data_ord[12];} else {$price_ord_obj = '';}	
if (isset($data_ord[13])) {$cur_obj = $data_ord[13];} else {$cur_obj = '';}	
if (isset($data_ord[14])) {$order_staff_obj = $data_ord[14];} else {$order_staff_obj = '';}
if (isset($data_ord[15])) {$discount_ord_obj = $data_ord[15];} else {$discount_ord_obj = '';}
if (isset($data_ord[16])) {$spots_control_ord_obj = $data_ord[16];} else {$spots_control_ord_obj = '';}
if (isset($data_ord[17])) {$payment_sys = $data_ord[17];} else {$payment_sys = '';}

$number_order_arr = explode('_',$id_order_obj);
if(isset($number_order_arr[5]) && isset($number_order_arr[6]) && isset($number_order_arr[7]))
{$number_order = $number_order_arr[5].$number_order_arr[6].$number_order_arr[7];} else {$number_order = '';}	



//=======================================DISPLAY SCHEDULE
if ($select_obj == $id_obj_obj) { // SELECT OBJ



if ($date_obj == '0') { //================================provide daily
	
$a_time_arr = explode ('||', $time_obj);
foreach ($a_time_arr as $adk => $adv){
	

$a_date_arr = explode ('.', $adv);
if (isset($a_date_arr[0])) {$a_day = $a_date_arr[0];} else {$a_day = '';}	
if (isset($a_date_arr[1])) {$a_month = $a_date_arr[1];} else {$a_month = '';}	
if (isset($a_date_arr[2])) {$a_year = $a_date_arr[2];} else {$a_year = '';}	
	

if ($qdate == $a_day.'.'.$a_month.'.'.$a_year) { 

$num_ul++;

echo '<div class="stime_item dt_'.$class_line.'" style="width:1056px; right:0;">'; 

echo '<div class="stime_bl" tabindex="1">';

echo '<i class="icon-pin"></i>';


//====================================FIDE INFO
echo '<div class="fade_order">';


for ($l = count($lines_data) - 1; $l >=0 ; $l--)  {
		
if (!empty($lines_data[$l])) {
	
$do = explode('::', $lines_data[$l]);	
if (isset($do[0])) {$id_order_obj_n = $do[0];} else {$id_order_obj_n = '';}
if (isset($do[1])) {$id_obj_obj_n = $do[1];} else {$id_obj_obj_n = '';}
if (isset($do[2])) {$name_ord_obj_n = $do[2];} else {$name_ord_obj_n = '';}
if (isset($do[3])) {$date_obj_n = $do[3];} else {$date_obj_n = '';}
if (isset($do[4])) {$time_obj_n = $do[4];} else {$time_obj_n = '';}
if (isset($do[5])) {$spots_ord_obj_n = $do[5];} else {$spots_ord_obj_n = '';}
if (isset($do[6])) {$client_name_ord_obj_n = $do[6];} else {$client_name_ord_obj_n = '';}
if (isset($do[7])) {$phone_client_obj_n = $do[7];} else {$phone_client_obj_n  = '';}
if (isset($do[8])) {$mail_client_obj_n = $do[8];} else {$mail_client_obj_n  = '';}
if (isset($do[9])) {$comment_client_obj_n = $do[9];} else {$comment_client_obj_n  = '';}
if (isset($do[10])) {$add_ip_obj_n = $do[10];} else {$add_ip_obj_n = '';}
if (isset($do[11])) {$status_obj_n = $do[11];} else {$status_obj_n = '';}	
if (isset($do[12])) {$price_ord_obj_n = $do[12];} else {$price_ord_obj_n = '';}	
if (isset($do[13])) {$cur_obj_n = $do[13];} else {$cur_obj_n = '';}	
if (isset($do[14])) {$order_staff_obj_n = $do[14];} else {$order_staff_obj_n = '';}
if (isset($do[15])) {$discount_ord_obj_n = $do[15];} else {$discount_ord_obj_n = '';}
if (isset($do[16])) {$spots_control_ord_obj_n = $do[16];} else {$spots_control_ord_obj_n = '';}
if (isset($do[17])) {$payment_sys_n = $do[17];} else {$payment_sys_n = '';}

$noa = explode('_',$id_order_obj_n);
if(isset($noa[5]) && isset($noa[6]) && isset($noa[7]))
{$number_order_n = $noa[5].$noa[6].$noa[7];} else {$number_order_n = '';}	



//=======================================DISPLAY SCHEDULE


if ($select_obj == $id_obj_obj_n) { // SELECT OBJ

$a_dt_arr = explode ('||', $time_obj_n);
foreach ($a_dt_arr as $adk => $adv){
	

$a_dateb_arr = explode ('.', $adv);
if (isset($a_dateb_arr[0])) {$a_dayb = $a_dateb_arr[0];} else {$a_dayb = '';}	
if (isset($a_dateb_arr[1])) {$a_monthb = $a_dateb_arr[1];} else {$a_monthb = '';}	
if (isset($a_dateb_arr[2])) {$a_yearb = $a_dateb_arr[2];} else {$a_yearb = '';}	
	

if ($qdate == $a_dayb.'.'.$a_monthb.'.'.$a_yearb) { 



echo '<ul>';

echo '
<li class="title_order_list"><a href="order.php?search='.$number_order_n.'" title="'.$lang['open'].' '.$lang['order'].'"><i class="icon-bell-1"></i> '.$lang['order'].' № <b>'.$number_order_n.'</b></a></li>';

echo '<li><i class="icon-calendar"></i><span>'.$a_day.'.'.$a_month.'.'.$a_year.'</span><div class="clear"></div></li>';

echo '<li><i class="icon-user"></i><span>'.$client_name_ord_obj_n.'</span><div class="clear"></div></li>';

if (!empty($phone_client_obj_n)) {echo '<li><i class="icon-phone"></i><span>'.$phone_client_obj_n.'</span><div class="clear"></div></li>';}
if (!empty($mail_client_obj_n)) {echo '<li><i class="icon-mail-3"></i><span><a href="mailto:'.$mail_client_obj_n.'">'.$mail_client_obj_n.'</a></span><div class="clear"></div></li>';}

if ($spots_control_ord_obj_n == '1') {
echo '<li><i class="icon-users-1"></i>
<span class="spots_'.$a_day.$num_ul.'">'.$spots_ord_obj_n.'</span>
<div class="clear"></div></li>';	
}

echo '</ul>';




} //found date

} //count

} //select obj
//--------------------------------------/display schedule
} //no empty

} //count orders



if ($spots_control_ord_obj == '1') { //count spots

echo '<ul><li class="total_spots">
<i class="icon-users-1"></i><span class="info_spots">'.$lang['order_totlal_spots'].': </span>
<span class="info_spots total" id="total_spots_'.$a_day.$num_ul.'"></span>
<div class="clear"></div>
</li></ul>';

echo '
<script>
var ord_spots_'.$a_day.$num_ul.' = document.getElementsByClassName("spots_'.$a_day.$num_ul.'");
var spots_disp_'.$a_day.$num_ul.' = document.getElementById("total_spots_'.$a_day.$num_ul.'");
var total_spots_'.$a_day.$num_ul.' = 0;

for(var i = 0; i < ord_spots_'.$a_day.$num_ul.'.length; i++) {
	
total_spots_'.$a_day.$num_ul.' += parseFloat(ord_spots_'.$a_day.$num_ul.'[i].innerHTML);

}

spots_disp_'.$a_day.$num_ul.'.innerHTML = total_spots_'.$a_day.$num_ul.';
</script>
';
} //count spots



echo '</div>';
//------------------------------------/fade info


echo '</div>';
echo '</div>';
}	
	
	
}




} else { //=====================================================================================provide hourly






$a_date_arr = explode ('.', $date_obj);
if (isset($a_date_arr[0])) {$a_day = $a_date_arr[0];} else {$a_day = '';}	
if (isset($a_date_arr[1])) {$a_month = $a_date_arr[1];} else {$a_month = '';}	
if (isset($a_date_arr[2])) {$a_year = $a_date_arr[2];} else {$a_year = '';}	





if ($qdate == $a_day.'.'.$a_month.'.'.$a_year) {  //==========FOUND DATE



$a_time_arr_b = explode ('||', $time_obj);
foreach ($a_time_arr_b as $atk => $atv){
$a_timed_arr = explode (':', $atv);

if (isset($a_timed_arr[0])) {$a_hstart = $a_timed_arr[0];} else {$a_hstart = '';}	
if (isset($a_timed_arr[1])) {$a_mstart = $a_timed_arr[1];} else {$a_mstart = '';}	
if (isset($a_timed_arr[2])) {$a_hend = $a_timed_arr[2];} else {$a_hend = '';}	
if (isset($a_timed_arr[3])) {$a_mend = $a_timed_arr[3];} else {$a_mend = '';}




$m_sta = (44/60)*$a_mstart;
$m_end = (44/60)*$a_mend;

$min_pos = '0';

$min_pos = $m_end - $m_sta;


$width_item = ($a_hend-$a_hstart)*44+$min_pos;

$style_time_item = 'left:'.($a_hstart*44+44+$m_sta-1).'px; width:'.$width_item.'px;';


$num_ul++;

//====================================TIME ITEM


echo '<div class="stime_item dt_'.$class_line.'" style="'.$style_time_item.'">'; 

echo '<div class="stime_bl" tabindex="1">';

echo '<i class="icon-pin"></i>';


//====================================FIDE INFO
echo '<div class="fade_order">';



//===================================================================================

for ($l = count($lines_data) - 1; $l >=0 ; $l--)  {
		
if (!empty($lines_data[$l])) {
	
$do = explode('::', $lines_data[$l]);	
if (isset($do[0])) {$id_order_obj_n = $do[0];} else {$id_order_obj_n = '';}
if (isset($do[1])) {$id_obj_obj_n = $do[1];} else {$id_obj_obj_n = '';}
if (isset($do[2])) {$name_ord_obj_n = $do[2];} else {$name_ord_obj_n = '';}
if (isset($do[3])) {$date_obj_n = $do[3];} else {$date_obj_n = '';}
if (isset($do[4])) {$time_obj_n = $do[4];} else {$time_obj_n = '';}
if (isset($do[5])) {$spots_ord_obj_n = $do[5];} else {$spots_ord_obj_n = '';}
if (isset($do[6])) {$client_name_ord_obj_n = $do[6];} else {$client_name_ord_obj_n = '';}
if (isset($do[7])) {$phone_client_obj_n = $do[7];} else {$phone_client_obj_n  = '';}
if (isset($do[8])) {$mail_client_obj_n = $do[8];} else {$mail_client_obj_n  = '';}
if (isset($do[9])) {$comment_client_obj_n = $do[9];} else {$comment_client_obj_n  = '';}
if (isset($do[10])) {$add_ip_obj_n = $do[10];} else {$add_ip_obj_n = '';}
if (isset($do[11])) {$status_obj_n = $do[11];} else {$status_obj_n = '';}	
if (isset($do[12])) {$price_ord_obj_n = $do[12];} else {$price_ord_obj_n = '';}	
if (isset($do[13])) {$cur_obj_n = $do[13];} else {$cur_obj_n = '';}	
if (isset($do[14])) {$order_staff_obj_n = $do[14];} else {$order_staff_obj_n = '';}
if (isset($do[15])) {$discount_ord_obj_n = $do[15];} else {$discount_ord_obj_n = '';}
if (isset($do[16])) {$spots_control_ord_obj_n = $do[16];} else {$spots_control_ord_obj_n = '';}
if (isset($do[17])) {$payment_sys_n = $do[17];} else {$payment_sys_n = '';}

$noa = explode('_',$id_order_obj_n);
if(isset($noa[5]) && isset($noa[6]) && isset($noa[7]))
{$number_order_n = $noa[5].$noa[6].$noa[7];} else {$number_order_n = '';}	



//=======================================DISPLAY SCHEDULE

if ($select_obj == $id_obj_obj_n) { // SELECT OBJ




$adarr = explode ('.', $date_obj_n);
if (isset($adarr[0])) {$ad = $adarr[0];} else {$ad = '';}	
if (isset($adarr[1])) {$am = $adarr[1];} else {$am = '';}	
if (isset($adarr[2])) {$ay = $adarr[2];} else {$ay = '';}	



if ($qdate == $ad.'.'.$am.'.'.$ay) {  //==========FOUND DATE



$atarr = explode ('||', $time_obj_n);
foreach ($atarr as $atk => $atv){
$tarr = explode (':', $atv);

if (isset($tarr[0])) {$hs = $tarr[0];} else {$hs = '';}	
if (isset($tarr[1])) {$ms = $tarr[1];} else {$ms = '';}	
if (isset($tarr[2])) {$he = $tarr[2];} else {$he = '';}	
if (isset($tarr[3])) {$me= $tarr[3];} else {$me= '';}



if ($a_hstart == $hs) {	  //=========================================================



echo '<ul>';

echo '
<li class="title_order_list"><a href="order.php?search='.$number_order_n.'" title="'.$lang['open'].' '.$lang['order'].'"><i class="icon-bell-1"></i> '.$lang['order'].' № <b>'.$number_order_n.'</b></a></li>';


echo '<li><i class="icon-clock-3"></i><span>'.$hs.':'.$ms.' - '.$he.':'.$me.'</span><div class="clear"></div></li>';


//$name_ord_obj_n_arr = explode('&&', $name_ord_obj_n);
//echo '<li><i class="icon-briefcase-1"></i><span>'.$name_ord_obj_n_arr[0].'';
//if (!empty($name_ord_obj_n_arr[1])) {echo ' <small>('.$name_ord_obj_n_arr[1].')</small>';}
//echo '</span><div class="clear"></div></li>';

echo '<li><i class="icon-user"></i><span>'.$client_name_ord_obj_n.'</span><div class="clear"></div></li>';

if (!empty($phone_client_obj_n)) {echo '<li><i class="icon-phone"></i><span>'.$phone_client_obj_n.'</span><div class="clear"></div></li>';}
if (!empty($mail_client_obj_n)) {echo '<li><i class="icon-mail-3"></i><span><a href="mailto:'.$mail_client_obj_n.'">'.$mail_client_obj_n.'</a></span><div class="clear"></div></li>';}

if ($spots_control_ord_obj_n == '1') {
echo '<li><i class="icon-users-1"></i>
<span class="spots_'.$a_hstart.$ad.$num_ul.'">'.$spots_ord_obj_n.'</span>
<div class="clear"></div></li>';	
}

echo '</ul>';



//===================================================================================
} // horus start = horus scale 


} // new count time


} // found date

} //select obj
} //no empty lines

} //new count order lines



//=====================================================================================


if ($spots_control_ord_obj == '1') { //count spots

echo '<ul><li class="total_spots">
<i class="icon-users-1"></i><span class="info_spots">'.$lang['order_totlal_spots'].':</span><span class="info_spots total" id="total_spots_'.$a_hstart.$a_day.$num_ul.'"></span>
<div class="clear"></div>
</li></ul>';

echo '
<script>
var ord_spots_'.$a_hstart.$a_day.$num_ul.' = document.getElementsByClassName("spots_'.$a_hstart.$a_day.$num_ul.'");
var spots_disp_'.$a_hstart.$a_day.$num_ul.' = document.getElementById("total_spots_'.$a_hstart.$a_day.$num_ul.'");
var total_spots_'.$a_hstart.$a_day.$num_ul.' = 0;

for(var i = 0; i < ord_spots_'.$a_hstart.$a_day.$num_ul.'.length; i++) {
	
total_spots_'.$a_hstart.$a_day.$num_ul.' += parseFloat(ord_spots_'.$a_hstart.$a_day.$num_ul.'[i].innerHTML);

}

spots_disp_'.$a_hstart.$a_day.$num_ul.'.innerHTML = total_spots_'.$a_hstart.$a_day.$num_ul.';
</script>
';
} //count spots


echo '</div>'; //fade_order
//-----------------------------------/fide info


echo '</div>'; //stime_bl

echo '</div>'; //-------------------/stime_item

//for ($st = 0; $st < 24; ++$st) {	
//if (strlen($st) == 1) { $st = '0'.$st; }
//if ($a_hstart == $st) { break 2; } // scale = time start
//} //count hours scale

} //count time



} //found date
	
} //provide

} // SELECT OBJ
//-----------------------------------------/display


} //no empty line	

} //count lenes bd

} else {  } // file size != 0





} else {  } //exists bd file 

echo '
<div class="clear"></div>

</div>

<div class="clear"></div>'; //sdate

} //---/COUNT DAYS

//----------------------------------------------------------

echo '<div class="scale scale_bottom">';
echo '<div class="date_bottom"><i class="icon-calendar"></i></div>';

echo '<div class="bottom_timeline">';

for ($s = 0; $s < 24; ++$s) {
if (strlen($s) == 1) {$s = '0'.$s;}
$class_s = 'hour_s';
if ($s == '00') {$class_s = 'first_h';} 
else if ($s == '23') {$class_s = 'last_h';} 

echo '<div class="scale_hour '.$class_s.'">
<div class="digit_h">'.$s.':00</div>
<div class="half_h"></div>
</div>';	
}

echo '<div class="clear"></div></div>';


echo '<div class="clear"></div>
</div>
<div class="clear"></div>';


//-----------------------------------/top calendar


} //access

echo '<div class="clear"></div>
</div>'; //main

include ('footer.php');
?>