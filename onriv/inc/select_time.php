<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;} 



$url_time ='';

if (!isset($_GET['weekday'])) {$_GET['weekday'] = date("N")-1;} //===WEEKDAY

$select_time = '';
if (isset($_GET['time'])) {$select_time = $_GET['time'];}


$select_time_spots = '';
$min_spots_ord = '1';
$max_spots_ord = '0';
$total_spots_ord = '';
$price_time = '';
$fixp = '0';
$sel_s_price = '';
$count_spots = '';


$b_time_spots = '0';
$left_spots_time = '';
$str_spots = '';
$id_spots_bl = '';
?>
<div id="select_time">

<div class="title_full_serv"><h3>
<?php
echo $name_obj; 
if (isset($_GET['day'])) {

echo ' '.$lang['in'].' '.$_GET['day'].' '.$lang_monts_r[$month].' '.$year;
} else {echo ' ('.$lang['select_date'].')';}
?>
</h3></div>

<div class="time">
<?php

//=======================SHIFT PRICE WEEKDAYS & DATES
//$active_wd = '0';
$sign_wd = '0';
$shift_price_wd = '0';
$check_swd = '0';

$act_count = 0;

$total_price_str = '';
$all_staff_str = '';

$arr_wd = explode('||',$working_days_obj);
if (isset($_GET['weekday']))	{
foreach ($arr_wd as $k_wd => $v_wd) {
$arr_d_wd = explode('&&',$v_wd);
	
if ($_GET['weekday'] == $k_wd) {  

//if ($arr_d_wd[1] != '0') { $check_swd = '1'; } // --- only one shift

$active_wd = $arr_d_wd[0]; // 1 - active day, 0 = disabled
$sign_wd = $arr_d_wd[1];
$shift_price_wd = $arr_d_wd[2];	

}
} // arr week
}// isset wd



//=============================CUSTOM DAYS IN YEAR
//if ($check_swd == '0') {
if(isset($custom_date_obj) && empty($custom_date_obj) || $custom_date_obj == '&&') { } else {
$arr_cdp = explode('||',$custom_date_obj);
$arr_dates_cd = explode('&&',$arr_cdp[0]); array_pop($arr_dates_cd);
$arr_active_cd = explode('&&',$arr_cdp[1]); array_pop($arr_active_cd);
$arr_sign_cd = explode('&&',$arr_cdp[2]); array_pop($arr_sign_cd);
$arr_prise_cd = explode('&&',$arr_cdp[3]); array_pop($arr_prise_cd);

for ($cdp = 0; $cdp < sizeof($arr_dates_cd); ++$cdp) { 
$arr_dm = explode('.',$arr_dates_cd[$cdp]);
if (isset($_GET['day']) && $arr_dm[0] == $_GET['day'] && $arr_dm[1] == $month) {


$active_wd = $arr_active_cd[$cdp];

$sign_wd = $arr_sign_cd[$cdp];
$shift_price_wd = $arr_prise_cd[$cdp];	
} // date month ==
	
} // count dates 	
} // isset custom date
//} // no shift
//-------------------/shift WD






if(!empty($hours_start_obj)) {
//=========================================================================ALL ARRAYS

$hours_start_arr = explode('||',$hours_start_obj); array_pop ($hours_start_arr);

$minutes_start_arr = explode('||',$minutes_start_obj); array_pop ($minutes_start_arr);

$hours_end_arr = explode('||',$hours_end_obj); array_pop ($hours_end_arr);

$minutes_end_arr = explode('||',$minutes_end_obj); array_pop ($minutes_end_arr);

$total_spots_arr = explode('||',$total_spots_obj); array_pop ($total_spots_arr);

$min_spots_arr = explode('||',$min_spots_obj); array_pop ($min_spots_arr);

$max_spots_arr = explode('||',$max_spots_obj); array_pop ($max_spots_arr);

$count_spots_arr = explode('||',$count_spots_obj); array_pop ($count_spots_arr);

$prices_arr = explode('||',$prices_obj); array_pop ($prices_arr);

//========================================================================/all arrays
$idtc = 0;


if (!empty($fix_price_obj) || $fix_price_obj != '0') { $fixp = '1';
if ($fix_price_obj == '-') { $price_time == '-'; } //var price
else {
//shift wd
if ($sign_wd == '+'){$fix_price_obj = $fix_price_obj + $shift_price_wd;}
if ($sign_wd == '-' && $fix_price_obj > $shift_price_wd){$fix_price_obj = $fix_price_obj - $shift_price_wd;} 
//shift wd 
} 
$price_time = $fix_price_obj;

}



for ($its = 0; $its < sizeof($hours_start_arr); ++$its) {
		
		
///////////////////////==========PRICE
if($fixp == '0') { 
$price_time = $prices_arr[$its]; 

if ($price_time == '-') { } else {

//shift wd	
if ($sign_wd == '+'){$price_time = $price_time + $shift_price_wd;}
if ($sign_wd == '-' && $price_time > $shift_price_wd) {$price_time = $price_time - $shift_price_wd;} 
//shift wd
} //price var
}

////////////////////----------/price		
		
		
		
		
$idtc++;

if($idtc % 4 == 0) {$last_tm = 'style="margin:0 0 1px 0;"';} else {$last_tm = 'style="margin:0 1px 1px 0;"';}

// -- value 
if ($hours_end_arr[$its] != 'XX') {
$val_time = $hours_start_arr[$its].':'.$minutes_start_arr[$its].':'.$hours_end_arr[$its].':'.$minutes_end_arr[$its];
} else {
$val_time = $hours_start_arr[$its].':'.$minutes_start_arr[$its].':XX:XX';	
}


if ($hours_end_arr[$its] == 'XX') {$minutes_end_arr[$its] = 'XX';}








//=======================BLOCKING NO ACTIVE DAYS
if (isset($_GET['day'])) {
if ($_GET['day'] < date('d') && $month == date('m') && $year == date("Y") || $month < date('m') && $year == date("Y") || $year < date("Y")) {$active_wd = '0';}


if (preg_match('/#'.$_GET['day'].'.'.$month.'.'.$year.'.'.$weekday.'&/i', $check_time_obj_str)) {$active_wd = '0';} //busy
} //get day
//----------------------/blocking no active days


//--------------ative two monts / active WD
if ($active_two_monts_obj == '1' && $month >= $na_month ||  
$active_two_monts_obj == '1' && $month != '01' && date('m') != '12' && $year > date('Y') ||
$active_two_monts_obj == '1' && $year > date('Y'))
{ $active_wd = '0';}



if (isset($_GET['day']) && $active_wd != '0') {
if ($_GET['day'] == date('d') && $month == date('m') && $year == date("Y") && date("H") >= $hours_start_arr[$its]) {

//=======================LOST TIME
echo '<div class="hours"><div class="h_block" '.$last_tm.'><div class="lost_time" title="'.$lang['lost_time'].'"><span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
echo '</span><div class="clear"></div></div></div></div>';
//======================/lost time	
}









//===============================================================================SPOTS TIME

else if ($total_spots_arr[$its] != '0' && $all_spots_obj == '0' || $total_spots_arr[$its] != '0' && empty($all_spots_obj)) {


if ($select_time == $val_time) { //====================select time = time

$left_spots_time_select = $left_spots_time;


$select_time_spots = '1'; //=========================START FUNCTIONS FOR SPOTS

$total_spots_ord = $total_spots_arr[$its];
$min_spots_ord = $min_spots_arr[$its];
$max_spots_ord = $max_spots_arr[$its];		
$count_spots = $count_spots_arr[$its];

if ($min_spots_ord == '0' || empty($min_spots_ord)) {$min_spots_ord = '1';}	



$sel_time_cl = 'sel_spots_time'; 

$sel_s_price = $price_time;

} else {$sel_time_cl = 'spots_time';}	
	


if ($end_spots == '1' && $select_time == $val_time) {
	
//=======================BUSSY SPOTS TIME
echo '<div class="hours"><div class="h_block" '.$last_tm.'><div class="busy_time" title="'.$lang['end_spots'].'"><span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
echo '</span><div class="clear"></div></div></div></div>';
//======================/bussy spots time		
	
	
//else if ($left_spots_time == 0) {
	
//=======================BUSSY SPOTS TIME
//echo '<div class="hours"><div class="h_block" '.$last_tm.'><div class="busy_time" title="'.$lang['end_spots'].'"><span class="ts">';
//echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
//if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
//echo '</span><div class="clear"></div></div></div></div>';
//======================/bussy spots time			
	
	
	
	
	
} else {	



	
	
echo '<div class="hours"><div class="h_block h_act" '.$last_tm.'>';


echo '<div id="b'.$idtc.'" class="time_bl atime_bl">';



$url_time = $action_form;
$url_time = str_replace('&amp;time='.$select_time, '', $url_time);
if (strpos($url_time, '?') === false) {
    $url_time = str_replace('qhero.ru/','qhero.ru/?',$url_time);
}

echo '<a href="'.$url_time.'&amp;time='.$val_time.'#select_time" class="atime '.$sel_time_cl.'">';

echo '<span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
echo '</span>';

echo '<span class="clear"></span></a>';


if($select_time == $val_time) {
echo '<input type="hidden" name="time['.$val_time.']" value="'.$select_time.'" />';}



echo '<div class="clear"></div>';
echo '<div class="time_data">';



//====================================display price
echo '<div class="price_inf">';
echo $lang['price'].': ';
if ($price_time == '-') { 
echo '<span class="price_var">'.$lang['price_variable'].'</span>';
echo '<span class="sp_price ag_no_view">0.0999</span>';
} else { //price var
if ($price_time == '0') {
echo '<span class="price_var">'.$lang['price_null'].'</span>';	
echo '<span class="sp_price ag_no_view">'.$price_time.'</span>';
} else {
//==============================price
echo $curr_left; //currensy position left
echo '<span class="t_prise">';
echo '<span class="sp_price">'.$price_time.'</span>';
echo '</span>';
echo $curr_right; //currensy position right
//==============================price
} //price = 0
}// price var 
echo '<div class="clear"></div>';
if ($fixp == '1' && $price_time != '-') { 
echo '<small class="quest" title="'.$lang['fix_price_hh'].'">('.$lang['fix_price'].')</small>';
}
echo '</div>';
//--------------------------------/prise




//============================================================display spots



//=================================================COUNT BUSSY SPOTS IN TIME

$id_spots_bl = str_replace(':', '', $val_time);


echo '<div class="dspots">'.$lang['vacancy_spots'].': <span class="ag_left_spots" id="spots'.$id_spots_bl.'"></span></div>';


echo '<script>';	
echo '
var bspots'.$id_spots_bl.' = 0;
var bl_spots'.$id_spots_bl.' = document.getElementById("spots'.$id_spots_bl.'");
var bl_time_spots = document.getElementById("b'.$idtc.'"); 
';
echo 'bspots'.$id_spots_bl.' = ';
if ($file_order_bd == '1') {
	
for ($lot = 0; $lot < sizeof($lines_data_order); ++$lot) { 

if (!empty($lines_data_order[$lot])) {
$data_ord = explode('::', $lines_data_order[$lot]);	
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

if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $date_obj){ //day	

if (!empty($time_obj)) {

if ($val_time == $time_obj) {
	
$str_spots = $spots_ord_obj.'+';

echo $str_spots; // FOR JS

}   //============LEFT SPOTS

} 

} //select day


} //empty lines
} //count lines orders
} //bd not empty
echo '0;
';
echo 'bspots'.$id_spots_bl.' = '.$total_spots_arr[$its].' - bspots'.$id_spots_bl.';';

echo 'bl_spots'.$id_spots_bl.'.innerHTML = bspots'.$id_spots_bl.';';

if (!isset($edit_true)) {
echo 'if (bspots'.$id_spots_bl.' <= 0) {
bl_time_spots.removeAttribute("class");
bl_time_spots.setAttribute("class","busy_time");
}';
}

echo '</script>';






//===============================================/count spots in time



//=========================================================STAFF

echo '<div class="title_staff_time">'.$lang['staff'].' <i class="icon-down-big"></i></div>';
echo '<div class="staff_time">';
$staff_obj_arr = explode('&&',$staff_obj); array_pop ($staff_obj_arr);
foreach($staff_obj_arr as $kst => $vst) {
	
$ind_staff = explode('-',$vst);		
$unit_number_staff = $ind_staff[0];
$unit_id_staff = $ind_staff[1];	

if ($unit_number_staff == $its) {


for ($lst = 0; $lst < sizeof($lines_staff); ++$lst) { 
if (!empty($lines_staff[$lst])) { 
$data_staff = explode("::", $lines_staff[$lst]);

if (isset($data_staff[0])) {$id_staff = $data_staff[0];} else {$id_staff = '';}


if (isset($data_staff[5])) {$name_staff = $data_staff[5];} else {$name_staff = '';}

if (isset($data_staff[6])) {$email_staff = $data_staff[6];} else {$email_staff = '';}

if (isset($data_staff[8])) {$phone_staff = $data_staff[8];} else {$phone_staff = '';}

if (isset($data_staff[14])) {$active_staff = $data_staff[14];} else {$active_staff = '';}

if ($unit_id_staff == $id_staff) {// display current staff in this time
if ($active_staff == 'yes') {
echo '<span class="staff_list_time"><!--<i class="icon-user"></i>--><a href="'.$folder.$psep.'card-staff.php?view='.$id_staff.'" class="iframe" title="'.$lang['open_card_staff'].'">'.$name_staff.'</a></span>';

//======================================================ORDER STAFF
if (isset($_POST['time'][$val_time])) {$all_staff_str .= $id_staff.'&&'.$name_staff.'&&'.$email_staff.'&&'.$phone_staff.'||';}

}
} //id staff = unit id staff

} //empty bd staff
} //count all staff
} //num staff = num unit
}//foreach current staff
echo '</div>';
//========================================================/staff

echo '</div>';
echo '</div>';

echo'</div></div>';	

//===========================ORDER PRICE
if (isset($_POST['time'][$val_time])) {$total_price_str .= $price_time.'&&';}	

} //SPOTS END	
}//----------------------------------------------------------------/spots time













//=======================BUSY TIME
else if (preg_match('/'.$hours_start_arr[$its].':'.$minutes_start_arr[$its].':'.$hours_end_arr[$its].':'.$minutes_end_arr[$its].'/i', $check_time_obj_str)) {
	
echo '<div class="hours"><div class="h_block" '.$last_tm.'><div class="busy_time" title="'.$lang['time_busy'].'"><span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
echo '</span><div class="clear"></div></div></div></div>';
//======================/busy time		





} else {

$act_count++;


 


//=======================ACTIVE TIME	


if (!empty($select_time)) {
//=======================SELECT SPOTS TIME
echo '<div class="hours"><div class="h_block" '.$last_tm.'><div class="disable_time" title="'.$lang['disabled'].'"><span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
echo '</span><div class="clear"></div></div></div></div>';
//======================/select spots time		
} else {


echo '<div class="hours"><div class="h_block h_act" '.$last_tm.'><label>';

//==============cecked
$checked_time = '';
if (isset($_POST['time'][$val_time])) {
$checked_time = 'checked="checked"';	
} else {$checked_time = '';}


//if ($hours_end_arr[$its] == 'XX') {$val_time = $hours_start_arr[$its].':'.$minutes_start_arr[$its];}


echo '<input type="checkbox" name="time['.$val_time.']" class="ch_time" value="'.$val_time.'" id="c'.$idtc.'" onclick="checkbg('.$idtc.')" '.$checked_time.'/>';
echo '<div id="b'.$idtc.'" class="time_bl"><span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 

echo '</span><div class="clear"></div>';
echo '<div class="time_data">';
//====================================display price
echo '<div class="price_inf">';
echo $lang['price'].': ';
if ($price_time == '-') { 
echo '<span class="price_var">'.$lang['price_variable'].'</span>';
echo '<span class="ag_price ag_no_view">0.0999</span>';
} else { //price var
if ($price_time == '0') {
echo '<span class="price_var">'.$lang['price_null'].'</span>';	
echo '<span class="ag_price ag_no_view">'.$price_time.'</span>';
} else {
//==============================price
echo $curr_left; //currensy position left
echo '<span class="t_prise">';
echo '<span class="ag_price">'.$price_time.'</span>';
echo '</span>';
echo $curr_right; //currensy position right
//==============================price
} //price = 0
}// price var 
echo '<div class="clear"></div>';
if ($fixp == '1' && $price_time != '-') { 
echo '<small class="quest" title="'.$lang['fix_price_hh'].'">('.$lang['fix_price'].')</small>';
}
echo '</div>';
//--------------------------------/prise


//=========================================================STAFF

echo '<div class="title_staff_time">'.$lang['staff'].' <i class="icon-down-big"></i></div>';
echo '<div class="staff_time">';
$staff_obj_arr = explode('&&',$staff_obj); array_pop ($staff_obj_arr);
foreach($staff_obj_arr as $kst => $vst) {
	
$ind_staff = explode('-',$vst);		
$unit_number_staff = $ind_staff[0];
$unit_id_staff = $ind_staff[1];	

if ($unit_number_staff == $its) {


for ($lst = 0; $lst < sizeof($lines_staff); ++$lst) { 
if (!empty($lines_staff[$lst])) { 
$data_staff = explode("::", $lines_staff[$lst]);

if (isset($data_staff[0])) {$id_staff = $data_staff[0];} else {$id_staff = '';}


if (isset($data_staff[5])) {$name_staff = $data_staff[5];} else {$name_staff = '';}

if (isset($data_staff[6])) {$email_staff = $data_staff[6];} else {$email_staff = '';}

if (isset($data_staff[8])) {$phone_staff = $data_staff[8];} else {$phone_staff = '';}

if (isset($data_staff[14])) {$active_staff = $data_staff[14];} else {$active_staff = '';}

if ($unit_id_staff == $id_staff) {// display current staff in this time
if ($active_staff == 'yes') {
echo '<span class="staff_list_time"><!--<i class="icon-user"></i>--><a href="'.$folder.$psep.'card-staff.php?view='.$id_staff.'" class="iframe" title="'.$lang['open_card_staff'].'">'.$name_staff.'</a></span>';

//======================================================ORDER STAFF
if (isset($_POST['time'][$val_time])) {$all_staff_str .= $id_staff.'&&'.$name_staff.'&&'.$email_staff.'&&'.$phone_staff.'||';}

}
} //id staff = unit id staff

} //empty bd staff
} //count all staff
} //num staff = num unit
}//foreach current staff
echo '</div>';
//========================================================/staff

echo '</div>';
echo '</div>';

echo'</label></div></div>';	

//===========================ORDER PRICE
if (isset($_POST['time'][$val_time])) {$total_price_str .= $price_time.'&&';}

//======================/active time	

} //===select spots time

} // =========================================================================== else active









}//GET DAY

else {

//=======================NO DATE TIME
echo '<div class="hours"><div class="h_block" '.$last_tm.'><div class="disable_time" title="'.$lang['select_date'].'"><span class="ts">';
echo $hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') { echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its]; } 
echo '</span><div class="clear"></div></div></div></div>';
//======================/no date time		
	
}// -- no get day



}//count hours
}//empty hours
echo '<div class="clear"></div>';




?>
</div>
</div>
<?php if ($active_wd != '0') { include ($folder.$psep.'inc/order_form.php'); } ?>
