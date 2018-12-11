<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;} 

if (!isset($color1) || isset($color1) && empty($color1)) {$color1 = '#FC8F1A';}
/////////////////////////////////////////////////////////////////////////



if (isset($edit_true)) {
$number_order_cl_arr = explode('_',$replace_id_order);
if(isset($number_order_cl_arr[5]) && isset($number_order_cl_arr[6]) && isset($number_order_cl_arr[7]))
{$number_order = $number_order_cl_arr[5].$number_order_cl_arr[6].$number_order_cl_arr[7];} else {$number_order = '';}
$id = $replace_id_order;	
}


if($provide_obj == 'daily') { //===========================================DAILY
	
$mess = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';

$mess .= '<table style="border:0; border-collapse:collapse; margin: 14px 0 14px 0; width:100%; font-size:14px; box-shadow: 0 0 14px rgba(16, 19, 33, 0.05);"><tbody>';


$mess .= '<tr><td colspan="2" style="border: #fff 1px solid; background:'.$color1.'; padding:14px; vertical-align:top;">
<h3 style="COLOR: #fff; margin: 0; padding:0; font-weight:normal; font-size:16px;">'.$title.'</h3></td></tr>';


if(!empty($number_order)){
$mess .= '<tr>
<td style="width:160px; border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_number'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$number_order.'</b></td>
</tr>'; }


$mess .= '<tr>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_in'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$add_client.'</td>
</tr>';  
  
  


$mess .= '<tr><td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['obj_name'].':</td><td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$name_obj_done;
if (!empty($name_cat_done)) {$mess .= '<br /><small>'.$name_cat_done.'</small>';}
$mess .= '</td></tr>';



$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['booking_dates'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'; 
$b_day = '';
$b_month = '0';
$b_year = '';
foreach ($select_time_arr as $bk => $bv) {
$bv_arr = explode('.', $bv);
if (isset($bv_arr[0])) {$b_day = $bv_arr[0];}
if (isset($bv_arr[1])) {$b_month = $bv_arr[1];}
if (isset($bv_arr[2])) {$b_year = $bv_arr[2];}
$mess .= '<li>'.$b_day.' '.$lang_monts_r[$b_month].' '.$b_year.'</li>';
}	
$mess .='</td></tr>';

if(!empty($add_mail)) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['mail'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$add_mail.'</td></tr>';}

if(!empty($add_phone)){
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['phone'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$add_phone.'</td></tr>';}

//SPOTS
if($add_spots > 1) {
if ($add_price != '0.0999') {
//$price_befote = $price_befote/$add_spots;	
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['spots'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$add_spots.'</b> x '.$curr_left_code.' '.$price_befote.' '.$curr_right_code.'</td></tr>';
} else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['spots'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$add_spots.'</b></td></tr>';} // variable price
} //spots > 1

//DISCOUNT DISPLAY
if($discount == '1') 
{$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['discount'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$curr_left_code.' ';
if ($discount_sim == '%') {$mess .= $price_befote*$add_spots.' - <b>'.$summp.'</b> ('.$discount_val.$discount_sim.')';} else 
{$mess .= $price_befote*$add_spots.' - <b>'.$discount_val.'</b>';}
$mess .= ' '.$curr_right_code.'</td></tr>';
}

//==price
if ($add_price == '0.0999') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['to_pay'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($add_price == 0) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['to_pay'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['to_pay'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$curr_left_code.' <b>'.$add_price.'</b> '.$curr_right_code.'</td></tr>';
}
//==

//== status
if (isset($_POST['payment_online'])) {} else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['status'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">';
if($add_status == '0') {$mess .= '<b style="color:#FC8F1A;">'.$status_arr[$add_status].'</b>';}
if($add_status == '1') {$mess .= '<b style="color:#1B98F7;">'.$status_arr[$add_status].'</b>';}
if($add_status == '2') {$mess .= '<b style="color:#669900;">'.$status_arr[$add_status].'</b>';}
$mess .= '</td></tr>';
} //payment

if (!empty($add_comment)){
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['comment'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><div class="add_comment">'.$add_comment.'<div class="fade_bl"></div></div></td></tr>';}


if (isset($_POST['payment_online'])) {} else {
if ($confirm_mail == '1' && $add_status == '0') {
$mess .= '<tr>
<td colspan="2" style="border: #fff 1px solid; background:#FFF7D9; padding:14px; color:#000; vertical-align:top;">
'.$lang['confirm_order_mail_link'].':<br /><a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?confirm='.$id.'" style="color:#FF4D00;">https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?confirm='.$id.'</a>
</td>
</tr>';	
}
} //payment


//================================ROW CONTACTS INFO

$mess .= '<tr>
<td colspan="2" style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">

<table style="border:0; border-collapse:collapse; font-size:12px; width:auto; float:right;">';

if(isset($org_phone) && !empty($org_phone)) {$mess .= '<tr>
<td style="text-align:right; padding:1px 3.5px 1px 3.5px;">'.$lang['phone'].': </td>
<td style="text-align:left; padding:1px 3.5px 1px 3.5px;">'.$org_phone.'</td></tr>';}

if(isset($org_mail) && !empty($org_mail)) {$mess .= '<tr>
<td style="text-align:right; padding:1px 3.5px 1px 3.5px;">'.$lang['mail'].': </td>
<td style="text-align:left; padding:1px 3.5px 1px 3.5px;"><a href="mailto:'.$org_mail.'" style="color:'.$color1.';">'.$org_mail.'</a></td></tr>';}

$mess .= '<tr>
<td style="text-align:right; padding:1px 3.5px 1px 3.5px;">'.$org_name.': </td>
<td style="text-align:left; padding:1px 3.5px 1px 3.5px;"><a href="https://'.$host_name.'" style="color:'.$color1.';">www.'.$host_name.'</a></td>
</tr>';
$mess .= '</table>

<div style="clear:both; margin:0; padding:0;"></div>
</td></tr>';

//------------------------------------------------



$mess .= '</tbody></table>';

$mess .= '<div style="padding:14px; color:#bebebf; font-size:12px;">IP: '.$add_ip.' || '.$dt.'</div>';

$mess .= '</body></html>';	
	
	
} else { //================================================================HOURLY


$mess = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';

$mess .= '<table style="border:0; border-collapse:collapse; margin: 14px 0 14px 0; width:100%; font-size:14px; box-shadow: 0 0 14px rgba(16, 19, 33, 0.05);"><tbody>';

$mess .= '<tr><td colspan="2" style="border: #fff 1px solid; background:'.$color1.'; padding:14px; vertical-align:top;">
<h3 style="COLOR: #fff; margin: 0; padding:0; font-weight:normal; font-size:16px;">'.$title.'</h3></td></tr>';

if(!empty($number_order)){
$mess .= '<tr>
<td style="width:160px; border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_number'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$number_order.'</b></td>
</tr>'; }


$mess .= '<tr>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_in'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$add_client.'</td>
</tr>';  



$mess .= '<tr><td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['obj_name'].':</td><td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$name_obj_done;
if (!empty($name_cat_done)) {$mess .= '<br /><small>'.$name_cat_done.'</small>';}
$mess .= '</td></tr>';


$disp_date_arr = explode('.', $add_date);
if (isset($disp_date_arr[0])) {$b_day = $disp_date_arr[0];}
if (isset($disp_date_arr[1])) {$b_month = $disp_date_arr[1];}
if (isset($disp_date_arr[2])) {$b_year = $disp_date_arr[2];}

$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['date'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$b_day.' '.$lang_monts_r[$b_month].' '.$b_year.'</b></td></tr>';

$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['booking_times'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'; 

$b_hs = '';
$b_ms = '';
$b_he = '';
$b_me = '';
foreach ($select_time_arr as $bk => $bv) {
$tv_arr = explode(':', $bv);
if (isset($tv_arr[0])) {$b_hs = $tv_arr[0];}
if (isset($tv_arr[1])) {$b_ms = $tv_arr[1];}
if (isset($tv_arr[2])) {$b_he = $tv_arr[2];}
if (isset($tv_arr[3])) {$b_me = $tv_arr[3];}
$mess .= '<li>'.$b_hs.':'.$b_ms; 
if (!empty($b_he) && $b_he != 'XX') {$mess .= ' - '.$b_he.':'.$b_me;}
$mess .= '</li>';
}	
$mess .='</td></tr>';

if(!empty($add_mail)){
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['mail'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$add_mail.'</td></tr>';}

if(!empty($add_phone)){
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['phone'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$add_phone.'</td></tr>';}

//============================================BUSSY SPOTS


if($add_spots > 1) {
	
if(!empty($select_time_spots) || $all_spots_obj != '0' && !empty($all_spots_obj)) {
//$price_befote = $price_befote/$add_spots;
}


$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['spots'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$add_spots.'</b>';

if($total_price != '0.0999') {
if ($count_spots == '1') { // count spots yes
$mess .= ' x '.$curr_left_code.' '.$price_befote.' '.$curr_right_code.'';
}
if ($all_spots_obj != '0' && !empty($all_spots_obj)) { // spots in all time
$mess .= ' x '.$curr_left_code.' '.$price_befote.' '.$curr_right_code.'';
}
}//var price
$mess .= '</td></tr>';

}


//DISCOUNT DISPLAY

if($discount == '1') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['discount'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$curr_left_code.' ';

if ($discount_sim == '%') { //====== DISCOUNT %


$mess .= $total_price+$summp.' - <b>'.$summp.'</b> ('.$discount_val.$discount_sim.')';


} else { //======= DISCOUNT =
	

$mess .= $total_price+$discount_val.' - <b>'.$discount_val.'</b>';

} // discount summ
 
$mess .= ' '.$curr_right_code.'</td></tr>';
}//discount yes

//==price
if ($add_price == '0.0999') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['to_pay'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($add_price == 0) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['to_pay'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['to_pay'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$curr_left_code.' <b>'.$add_price.'</b> '.$curr_right_code.'</td></tr>';
}
//==

//== status
if (isset($_POST['payment_online'])) {} else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['status'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">';
if($add_status == '0') {$mess .= '<b style="color:#FC8F1A;">'.$status_arr[$add_status].'</b>';}
if($add_status == '1') {$mess .= '<b style="color:#1B98F7;">'.$status_arr[$add_status].'</b>';}
if($add_status == '2') {$mess .= '<b style="color:#669900;">'.$status_arr[$add_status].'</b>';}
$mess .= '</td></tr>';
} //payment


if (!empty($add_comment)){
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['comment'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><div class="add_comment">'.htmlspecialchars_decode($add_comment, ENT_NOQUOTES).'<div class="fade_bl"></div></div></td></tr>';}

if (isset($_POST['payment_online'])) {} else {
if ($confirm_mail == '1' && $add_status == '0') {
$mess .= '<tr>
<td colspan="2" style="border: #fff 1px solid; background:#FFF7D9; padding:14px; color:#000; vertical-align:top;">
'.$lang['confirm_order_mail_link'].':<br /><a href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?confirm='.$id.'" style="color:#FF4D00;">https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?confirm='.$id.'</a>
</td>
</tr>';	
}
} //payment


//================================ROW CONTACTS INFO

$mess .= '<tr>
<td colspan="2" style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">

<table style="border:0; border-collapse:collapse; font-size:12px; width:auto; float:right;">';

if(isset($org_phone) && !empty($org_phone)) {$mess .= '<tr>
<td style="text-align:right; padding:1px 3.5px 1px 3.5px;">'.$lang['phone'].': </td>
<td style="text-align:left; padding:1px 3.5px 1px 3.5px;">'.$org_phone.'</td></tr>';}

if(isset($org_mail) && !empty($org_mail)) {$mess .= '<tr>
<td style="text-align:right; padding:1px 3.5px 1px 3.5px;">'.$lang['mail'].': </td>
<td style="text-align:left; padding:1px 3.5px 1px 3.5px;"><a href="mailto:'.$org_mail.'" style="color:'.$color1.';">'.$org_mail.'</a></td></tr>';}

$mess .= '<tr>
<td style="text-align:right; padding:1px 3.5px 1px 3.5px;">'.$org_name.': </td>
<td style="text-align:left; padding:1px 3.5px 1px 3.5px;"><a href="https://'.$host_name.'" style="color:'.$color1.';">www.'.$host_name.'</a></td>
</tr>';
$mess .= '</table>

<div style="clear:both; margin:0; padding:0;"></div>
</td></tr>';

//------------------------------------------------

$mess .= '</tbody></table>';

$mess .= '<div style="padding:14px; color:#bebebf; font-size:12px;">IP: '.$add_ip.' || '.$dt.'</div>';

$mess .= '</body></html>';
}//--provide


?>