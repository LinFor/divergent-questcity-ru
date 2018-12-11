<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;} 

$price_day = '';

if (isset($_GET['cat'])) {$cat_url = '&amp;cat='.$_GET['cat']; $cat_url_alt = '?cat='.$_GET['cat'];} else {$cat_url = ''; $cat_url_alt = '';}
//if (isset($cat)) {$cat_url = '&amp;cat='.$cat;} else {$cat_url = '';}



$active_wd = '0';

$total_price_str = '';

$all_staff_str = '';


//$daily_total_spots_obj
//$daily_min_spots_obj
//$daily_max_spots_obj
//$daily_count_spots_obj



//===========================NO WORK DAYS
if (isset($working_days_obj) && !empty($working_days_obj)) {
$working_days_arr = explode('||',$working_days_obj); 
if (isset($working_days_arr[0])) {$Mon = $working_days_arr[0];} 
if (isset($working_days_arr[1])) {$Tue = $working_days_arr[1];}
if (isset($working_days_arr[2])) {$Wed = $working_days_arr[2];}
if (isset($working_days_arr[3])) {$Thu = $working_days_arr[3];}
if (isset($working_days_arr[4])) {$Fri = $working_days_arr[4];}
if (isset($working_days_arr[5])) {$Sat = $working_days_arr[5];}
if (isset($working_days_arr[6])) {$Sun = $working_days_arr[6];}

if (empty($working_days_arr[0])) {$Mon = '1&&0&&0';} 
if (empty($working_days_arr[1])) {$Tue = '1&&0&&0';}
if (empty($working_days_arr[2])) {$Wed = '1&&0&&0';}
if (empty($working_days_arr[3])) {$Thu = '1&&0&&0';}
if (empty($working_days_arr[4])) {$Fri = '1&&0&&0';}
if (empty($working_days_arr[5])) {$Sat = '1&&0&&0';}
if (empty($working_days_arr[6])) {$Sun = '1&&0&&0';}

$monarr = explode('&&',$Mon);
$tuearr = explode('&&',$Tue);
$wedarr = explode('&&',$Wed);
$thuarr = explode('&&',$Thu);
$friarr = explode('&&',$Fri);
$satarr = explode('&&',$Sat);
$sunarr = explode('&&',$Sun);

if (!isset($monarr[0])) {$monarr[0] = '1';} 
if (!isset($tuearr[0])) {$tuearr[0] = '1';} 
if (!isset($wedarr[0])) {$wedarr[0] = '1';} 
if (!isset($thuarr[0])) {$thuarr[0] = '1';} 
if (!isset($friarr[0])) {$friarr[0] = '1';} 
if (!isset($satarr[0])) {$satarr[0] = '1';} 
if (!isset($sunarr[0])) {$sunarr[0] = '1';} 

if (!isset($monarr[1])) {$monarr[1] = '0';} 
if (!isset($tuearr[1])) {$tuearr[1] = '0';} 
if (!isset($wedarr[1])) {$wedarr[1] = '0';} 
if (!isset($thuarr[1])) {$thuarr[1] = '0';} 
if (!isset($friarr[1])) {$friarr[1] = '0';} 
if (!isset($satarr[1])) {$satarr[1] = '0';} 
if (!isset($sunarr[1])) {$sunarr[1] = '0';} 

if (!isset($monarr[2])) {$monarr[2] = '0';} 
if (!isset($tuearr[2])) {$tuearr[2] = '0';} 
if (!isset($wedarr[2])) {$wedarr[2] = '0';} 
if (!isset($thuarr[2])) {$thuarr[2] = '0';} 
if (!isset($friarr[2])) {$friarr[2] = '0';} 
if (!isset($satarr[2])) {$satarr[2] = '0';} 
if (!isset($sunarr[2])) {$sunarr[2] = '0';} 

$nwd_arr = array($monarr[0],$tuearr[0],$wedarr[0],$thuarr[0],$friarr[0],$satarr[0],$sunarr[0]);
} else {$nwd_arr = array(1,1,1,1,1,1,1);}

//===========================CUSTOM NO WORK DAYS IN YEAR
if(isset($custom_date_obj) && empty($custom_date_obj) || $custom_date_obj == '&&') {
	
$date_arr = '';
$dp_arr = '';
$pm_arr = '';
$cprices_arr = '';	

} else {		

$custom_date_arr = explode('||', $custom_date_obj);

if (isset($custom_date_arr[0])) {$date_arr = explode('&&', $custom_date_arr[0]); array_pop($date_arr);}
if (isset($custom_date_arr[1])) {$dp_arr = explode('&&', $custom_date_arr[1]);}
if (isset($custom_date_arr[2])) {$pm_arr = explode('&&', $custom_date_arr[2]);}
if (isset($custom_date_arr[3])) {$cprice_arr = explode('&&', $custom_date_arr[3]);}

}

$nwdays_str = '';
$nwmonth_str = ''; 

if (array($date_arr)) {
for ($cd = 0; $cd < sizeof($date_arr); ++$cd) { 
$md_arr = explode('.', $date_arr[$cd]);



if($dp_arr[$cd] == 0) { 
if (isset($md_arr[0]) && isset($md_arr[1])) {$nwdays_str .= '#'.$md_arr[0].'.'.$md_arr[1].'&';}
} 
}//count
}
//====================================================================

if (!isset($_GET['day']) && !isset($_GET['month']) || $_GET['month'] == date('m') && !isset($_GET['day'])) {$_GET['day'] = date('d');} 



// local script
$self = $_SERVER['PHP_SELF'];

//check url month
if(isset($_GET['month'])) {
	$month = $_GET['month'];
}
else if(isset($_GET['viewmonth'])) {
	$month = $_GET['viewmonth']; 
}
else {
	$month = date('n');	
}
	
//check url year
if(isset($_GET['year'])) {
	$year = $_GET['year'];
}
else if(isset($_GET['viewyear'])) {
	$year = $_GET['viewyear'];
}
else {
	$year = date('Y');
}

if($month == '12') {
	$next_year = $year + 1;
}
else {
	$next_year = $year;
}
	


$first_of_month = mktime(0, 0, 0, $month, 1, $year);


$maxdays = date('t', $first_of_month);
$date_info = getdate($first_of_month);
$month = $date_info['mon'];
$year = $date_info['year'];


//if current month Januar, then next year +1
if($month == '01') 
	$last_year = $year-1;
else 
	$last_year = $year;

// end last month and early next month
$timestamp_last_month = $first_of_month - (24*60*60);
$last_month = date('n', $timestamp_last_month);


//if December, then next month = 1
if($month == '12') {$next_month = '01';}
else {$next_month = $month+1;}


$na_month = date('n')+2; 


if (strlen($last_month) == 1) {$last_month = '0'.$last_month;}
if (strlen($next_month) == 1) {$next_month = '0'.$next_month;}
if (strlen($na_month) == 1) {$na_month = '0'.$na_month;} 	 	
if (strlen($month) == 1) {$month = '0'.$month;} 
	
//$month = '02'; 	$next_month = '03'; $na_month = '04';
	
$calendar = '<table><tbody>';

$calendar .= '<tr><th colspan="7" class="t_month">';

$calendar .= '<h4>'.$lang_monts[$month].' '.$year.'</h4><div class="clear"></div>';

$calendar .= '</th></tr>';//------------






$calendar .= '<tr><th class="calendar_top" colspan="7">';
$calendar .= '<div class="tools_calendar">';

if ($year > date('Y') || $year >= date('Y') && $month > date('m')) {
$calendar .= '<a href="'.$self.'?obj='.$obj.'&amp;month='.$last_month.'&amp;year='.$last_year.$cat_url.$ofadm_url.'#ag_calendar" class="back_month" title="'.$lang['back_month'].'"><i class="icon-left-open"></i></a>';
} else {
$calendar .= '<span class="disable_back_month"><i class="icon-left-open"></i></span>';	
}







// select form =========================
$months = array($lang_monts['01'], $lang_monts['02'], $lang_monts['03'], $lang_monts['04'], $lang_monts['05'], $lang_monts['06'], $lang_monts['07'], $lang_monts['08'], $lang_monts['09'], $lang_monts['10'], $lang_monts['11'],$lang_monts['12']);


$calendar .= '<div class="select_cal" id="period">';
$calendar .= '<form action="'.$self.'#ag_calendar" method="get">';

$calendar .= '<input type="hidden" name="obj" value="'.$obj.'" />';

if (isset($_GET['cat'])) {
$calendar .= '<input type="hidden" name="cat" value="'.$_GET['cat'].'" />';
}

if (isset($_GET['reservation'])) {
$calendar .= '<input type="hidden" name="reservation" value="" />';
}
if (isset($_GET['edit'])) {
$calendar .= '<input type="hidden" name="edit" value="'.$_GET['edit'].'" />';	
}


if($month != date('m') || $year != date('Y')) {$calendar .= '<a href="'.$self.'?obj='.$obj.'&amp;month='.date('m').'&amp;year='.date('Y').$cat_url.$ofadm_url.'#ag_calendar" class="back_month_select" title="'.$lang['back_to_current_month'].'"><i class="icon-history"></i></a>';} else {
$calendar .= '<span><i class="icon-history"></i></span>';
}

$calendar .= '<select name="month">';
for($i=0; $i<=11; $i++) {
$mn = $i+1;	
if (strlen($mn) == 1) {$mn = '0'.$mn;} 	

$calendar .= '<option value="'.$mn.'" '; if($month == $i+1) {$calendar .='selected = "selected"';} $calendar .= '>'.$months[$i].'</option>';

}
$calendar .= '</select>';

$calendar .= '<select name="year">';
for($i=date('Y'); $i<=(date('Y')+2); $i++){
$selected = ($year == $i ? 'selected = "selected"' : '');	
$calendar .= '<option value="'.($i).'" '.$selected.'>'.$i.'</option>';}
$calendar .= '</select>
<button title="'.$lang['go_submit'].'"><i class="icon-cw"></i></button>';
$calendar .='</form>';

$calendar .= '<div class="clear"></div>
</div>'; 


//---------------------------------------------------------/select form


$calendar .= '<a href="'.$self.'?obj='.$obj.'&amp;month='.$next_month.'&amp;year='.$next_year.$cat_url.$ofadm_url.'#ag_calendar" class="next_month" title="'.$lang['next_month'].'"><i class="icon-right-open"></i></a>';

$calendar .= '<div class="clear"></div></div>';
$calendar .= '</th></tr>';
	

	
	
	
	
$calendar .= '<tr>
        <th>'.$lang_days_short[1].'</th>
        <th>'.$lang_days_short[2].'</th>
        <th>'.$lang_days_short[3].'</th>
        <th>'.$lang_days_short[4].'</th>
        <th>'.$lang_days_short[5].'</th>
        <th>'.$lang_days_short[6].'</th>
		<th>'.$lang_days_short[7].'</th>
</tr>';

//$calendar .=  '</tbody></table>';

//=============================================================================START BOOKING FORM

$action_form = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$action_form = str_replace('&', '&amp;', $action_form);

$calendar .=  '<form id="order" action="'.$action_form.'#order_form" method="post">';



//$calendar .=  '<table><tbody>';

$calendar .=  '<tr>'; 

// css class clear
$class = '';

$weekday = $date_info['wday'];

// format  1 - Monday, ..., 6 - Saturday
$weekday = $weekday-1; 
if($weekday == -1) $weekday=6;

// day as 1
$day = 1;

// width calendar
if($weekday > 0) 
	$calendar .= '<td colspan="'.$weekday.'"> </td>';
	
while($day <= $maxdays)
{
	// if Saturday, display new column
    if($weekday == 7) {
		$calendar .= '</tr><tr>';
		$weekday = 0;
	}
	
	$linkDate = mktime(0, 0, 0, $month, $day, $year);


	
	// today date

    if((($day < 10 and $day == date('d')) or ($day >= 10 and $day == date('d'))) and (($month < 10 and $month == date('m')) or ($month >= 10 and $month == date('m'))) and $year == date('Y')) {
		
		 $a_class = 'today';
		 
	//all days
	} else {
		$d = date('m/d/Y', $linkDate);

		$a_class = 'day';
	}
	
	//weekend days red color
	if($weekday == 5 || $weekday == 6) {$class_day='day-red';} else {$class_day='day';}	 
	


if (strlen($day) == 1) {$dd = '0'.$day;} else {$dd = $day;} // 01 - 09


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
	

    $calendar .= '<td class="caltd">';


//===========================ATIVE ONLY TWO MONTS

//$calendar .= $month.' / '.$na_month.' / '.$next_month;



if ($active_two_monts_obj == '1' && $month >= $na_month ||  
$active_two_monts_obj == '1' && $month != '01' && date('m') != '12' && $year > date('Y') ||
$active_two_monts_obj == '1' && $year > date('Y')
) 

{ $active_wd = '0';
$calendar .= '<div class="no_work_day tdd" title="'.$lang['not_active_dates'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>';	
}

	
//===========================NO WORK DAYS
else if ($nwd_arr[$weekday] == 0 && !preg_match('/#'.$dd.'.'.$month.'&/i', $amays_str)) {

if ($year < date('Y') || $year <= date('Y') && $month < date('m') || $year <= date('Y') && $month == date('m') && $day <= date('d')){

$calendar .= '<div class="lost_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>';} else {			
	
	
$calendar .= '<div class="no_work_day tdd" title="'.$lang['disabled_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>'; }
}	
	
//===========================CUSTOM NO WORK DAYS IN YEAR 
else if (preg_match('/#'.$dd.'.'.$month.'&/i', $nwdays_str)) {
	
if ($year < date('Y') || $year <= date('Y') && $month < date('m') || $year <= date('Y') && $month == date('m') && $day <= date('d')){

$calendar .= '<div class="lost_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>';} else {		
	
$calendar .= '<div class="no_work_day tdd" title="'.$lang['disabled_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>'; }	
}		
	
//===========================BUSY DAY 
else if (preg_match('/'.$dd.'.'.$month.'.'.$year.'.'.$weekday.'/i', $check_time_obj_str)) {

	
if ($year > date('Y') || $year >= date('Y') && $month > date('m') || $year >= date('Y') && $month == date('m') && $day >= date('d')){
// lost busy day
$calendar .= '<div class="busy_day tdd" title="'.$lang['day_busy'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>';


	
} else { // display busy day	 

$calendar .= '<div class="lost_busy_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
	</div>';

} // lost busy day
}	

//===========================ACTIVE DAYS
else if ($year > date('Y') || $year >= date('Y') && $month > date('m') || $year >= date('Y') && $month == date('m') && $day >= date('d')){	

	
$calendar .= '<div class="tdd">';

if(isset($_GET['day']) && $_GET['day'] == $dd) {$a_class = $a_class.' select_date';}

if($provide_obj == 'daily') { // ======================== DAILY

//=======================SHIFT PRICE WEEKDAYS & DATES
//$active_wd = '0';
$sign_wd = '0';
$shift_price_wd = '0';
$check_swd = '0';

$arr_wd = explode('||',$working_days_obj);

foreach ($arr_wd as $k_wd => $v_wd) {
$arr_d_wd = explode('&&',$v_wd);
	
if ($weekday == $k_wd) {  

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
if ($arr_dm[0] == $dd && $arr_dm[1] == $month) {

//$active_wd = $arr_active_cd[$cdp];
$sign_wd = $arr_sign_cd[$cdp];
$shift_price_wd = $arr_prise_cd[$cdp];	
} // date month ==
	
} // count dates 	
} // isset custom date
//} // no shift
//-------------------/shift WD



//if ($provide_obj == 'daily') {}	




if ($dd == date('d') && $month == date('m') && $year == date('Y') && $allow_today_obj == 0) { // allow today orders

$calendar .= '<div class="no_work_day" title="'.$lang['closed_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
</div>';	



} else {  



$calendar .= '<label>';

//==============cecked
$checked = '';
if (isset($_POST['dates'][$dd.'.'.$month.'.'.$year])) {
$checked = 'checked="checked"';	
} else {$checked = '';}


//========================================== dates spots
if($select_time_spots == '1') { 
if ($provide_obj == 'daily') {

$calendar .= '<div id="dd_'.$dd.$month.'" class="spots_day"><a href="'.$script_name.'?obj='.$obj.'&amp;day='.$dd.'&amp;month='.$month.'&amp;year='.$year.'&amp;weekday='.$weekday.$cat_url.$ofadm_url.'#ag_calendar" class="'.$a_class.'">
<span class="'.$class_day.' sdd">'.$dd.'</span>
</a></div>';

if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $dd.'.'.$month.'.'.$year.'.'.$weekday){
$calendar .= '<input type="hidden" name="dates['.$dd.'.'.$month.'.'.$year.']" value="'.$dd.'.'.$month.'.'.$year.'.'.$weekday.'" />';
}

$calendar .= '';

}//provide daily
} else {

//checkbox
$calendar .= '<input type="checkbox" name="dates['.$dd.'.'.$month.'.'.$year.']" value="'.$dd.'.'.$month.'.'.$year.'.'.$weekday.'" id="c'.$dd.'" class="ch_time" onclick="checkbg(\''.$dd.'\')" '.$checked.'/>';
$calendar .= '<div class="'.$a_class.' h_act" id="b'.$dd.'"><span class="'.$class_day.' sdd">'.$dd.'</span></div>';
}

$calendar .= '<div class="time_data">
<div class="price_inf">'.$lang['price'].': ';



$calendar .= $curr_left;

$calendar .= '<span class="t_prise">';

//==============================price



if ($provide_obj == 'daily') { 
$price_day = $daily_price_obj; 
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $dd.'.'.$month.'.'.$year.'.'.$weekday){
$sel_s_price = $daily_price_obj;
}
}


if (!empty($fix_price_obj) || $fix_price_obj != '0') { 
//shift wd
if ($sign_wd == '+'){$fix_price_obj = $fix_price_obj + $shift_price_wd;}
if ($sign_wd == '-' && $fix_price_obj > $shift_price_wd){$fix_price_obj = $fix_price_obj - $shift_price_wd;} 
//shift wd 

/////////////////////////////////////////////////////////////////
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $dd.'.'.$month.'.'.$year.'.'.$weekday){
if ($provide_obj == 'daily') { $sel_s_price = $fix_price_obj; }	
}
//===============================================================

$calendar .= $lang['fix_price'].': <span class="ag_price">'.$fix_price_obj.'</span>';  

} else {
	
//shift wd	
if ($sign_wd == '+'){$price_day = $price_day + $shift_price_wd;}
if ($sign_wd == '-' && $price_day > $shift_price_wd){$price_day = $price_day - $shift_price_wd;} 
//shift wd
	
/////////////////////////////////////////////////////////////////
if ($select_day.'.'.$select_month.'.'.$select_year.'.'.$select_weekday == $dd.'.'.$month.'.'.$year.'.'.$weekday){
if ($provide_obj == 'daily') { $sel_s_price = $price_day; }	
}
//===============================================================
	
$calendar .= '<span class="ag_price">'.$price_day.'</span>'; 

}



$calendar .= '</span>';

$calendar .= $curr_right;

$calendar .= '<div class="clear"></div>';

$calendar .= '</div>';

//===============================================================LEFT SPOTS
if ($select_time_spots == '1') {
if ($provide_obj == 'daily') {	
$str_spots = '0';
///////////////////////

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



//if (!empty($time_obj)) {

if ($time_obj == $dd.'.'.$month.'.'.$year.'.'.$weekday) {

$str_spots += $spots_ord_obj;

//echo $str_spots; // FOR JS

$d_left_spots = $daily_total_spots_obj - $str_spots;


} 



//============LEFT SPOTS

//} 


} //empty lines
} //count order lines
} //check file bd
///////////////////////


if ($str_spots == '0') {
$calendar .= '<div class="dspots">'.$lang['vacancy_spots'].': <span class="ag_left_spots">'.$daily_total_spots_obj.'</span></div>';
} else {
	if ($d_left_spots < 0) {$d_left_spots = 0;}
$calendar .= '<div class="dspots">'.$lang['vacancy_spots'].': <span class="ag_left_spots" id="spots_'.$dd.$month.'">'.$d_left_spots.'</span></div>'; 

if (!isset($edit_true)) {
$calendar .= '
<script>
var ddbl = document.getElementById("dd_'.$dd.$month.'"); 
var lspots = document.getElementById("spots_'.$dd.$month.'").innerHTML; 
if (lspots <= 0) {
ddbl.removeAttribute("class");
ddbl.setAttribute("class","busy_day tdd");
}
</script>
';}


}



} //provide
} //spots
//===============================================================/LEFT SPOTS




//=========================================================STAFF
$calendar .= '<div class="title_staff_time">'.$lang['staff'].' <i class="icon-down-big"></i></div>';

$calendar .= '<div class="staff_time">';

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
$calendar .= '<span class="staff_list_time"><!--<i class="icon-user"></i>--><a href="'.$folder.$psep.'card-staff.php?view='.$id_staff.'" class="iframe" title="'.$lang['open_card_staff'].'">'.$name_staff.'</a></span>';

//======================================================ORDER STAFF
if (isset($_POST['dates'][$dd.'.'.$month.'.'.$year])) 
{$all_staff_str .= $id_staff.'&&'.$name_staff.'&&'.$email_staff.'&&'.$phone_staff.'||';} 


}
} //id staff = unit id staff

} //empty bd staff
} //count all staff

}//count current staff







$calendar .= '';

$calendar .= '</div>'; //staff

$calendar .= '</div>'; //time_data


$calendar .= '</label>';  }
	
//=================TOTAL PRICE	
if (isset($_POST['dates'][$dd.'.'.$month.'.'.$year])) {$total_price_str .= $price_day.'&&';}	
	
} else { // ====================== HOURLY
	
$calendar .= '<a href="'.$script_name.'?obj='.$obj.'&amp;day='.$dd.'&amp;month='.$month.'&amp;year='.$year.'&amp;weekday='.$weekday.$cat_url.$ofadm_url.'#ag_calendar" class="'.$a_class.'">
<span class="'.$class_day.' sdd">'.$dd.'</span>
</a>';
}

$calendar .= '<div class="clear"></div>';
$calendar .= '</div>';
	

} else {
	
//===========================LOST DAYS
$calendar .= '<div class="lost_day tdd" title="'.$lang['lost_day'].'">
	<span class="bsdd"><span class="sdd">'.$dd.'</span></span>
	<div class="clear"></div>
	</div>';	
}

	$calendar .= '</td>';
	
//-----------------------------/display days	
	
    $day++;
    $weekday++;	
}

if($weekday != 7) { $calendar .= '<td colspan="'.(7 - $weekday).'"></td>'; }



$calendar .= '</tbody></table>'; 






// display calendar...

?>