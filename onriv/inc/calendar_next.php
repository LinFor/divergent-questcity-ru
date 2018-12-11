<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;} 

//check url month
if(isset($_GET['month'])) {
	
    $month_next = $_GET['month']+1;
}
else if(isset($_GET['viewmonth'])) {
	
    $month_next = $_GET['viewmonth']+1;
}
else {
	
    $month_next = date('n')+1;
}
	
//check url year
if(isset($_GET['year'])) {
	$year_next = $_GET['year'];
}
else if(isset($_GET['viewyear'])) {
	$year_next = $_GET['viewyear'];
}
else {
	$year_next = date('Y');
}

if($month_next == '12') {
	$next_year_next = $year_next + 1;
}
else {
	$next_year_next = $year_next;
}
	


$first_of_month_next = mktime(0, 0, 0, $month_next, 1, $year_next);


$maxdays_next = date('t', $first_of_month_next);
$date_info_next = getdate($first_of_month_next);
$month_next = $date_info_next['mon'];
$year_next = $date_info_next['year'];


//if current month Januar, then next year +1
if($month_next == '01') {
$last_year_next = $year-1;}
else {
$last_year_next = $year;}

// end last month and early next month
$timestamp_last_month = $first_of_month_next - (24*60*60);
$last_month_next = date('n', $timestamp_last_month);


//if December, then next month = 1
if($month_next == '12') {$next_month_next = '01';}
else {$next_month_next = $month_next+1;}

$na_month_next = date('n')+2; 

if (strlen($last_month_next) == 1) {$last_month_next = '0'.$last_month_next;}
if (strlen($next_month_next) == 1) {$next_month_next = '0'.$next_month_next;} 
if (strlen($na_month_next) == 1) {$na_month_next = '0'.$na_month_next;} 		
if (strlen($month_next) == 1) {$month_next = '0'.$month_next;} 

	
$calendar_next = '<table class="next_cal"><tbody>';








$calendar_next .= '<tr><th colspan="7" class="t_month">';

$calendar_next .= '<h4>'.$lang_monts[$month_next].' '.$year_next.'</h4><div class="clear"></div>';

$calendar_next .= '</th></tr>';//------------







	

	
	
	
	
$calendar_next .= '<tr>
        <th>'.$lang_days_short[1].'</th>
        <th>'.$lang_days_short[2].'</th>
        <th>'.$lang_days_short[3].'</th>
        <th>'.$lang_days_short[4].'</th>
        <th>'.$lang_days_short[5].'</th>
        <th>'.$lang_days_short[6].'</th>
		<th>'.$lang_days_short[7].'</th>
</tr>';


$calendar_next .=  '<tr>'; 

// css class clear
$class = '';

$weekday_next = $date_info_next['wday'];

// format  1 - Monday, ..., 6 - Saturday
$weekday_next = $weekday_next-1; 
if($weekday_next == -1) $weekday_next=6;

// day as 1
$day_next = 1;

// width calendar
if($weekday_next > 0) 
	$calendar_next .= '<td colspan="'.$weekday_next.'"> </td>';
	
while($day_next <= $maxdays_next)
{
	// if Saturday, display new column
    if($weekday_next == 7) {
		$calendar_next .= '</tr><tr>';
		$weekday_next = 0;
	}
	
	$linkDate = mktime(0, 0, 0, $month_next, $day_next, $year_next);


	
	// today date

    if((($day_next < 10 and $day_next == date('d')) or ($day_next >= 10 and $day_next == date('d'))) and (($month_next < 10 and $month_next == date('m')) or ($month_next >= 10 and $month_next == date('m'))) and $year_next == date('Y')) {
		
		 $a_class = 'today';
		 
	//all days
	} else {
		$d = date('m/d/Y', $linkDate);

		$a_class = 'day';
	}
	
	//weekend days red color
	if($weekday_next == 5 || $weekday_next == 6) {$class_day='day-red';} else {$class_day='day';}	 
	


if (strlen($day_next) == 1) {$dd_next = '0'.$day_next;} else {$dd_next = $day_next;} // 01 - 09


//===========================================================================================
$amays_str = '';
if(isset($custom_date_obj) && empty($custom_date_obj) || $custom_date_obj == '&&') { } else {
$arr_cdp = explode('||',$custom_date_obj);
$arr_dates_cd = explode('&&',$arr_cdp[0]); array_pop($arr_dates_cd);
$arr_active_cd = explode('&&',$arr_cdp[1]); array_pop($arr_active_cd);
$arr_sign_cd = explode('&&',$arr_cdp[2]); array_pop($arr_sign_cd);
$arr_prise_cd = explode('&&',$arr_cdp[3]); array_pop($arr_prise_cd);

for ($cdp = 0; $cdp < sizeof($arr_dates_cd); ++$cdp) { 
$arr_dm = explode('.',$arr_dates_cd[$cdp]);


if ($arr_active_cd[$cdp] != 0) {$amays_str .= '#'.$arr_dm[0].'.'.$arr_dm[1].'&';}


	
} // count dates 	
} // isset custom date
//========================================================




	
//==========================================DISPLAY DAYS	
	

    $calendar_next .= '<td class="caltd">';


//===========================ATIVE ONLY TWO MONTS

//$calendar_next .= $month_next.' / '.$na_month_next .' / '.$next_month_next;

if ($active_two_monts_obj == '1' && $month_next >= $na_month_next || 
$active_two_monts_obj == '1' && $month_next != '01' && date('m') != '12' && $year_next > date('Y') ||
$active_two_monts_obj == '1' && $year_next > date('Y')) 

{ 
$calendar_next .= '<div class="no_work_day tdd" title="'.$lang['not_active_dates'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>';	
}
	
//===========================NO WORK DAYS
else if ($nwd_arr[$weekday_next] == 0 && !preg_match('/#'.$dd_next.'.'.$month_next.'&/i', $amays_str)) {
	
if ($year_next < date('Y') || $year_next <= date('Y') && $month_next < date('m') || $year_next <= date('Y') && $month_next == date('m') && $day_next <= date('d')){

$calendar_next .= '<div class="lost_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>';} else {			
	
	
$calendar_next .= '<div class="no_work_day tdd" title="'.$lang['disabled_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>'; }
}	
	
//===========================CUSTOM NO WORK DAYS IN YEAR $nwdays_str $nwmonth_str
else if (preg_match('/#'.$dd_next.'.'.$month_next.'&/i', $nwdays_str)) {
	
if ($year_next < date('Y') || $year_next <= date('Y') && $month_next < date('m') || $year_next <= date('Y') && $month_next == date('m') && $day_next <= date('d')){

$calendar_next .= '<div class="lost_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>';} else {		
	
$calendar_next .= '<div class="no_work_day tdd" title="'.$lang['disabled_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>'; }	
}		
	
//===========================BUSY DAY 
else if (preg_match('/'.$dd_next.'.'.$month_next.'.'.$year_next.'.'.$weekday_next.'/i', $check_time_obj_str)) {
if ($year_next > date('Y') || $year_next >= date('Y') && $month_next > date('m') || $year_next >= date('Y') && $month_next == date('m') && $day_next >= date('d')){
// lost busy day
$calendar_next .= '<div class="busy_day tdd" title="'.$lang['day_busy'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>';


	
} else { // display busy day	 

$calendar_next .= '<div class="lost_busy_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
	</div>';

} // lost busy day
}	

//===========================ACTIVE DAYS
else if ($year_next > date('Y') || $year_next >= date('Y') && $month_next > date('m') || $year_next >= date('Y') && $month_next == date('m') && $day_next >= date('d')){	

	
$calendar_next .= '<div class="tdd">';

if(isset($_GET['day']) && $_GET['day'] == $dd_next) {$a_class = $a_class.' select_date';}

if($provide_obj == 'daily') { // ======================== DAILY

//=======================SHIFT PRICE WEEKDAYS & DATES
//$active_wd = '0';
$sign_wd = '0';
$shift_price_wd = '0';
$check_swd = '0';

$arr_wd = explode('||',$working_days_obj);

foreach ($arr_wd as $k_wd => $v_wd) {
$arr_d_wd = explode('&&',$v_wd);
	
if ($weekday_next == $k_wd) {  

if ($arr_d_wd[1] != '0') { $check_swd = '1'; } // --- only one shift

$active_wd = $arr_d_wd[0]; // 1 - active day, 0 = disabled
$sign_wd = $arr_d_wd[1];
$shift_price_wd = $arr_d_wd[2];	
}
} // arr week




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
if ($arr_dm[0] == $dd_next && $arr_dm[1] == $month_next) {

//$active_wd = $arr_active_cd[$cdp];
$sign_wd = $arr_sign_cd[$cdp];
$shift_price_wd = $arr_prise_cd[$cdp];	
} // date month ==
	
} // count dates 	
} // isset custom date
//} // no shift
//-------------------/shift WD








if ($dd_next == date('d') && $month_next == date('m') && $year_next == date('Y') && $allow_today_obj == 0) { // allow today orders

$calendar_next .= '<div class="no_work_day" title="'.$lang['closed_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
</div>';	



} else {

//==============cecked
$checked_next = '';
if (isset($_POST['dates_next'][$dd_next.'.'.$month_next.'.'.$year_next])) {
$checked_next = 'checked="checked"';
} else {$checked_next = '';}
	
$calendar_next .= '<label>
<input type="checkbox" name="dates_next['.$dd_next.'.'.$month_next.'.'.$year_next.']" value="'.$dd_next.'.'.$month_next.'.'.$year_next.'.'.$weekday_next.'" id="cn'.$dd_next.'" class="ch_time" onclick="checkbgn(\''.$dd_next.'\')" '.$checked_next.'/>

<div class="'.$a_class.' h_act" id="bn'.$dd_next.'"><span class="'.$class_day.' sdd">'.$dd_next.'</span></div>';

$calendar_next .= '<div class="time_data">
<div class="price_inf">'.$lang['price'].':


<span class="t_prise">';

$calendar_next .= $curr_left;

//==============================price
$price_day = '';
if ($provide_obj == 'daily') { $price_day = $daily_price_obj; }

if (!empty($fix_price_obj) || $fix_price_obj != '0') { 
//shift wd
if ($sign_wd == '+'){$fix_price_obj = $fix_price_obj + $shift_price_wd;}
if ($sign_wd == '-' && $fix_price_obj > $shift_price_wd){$fix_price_obj = $fix_price_obj - $shift_price_wd;} 
//shift wd 
$calendar_next .= $lang['fix_price'].': <span class="ag_price">'.$fix_price_obj.'</span>';  

} else {
	
//shift wd	
if ($sign_wd == '+'){$price_day = $price_day + $shift_price_wd;}
if ($sign_wd == '-' && $price_day > $shift_price_wd){$price_day = $price_day - $shift_price_wd;} 
//shift wd
	
$calendar_next .= '<span class="ag_price">'.$price_day.'</span>'; 
}

$calendar_next .= '</span>';

$calendar_next .= $curr_right;

$calendar_next .= '<div class="clear"></div></div>';

//=========================================================STAFF
$calendar_next .= '<div class="title_staff_time">'.$lang['staff'].' <i class="icon-down-big"></i></div>';

$calendar_next .= '<div class="staff_time">';

$d_staff_arr = explode('||', $daily_staff_obj); array_pop($d_staff_arr);


foreach($d_staff_arr as $kst => $unit_id_staff) {


for ($lst = 0; $lst < sizeof($lines_staff); ++$lst) { 
if (!empty($lines_staff[$lst])) { 
$data_staff = explode("::", $lines_staff[$lst]);

if (isset($data_staff[0])) {$id_staff = $data_staff[0];} else {$id_staff = '';}
if (isset($data_staff[1])) {$login_staff = $data_staff[1];} else {$login_staff = '';}
if (isset($data_staff[2])) {$sapas_staff = $data_staff[2];} else {$sapas_staff = '';}
if (isset($data_staff[3])) {$passw_staff = $data_staff[3];} else {$passw_staff = '';}
if (isset($data_staff[4])) {$access_staff = $data_staff[4];} else {$access_staff = '';}


if (isset($data_staff[5])) {$name_staff = $data_staff[5];} else {$name_staff = '';}
if (isset($data_staff[6])) {$email_staff = $data_staff[6];} else {$email_staff = '';}
if (isset($data_staff[7])) {$email_display_staff = $data_staff[7];} else {$email_display_staff = '';}
if (isset($data_staff[8])) {$phone_staff = $data_staff[8];} else {$phone_staff = '';}
if (isset($data_staff[9])) {$phone_display_staff = $data_staff[9];} else {$phone_display_staff = '';}
if (isset($data_staff[10])) {$post_staff = $data_staff[10];} else {$post_staff = '';}
if (isset($data_staff[11])) {$description_staff = $data_staff[11];} else {$description_staff = '';}
if (isset($data_staff[12])) {$photo_staff = $data_staff[12];} else {$photo_staff = '';}
if (isset($data_staff[13])) {$photo_display_staff = $data_staff[13];} else {$photo_display_staff = '';}
if (isset($data_staff[14])) {$active_staff = $data_staff[14];} else {$active_staff = '';}

if ($unit_id_staff == $id_staff) {// display current staff in this time
if ($active_staff == 'yes') {
$calendar_next .= '<span class="staff_list_time"><!--<i class="icon-user"></i>--><a href="'.$folder.$psep.'card-staff.php?view='.$id_staff.'" class="iframe" title="'.$lang['open_card_staff'].'">'.$name_staff.'</a></span>';

//======================================================ORDER STAFF
if (isset($_POST['dates_next'][$dd_next.'.'.$month_next.'.'.$year_next]))
{$all_staff_str .= $id_staff.'&&'.$name_staff.'&&'.$email_staff.'&&'.$phone_staff.'||';}

}
} //id staff = unit id staff

} //empty bd staff
} //count all staff

}//count current staff







$calendar_next .= '';

$calendar_next .= '</div>'; //staff

$calendar_next .= '</div>'; //time_data


$calendar_next .= '</label>';}

//=================TOTAL PRICE		
if (isset($_POST['dates_next'][$dd_next.'.'.$month_next.'.'.$year_next])) {$total_price_str .= $price_day.'&&';}		
	
} else { // ====================== HOURLY
	
$calendar_next .= '<a href="'.$script_name.'?obj='.$obj.'&amp;day='.$dd_next.'&amp;month='.$month_next.'&amp;year='.$year_next.'&amp;weekday='.$weekday_next.'#select_time" class="'.$a_class.'" title="'.$lang['active_day'].'">
<span class="'.$class_day.' sdd">'.$dd_next.'</span>
</a>';
}

$calendar_next .= '<div class="clear"></div>';
$calendar_next .= '</div>';
	

} else {
	
//===========================LOST DAYS
$calendar_next .= '<div class="lost_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd_next.'</span></span>
	<div class="clear"></div>
	</div>';	
}

	$calendar_next .= '</td>';
	
//-----------------------------/display days	
	
    $day_next++;
    $weekday_next++;	
}

if($weekday_next != 7) { $calendar_next .= '<td colspan="'.(7 - $weekday_next).'"></td>'; }



$calendar_next .= '</tbody></table>'; 






// display calendar...

?>