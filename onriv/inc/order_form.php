<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;} ?>

<div id="order_form">

<?php



$spots_for_edit = '0';

$max_spots_inp = '';

if(!isset($totlal_spots_ord)) {$totlal_spots_ord = '';} 

if (!empty($select_time_spots) && $all_spots_obj == '0' || !empty($select_time_spots) && empty($all_spots_obj)) {
	

	
if (empty($left_spots_ord)) {
	
if ($max_spots_ord == '0') {$max_spots_inp = $totlal_spots_ord;} else { $max_spots_inp = $max_spots_ord; }
	
	} else {	
	
if ($max_spots_ord == '0') {$max_spots_inp = $left_spots_ord;} else {$max_spots_inp = $max_spots_ord;}

if ($max_spots_ord > $left_spots_ord) {$max_spots_inp = $left_spots_ord;}

}

}

 ///// DAILY
if ($provide_obj == 'daily') {$url_time = '';}//provide daily
//-------------------------------------------------------------

if ($total_spots_ord != '0' && !empty($total_spots_ord)) {$spots_for_edit = '1';}	


//==========================================================ALL SPOTS
if (!empty($all_spots_obj) && $all_spots_obj != '0') {
	
if ($max_spots_ord == '0') {$max_spots_inp = $all_spots_obj;} else {$max_spots_inp = $max_spots_ord;}

}
//===========================================================MIN SPOTS

if(empty($max_spots_inp)) {$max_spots_inp = $total_spots_ord;}

if ($min_spots_ord > $max_spots_inp) {$min_spots_ord = $max_spots_inp;}

//echo $max_spots_inp.' - max<br />'.$min_spots_ord .' - min';

unset($ERROR);


$order_test = '0';
$stop_booking = '0';
$discount = '0';
$add_discount = '';
$dval = '';
$add_spots = '1';


//===========================ID
$rnd_num = rand(10, 99);
$id_prefix = 'order';
$id = $id_prefix.'_'.date('d_m_Y_H_i_s').'_'.$rnd_num;
$time_current = date('d_m_Y_H_i_s');
//===========================/ID
if(!isset($onriv_take)) {die();}
$file_name = $folder.$psep.'data/order.dat'; 
$new_line = '';

//===================================================================DISCOUNT
$promo_code = '';
$discount_val = '';
$discount_sim = '';
$summp = '';


if(!empty($discount_obj)) {
$discount_arr =	explode('||', $discount_obj);
if (isset($discount_arr[0])) {$promo_code = $discount_arr[0];}	
if (isset($discount_arr[1])) {$discount_val = $discount_arr[1];}	
if (isset($discount_arr[2])) {$discount_sim = $discount_arr[2];}	
}



//==============================VALUE INPUTS
$val_name = $lang['name']; $val_name1 = $lang['name']; 
$val_mail = $lang['mail_temp']; $val_mail1 = $lang['mail_temp'];
$val_phone = $lang['phone']; $val_phone1 = $lang['phone'];
$val_comment = $lang['comment']; $val_comment1 = $lang['comment'];


$add_client = '';
$add_mail = '';
$add_phone = '';
$add_comment = '';


if ($min_spots_ord != '0') {$add_spots = $min_spots_ord;}



//==============================CHECK SUBMIT FORM
if(isset($_POST['booking'])) {
	

if ($captcha == '1' && !isset($edit_true) && !isset($_GET['reservation'])) {
if(isset($_POST['keystring']) && isset($_SESSION['captcha_keystring']) && strtolower($_SESSION['captcha_keystring']) != strtolower($_POST['keystring'])) {$ERROR['captcha'] = $lang['error_captcha'];} 
}	
	

//-----------TIME/DATE HOURLY/DAILY
$add_time = '';
if($provide_obj == 'daily') { 





if (isset($_POST['dates'])) {
if (!empty($_POST['dates'])) {	
$_POST['dates'] = array_diff($_POST['dates'], array(''));	
$add_time .= implode('||', $_POST['dates']);
$sep_dd = '||'; } //no empty


} else { $sep_dd = ''; 
if (!isset($_POST['dates_next'])) {$ERROR['dates'] = $lang['error_select_dates']; }
}

if (isset($_POST['dates_next'])) {
if (!empty($_POST['dates_next'])) {	
$_POST['dates_next'] = array_diff($_POST['dates_next'], array(''));	
$add_time .= $sep_dd.implode('||', $_POST['dates_next']);} //no empty
 
} else { 
if (!isset($_POST['dates'])) {$ERROR['dates'] = $lang['error_select_dates']; }
}

} else {  //hourly
	
if (isset($_POST['time'])) {
if (!empty($_POST['time'])) {	
$_POST['time'] = array_diff($_POST['time'], array(''));	
$add_time .= implode('||', $_POST['time']);} //no empty
 
} else {
	
$ERROR['time'] = $lang['error_select_time'];

} //isset post time 
 	
} //provide

$add_time = htmlspecialchars($add_time,ENT_QUOTES);
$add_time = str_replace(array('::', '&&'), '', trim($add_time));
$add_time = str_replace("\'",'',$add_time);
$add_time = str_replace("'",'',$add_time);	


//-----------ID Obj
$id_obj = $obj;

//-----------Date
if($provide_obj == 'daily') { $add_date = '0';} else {
$add_date = $_GET['day'].'.'.$month.'.'.$year.'.'.$_GET['weekday']; }

//-----------Name OBJ
if (!empty($name_cat_disp)) { $add_name_obj = $name_obj.'&&'.$name_cat_disp; } else { $add_name_obj = $name_obj.'&&'; }


//-----------Client

$_POST['name'] = str_replace(array('::', '|', '&&'), '', trim($_POST['name']));
$_POST['name'] = str_replace("\'",'',$_POST['name']);
$_POST['name'] = str_replace("'",'',$_POST['name']);
$_POST['name'] = preg_replace('/\\\\+/','',$_POST['name']); 
$_POST['name'] = preg_replace("|[\r\n]+|", " ", $_POST['name']); 
$_POST['name'] = preg_replace("|[\n]+|", " ", $_POST['name']); 
$_POST['name'] = htmlspecialchars($_POST['name'],ENT_QUOTES);
if(empty($_POST['name']) || $_POST['name'] == $val_name1 || $_POST['name'] == $lang['error_name_empty']) 
{$ERROR['name'] = $lang['error_name_empty'];}
$add_client = $_POST['name'];

//-----------Mail
if (isset($_POST['mail'])) {
$_POST['mail'] = str_replace(array('::', '||', '**'), '', trim($_POST['mail']));
$_POST['mail'] = str_replace("\'",'',$_POST['mail']);
$_POST['mail'] = str_replace("'",'',$_POST['mail']);
$_POST['mail'] = preg_replace('/\\\\+/','',$_POST['mail']); 
$_POST['mail'] = preg_replace("|[\r\n]+|", "", $_POST['mail']); 
$_POST['mail'] = preg_replace("|[\n]+|", "", $_POST['mail']); 
$_POST['mail'] = htmlspecialchars($_POST['mail'],ENT_QUOTES);

if(empty($_POST['mail']) || $_POST['mail'] == $val_mail1 || $_POST['mail'] == $lang['error_mail_empty']) {$ERROR['mail'] = $lang['error_mail_empty'];} 
else if(!preg_match('/.+@.+\..+/i', $_POST['mail'])) {$ERROR['mail'] = $_POST['mail']. ' &larr; ' .$lang['error_mail_invalid'];}

$_POST['mail'] = str_replace('' .$lang['error_mail_invalid'].'', '', $_POST['mail']); 
$_POST['mail'] = str_replace(' ← ', '', $_POST['mail']); 
if ($_POST['mail'] != $val_mail && $_POST['mail'] != $lang['error_mail_empty']) 
{ $add_mail = $_POST['mail']; }
} //isset post mail

//-----------Phone
if (isset($_POST['phone'])) {
$_POST['phone'] = str_replace(array('::', '||', '**', '(', ')', '-', ' '), '', trim($_POST['phone']));
if(empty($_POST['phone']) || $_POST['phone'] == $val_phone1 || $_POST['phone'] == $lang['error_phone_empty']) 
{$ERROR['phone'] = $lang['error_phone_empty'];} 
else if (preg_match("/[^0-9+()-]/u", $_POST['phone'])) {$ERROR['phone'] = $_POST['phone']. ' &larr; ' .$lang['error_phone_invalid'];}	
$_POST['phone'] = htmlspecialchars($_POST['phone'],ENT_QUOTES);
$_POST['phone'] = str_replace(''.$lang['error_phone_invalid'].'', '', $_POST['phone']); 
$_POST['phone'] = str_replace(' ← ', '', $_POST['phone']); 
if ($_POST['phone'] != $val_phone && $_POST['phone'] != $lang['error_phone_empty']) 
{ $add_phone = $_POST['phone']; }
} //isset post phone
	
//-----------Comment	
if (isset($_POST['comment'])) {
$_POST['comment'] = str_replace(array('::', '||', '**', '&&'), '', trim($_POST['comment']));
$_POST['comment'] = str_replace("\'",'',$_POST['comment']);
$_POST['comment'] = str_replace("'",'',$_POST['comment']);
$_POST['comment'] = preg_replace('/\\\\+/','',$_POST['comment']); 
$_POST['comment'] = htmlspecialchars($_POST['comment'],ENT_QUOTES);
$_POST['comment'] = preg_replace("|[\r\n]+|", "<br />", $_POST['comment']); 
$_POST['comment'] = preg_replace("|[\n]+|", "<br />", $_POST['comment']); 
if($_POST['comment'] != $lang['comment']){	
$add_comment = $_POST['comment'];}
} //isset post comment

	
//-----------IP Client
$add_ip = $_SERVER['REMOTE_ADDR'];

//-----------Spots

if (isset($_POST['spots'])) {$add_spots = $_POST['spots'];} else {	
if (empty($select_time_spots) && $all_spots_obj == '0' || empty($select_time_spots) && empty($all_spots_obj)) 
{ $add_spots = '1'; } else {$add_spots = '';}
}

if (!empty($select_time_spots)) {


if ($add_spots > $max_spots_inp) {$ERROR['spots'] = $lang['error_max_spots'];}
	
if ($max_spots_ord != '0') {
if ($add_spots > $max_spots_ord) {$ERROR['spots'] = $lang['error_max_spots'];}
} 


if ($min_spots_ord > '1') {
if ($add_spots < $min_spots_ord) {$ERROR['spots'] = $lang['error_min_spots'];}
}


} 

if ($all_spots_obj != '0' && !empty($all_spots_obj)) {
if ($add_spots > $max_spots_inp) {$ERROR['spots'] = $lang['error_max_spots'];} 
}




if (empty($add_spots)) {$ERROR['spots'] = $lang['error_empty_spots'];}

if($count_spots == '1' || $all_spots_obj != '0' && !empty($all_spots_obj)) {$ispots = $add_spots;} else {$ispots = '1';}

if (preg_match("/[^0-9]/u", $add_spots)) {$ERROR['spots'] = $lang['error_simbol_spots'];}



//====================================================================COUNT TOTAL PRICE

$total_price_str = str_replace("-",'0.0999',$total_price_str);

if (!empty($fix_price_obj) || $fix_price_obj != '0') { $total_price = $fix_price_obj; } else {
$total_price = '0';
$total_arr = explode('&&', $total_price_str); array_pop($total_arr);

for ($cp = 0; $cp < sizeof($total_arr); ++$cp) {
	
if($total_arr[$cp] == '0.0999')	{ 
$total_price = '0.0999'; break;
} else { $total_price += $total_arr[$cp]; }

}
}

if($total_price != '0.0999') {
$total_price = $total_price*$ispots;
$total_price = round($total_price, 2);
}


 



//--------------------------------discount value minus

$price_befote = $total_price;

//---

if($total_price != '0.0999') { // var price
if($total_price != '0') { // free price	

if (isset($_POST['discount']) && !empty($promo_code)) {
$dval = $_POST['discount'];


if($_POST['discount'] == $promo_code) {
	
$discount = '1';

if ($discount_sim == '%') {
$summp = $total_price*$discount_val/100; 
$summp = round($summp, 2);
$total_price = $total_price - $summp; 
} 
if ($discount_sim == '=') {$total_price = $total_price - $discount_val;}


$add_discount = $price_befote.'||'.$discount_val.'||'.$discount_sim.'||'.$summp; //to bd

} //promo code true
else {
if(!empty($_POST['discount'])) {$ERROR['discount'] = $lang['error_promo_code'];}
} //promo code false	

}//post discount
//echo '<div class="log">'.$total_price.'</div>';

} // no free price
} //no varible price




//-----------Price
$add_price = $total_price;	
if($add_price != '0.0999') {
$add_price = round($add_price, 2); }
	
//-----------Currensy	
$add_currency = $curr_code;

//-----------Status
$add_status = '0';
if (isset($replace_status)) {$add_status = $replace_status;}

//-----------Staff
$all_staff_arr = explode('||', $all_staff_str);
array_pop($all_staff_arr);
$all_staff_arr = array_unique($all_staff_arr);
$order_staff_str = implode('||',$all_staff_arr);
$add_staff = $order_staff_str;


	
//==============================VALUE INPUTS AFTER SUBMIT	
if (!empty($_POST['name'])) {$val_name = $_POST['name'];}
if (!empty($_POST['mail'])) {$val_mail = $_POST['mail'];}
if (!empty($_POST['phone'])) {$val_phone = $_POST['phone'];}
if (!empty($_POST['comment'])) {$val_comment = $_POST['comment'];}

} //---------------/check form



//no select payment method
if (isset($_POST['payment_online']) && !isset($_POST['payment'])) 
{ $ERROR['payment_select'] = $lang['select_payment']; }





if(isset($_POST['booking']) && !isset($ERROR)) { 


	
if ($order_test == '1') {	
echo '<div class="log"><h3>Order detail</h3>
<b>ID order:</b> '.$id.'<br />
<b>Price:</b> '.$total_price.' '.$add_currency.'<br />
<b>Status:</b> '.$add_status.'<br />
<b>Spots control:</b> '.$spots_for_edit.'<br />
<b>Spots:</b> '.$add_spots.'<br />
<b>Date:</b> '.$add_date.'<br />
<b>Object:</b> '.$add_name_obj.'<br />
<b>ID Object:</b> '.$id_obj.'<br />
<b>Time:</b> '.$add_time.'<br />
<b>Client:</b> '.$add_client.'<br />
<b>Cl mail:</b> '.$add_mail.'<br />
<b>Cl phone:</b> '.$add_phone.'<br />
<b>Cl IP:</b> '.$add_ip.'<br />
<b>Staff:</b> '.$add_staff.'
</div>';	
} 

//====================================================================ADD ORDER TO BD
$line_data_add = $id.'::'.$id_obj.'::'.$add_name_obj.'::'.$add_date.'::'.$add_time.'::'.$add_spots.'::'.$add_client.'::'.$add_phone.'::'.$add_mail.'::'.$add_comment.'::'.$add_ip.'::'.$add_status.'::'.$add_price.'::'.$add_currency.'::'.$add_staff.'::'.$add_discount.'::'.$spots_for_edit.'::';	
//======================Add process

//=====================================================================CHECK BOOKING DATES/TIMES

//$check_date_obj_str
//$check_time_obj_str	

$number_order_arr = explode('_',$id);
if(isset($number_order_arr[5]) && isset($number_order_arr[6]) && isset($number_order_arr[7]))
{$number_order = $number_order_arr[5].$number_order_arr[6].$number_order_arr[7];} else {$number_order = '';}


$ch_date = $add_date;
$ch_time_arr = explode('||',$check_time_obj_str); array_pop($ch_time_arr);
$select_time_arr = explode('||',$add_time); 

$disp_obj_cat_arr = explode('&&', $add_name_obj);
if (isset($disp_obj_cat_arr[0])) {$name_obj_done = $disp_obj_cat_arr[0];} else {$name_obj_done = '';}
if (isset($disp_obj_cat_arr[1])) {$name_cat_done = $disp_obj_cat_arr[1];} else {$name_cat_done = '';}

if($provide_obj == 'daily') {  // ---------------------------- Daily




$diff_time = array_intersect($ch_time_arr, $select_time_arr); 


if(!empty($diff_time)) {
	
if ($time_obj_cl_arr == $select_time_arr) {	} else { //===========EDIT
$stop_booking = '1';	
//=============================================DISPLAY BOOKING DATES IF dates are already busy DAILY
echo '<div class="stop_booking error_mess"><h4>'.$lang['dates_busy'].'</h4><ul>';
$db_day = '';
$db_month = '0';
$db_year = '';
foreach ($diff_time as $dk => $dv) {
$dv_arr = explode('.', $dv);
if (isset($dv_arr[0])) {$db_day = $dv_arr[0];}
if (isset($dv_arr[1])) {$db_month = $dv_arr[1];}
if (isset($dv_arr[2])) {$db_year = $dv_arr[2];}
echo '<li>'.$db_day.' '.$lang_monts_r[$db_month].' '.$db_year.'</li>';
}	
echo '</ul></div>'; } //=============EDIT


}//empty 

else { //================================================== DISPLAY ORDER DAILY


if (!isset($edit_true)) { //===========EDIT

echo '<div class="shadow_back"></div>';
echo '<div id="ok_order">';	
echo '<div class="print_order">';

echo '<h4>'.$add_client.', '.$lang['order_ok_title'].'</h4>';

echo '<a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" class="exit_order_list_top" title="'.$lang['close'].'"><i class="icon-ok"></i></a>';

echo '<table><tbody>';

echo '<tr><th>'.$lang['order_number'].':</th><td><b>'.$number_order.'</b></td></tr>';


$disp_obj_cat_arr = explode('&&', $add_name_obj);
echo '<tr><th>'.$lang['obj_name'].':</th><td>'.$disp_obj_cat_arr[0];
if (!empty($disp_obj_cat_arr[1])) {echo '<br /><small>'.$disp_obj_cat_arr[1].'</small>';}
echo '</td></tr>';



echo '<tr><th>'.$lang['booking_dates'].':</th><td>'; 
$b_day = '';
$b_month = '0';
$b_year = '';
foreach ($select_time_arr as $bk => $bv) {
$bv_arr = explode('.', $bv);
if (isset($bv_arr[0])) {$b_day = $bv_arr[0];}
if (isset($bv_arr[1])) {$b_month = $bv_arr[1];}
if (isset($bv_arr[2])) {$b_year = $bv_arr[2];}
echo '<li>'.$b_day.' '.$lang_monts_r[$b_month].' '.$b_year.'</li>';
}	
echo'</td></tr>';

if(!empty($add_mail))
{echo '<tr><th>'.$lang['mail'].':</th><td>'.$add_mail.'</td></tr>';}

if(!empty($add_phone))
{echo '<tr><th>'.$lang['phone'].':</th><td>'.$add_phone.'</td></tr>';}

//SPOTS
if($add_spots > 1) {
if ($add_price != '0.0999') {
	
$price_befote = $price_befote/$add_spots;
	
echo '<tr><th>'.$lang['spots'].':</th><td><b>'.$add_spots.'</b> x '.$curr_left_code.' '.$price_befote.' '.$curr_right_code.'</td></tr>';
} else {
echo '<tr><th>'.$lang['spots'].':</th><td><b>'.$add_spots.'</b></td></tr>';} // variable price
} //spots > 1

//DISCOUNT DISPLAY
if($discount == '1') 
{echo '<tr><th>'.$lang['your_discount'].':</th><td>'.$curr_left_code.' ';

if ($discount_sim == '%') {echo $price_befote*$add_spots.' - <b>'.$summp.'</b> ('.$discount_val.$discount_sim.')';} else 
{echo $price_befote*$add_spots.' - <b>'.$discount_val.'</b>';}

echo ' '.$curr_right_code.'</td></tr>';
}

//==price
if ($add_price == '0.0999') {
echo '<tr><th>'.$lang['to_pay'].':</th><td><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($add_price == 0) {
echo '<tr><th>'.$lang['to_pay'].':</th><td><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
echo '<tr><th>'.$lang['to_pay'].':</th><td>'.$curr_left_code.' <b>'.$add_price.'</b> '.$curr_right_code.'</td></tr>';
}
//==


if (!empty($add_comment)){
echo '<tr><th>'.$lang['comment'].':</th><td><div class="add_comment">'.$add_comment.'<div class="fade_bl"></div></div></td></tr>';}



//================================ROW CONTACTS INFO
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {} else {
echo '<tr>
<td colspan="2" class="contacts">

<table class="contact_info">';
if(isset($org_phone) && !empty($org_phone)) {echo '<tr><td><i class="icon-phone"></i></td><td>'.$org_phone.'</td></tr>';}
if(isset($org_mail) && !empty($org_mail)) {echo '<tr><td><i class="icon-mail-2"></i></td><td>'.$org_mail.'</td></tr>';}
echo '<tr><td><i class="icon-globe"></i></td><td>www.'.$host_name.' ('.$org_name.')</td></tr>';
echo '</table>

<div class="clear"></div>
</td></tr>';
}
//------------------------------------------------



echo '</tbody></table>';


if (isset($_POST['payment_online'])) { echo '<div class="done_mess_order"><span><i class="icon-spin5 animate-spin"></i> '.$lang['payment_wait'].'...</span></div>'; 

} else {

if ($sent_mail == '1' && !empty($add_mail)) {
echo '<div class="done_mess_order"><span>'.$lang['done_order_mail_mess'].'.</span>';
if ($confirm_mail == '1') {echo '<span class="confirm_mail">'.$lang['confirm_order_mail_mess'].'.</span>';}
echo '</div>';
} 



echo '<div class="bot_order">
<a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" class="exit_order_list"><i class="icon-ok-squared"></i> '.$lang['close'].'</a>
<a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" id="to_print" class="print_go"><i class="icon-print-2"></i> '.$lang['print'].'</a>
<div class="clear"></div>
</div>';

} //payment

echo '</div>';		
echo '</div>';	


echo'<script>
//var anc = window.location.hash.replace("#","");
setTimeout (function() {document.getElementById("ag_arrow_top").click();}, 200);
</script>';

}//===========EDIT

}//----------------------------------------------------/display daily order


} else { // --------------------------------------------------------------- Hourly
	
$diff_time = array_intersect($ch_time_arr, $select_time_arr); 
if(!empty($diff_time)) {
	
if ($time_obj_cl_arr == $select_time_arr) {	} else { //========EDIT	
$stop_booking = '1';	
//=============================================DISPLAY BOOKING DATES IF dates are already busy HOURLY
echo '<div class="stop_booking error_mess"><h4>'.$lang['times_busy'].'</h4><ul>';
$db_hs = '';
$db_ms = '';
$db_he = '';
$db_me = '';
foreach ($diff_time as $tk => $tv) {
$tv_arr = explode(':', $tv);
if (isset($tv_arr[0])) {$db_hs = $tv_arr[0];}
if (isset($tv_arr[1])) {$db_ms = $tv_arr[1];}
if (isset($tv_arr[2])) {$db_he = $tv_arr[2];}
if (isset($tv_arr[3])) {$db_me = $tv_arr[3];}
echo '<li>'.$db_hs.':'.$db_ms; 
if (!empty($db_he) && $db_he != 'XX') {echo ' - '.$db_hs.':'.$db_ms;}
echo '</li>';

}	
echo '</ul></div>';
} //======================EDIT


}//empty 	
else { //================================================== DISPLAY ORDER HOURLY


if (!isset($edit_true)) { //=======================EDIT

echo '<div class="shadow_back"></div>';
echo '<div id="ok_order">';	
echo '<div class="print_order">';

echo '<h4>'.$add_client.', '.$lang['order_ok_title'].'</h4>';

echo '<a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" class="exit_order_list_top" title="'.$lang['close'].'"><i class="icon-ok"></i></a>';

echo '<table><tbody>';

echo '<tr><th>'.$lang['order_number'].':</th><td><b>'.$number_order.'</b></td></tr>';

$disp_obj_cat_arr = explode('&&', $add_name_obj);
echo '<tr><th>'.$lang['obj_name'].':</th><td>'.$disp_obj_cat_arr[0];
if (!empty($disp_obj_cat_arr[1])) {echo '<br /><small>'.$disp_obj_cat_arr[1].'</small>';}
echo '</td></tr>';


$disp_date_arr = explode('.', $add_date);
if (isset($disp_date_arr[0])) {$b_day = $disp_date_arr[0];}
if (isset($disp_date_arr[1])) {$b_month = $disp_date_arr[1];}
if (isset($disp_date_arr[2])) {$b_year = $disp_date_arr[2];}

echo '<tr><th>'.$lang['date'].':</th><td><b>'.$b_day.' '.$lang_monts_r[$b_month].' '.$b_year.'</b></td></tr>';

echo '<tr><th>'.$lang['booking_times'].':</th><td>'; 

$b_hs = '';
$b_ms = '';
$b_he = '';
$b_me = '';
$start_time_str = '';
foreach ($select_time_arr as $bk => $bv) {
$tv_arr = explode(':', $bv);
if (isset($tv_arr[0])) {$b_hs = $tv_arr[0];}
if (isset($tv_arr[1])) {$b_ms = $tv_arr[1];}
if (isset($tv_arr[2])) {$b_he = $tv_arr[2];}
if (isset($tv_arr[3])) {$b_me = $tv_arr[3];}
echo '<li>'.$b_hs.':'.$b_ms; 
$start_time_str .= $b_hs.':'.$b_ms.'||';
if (!empty($b_he) && $b_he != 'XX') {echo ' - '.$b_he.':'.$b_me;}
echo '</li>';
}	
echo'</td></tr>';





if(!empty($add_mail))
{echo '<tr><th>'.$lang['mail'].':</th><td>'.$add_mail.'</td></tr>';}

if(!empty($add_phone))
{echo '<tr><th>'.$lang['phone'].':</th><td>'.$add_phone.'</td></tr>';}

//============================================BUSSY SPOTS


if($add_spots > 1) {
	
if(!empty($select_time_spots) || $all_spots_obj != '0' && !empty($all_spots_obj)) {$price_befote = $price_befote/$add_spots;}


echo '<tr><th>'.$lang['spots'].':</th><td><b>'.$add_spots.'</b>';

if($total_price != '0.0999') {
if ($count_spots == '1') { // count spots yes
echo ' x '.$curr_left_code.' '.$price_befote.' '.$curr_right_code.'';
}
if ($all_spots_obj != '0' && !empty($all_spots_obj)) { // spots in all time
echo ' x '.$curr_left_code.' '.$price_befote.' '.$curr_right_code.'';
}
}//var price
echo '</td></tr>';

}


//DISCOUNT DISPLAY

if($discount == '1') {
echo '<tr><th>'.$lang['your_discount'].':</th><td>'.$curr_left_code.' ';

if ($discount_sim == '%') { //====== DISCOUNT %


echo $total_price+$summp.' - <b>'.$summp.'</b> ('.$discount_val.$discount_sim.')';


} else { //======= DISCOUNT =
	

echo $total_price+$discount_val.' - <b>'.$discount_val.'</b>';

} // discount summ
 
echo ' '.$curr_right_code.'</td></tr>';
}//discount yes

//==price
if ($add_price == '0.0999') {
echo '<tr><th>'.$lang['to_pay'].':</th><td><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($add_price == 0) {
echo '<tr><th>'.$lang['to_pay'].':</th><td><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
echo '<tr><th>'.$lang['to_pay'].':</th><td>'.$curr_left_code.' <b>'.$add_price.'</b> '.$curr_right_code.'</td></tr>';
}
//==

//echo '<tr><th>'.$lang['currency'].':</th><td>'.$add_currency.'</td></tr>';

if (!empty($add_comment)){
echo '<tr><th>'.$lang['comment'].':</th><td><div class="add_comment">'.$add_comment.'<div class="fade_bl"></div></div></td></tr>';}



//================================ROW CONTACTS INFO
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {} else {
echo '<tr>
<td colspan="2" class="contacts">

<table class="contact_info">';
if(isset($org_phone) && !empty($org_phone)) {echo '<tr><td><i class="icon-phone"></i></td><td>'.$org_phone.'</td></tr>';}
if(isset($org_mail) && !empty($org_mail)) {echo '<tr><td><i class="icon-mail-2"></i></td><td>'.$org_mail.'</td></tr>';}
echo '<tr><td><i class="icon-globe"></i></td><td>www.'.$host_name.' ('.$org_name.')</td></tr>';
echo '</table>';

echo '<div class="clear"></div>
</td></tr>';
}
//------------------------------------------------

echo '</tbody></table>';

if (isset($_POST['payment_online'])) {echo '<div class="done_mess_order"><span><i class="icon-spin5 animate-spin"></i>  '.$lang['payment_wait'].'...</span></div>';} else { //payment
	
	
if ($sent_mail == '1' && !empty($add_mail)) {
echo '<div class="done_mess_order"><span>'.$lang['done_order_mail_mess'].'.</span>';
if ($confirm_mail == '1') {echo '<span class="confirm_mail">'.$lang['confirm_order_mail_mess'].'.</span>';}
echo '</div>';
} 



echo '<div class="bot_order">
<a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" class="exit_order_list"><i class="icon-ok-squared"></i> '.$lang['close'].'</a>
<a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" id="to_print" class="print_go"><i class="icon-print-2"></i> '.$lang['print'].'</a>
<div class="clear"></div>
</div>';

} //payment


echo '</div>';		
echo '</div>';	



echo'<script>
//var anc = window.location.hash.replace("#","");
setTimeout (function() {document.getElementById("ag_arrow_top").click();}, 200);
</script>';




} //===============EDIT

}//----------------------------------------------------/display hourly order


} //--------------------/provide








//=========================================MAIL MESSAGE
if ($sent_mail == '1' && $stop_booking != '1') {

$dt = date("d.m.Y, H:i:s"); // time


$title = $org_name.' - '.$lang['title_mail_message']; // title

if (isset($edit_true)) { $title = $org_name.' - '.$lang['title_mail_message_change_order']; }// title

include_once ($folder.$psep.'inc/mail_message.php');

$add_staff_mm_arr = explode('||', $add_staff);

if ($sent_in_org_mail == '1') {
array_push($add_staff_mm_arr, '00&&00&&'.$add_mail.'', '00&&00&&'.$org_mail.'');
} else {
array_push($add_staff_mm_arr, '00&&00&&'.$add_mail.'');}

if (isset($edit_true)) { //==================EDIT ORDER MAIL SENT

if(isset($_POST['sent_edit_order'])) {

$add_staff_mm_arr = array_diff($add_staff_mm_arr, array(''));	
$add_staff_mm_arr = array_unique($add_staff_mm_arr);

foreach ($add_staff_mm_arr as $kms => $vms) {
$vms = str_replace(' ', '', $vms);
$vms = str_replace('"', '', $vms);
$vms = str_replace('\"', '', $vms);
$vms = str_replace("\'",'', $vms);
$vms = str_replace("'", '', $vms);
		
$vms_arr = explode('&&', $vms);

$vms_arr = array_diff($vms_arr, array(''));	
$vms_arr = array_unique($vms_arr);

if (isset($vms_arr[2])) {$staff_mail_sent = $vms_arr[2];} else {$staff_mail_sent = '';}
if (!empty($staff_mail_sent)) {
//--------------sent
	
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  $headers .= "Content-type:text/html;charset=utf-8 \r\n"; 
  $headers .= "From: ".$org_name." <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; // from
  $headers.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
  mail($staff_mail_sent, $title, $mess, $headers); // SENT		

usleep(200000); 
//-------------/sent	
} //no empty mail

}// count staff mail

}//checkbox sent edit order

} else {

if($_POST['booking'] == '1') {
foreach ($add_staff_mm_arr as $kms => $vms) {
$vms_arr = explode('&&', $vms);
if (isset($vms_arr[2])) {$staff_mail_sent = $vms_arr[2];} else {$staff_mail_sent = '';}
if (!empty($staff_mail_sent)) {
//--------------sent
	
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  $headers .= "Content-type:text/html;charset=utf-8 \r\n"; 
  $headers .= "From: ".$org_name." <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; // from
  //if(!empty($add_mail)) { $headers .= "Bcc: ".$add_mail."\r\n"; } // copy  
  $headers.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
  mail($staff_mail_sent, $title, $mess, $headers); // SENT		
usleep(200000); 	
//-------------/sent	
} //no empty mail

}// count staff mail
} //post booking user	
	
} //========edit

} //config sent mail
//-----------------------------------------/mail message






//=========================================if reservation of adm panel
if (isset($_GET['reservation'])) { 
echo '
<script>
setTimeout(window.parent.document.getElementById("cboxClose").click(), 200);
window.onunload=function() {window.parent.document.getElementById("refresh").click();}
</script>';
}
//----------------------------------------/if reservation of adm panel









//---------------------------------------------------------------------/check booking dates/times

if ($order_test == '1') { } else { // === TESTING

if ($stop_booking == '0' && $_POST['booking'] == '1') {

define('ADD_LINE', $file_name);
if (!file_get_contents(ADD_LINE)) { //empty bd

$fp=fopen($file_name, "a+"); 
fputs
($fp, "$line_data_add"); 
fclose($fp);

} else { //add next line
$file = fopen($file_name,"rb") ; 
flock($file,LOCK_SH) ; 
flock($file,LOCK_UN) ; 
fclose($file) ; 

$fp=fopen($file_name, "a+"); 
fputs
($fp, "\n$line_data_add"); 
fclose($fp);}


}// STOP BOOKING



//==============================================EDIT ORDER (REPLACE)
if ($stop_booking == '0' && $_POST['booking'] == 'edit_go') {




if ($check_order_data_bd == 1) {
for ($ls_cl = 0; $ls_cl < sizeof($lines_orders_cl); ++$ls_cl) { 
if (!empty($lines_orders_cl[$ls_cl])) {
$arr_order = explode('::', $lines_orders_cl[$ls_cl]);	
if (isset($arr_order[0])) {$id_order_obj_cl = $arr_order[0];} else {$id_order_obj_cl = '';}

if ($replace_id_order == $id_order_obj_cl) {
//echo $id_order_obj_cl.' - '.$ls_cl;
$line_order_id = $ls_cl;
} //id order


}//no empty lines
}//count lines orders bd
}//check file bd



$add_comment = htmlspecialchars($add_comment, ENT_QUOTES);

$line_data_replace = $replace_id_order.'::'.$id_obj.'::'.$add_name_obj.'::'.$add_date.'::'.$add_time.'::'.$add_spots.'::'.$add_client.'::'.$add_phone.'::'.$add_mail.'::'.$add_comment.'::'.$add_ip.'::'.$replace_status.'::'.$add_price.'::'.$add_currency.'::'.$add_staff.'::'.$add_discount.'::'.$spots_for_edit.'::'.$replase_payment_obj.'::';	


//---------------------replace progress
$file_edit_ord = $file_name_data_orders;
$contents = file_get_contents($file_edit_ord);
 
 

$contents = explode("\n", $contents);
   
    if (isset($contents[$line_order_id])) {
        $contents[$line_order_id] = $line_data_replace;
       
        if (is_writable($file_edit_ord)) {
            if (!$handle = fopen($file_edit_ord, 'wb')) { echo ''; }
                   
            if (fwrite($handle, implode("\n", $contents)) === FALSE) { echo ''; }
//--replace done	
fclose($handle);
		}
	}
	
echo '
<script>
setTimeout(window.parent.document.getElementById("cboxClose").click(), 200);
window.onunload=function() {window.parent.document.getElementById("refresh").click();}
</script>';
	
} // post edit order
//---------------------------------------------/edit order (replace)


}
//=================================== /ADD



} //Isset POST and no ERRORS

?>


<div class="form_bl">

<?php


if ($wording_obj == 0) {$val_button = $lang['booking_go'];} else {$val_button = $lang['order_go'];}

$class_inp_name = 'w_input';
$class_inp_mail = 'w_input';
$class_inp_phone = 'w_input';
$class_inp_comment = 'w_input';

if(isset($_POST['booking'])) {
$class_inp_name = 'done_input';
$class_inp_mail = 'done_input';
$class_inp_phone = 'done_input';
if (empty($_POST['comment']) || $_POST['comment'] == $val_comment1) {} else {$class_inp_comment = 'done_input';}
}

if (isset($ERROR['name'])) {$val_name = $ERROR['name']; $val_name1 = $ERROR['name']; $class_inp_name = 'error_input error_mess';}
if (isset($ERROR['mail'])) {$val_mail = $ERROR['mail']; $val_mail1 = $ERROR['mail']; $class_inp_mail = 'error_input error_mess';}
if (isset($ERROR['phone'])) {$val_phone = $ERROR['phone']; $val_phone1 = $ERROR['phone']; $class_inp_phone = 'error_input error_mess';}

echo '<div class="oform">';





//=====================OTHER ERRORS
if (isset($ERROR['dates'])){ echo '<div class="error">'.$ERROR['dates'].'</div>';}

if (isset($ERROR['time'])){ echo '<div class="error">'.$ERROR['time'].'</div>';}

if (isset($ERROR['spots'])){ echo '<div class="error">'.$ERROR['spots'].'</div>';}

if (isset($ERROR['total_spots'])){ echo '<div class="error">'.$ERROR['total_spots'].'</div>';}

if (isset($ERROR['payment_select'])){ echo '<div class="error">'.$ERROR['payment_select'].'</div>';}

if (isset($ERROR['captcha'])){ echo '<div class="error">'.$ERROR['captcha'].'</div>';}

//==========================================================SPOTS INPUT
$inpn1 = '0';
$inpn2 = '1';
$inpn3 = '2';
$inpn4 = '3';
if ($conf_form != '0') {
$inpn1 = '0';
$inpn2 = '1';
$inpn3 = '1';
$inpn4 = '2';	
}




if (!empty($select_time_spots) && $all_spots_obj == '0' || !empty($select_time_spots) && empty($all_spots_obj)) {
	
	
if ($end_spots == '1') {
	

	
	
if ($provide_obj == 'daily') {
$urlback = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'';	
echo '<div class="error"><b>'.$_GET['day'].'.'.$month.'.'.$year.'</b> - '.$lang['end_spots_in_date'].'</div>';	
//echo '<script>var delay = 3000; setTimeout("document.location.href=\''.$urlback.'#ag_calendar\'", delay);</script>
//<noscript><meta http-equiv="refresh" content="3; url='.$urlback.'#ag_calendar"></noscript>';		

} else {	
$urlback = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'';	
$urlback = str_replace('&time='.$select_time, '', $urlback);
$war_select_time_arr = explode(':', $select_time);
if (isset($war_select_time_arr[0])) {$war_hs = $war_select_time_arr[0];} else {$war_hs = '';}	
if (isset($war_select_time_arr[1])) {$war_ms = $war_select_time_arr[1];} else {$war_ms = '';}	
if (isset($war_select_time_arr[2])) {$war_he = $war_select_time_arr[2];} else {$war_he = '';}	
if (isset($war_select_time_arr[3])) {$war_me = $war_select_time_arr[3];} else {$war_me = '';}	
echo '<div class="error"><b>'.$war_hs.':'.$war_ms.' - '.$war_he.':'.$war_me.'</b> - '.$lang['end_spots_in_time'].'</div>';	
echo '<script>var delay = 3000; setTimeout("document.location.href=\''.$urlback.'#select_time\'", delay);</script>
<noscript><meta http-equiv="refresh" content="3; url='.$urlback.'#select_time"></noscript>';	
}
	
} else {	


	
echo '<div class="b_inp_bl in_spots" tabindex="1">
<input type="number" name="spots" value="'.$add_spots.'" id="inp_spots" class="oinp" onblur="outfocus(0)" onfocus="infocus(0)" onchange="count_spots_price()" onkeyup="count_spots_price()" min="'.$min_spots_ord.'" max="'.$max_spots_inp.'" title="'.$lang['select_count_spots'].'" /> 


<div class="desc_spots clicker">
<span id="spup" onclick="splus()" tabindex="1" onselectstart="return false" onmousedown="return false"><i class="icon-up-dir"></i></span>
<span id="spdw" onclick="sminus()" tabindex="1" onselectstart="return false" onmousedown="return false"><i class="icon-down-dir"></i></span>
</div>

<script>
var spup = document.getElementById("spup");
var spdw = document.getElementById("spdw");
var sinp = document.getElementById("inp_spots");

var min = sinp.getAttribute("min");
var max = sinp.getAttribute("max");

max = parseInt(max);
min = parseInt(min);

function splus() {
sval = sinp.value;
sval = parseInt(sval);

if(sval == max-1) { spup.setAttribute("class", "spstop"); }

if(sval >= max) {   
outfocus(0); alert("'.$lang['order_max_allow_spots'].' "+max);	
} else {
    sinp.value = sval+1; count_spots_price();
    spdw.removeAttribute("class");
}	
sinp.focus();
}

function sminus() {
sval = sinp.value;
sval = parseInt(sval);

if(sval == min+1) { spdw.setAttribute("class", "spstop"); }

if(sval <= min) {
if(min > 1){outfocus(0); alert("'.$lang['order_min_allow_spots'].' "+min);}
	
} else {
	sinp.value = sval-1; count_spots_price(); 
	spup.removeAttribute("class");}
sinp.focus();
}

</script>

<div class="desc_spots" tabindex="1">
<div>
'.$lang['select_count_spots'].', <span class="left_spots">'.$lang['enable_spots'].': ';
if($max_spots_inp != '0' && $max_spots_inp != '') {
echo '<b>'.$max_spots_inp.'</b>';} else {echo '<b>'.$total_spots_ord.'</b>';}
 
echo ' </span>';

if ($provide_obj == 'hourly') {
echo '<a href="'.$url_time.'#select_time" title="'.$lang['reset_select_time'].'"><i class="icon-block-1"></i></a>';
} else {echo '<span style="width:9px; display:inline-block; padding:0; margin:0;"></span>';}

echo '
<div class="desc_spots_q">
<table>';

if($left_spots_ord != '') {
echo '<tr><td>'.$lang['order_totlal_spots'].':</td>
<td><b>'.$left_spots_ord.'</b></td></tr>';
} else {
echo '<tr><td>'.$lang['order_totlal_spots'].':</td>
<td><b>'.$total_spots_ord.'</b></td></tr>';	
}

if($max_spots_inp != '0' && $max_spots_inp != '') {
echo '<tr><td>'.$lang['order_max_allow_spots'].':</td>
<td><b>'.$max_spots_inp.'</b></td></tr>';
} else {
echo '<tr><td>'.$lang['order_max_allow_spots'].':</td>
<td><b>'.$total_spots_ord.'</b></td></tr>';
}

if($min_spots_ord > '1') {
echo '<tr><td>'.$lang['order_min_allow_spots'].':</td>
<td><b>'.$min_spots_ord.'</b></td></tr>';}

echo '</table>
</div>';

echo '
</div>
</div>

</div>'; 	

$inpn1 = '1';
$inpn2 = '2';
$inpn3 = '3';
$inpn4 = '4';

if ($conf_form != '0') {
$inpn1 = '1';
$inpn2 = '2';
$inpn3 = '2';
$inpn4 = '3';	
}

} //left spots != 0

}//spots enable

//==========================================================ALL SPOTS
if ($all_spots_obj != '0' && !empty($all_spots_obj)) {

echo '<div class="b_inp_bl in_spots">
<input type="number" name="spots" value="'.$add_spots.'" id="inp_spots" class="oinp" onblur="outfocus(0)" onfocus="infocus(0)" onchange="count_spots_price()" onkeyup="allow_ch()" min="1" max="'.$max_spots_inp.'" title="'.$lang['select_count_spots'].'" /> 

<div class="desc_spots all_spots" tabindex="1">
<div>
'.$lang['select_count_spots'].', <span class="left_spots">'.$lang['enable_spots'].': ';

  echo '<b>'.$max_spots_inp.'</b>';
 
echo '</span>';

echo '</div>
</div>


<div class="desc_spots clicker">
<span id="spup" onclick="splus()" onselectstart="return false" onmousedown="return false"><i class="icon-up-dir"></i></span>
<span id="spdw" onclick="sminus()" onselectstart="return false" onmousedown="return false"><i class="icon-down-dir"></i></span>
</div>

<script>
var spup = document.getElementById("spup");
var spdw = document.getElementById("spdw");
var sinp = document.getElementById("inp_spots");

var min = sinp.getAttribute("min");
var max = sinp.getAttribute("max");

max = parseInt(max);
min = parseInt(min);

function splus() {
sval = sinp.value;
sval = parseInt(sval);

if(sval == max-1) { spup.setAttribute("class", "spstop"); }

if(sval >= max) {   
outfocus(0); alert("'.$lang['order_max_allow_spots'].' "+max);	
} else {
    sinp.value = sval+1; count_spots_price();
    spdw.removeAttribute("class");
}	
sinp.focus();
}

function sminus() {
sval = sinp.value;
sval = parseInt(sval);

if(sval == min+1) { spdw.setAttribute("class", "spstop"); }

if(sval <= min) {
if(min > 1){outfocus(0); alert("'.$lang['order_min_allow_spots'].' "+min);}
	
} else {
	sinp.value = sval-1; count_spots_price(); 
	spup.removeAttribute("class");}
sinp.focus();
}

</script>



</div>'; 	
	
$inpn1 = '1';
$inpn2 = '2';
$inpn3 = '3';
$inpn4 = '4';	

if ($conf_form != '0') {
$inpn1 = '1';
$inpn2 = '2';
$inpn3 = '2';
$inpn4 = '3';	
}

}


echo '<div class="b_inp_bl in_name '.$class_inp_name.'"><input type="text" name="name" value="'.$val_name.'" class="oinp" onblur="if (this.value == \'\')  {this.value = \''.$val_name1.'\';} outfocus('.$inpn1.')" onfocus="if (this.value == \''.$val_name1.'\') {this.value = \'\';} infocus('.$inpn1.')" /></div>';

if ($conf_form == '0' || $conf_form == '1') {
echo '<div class="b_inp_bl in_mail '.$class_inp_mail.'"><input type="text" name="mail" value="'.$val_mail.'" class="oinp" onblur="if (this.value == \'\')  {this.value = \''.$val_mail1.'\';} outfocus('.$inpn2.')" onfocus="if (this.value == \''.$val_mail1.'\') {this.value = \''.$add_mail.'\';} infocus('.$inpn2.')" /></div>';
}

if ($conf_form == '0' || $conf_form == '2') {
echo '<div class="b_inp_bl in_phone '.$class_inp_phone.'"><input type="text" name="phone" value="'.$val_phone.'" class="oinp" onblur="if (this.value == \'\')  {this.value = \''.$val_phone1.'\';} outfocus('.$inpn3.')" onfocus="if (this.value == \''.$val_phone1.'\') {this.value = \''.$add_phone.'\';} infocus('.$inpn3.')" /></div>';
}

echo '<div class="b_inp_bl in_comment '.$class_inp_comment.'"><textarea id="comment" name="comment" onblur="if (this.value == \'\')  {this.value = \''.$val_comment1.'\';} outfocus('.$inpn4.')" onfocus="if (this.value == \''.$val_comment1.'\') {this.value = \'\';} infocus('.$inpn4.')">'.$val_comment.'</textarea></div>';


echo '
<script>
$("#comment").each(function(){ 
  this.value=this.value.replace(/<br \/>/g,"\n"); 
});
</script>
';

echo '</div>';

//discount

if(!empty($promo_code) && !empty($discount_val)) {
if (!empty($dval) && $discount == '0') {$class_pi = 'inp_pc error_input error_mess';} else {$class_pi = 'inp_pc';}	
 
echo '

<div class="discount_bl">

<div class="dinfo '.$class_pi.'"><table><tr>';
if ($discount_sim == '%') {
echo '<td><div class="discount_str '.$class_pi.'"><span>'.$discount_val.$discount_sim.'</span></div></td>';
} else {
echo '<td><div class="discount_str '.$class_pi.'"><span>'.$curr_left.$discount_val.$curr_right.'</span></div></td>';	
}
echo '<td><input type="text" id="promo_code" class="'.$class_pi.'" name="discount" value="'.$dval.'" /></td></tr></table></div>';

if (!empty($dval) && $discount == '0') {echo '<span class="red_text">'.$lang['error_promo_code'].'</span>';} else 
{echo '<span>'.$lang['enter_promocode_discount'].'</span>';}
echo '<div class="clear"></div>';
echo '</div>';


}

echo '<div class="clear"></div>';

if (isset($_POST['booking']) && !isset($ERROR) && !isset($_GET['edit']) && $stop_booking == '0') { echo '</form>'; }





//==============================================================PAYMENT MODULES


$count_payment_modules = 0;

if (!isset($edit_true) && !isset($_GET['reservation'])) { 


$modules_dir = $folder.$psep.'payment';
if(is_dir($modules_dir)) {
function getModulesList($dir)
  {
    // massive return
    $retval = array();

    // add slash to end
    if(substr($dir, -1) != "/") $dir .= "/";

    // path to dir and read file
    $d = dir($dir) or die(' <div class="error"><span class="red_text">read modules error</span></div> ');
    while(false !== ($entry = $d->read())) {

      // skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
        $retval[] = array(
          "name" => "$dir$entry/",
          "size" => 0,
          "lastmod" => filemtime("$dir$entry")
        );
		
      } elseif(is_readable("$dir$entry")) {

        $retval[] = array(
          "name" => "$dir$entry",
          "size" => filesize("$dir$entry"),
          "lastmod" => filemtime("$dir$entry")
        );

      }
    }
    $d->close();

    return $retval;
}

$dir_modules = getModulesList($modules_dir);




if (is_array($dir_modules) == true) {

if (sizeof($dir_modules) > 0) {
	
$checked_open_payment = '';	
if (isset($_POST['payment_online'])) {$checked_open_payment = 'checked="checked" ';}	

if (isset($pay_only) && $pay_only == '1') {

echo '<div style="display:none;"><div id="open_payment"><input type="checkbox" id="select_payment" name="payment_online" onclick="view_payment()" checked="checked" /></div></div>';	
	
} else {
	
echo '<div id="open_payment"><label><input type="checkbox" id="select_payment" name="payment_online" onclick="view_payment()" '.$checked_open_payment.'/><div class="payment_check"><h5>'.$lang['payment_now'].'</h5></div></label></div>';	
	
}
	
echo '<div id="ag_payment_modules">';



foreach($dir_modules as $index_module => $file_modules) {
	
//---------checked	
$checked_module[$index_module] = '';


if (isset($_POST['payment']) && $_POST['payment'] == $index_module) {$checked_module[$index_module] = 'checked="checked"';} else {$checked_module[$index_module] = '';}
if (sizeof($dir_modules) == 1) {$checked_module[0] = 'checked="checked"';}
//---------/checked

if (file_exists($file_modules['name'].'/display.php')) { $payment_display = '1'; 

echo '<div class="payment_item">';
include_once($file_modules['name'].'/display.php');
echo '</div>';	
if (isset($display_module[$index_module])) { $count_payment_modules += $display_module[$index_module];}		

} //file exists display
} // count modules



echo '<div class="clear"></div>';
echo '</div>';
echo '<div class="clear"></div>';



echo '
<script>
var count_payment = '.$count_payment_modules.';

if (count_payment == 1) { document.getElementsByName("payment")[0].setAttribute("checked","checked"); }

if (count_payment > 0) {
	
var pay_check = document.getElementById("select_payment");
var pay_items = document.getElementById("ag_payment_modules");

if (pay_check.checked) {
pay_items.className = pay_items.className.replace( /(?:^|\s)ag_no_view(?!\S)/ , "" );
pay_items.className += "ag_view";
} else {
pay_items.className = pay_items.className.replace( /(?:^|\s)ag_view(?!\S)/ , "" );	
pay_items.className += "ag_no_view";
}

function view_payment() {
	
if (pay_check.checked) {
pay_items.className = pay_items.className.replace( /(?:^|\s)ag_no_view(?!\S)/ , "" );
pay_items.className += "ag_view";
} else {
pay_items.className = pay_items.className.replace( /(?:^|\s)ag_view(?!\S)/ , "" );	
pay_items.className += "ag_no_view";
}	
	
}




} else {
document.getElementById("ag_payment_modules").style.display = "none";
document.getElementById("open_payment").style.display = "none";	
}
</script>
';

} // array > 0
} // array files modules





} // directory
} // no edit & no reservation



//----------------------------------------------------------------/payment modules













if (isset($edit_true)) {
	
	
if ($sent_mail == '1') {	
if (isset($_POST['mail']) && !empty($_POST['mail'])) {
echo '<div class="sent_edit_ch">
<label>
<input type="checkbox" name="sent_edit_order" value="1" checked="checked" />
'.$lang['sent_cange'].'
</label>
</div>';
} }

//==================================Change status edit

if (isset($_POST['change_status']) && isset($_POST['new_status'])) {
$replace_status	= $_POST['new_status'];
$ch_st_ed = 'checked="checked"';
} else {$ch_st_ed = '';}

echo '<div class="edit_change_status">
<div class="sent_edit_ch">
<label><input type="checkbox" name="change_status" id="ch_st" value="1" onClick="view_select_st()" '.$ch_st_ed.'/>'.$lang['change_status'].'</label></div>';

echo '<div id="sel_st" class="ag_no_view">';

$select_status_opt = '';
foreach ($status_arr as $kst => $vst){ 
if ($kst != '2') {
$select_status_opt .= '<option value="'.$kst.'"'; 
if($replace_status == $kst) {$select_status_opt .=' selected="selected"';}
$select_status_opt .='>'.$vst.'</option>'; }
}
echo '<select name="new_status" class="sel_new_st">'.$select_status_opt.'</select>';
echo '</div>';

echo '
<script>
var sst = document.getElementById("sel_st");
var ech = document.getElementById("ch_st");';

if (isset($_POST['change_status'])) {echo 'sst.removeAttribute("class","ag_no_view");';}

echo '
function view_select_st() {
if (ech.checked) {
sst.removeAttribute("class","ag_no_view");
} else {
sst.setAttribute("class","ag_no_view");
}

}
</script>

</div>';



echo '
<div class="clear"></div>
<input type="hidden" name="booking" value="edit_go" />';


} else {
echo '<input type="hidden" name="booking" value="1" />';
}




if (isset($edit_true)) { 
echo '<button id="submit"><i class="icon-floppy"></i>'.$lang['safe'].'</button><div class="clear"></div>';
} 
else if(isset($_GET['reservation'])) {echo '<button id="submit"><i class="icon-flag"></i>'.$lang['reservation'].'</button><div class="clear"></div>';
} else {

if($captcha == '1' && !isset($_GET['reservation'])) {	
echo '<img title="'.$lang['change_captcha'].'" alt="'.$lang['change_captcha'].'" onclick="this.src=this.src+\'&amp;\'+Math.round(Math.random())" src="'.$folder.$psep.'inc/captcha/imaga.php?'.session_name().'='.session_id().'" class="img_captcha" /><input type="text" name="keystring" class="captcha" />';}
	
echo '<button id="submit"><i class="icon-pin"></i>'.$val_button.'</button><div class="clear"></div>';}

echo '
<script>
var in_bl = document.getElementsByClassName("b_inp_bl");

function infocus(n) {
in_bl[n].className +=" in_focus";
}

function outfocus(n) {
in_bl[n].className = in_bl[n].className.replace( /(?:^|\s)in_focus(?!\S)/ , \'\' );
}
</script>
';

//echo $daily_price_obj;

//============================================JAVA SCRIPT DISPLAY PRICE SELECT DATE & TIME 




echo '<div id="p_info">
<span class="p_ticon"><i class="icon-calc"></i> '.$lang['total_price'].':</span>
<span class="p_block">'.$curr_left.'<span id="total" class="ag_price"></span>'.$curr_right.'</span>
<div class="clear"></div>
</div>';




echo '<script>';
if ($count_payment_modules > 0) {
echo 'var paym = document.getElementById("open_payment");';
echo 'var paym_ch = document.getElementById("select_payment");';
echo 'var paym_m = document.getElementById("ag_payment_modules");';
}

//=============================Count spots total price
if (!empty($select_time_spots) && $end_spots != '1') {

echo 'function count_spots_price() {
var cspots = document.getElementById("inp_spots").value;';
if ($count_spots == '1') {
	if ($sel_s_price != '-') {
		
	echo '
	var summ = parseFloat('.$sel_s_price.'*cspots);
	
	summ = Math.round(summ * 100) / 100;
	document.getElementById("total").innerHTML = summ;  '; }
	else {echo 'document.getElementById("p_info").className = "fadeIn_price"; 
	document.getElementById("total").innerHTML = "'.$lang['price_variable'].'"; ';}

} else {
	if ($sel_s_price != '-') {
	echo 'document.getElementById("total").innerHTML = '.$sel_s_price.';';}	
    else {echo 'document.getElementById("p_info").className = "fadeIn_price"; 
	document.getElementById("total").innerHTML = "'.$lang['price_variable'].'"; ';}
}
echo '}';


//echo 'window.onbeforeunload = count_spots_price();  ';	
echo '$(document).ready(function() {count_spots_price();}); ';
//echo 'window.onload = count_spots_price(); ';	
	
	
echo 'document.getElementById("p_info").className = "fadeIn_price";	';
} //Select spots time 

else {

//=============================================================Daily All Spots
if ($all_daily_spots != '0' || !empty($all_daily_spots)) {

echo 'function count_spots_price() {allow_ch();}'; }
//============================================================================	




echo '
document.getElementById("submit").setAttribute("disabled","disabled");';

if ($count_payment_modules > 0) {
echo '
paym_ch.setAttribute("disabled","disabled");
paym.setAttribute("style","display:none;");
paym_m.setAttribute("style","display:none;");
';
}

echo '
function allow_ch() {
	
var tc = document.getElementsByClassName("ch_time"); 

var count_price = "0";
var cprice = document.getElementsByClassName("ag_price"); 

var ch_block = document.getElementsByClassName("h_act"); 



var count = 0;

for (var ic=0; ic < tc.length; ic++) { 

if (tc[ic].checked) { count++;
if(cprice[ic].innerHTML != \'\') { str_pr = parseFloat(cprice[ic].innerHTML); } else {str_pr = 0;}



if(cprice[ic].innerHTML == \'0.0999\') { 

count_price = "-1"; ';

if ($count_payment_modules > 0) {
echo '
paym_ch.setAttribute("disabled","disabled");
paym.setAttribute("style","display:none;");
paym_m.setAttribute("style","display:none;");
';
}

echo '

} else {

count_price += str_pr;
count_price++;

}


';

if ($only_row_obj == '1') {
echo '	
var icp = ic-1;
var icn = ic+1;	


if(icn != tc.length) {
setTimeout(function() { tc[icn].removeAttribute("disabled"); ch_block[icn].className = ch_block[icn].className.replace( /(?:^|\s)disabled(?!\S)/ , \'\' ); }, 40);
}

//if(icn == tc.length) {alert(ic+" / "+icn+" - "+tc.length);}

if (ic != 0) {setTimeout(function() { tc[icp].removeAttribute("disabled"); ch_block[icp].className = ch_block[icp].className.replace( /(?:^|\s)disabled(?!\S)/ , \'\' ); }, 40);}




//----------------???
//setTimeout(function() { tc[ic].removeAttribute("disabled"); ch_block[ic].className = ch_block[ic].className.replace( /(?:^|\s)disabled(?!\S)/ , \'\' );}, 40);
//---------------/???


} else { 
tc[ic].setAttribute("disabled","disabled"); 



if (ch_block[ic].className.indexOf("disabled") == -1)  
{ch_block[ic].className +=" disabled";}
'; }

echo '
}

} //count

if (count_price >= 0) {
count_price = count_price - count;
} 


if (count_price != 0) {
document.getElementById("p_info").className = "fadeIn_price";
}';

if ($count_payment_modules > 0) {
echo '
if (count_price > 0) {
paym_ch.removeAttribute("disabled");
paym.removeAttribute("style");	
paym_m.removeAttribute("style");	
} else {
paym_ch.setAttribute("disabled","disabled");
paym.setAttribute("style","display:none;");	
paym_m.setAttribute("style","display:none;");	
}';
}

echo'

var cspots = 1;
';

// -- DISPLAY TOTAL PRICE
if (!empty($fix_price_obj) || $fix_price_obj != '0') 
{ echo 'document.getElementById("total").innerHTML = '.$fix_price_obj.';'; }
else 
{ 
if ($all_spots_obj != '0' && !empty($all_spots_obj)) {
	
	
echo '

cspots = document.getElementById("inp_spots").value;  ';
echo '

if (count_price >= 0) {
count_price = count_price*cspots;
count_price = Math.round(count_price * 100) / 100;	
document.getElementById("total").innerHTML = count_price; 
} else {document.getElementById("total").innerHTML = "'.$lang['price_variable'].'";}

';	
} else { 
echo ' 
if (count_price >= 0) {
count_price = count_price*cspots;
count_price = Math.round(count_price * 100) / 100;		
document.getElementById("total").innerHTML = count_price; 
} else {document.getElementById("total").innerHTML = "'.$lang['price_variable'].'";}
 '; }

}
// --/display total price

echo '
if (count == 0 || count_price == 0) {
setTimeout(function() { reset_ch(); },60); 
document.getElementById("p_info").removeAttribute("class");
document.getElementById("submit").setAttribute("disabled","disabled");
} else {document.getElementById("submit").removeAttribute("disabled");}

if (count != 0 && count_price == 0) {
document.getElementById("submit").removeAttribute("disabled");
}


}


function reset_ch() {
var tcc = document.getElementsByClassName("ch_time"); 	
var rch_block = document.getElementsByClassName("h_act"); 
for (var icc=0; icc<tcc.length; icc++) {
tcc[icc].removeAttribute("disabled");
rch_block[icc].className = rch_block[icc].className.replace( /(?:^|\s)disabled(?!\S)/ , \'\' );	
}	
}


function checkbg(dd) {	
var chk = document.getElementById("c"+dd);
var chk_bl = document.getElementById("b"+dd);
if (chk.checked) {
chk_bl.className +=" checked";
} else { 
chk_bl.className = chk_bl.className.replace( /(?:^|\s)checked(?!\S)/ , \'\' );
}

allow_ch();
}

function checkbgn(ddn) {	
var chkn = document.getElementById("cn"+ddn);
var chk_bln = document.getElementById("bn"+ddn);
if (chkn.checked) {
chk_bln.className +=" checked";
} else { 
chk_bln.className = chk_bln.className.replace( /(?:^|\s)checked(?!\S)/ , \'\' );
}

allow_ch();
}';


if(isset($_POST['booking'])) {
//------------------------------------------checked
if ($only_row_obj == '1') {

echo '
var pch = document.getElementsByClassName("ch_time"); 	
var pch_block = document.getElementsByClassName("h_act"); 
count_check_box = 0;
for (var ipch=0; ipch < pch.length; ipch++) {

if (pch[ipch].checked) {
count_check_box++;
ccph = ipch + 1;	
} else {
ccph = ipch + 1;	
if (count_check_box == 0) {} else {
pch[ipch].setAttribute("disabled","disabled");
pch_block[ipch].className +=" disabled";}
}

}

if (ccph != pch.length) {
setTimeout(function() { 
pch[ccph].removeAttribute("disabled");
pch_block[ccph].className = pch_block[ccph].className.replace( /(?:^|\s)disabled(?!\S)/ , \'\' );	
}, 80); }

document.getElementById("p_info").className = "fadeIn_price"; allow_ch();';


echo 'document.getElementById("submit").removeAttribute("disabled");';



} else { echo 'allow_ch();'; }


}// post booking

}//select spots time



echo '</script>';


if(isset($_POST['booking']) && !isset($ERROR)) { //==================PRINT SCRIPT
echo '
<script>

$("#to_print").click(function(){
	
var printing_css=\'<link rel="stylesheet" href="css/fontello.css" media="print"><style media="print">body{margin:0;padding:0;background:#fff;color:#000;font-family:"Courier New",Arial,Verdana,Tahoma;font-size:14px;}.print_order {width:70%;margin:0 auto;}th{text-align: left;font-style:normal;font-weight: normal;}table{width:100%;border-collapse:collapse;border-spacing:0;}table td, table th{border: #acacae 1px solid; padding:7px; vertical-align:top;}table.contact_info th, .print_order table.contact_info td{border: 0 none;padding:0 0 3px 0;font-size:12px;}.bot_order{display:none;}h4{display:none;}a.exit_order_list_top{display:none;}.done_mess_order{display:none;}</style>\';
	
var html_to_print=\'<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>'.$lang['order_in'].': '.$add_client.' ('.date('d.m.Y').')</title>\'+printing_css+\'</head><body>\'+$("#ok_order").html()+\'</body></html>\';
        var iframe = $(\'<iframe id="print_frame">\');
        $("body").append(iframe);
        var doc = $("#print_frame")[0].contentDocument || $("#print_frame")[0].contentWindow.document;
        var win = $("#print_frame")[0].contentWindow || $("#print_frame")[0];
        doc.getElementsByTagName("body")[0].innerHTML = html_to_print;
        win.print();

		//alert(html_to_print);
        $("iframe").remove();	
return false;	
    }); ';
if (!isset($edit_true)) { echo 'document.getElementById("p_info").removeAttribute("class");'; }
echo '</script>';
}//print




//============================================/java script

echo '</div>';
echo '</div>';
if (isset($_POST['booking']) && !isset($ERROR) && !isset($_GET['edit']) && $stop_booking == '0')  { } else { echo '</form>'; }
//echo '</form>';
include_once('utc_start_time.php');
?>