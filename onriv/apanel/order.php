<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
include ('header.php');
if (!isset($mr)) {die;}
if(!isset($onriv_take)) {die();}
if (!empty($access) && $access == 'yes') {

echo '<div id="norefresh" onclick="refresh(0)"></div>';
echo '<div id="refresh" onclick="refresh(1)"></div>';

$re_url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'';


echo '<script>

var timerRefresh;

timerRefresh = setTimeout(function() {document.location.href=\''.$re_url.'\'}, 120000);

function refresh(trig) { 

if (trig == 0) {  clearTimeout(timerRefresh); } else {document.location.href=\''.$re_url.'\'}

} 
</script>
<noscript><meta http-equiv="refresh" content="300; url='.$re_url.'"></noscript>'; //refresh


$file_name = '../data/'.$id_prefix.'.dat'; 
$file_name_ord_obj = '../data/object.dat'; 
$file_name_staff = '../data/staff.dat';


$found_obj = '0';
$found_staff = '0';
$stop_act = '0';
$ancor_ch = '';




$swing_line = '0';
$swing_line_change = '0';
$not_line_change = '0';
$act_done = '0';
$ID_str = '';

$actual = '0';
$found = '0';
$display_order = '0';

$str_search = '';
$found_search = '0';

$actual_u = '';
$actual_u_alt = '';

//if(isset($_GET['actual'])) {$actual_u = '?actual'; $actual_u_alt = '&actual';}

if(isset($_GET['actual_orders'])) {$actual_u = '?actual_orders'; $actual_u_alt = '&actual_orders';}

if(isset($_POST['actual_orders'])) {$actual_u = '?actual_orders'; $actual_u_alt = '&actual_orders';}

if(isset($_GET['search'])) {$actual_u = '?search='.$_GET['search'].''; $actual_u_alt = '&search='.$_GET['search'].'';}

if(isset($_GET['actual_orders']) && isset($_GET['search']) && $_GET['search'] == $id_this_user) {$actual_u = '?search='.$_GET['search'].'&actual_orders'; $actual_u_alt = '&search='.$_GET['search'].'&actual_orders';}

if(isset($_POST['actual_orders']) && isset($_GET['search']) && $_GET['search'] == $id_this_user) {$actual_u = '?search='.$_GET['search'].'&actual_orders'; $actual_u_alt = '&search='.$_GET['search'].'&actual_orders';}

$num_ord = 0;

if (file_exists($file_name)) { // keep data file 

$cmod_file = substr(sprintf('%o', fileperms($file_name)), -4);
if ($cmod_file !='0644') {chmod ($file_name, 0644);}
//echo $cmod_file;




define('DATA', $file_name);
if (!file_get_contents(DATA)) { //empty data file 
echo '<div class="mess">'.$lang['empty_data_orders'].'</div>';
if(!empty($_GET) || !empty($_POST)) {echo $refresh_0;}
} else { //====================================================ISSET BD 




//=============================================================CHECK ID
$data_file_ID = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file_ID, LOCK_SH); 
$lines_data_ID = preg_split("~\r*?\n+\r*?~", fread($data_file_ID,filesize($file_name))); 
flock($data_file_ID, LOCK_UN); 
fclose($data_file_ID); 

//for ($ls = 0; $ls < sizeof($lines_data_ID); ++$ls) { 
for ( $lsi = count($lines_data_ID) - 1; $lsi >=0 ; $lsi--)  {
	
$number_line_ID = $lsi+1;

if (!empty($lines_data_ID[$lsi])) {
$data_ord_ID = explode('::', $lines_data_ID[$lsi]);	
if (isset($data_ord_ID[0])) {$id_order_ch = $data_ord_ID[0];} else {$id_order_ch = '';}
$ID_str .= $id_order_ch;
}}}
//-------------------------------------------------------------/check id



// =====================================BLOCK MOOVES

if(isset($_GET['moves'])) { if ($_GET['moves'] !='') {
$move1=$_GET['moves']; $where=$_GET['where']; 
if ($where=="0") $where="-1";
$move2=$move1-$where;

$file=file($file_name);
 

$imax=sizeof($file);


if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;} else {
	
if (($move2>=$imax) or ($move2<"0")) {
echo $refresh_3;
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error'].'</div></div>'; } else { // no error moove


$nl = chr(13).chr(10);

if (isset($_GET['where'])) {if ($_GET['where']==0){$this_line = $_GET['moves']+2;} if ($_GET['where']==1){$this_line = $_GET['moves'];} }

if ($move1 == $imax-1) { //last up!!!
$data1=$file[$move1]; 
$data2=$nl.$file[$move2];
$del_l_line = "?delete_moves=".$imax."&this=line".$this_line.$actual_u_alt."";
} 

else if ($move2 == $imax-1) { //last-1 down!!!
$data1=$nl.$file[$move1]; 
$data2=$file[$move2];
$del_l_line = "?delete_moves=".$imax."&this=line".$this_line.$actual_u_alt."";
}

else {
$data1=$file[$move1]; 
$data2=$file[$move2];
$del_l_line = $actual_u.'#line'.$this_line;
}


$fp=fopen($file_name, "a+"); 
 

flock ($fp,LOCK_EX); 

ftruncate($fp,0);//Delet data in file 
// change position




for ($i=0; $i<$imax; $i++) {


if ($move1==$i) { 
fputs
($fp,$data2); 
} 

else if ($move2==$i) { 
fputs
($fp,$data1); 
}

else { 
fputs
($fp,$file[$i]); 
} 

}
 
 
fflush ($fp);


flock ($fp,LOCK_UN);
fclose($fp);
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';
echo "<script>
    var delay = 800;
    setTimeout(\"document.location.href='".$script_name."".$del_l_line."'\", delay);
    </script><noscript><meta http-equiv=\"refresh\" content=\"0; url=".$script_name."".$del_l_line."\"></noscript>";
}
} // staff access
} else { echo '<div class="shadow_back">'.$error_any.'</div>'.$refresh_3; }//no 0 line
} // no first / no last
//=============================/MOOVES

//======================================================DELET Moves
$crlf = "\n"; 

if (isSet($_GET['delete_moves']) == true) {


	

$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//delete progress
	
    if (isSet($lines[(integer) $_GET['delete_moves']]) == true) 
    {   unset($lines[(integer) $_GET['delete_moves']]) ; 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 

echo"
<script>
    var delay = 0;
    setTimeout(\"document.location.href='".$script_name."".$actual_u ."#".$_GET['this']."'\", delay);
    </script>
	<noscript><meta http-equiv=\"refresh\" content=\"0; url=".$script_name."".$actual_u ."#".$_GET['this']."\"></noscript>
";
}
 //======================delet moves		
	
	
	
//====================================================DISPLAY	



echo '<div id="main">';
	
echo'<div id="data" class="table"><ul class="th">';

echo '<li class="tools"><i class="icon-ok"></i></li>';
echo '<li class="tools"><i class="icon-list-numbered"></i></li>';


echo '<li>'.$lang['services_order'].'</li>';
echo '<li>'.$lang['date'].' / '.$lang['time'].'</li>';
echo '<li>'.$lang['total_price'].': '.$lang['c_spots'].' / '.$lang['price'].'</li>';
echo '<li>'.$lang['client'].' / '.$lang['added'].'</li>';
echo '<li>'.$lang['status_order'].'</li>';

echo '<li class="tools"><i class="icon-edit-alt"></i></li>';
echo '<li class="tools"><i class="icon-trash-2"></i></li>';

echo '<div class="clear"></div>';
echo '</ul>';

//=========================================================FORM ORDER
echo '<form method="post" id="order" action="'.$script_name.''.$actual_u.'">';


$found_ls = '';
$data_file = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file, LOCK_SH); 
$lines_data = preg_split("~\r*?\n+\r*?~", fread($data_file,filesize($file_name))); 
flock($data_file, LOCK_UN); 
fclose($data_file); 

$sear_id_staff = '';

//for ($ls = 0; $ls < sizeof($lines_data); ++$ls) { 
for ( $ls = count($lines_data) - 1; $ls >=0 ; $ls--)  { //last = 1
	
$number_line = $ls+1;
$new_line = sizeof($lines_data);



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



if(isset($_GET['search']) && $_GET['search'] == $id_this_user) { $sear_id_staff = $order_staff_obj; }

$obj_nms_arr = explode('&&', $name_ord_obj);
if (!isset($obj_nms_arr[0])) {$obj_nms_arr[0] = '';}
if (!isset($obj_nms_arr[1])) {$obj_nms_arr[1] = '';}

$phone_client_sear_obj = str_replace('+', '', $phone_client_obj);

$str_search = '::'.$obj_nms_arr[0].'::'.$obj_nms_arr[1].'::'.$date_obj.'::'.$time_obj.'::'.$client_name_ord_obj.'::'.$phone_client_sear_obj.'::'.$mail_client_obj.'::'.$sear_id_staff.'::'.$number_order;


$str_search = mb_strtolower($str_search, 'utf8');
$str_search = str_replace(array('||', '&&'), '::', trim($str_search));

//echo $str_search.'<br />';

//-------------------------------------------------------ACTUAL DATES 
//if (!isset($_GET['search'])) {
if ($date_obj != '0') {
$a_date_arr = explode ('.', $date_obj);
if (isset($a_date_arr[0])) {$a_day = $a_date_arr[0];} else {$a_day = '';}	
if (isset($a_date_arr[1])) {$a_month = $a_date_arr[1];} else {$a_month = '';}	
if (isset($a_date_arr[2])) {$a_year = $a_date_arr[2];} else {$a_year = '';}	


if ($a_day >= date('d') && $a_month == date('m') && $a_year == date('Y') || $a_month > date('m') && $a_year == date('Y') || $a_year > date('Y')) 
{$actual = '1';} else {$actual = '0';}

$a_time_arr_b = explode ('||', $time_obj);
foreach ($a_time_arr_b as $atk => $atv){
$a_timed_arr = explode (':', $atv);

if (isset($a_timed_arr[0])) {$a_hstart = $a_timed_arr[0];} else {$a_hstart = '';}	
if (isset($a_timed_arr[1])) {$a_mstart = $a_timed_arr[1];} else {$a_mstart = '';}	
if (isset($a_timed_arr[2])) {$a_hend = $a_timed_arr[2];} else {$a_hend = '';}	
if (isset($a_timed_arr[3])) {$a_mend = $a_timed_arr[3];} else {$a_mend = '';}

}
if ($a_day == date('d')) {
if ($a_day == date('d') && date('H') == $a_hend && date('i') < $a_mend || $a_day == date('d') && date('H') < $a_hend){$actual = '1';} else {$actual = '0';}
}
//echo date("H").'n - '.$a_hend .'b : '.date("i").'n - '.$a_mend.'b || '.$a_day.' == '.date('d');

} else {
	
	
	
$a_time_arr = explode ('||', $time_obj);
foreach ($a_time_arr as $adk => $adv){
$a_date_arr = explode ('.', $adv);
if (isset($a_date_arr[0])) {$a_day = $a_date_arr[0];} else {$a_day = '';}	
if (isset($a_date_arr[1])) {$a_month = $a_date_arr[1];} else {$a_month = '';}	
if (isset($a_date_arr[2])) {$a_year = $a_date_arr[2];} else {$a_year = '';}	
if ($a_day >= date('d') && $a_month == date('m') && $a_year == date('Y') || $a_month > date('m') && $a_year == date('Y') || $a_year > date('Y')) 
{$actual = '1';} else {$actual = '0';}

} //count time	
}// date 0

//-----------/actual dates
//} //get search


//=====================================================================SEARCH 
if (isset($_GET['search']) == true) {
if (empty($_GET['search'])) { 

	} else {
		
$_GET['search'] = urldecode($_GET['search']);
$query = mb_strtolower($_GET['search'], 'utf8');	
$query = str_replace('+', '', $query);



//echo $str_search;
if (preg_match('/::'.$query.'/i', $str_search)) {$found = '1'; $found_search = '1';} else {$found = '0';}

	}
}
//==================================================================/SEARCH






//====================================================== GET DELET
$id_del_l = 'none';
$crlf = "\n"; 
if (isSet($_GET['delete']) == true) {

if (isset($_GET['id'])) {$id_del_l = $_GET['id'];}

//$ID_str
if ($id_del_l == $id_order_obj) {
	
$act_done = '1';

if(isset($nl)) {$ancor_ch = 'position'.$nl;}
	
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//DELET
	
    if (isSet($lines[(integer) $ls]) == true) 
    {   unset($lines[(integer) $ls]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 

	
	
if ($_GET['delete'] != $ls)	{$swing_line = '1'; $act_done = '0';} //Num Line
	

} else {
if (!preg_match('/'.$id_del_l.'/i', $ID_str)) {$swing_line = '1'; $act_done = '0';}
}//Check ID

} //======================================== /get delet







//========================================== POST DELETE
if (isset($_POST['act_ord'])) {
if (isset($_POST['check_order']) && $_POST['act_ord'] == 'del') {

foreach($_POST['check_order'] as $ok => $ov) {
	
$del_lines_arr = explode('&&', $ov);
if (isset($del_lines_arr[0])) {$num_del_lines = $del_lines_arr[0];}
if (isset($del_lines_arr[1])) {$id_del_lines = $del_lines_arr[1];}
//$ID_str




if ($id_del_lines == $id_order_obj) { // CHECK ID

$act_done = '1';
if(isset($nl)) {$ancor_ch = 'position'.$nl;}


$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//DELET
	
if (isSet($lines[(integer) $ls]) == true) 
    {   unset($lines[(integer) $ls]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 
	

if ($num_del_lines != $ls) {$swing_line = '1'; $act_done = '0';}//num lines	

} else {
if (!preg_match('/'.$id_del_lines.'/i', $ID_str)) {$swing_line = '1'; $act_done = '0';}
}//Check ID


}//count del lines



}//post #order		
}//post delet













//===================================CHANGE STATUS GET
if(isset($_GET['change_status'])) {


$add_status = '0';
$ch_id = 'none';
if (isset($_GET['status'])) {
$add_status = $_GET['status'];
}
if (isset($_GET['id'])) {
$ch_id = $_GET['id'];
}

$line_data_r = $id_order_obj.'::'.$id_obj_obj.'::'.$name_ord_obj.'::'.$date_obj.'::'.$time_obj.'::'.$spots_ord_obj.'::'.$client_name_ord_obj.'::'.$phone_client_obj.'::'.$mail_client_obj.'::'.$comment_client_obj.'::'.$add_ip_obj.'::'.$add_status.'::'.$price_ord_obj.'::'.$cur_obj.'::'.$order_staff_obj.'::'.$discount_ord_obj.'::'.$spots_control_ord_obj.'::'.$payment_sys.'::';	

//======================================Replase process
if ($ch_id == $id_order_obj) {


if(isset($nl)) {$ancor_ch = 'position'.$nl;}

$nl = $ls;
$filename = $file_name;
$contents = file_get_contents($filename);
 
    $contents = explode("\n", $contents);
   
    if (isset($contents[$nl])) {
        $contents[$nl] = $line_data_r;
       
        if (is_writable($filename)) {
            if (!$handle = fopen($filename, 'wb')) { echo ''; }
                   
            if (fwrite($handle, implode("\n", $contents)) === FALSE) { echo ''; }
//--replace done	
$ancor_line_replace = $nl+1;



//====================================================MAIL MESSAGE CHAHGE STATUS
if ($sent_mail_status == '1') {
$dt = date("d.m.Y, H:i:s"); // time
$title = $org_name.' - '.$lang['title_mail_message_change_status']; // title
$clmail = $mail_client_obj;

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
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$client_name_ord_obj.'</td>
</tr>';  

$disp_obj_cat_arr = explode('&&', $name_ord_obj);

if (!isset($disp_obj_cat_arr[0])) {$disp_obj_cat_arr[0] = '';}
if (!isset($disp_obj_cat_arr[1])) {$disp_obj_cat_arr[1] = '';}

$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['obj_name'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$disp_obj_cat_arr[0];
if (!empty($disp_obj_cat_arr[1])) {$mess .= '<br /><small>'.$disp_obj_cat_arr[1].'</small>';}
$mess .= '</td></tr>';


//==price
if ($price_ord_obj == '0.0999') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($price_ord_obj == 0) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$price_ord_obj.'</b> '.$cur_obj.'</td></tr>';
}
//==



//== status
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['status'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">';
if($add_status == '0') {$mess .= '<b style="color:#FC8F1A;">'.$status_arr[$add_status].'</b>';}
if($add_status == '1') {$mess .= '<b style="color:#1B98F7;">'.$status_arr[$add_status].'</b>';}
if($add_status == '2') {$mess .= '<b style="color:#669900;">'.$status_arr[$add_status].'</b>';}
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

echo'
<script>
    var delay = 80;
    setTimeout("document.location.href=\''.$script_name.''.$actual_u.'#line'.$ancor_line_replace.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.''.$actual_u.'#line'.$ancor_line_replace.'"></noscript>';
	
	
fclose($handle);
}
}
if ($_GET['change_status'] != $ls) { $swing_line_change = '1'; } 

} else {
if (!preg_match('/'.$ch_id.'/i', $ID_str)) { $not_line_change = '1'; }
}//Check ID

//echo '<div class="shadow_back"><div class="warring modal_mess textleft">'.$lang['error_act_orders'].'
//<div class="conf_but"><a href="'.$script_name.'">'.$lang['yes'].' <i class="icon-right-open"></i></a></div>
//</div></div>';	


	

}//GET
//----------------------------------/change status





//==================================CHANGE STATUS POST (massive)


if (isset($_POST['act_ord'])) {
if (isset($_POST['check_order']) && $_POST['act_ord'] == 'chs') {
$add_status = '0';
if (isset($_POST['statusm'])) {$add_status = $_POST['statusm'];}

foreach($_POST['check_order'] as $ok => $ov) {

	
$ch_lines_arr = explode('&&', $ov);
if (isset($ch_lines_arr[0])) {$num_ch_lines = $ch_lines_arr[0];}
if (isset($ch_lines_arr[1])) {$id_ch_lines = $ch_lines_arr[1];}
//$ID_str

$pos_anc = $num_ch_lines + sizeof($_POST['check_order']);

$line_data_r = $id_order_obj.'::'.$id_obj_obj.'::'.$name_ord_obj.'::'.$date_obj.'::'.$time_obj.'::'.$spots_ord_obj.'::'.$client_name_ord_obj.'::'.$phone_client_obj.'::'.$mail_client_obj.'::'.$comment_client_obj.'::'.$add_ip_obj.'::'.$add_status.'::'.$price_ord_obj.'::'.$cur_obj.'::'.$order_staff_obj.'::'.$discount_ord_obj.'::'.$spots_control_ord_obj.'::'.$payment_sys.'::';	

//======================================Replase process

if ($id_ch_lines == $id_order_obj) {
	
$act_done = '1';
$ancor_ch = 'position'.$pos_anc;	
	
$nl = $ls;
$filename = $file_name;
$contents = file_get_contents($filename);
 
    $contents = explode("\n", $contents);
   
    if (isset($contents[$nl])) {
        $contents[$nl] = $line_data_r;
       
        if (is_writable($filename)) {
            if (!$handle = fopen($filename, 'wb')) { echo ''; }
                   
            if (fwrite($handle, implode("\n", $contents)) === FALSE) { echo ''; }
//--replace done	

fclose($handle);
}
}



//====================================================MAIL MESSAGE CHAHGE STATUS
if ($sent_mail_status == '1') {
$dt = date("d.m.Y, H:i:s"); // time
$title = $org_name.' - '.$lang['title_mail_message_change_status']; // title
$clmail = $mail_client_obj;

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
<td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$client_name_ord_obj.'</td>
</tr>';  

$disp_obj_cat_arr = explode('&&', $name_ord_obj);

if (!isset($disp_obj_cat_arr[0])) {$disp_obj_cat_arr[0] = '';}
if (!isset($disp_obj_cat_arr[1])) {$disp_obj_cat_arr[1] = '';}

$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['obj_name'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$disp_obj_cat_arr[0];
if (!empty($disp_obj_cat_arr[1])) {$mess .= '<br /><small>'.$disp_obj_cat_arr[1].'</small>';}
$mess .= '</td></tr>';


//==price
if ($price_ord_obj == '0.0999') {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span></td></tr>';	
}

else if ($price_ord_obj == 0) {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><span class="price_var">'.$lang['price_null'].'</span></td></tr>';	
}

else {
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['sum'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;"><b>'.$price_ord_obj.'</b> '.$cur_obj.'</td></tr>';
}
//==



//== status
$mess .= '<tr> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">'.$lang['status'].':</td> <td style="border: #fff 1px solid; background:#f3f3f5; padding:14px; color:#000; vertical-align:top;">';
if($add_status == '0') {$mess .= '<b style="color:#FC8F1A;">'.$status_arr[$add_status].'</b>';}
if($add_status == '1') {$mess .= '<b style="color:#1B98F7;">'.$status_arr[$add_status].'</b>';}
if($add_status == '2') {$mess .= '<b style="color:#669900;">'.$status_arr[$add_status].'</b>';}
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




if ($id_ch_lines == $id_order_obj && $num_ch_lines != $ls) { $stop_act = '1'; $act_done = '0';}// Num Lines

usleep(200000); 	

} else {
if (!preg_match('/'.$id_ch_lines.'/i', $ID_str)) { $stop_act = '1'; }
}//Check ID
	
} //count cange lines


}//post change

}//post act


//----------------------------------/cange status massive

















$cl_actual = 'all';
if ($actual == '1') {$cl_actual = 'actual';} else {$cl_actual = 'lost';}

if (isset($_GET['actual'])) {
if ($actual == '1') {$display_order = '1';} else {$display_order = '0';} //display actual orders
} else {$display_order = '1';}


if (isset($_GET['search'])) {
if ($found == '1') {$display_order = '1';} else {$display_order = '0';} //display search orders
} 

if (isset($_GET['search']) && isset($_GET['actual'])) {
if ($found == '1' && $actual == '1') {$display_order = '1';} else {$display_order = '0';} //display search orders
} 

if ($display_order == '1') {
$num_ord++;


$class_line = '';
if ($num_ord % 2 == 0) {$class_line = 'second';} else {$class_line = 'first';}


echo '<ul id="position'.$number_line.'" class="order '.$class_line.' '.$cl_actual.'">';

//if (sizeof($lines_data) == 1) {
//echo '<li class="tools none_active"><i class="icon-sort"></i></li>-->';
//} else {
//echo '<li class="tools list_tools" tabindex="1"><i class="icon-sort"></i><div>';	

//echo '<div class="display_id" id="line'.$number_line.'"></div>';

//if ($ls != 0) { echo '
//<span>
//<a href="'.$script_name.'?moves='.$ls.'&where=1" title="'.$lang['moove'].' '.$lang['up'].'"><i class="icon-up-circled"></i>'.$lang['up'].'</a>
//</span>';} 
//if ($ls != sizeof($lines_data)-1) { echo '
//<span>
//<a href="'.$script_name.'?moves='.$ls.'&where=0" title="'.$lang['moove'].' '.$lang['down'].'"><i class="icon-down-circled"></i>'.$lang['down'].'</a>
//</span>';}
//echo '</div></li>';}

//==========================================CHECKBOXES
echo '<li class="num">
<div class="ch_bl">';

if (sizeof($lines_data) == 1) {} else {
echo '<label><input type="checkbox" name="check_order['.$ls.']" value="'.$ls.'&&'.$id_order_obj.'" id="cho'.$ls.'" class="chord" onclick="ch_order('.$ls.')" /><span></span></label>';}

echo '</div>
<div class="clear"></div>
</li>';



//if (isset($_GET['search']) && isset($_GET['actual_orders'])) {}


echo '<li class="tools">'.$num_ord.' <div class="display_id" id="line'.$number_line.'"></div></li>';

echo '<li>'; //================================== NAME OBJ

echo '<span class="str_left">'; 

$disp_obj_cat_arr = explode('&&', $name_ord_obj);

echo '<span class="disp_date">'.$disp_obj_cat_arr[0].'</span>';
if (!empty($disp_obj_cat_arr[1])) {echo '<span class="gray_text">'.$disp_obj_cat_arr[1].'</span>';}

//=====================================DISPLAY OBJ
//$name_ord_obj = '';
//$data_file_obj = fopen($file_name_ord_obj, "rb"); 
//if (filesize($file_name_ord_obj) != 0) {
//flock($data_file_obj, LOCK_SH); 
//$lines_obj = preg_split("~\r*?\n+\r*?~", fread($data_file_obj,filesize($file_name_ord_obj))); 
//flock($data_file_obj, LOCK_UN); 
//fclose($data_file_obj); 

//for ($cobj = 0; $cobj < sizeof($lines_obj); ++$cobj) { 

//$obj_data = explode('::', $lines_obj[$cobj]); 
//if ($obj_data[0] == $id_obj_obj) { 
//$found_obj = '1'; 
//echo $obj_data[1]; //==============================
//$name_ord_obj .= $obj_data[1];
// } // =====NAME OBJ

// }// count lines obj
// }// check file size !=0


//if($found_obj == '0') {echo '<span class="orange_text">'.$lang['not_found_obj'].'</span>';} //not found obj
//====================================/display obj

echo '</span>';


echo '<div class="clear"></div>';


//===============================================STAFF DISPLAY

echo '<div class="ord_staff">';
echo '<span><i class="icon-down-big"></i>'.$lang['staff'].'</span>';
echo '<ul class="ord_staff_list">';
$d_staff_arr = explode('||', $order_staff_obj); 
foreach ($d_staff_arr as $kds => $vds) {
$vds_arr = explode('&&', $vds);	

if (isset($vds_arr[0])) { } else {$vds_arr[0] = '';}
if (isset($vds_arr[1])) { } else {$vds_arr[1] = '';}

if (isset($_GET['search']) && $_GET['search'] == $vds_arr[0]) {
echo '<li class="this_user"><i class="icon-right-big"></i> <a href="../card-staff.php?view='.$vds_arr[0].'&apanel" class="iframe">'.$vds_arr[1].'</a><div class="clear"></div></li>'; } 
else { echo '<li><i class="icon-user"></i> <a href="../card-staff.php?view='.$vds_arr[0].'&apanel" class="iframe">'.$vds_arr[1].'</a><div class="clear"></div></li>'; }	

	

}
echo '<li class="clear"></li>';
echo '</ul>';
echo '</div>';
//-----------------------------------------------/display staff

if(!empty($number_order)){
echo '<span class="order_number">'.$lang['order_number'].': <b>'.$number_order.'</b></span>'; }

echo '</li>';// =====/NAME OBJ


echo '<li>'; //==========================DATE / TIME
$time_arr = explode('||', $time_obj);


if ($date_obj == '0') {
echo '<span class="disp_date">'.$lang['daily'].'</span>';
foreach ($time_arr as $kd => $vd) {
	
$date_arr = explode('.', $vd);
if (isset($date_arr[0])) {$disp_day = $date_arr[0];} else {$disp_day = '00';}
if (isset($date_arr[1])) {$disp_month = $date_arr[1];} else {$disp_month = '00';}
if (isset($date_arr[2])) {$disp_year = $date_arr[2];} else {$disp_year = '0000';}
if (isset($date_arr[3])) {$disp_weekday = $date_arr[3] + 1;} else {$disp_weekday = '0';}
echo '<span class="disp_date_list">'.$disp_day.' '.$lang_monts_r[$disp_month].' '.$disp_year.' ('.$lang_days_short[$disp_weekday].')</span>';


}//count select dates
} else {
$date_arr = explode('.', $date_obj);
if (isset($date_arr[0])) {$disp_day = $date_arr[0];} else {$disp_day = '00';}
if (isset($date_arr[1])) {$disp_month = $date_arr[1];} else {$disp_month = '00';}
if (isset($date_arr[2])) {$disp_year = $date_arr[2];} else {$disp_year = '0000';}
if (isset($date_arr[3])) {$disp_weekday = $date_arr[3] + 1;} else {$disp_weekday = '0';}
echo '<span class="disp_date">'.$disp_day.' '.$lang_monts_r[$disp_month].' '.$disp_year.' ('.$lang_days_short[$disp_weekday].')</span>';
foreach ($time_arr as $kd => $vd) {
echo '<span class="disp_date_list">'.$vd.'</span>';
}//count select time
}


echo '</li>'; //==========================/DATE / TIME

//==========================/SPOTS / PRICE / CURENCY
echo '<li><span class="disp_date">'.$spots_ord_obj.'</span>';
echo '<span class="disp_date_list">';
if ($price_ord_obj == '0.0999') {echo '<span class="price_var">'.$lang['price'].' '.$lang['price_variable'].'</span>';}
else if ($price_ord_obj == '0') {echo '<span class="price_var">'.$lang['price_null'].'</span>';}
else {echo '<b>'.$price_ord_obj.'</b> '.$cur_obj.'';}
echo '</span>';

//--------------if discount
if(!empty($discount_ord_obj)) {
	
$price_befote = '';
$discount_val = '';
$discount_sim = '';
$discount_summp = '';

if(!empty($discount_ord_obj)) {
$discount_arr =	explode('||', $discount_ord_obj);
if (isset($discount_arr[0])) {$price_befote = $discount_arr[0];}	
if (isset($discount_arr[1])) {$discount_val = $discount_arr[1];}	
if (isset($discount_arr[2])) {$discount_sim = $discount_arr[2];}	
if (isset($discount_arr[3])) {$discount_summp = $discount_arr[3];}	
}
	

	
echo '<span class="discount blue_text">'.$lang['discount_use_promo_code'].': <br />'; 
if ($discount_sim == '%') {echo '('.$discount_val.$discount_sim.')<br />'.$price_befote.' - <b>'.$discount_summp.'</b> '.$cur_obj.'';} else 
{echo $price_befote.' - <b>'.$discount_val.'</b> '.$cur_obj.'';}
echo'</span>';
}//--/if discount

echo'</li>'; //==========================/SPOTS / PRICE / CURENCY

//==========================/CLIENT / ADD

$add_day = '';
$add_month = '';
$add_year = '';
$add_hour = '';
$add_minutes = '';
$add_seconds = '';

$add_date_arr = explode('_',$id_order_obj);
if(isset($add_date_arr[1])) {$add_day = $add_date_arr[1];} 
if(isset($add_date_arr[2])) {$add_month = $add_date_arr[2];} 
if(isset($add_date_arr[3])) {$add_year = $add_date_arr[3];} 

if(isset($add_date_arr[4])) {$add_hour = $add_date_arr[4];}
if(isset($add_date_arr[5])) {$add_minutes = $add_date_arr[5];}
if(isset($add_date_arr[6])) {$add_seconds = $add_date_arr[6];}

$add_date_obj = $add_day.' '.$lang_monts_r[$add_month].' '.$add_year.' ('.$add_hour.':'.$add_minutes.':'.$add_seconds.')';

echo '<li>
<span class="disp_date name_client">'.$client_name_ord_obj.'</span>';

//---------------------------------contacts info
if(!empty($phone_client_obj)) {
echo'<span class="ord_cont_info"><i class="icon-phone"></i>'.$phone_client_obj.' <a href="skype:'.$phone_client_obj.'"><i class="icon-skype"></i></a></span>';}

if(!empty($mail_client_obj)) {
echo'<span class="ord_cont_info"><i class="icon-mail-3"></i><a href="mailto:'.$mail_client_obj.'">'.$mail_client_obj.'</a></span>';}


if(!empty($phone_client_obj) || !empty($mail_client_obj)) {echo'<span class="ord_cont_info_bott"></span>';}
//---------------------------------/contacts info

if (!empty($comment_client_obj)) { 
//&lt;br /&gt;
$comment_client_obj = str_replace('&lt;br /&gt;','<br />',$comment_client_obj);

echo '<div class="help_obj comment_client" tabindex="1"><i class="icon-comment-1"></i><div>'.$comment_client_obj.'</div></div>'; }

echo '<span class="disp_date_list_add">'.$add_date_obj.'</span>
<span class="disp_date_list"><small>IP: '.$add_ip_obj.'</small></span>
</li>'; //==========================/CLIENT / ADD

//==========================/STATUS
echo '<li>';
//'.$status_obj.'


$select_status_opt = '';
foreach ($status_arr as $kst => $vst){ 
$select_status_opt .= '<option value="'.$kst.'&id='.$id_order_obj.''.$actual_u_alt.'#line'.($ls+1).'"'; 
if(isset($_GET['status']) && $_GET['change_status'] == $ls && $_GET['id'] == $id_order_obj) { 
$status_obj = $_GET['status'];} 

if($status_obj == $kst) {$select_status_opt .=' selected="selected"';}
$select_status_opt .='>'.$vst.'</option>';
}

$ic_st = '';
$status_t = '';
if ($status_obj == '0') {$status_t = $status_arr[0]; $ic_st = '<i class="icon-bell-off iorange"></i>';}
if ($status_obj == '1') {$status_t = $status_arr[1]; $ic_st = '<i class="icon-bell-alt iblue"></i>'; }
if ($status_obj == '2') {$status_t = $status_arr[2]; $ic_st = '<i class="icon-ok-1 igreen"></i>'; }
//if ($status_obj == '3') {$status_t = $status_arr[3]; $ic_st = '<i class="icon-right-big"></i>'; }


echo '<div class="sl_block">';

echo '<div class="st_ind" title="'.$status_t.'">'.$ic_st.'</div>';

echo '<div class="sel_st">';
echo '<select name="status'.$ls.'" id="cst'.$ls.'" onChange="change_status('.$ls.')" class="sels">'.$select_status_opt.'</select>';
echo '</div>';

echo '<div class="clear"></div>';

if ($status_obj == '2') {
if (!empty($payment_sys)) {echo '<div class="st_txt">'.$lang['payment_way'].': '.$payment_sys.'</div>';} else {echo '<div class="st_txt">'.$lang['payment_way'].': '.$lang['payment_fact'].'</div>';}
}
echo '</div>';

echo '</li>'; //==========================/STATUS


echo '<li class="tools"><a href="../index.php?obj='.$id_obj_obj.'&edit='.$id_order_obj.'" class="iframe_order" title="'.$lang['edit'].' '.$lang['order'].' '.$lang['in'].' &quot;'.$disp_obj_cat_arr[0].'&quot;" class="edit"><i class="icon-edit-alt"></i></a></li>';

echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'&id='.$id_order_obj.''.$actual_u_alt.'" title="'.$lang['delete'].' '.$lang['order'].' '.$lang['in'].' &quot;'.$disp_obj_cat_arr[0].'&quot;" class="delete" onclick ="return confirm(\''.$lang['order'].' '.$lang['in'].' &quot;'.$disp_obj_cat_arr[0].'&quot; '.$lang['delete_m'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';


echo '<div class="clear"></div>';
echo '</ul>';


} //DISPLAY ORDER


















} //no empty lines 

else { //==============DELETE EMPTY LINES
if (isSet($_GET['delete_moves']) == false) {
$crlf = "\n"; 
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//delete process
	
    if (isSet($lines[(integer) $ls]) == true) 
    {   unset($lines[(integer) $ls]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ;  echo $refresh_0;}
} // delete empty lines


echo'<script>
var anc = window.location.hash.replace("#","");
if (anc=="line'.$number_line.'"){
document.getElementById("position'.$number_line.'").className +=" this_element";
}</script>';


}//count lines


echo '<div id="tools_bl">
<div class="title_ch_inf"><h5>'.$lang['check_order'].':</h5></div>

<div class="ch_bl flno"><label>
<input type="radio" name="act_ord" value="del" class="act_ch" onclick="action_order()" />
<span class="fleft"></span><div class="name_ch_tools fleft">'.$lang['delete'].'</div>
</label><div class="clear"></div></div>

<div class="ch_bl flno"><label>
<input type="radio" name="act_ord" value="chs" class="act_ch" id="chsel" onclick="action_order()" />
<span class="fleft"></span><div class="name_ch_tools fleft">'.$lang['change_status'].'</div>
</label><div class="clear"></div></div>';


$select_status_m = '';
foreach ($status_arr as $kstm => $vstm){ 
$select_status_m .= '<option value="'.$kstm.'">'.$vstm.'</option>';
}
echo '<div id="selm"><select name="statusm" class="sels">'.$select_status_m.'</select></div>';




$urlback = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'';	
if (isset($_GET['actual_orders'])) {$urlback = str_replace('actual_orders', '', $urlback);}

if (isset($_GET['actual_orders'])) {echo '<input type="hidden" name="actual_orders" value="1" />';}

echo '<div class="clear" id="reactual"></div>';
echo '
<script>
$(document).ready(function(){';

echo 'view_actual(); '; 
	
echo '	
var chk_actual = document.getElementById("vactual");
var bl_actual = document.getElementById("reactual");

chk_actual.onclick = function() {
if(chk_actual.checked) {bl_actual.innerHTML = \'<input type="hidden" name="actual_orders" value="1" />\';} else {bl_actual.innerHTML = "";} ';

if (!isset($_GET['actual_orders'])) { echo 'document.location.href=\''.$script_name.'?actual_orders\'; '; }
if (!isset($_GET['actual_orders']) && isset($_GET['search']) && $_GET['search'] == $id_this_user) 
{ echo 'document.location.href=\''.$script_name.'?search='.$_GET['search'].'&actual_orders\'; '; }

echo 'view_actual(); '; 

if (isset($_GET['actual_orders'])) { echo 'document.location.href=\''.$urlback.'\'; ';}

echo '}

});
</script>
';

echo '<div id="tools_dinf"></div>

<div class="clear"></div>
<button type="submit" class="fright" id="subm_ch">'.$lang['submit'].' <i class="icon-right-open"></i></button>
<div class="clear"></div>
</div>';




echo '</form>';

//<input type="checkbox" name="check_order['.$ls.']" value="'.$ls.'" id="cho'.$ls.'" class="chord" onclick="ch_order('.$ls.')" />









//=================================================DISPLAY MESSAGE
if (!empty($ancor_ch)) {$ancor_ch = '#'.$ancor_ch;}

if ($act_done == '1' && $stop_act == '0') {
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';
	
echo '<script>
var delay = 1000;setTimeout("document.location.href=\''.$script_name.'?act=done'.$actual_u_alt.''.$ancor_ch.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?act=done'.$actual_u_alt.''.$ancor_ch.''.$actual_u_alt.'"></noscript>';}


if ($stop_act == '1') { 
// ID NOT FOUND
echo '<div class="shadow_back"><div class="warring modal_mess textleft">'.$lang['warrring_act_orders'].'
<div class="conf_but"><a href="'.$script_name.'?act=done'.$actual_u_alt.''.$ancor_ch.'">'.$lang['yes'].' <i class="icon-right-open"></i></a></div>
</div></div>';
//echo $refresh_5;
}	

if ($swing_line == '1') { 
// ID NOT FOUND
echo '<div class="shadow_back"><div class="mess modal_mess textleft">'.$lang['warrring_act_orders'].'
<div class="conf_but"><a href="'.$script_name.'?act=done'.$actual_u_alt.''.$ancor_ch.'">'.$lang['yes'].' <i class="icon-right-open"></i></a></div>
</div></div>';
//echo $refresh_5;
}	

if ($swing_line_change == '1') { 
// ID NOT FOUND
echo '<div class="shadow_back"><div class="warring modal_mess textleft">'.$lang['error_act_orders'].'
<div class="conf_but"><a href="'.$script_name.'?act=done'.$actual_u_alt.''.$ancor_ch.'">'.$lang['yes'].' <i class="icon-right-open"></i></a></div>
</div></div>';
//echo $refresh_5;
}	

if ($not_line_change == '1') { 
// ID NOT FOUND
echo '<div class="shadow_back"><div class="warring modal_mess textleft">'.$lang['not_found_act_order'].'
</div></div>';
echo $refresh_5;
}	

echo '
<script>

var tbl = document.getElementById("tools_bl");
var tbi = document.getElementById("tools_dinf");
var chb = document.getElementsByClassName("chord");
var ach = document.getElementsByClassName("act_ch");
var sbl = document.getElementById("subm_ch");
var chs = document.getElementById("chsel");
var bsl = document.getElementById("selm");

sbl.setAttribute("disabled","disabled");
//bsl.setAttribute("class","fade_sel");

function ch_order(na) {
cch = 0;
for (var i=0; i < chb.length; i++) {
if (chb[i].checked) { cch++; }
}

if(cch != 0) { 
tbl.setAttribute("style","right:14px;"); 
} else { 
tbl.removeAttribute("style"); }

var nom = na + 1;
if(document.getElementById("cho"+na).checked) 
{document.getElementById("position"+nom).className +=" select_ch";}
else 
{document.getElementById("position"+nom).className = document.getElementById("position"+nom).className.replace( /(?:^|\s)select_ch(?!\S)/ , \'\' );}

}


function action_order() {
ccha = 0;
for (var ia=0; ia < ach.length; ia++) {
if (ach[ia].checked) { ccha++; }
}

if(ccha == 0) { 
sbl.setAttribute("disabled","disabled"); 
} else { 
sbl.removeAttribute("disabled"); }


if (chs.checked) {bsl.setAttribute("class","fade_sel");}  else {bsl.removeAttribute("class");}

}

function change_status(ns) {
var sels = document.getElementById("cst"+ns);
var vals = sels.options[sels.selectedIndex].value;

document.location.href="'.$script_name.'?change_status="+ns+"&status="+vals+"'.$actual_u_alt.'";
}
</script>
';



} //file size !=0


if(!isset($_POST['line']) && isset($_GET['edit']) && $found_ls != '1') {
echo '<div class="shadow_back">
<div class="error modal_mess">'.$lang['error_found_replace'].'
<div class="conf_but"><a href="'.$script_name.'">'.$lang['yes'].'</a></div>
</div>
</div>';
//echo $refresh_3;	//not found line for edit		
}


//===================================================== SEARCH NOT FOUND MESSAGE
if (isset($_GET['search']) && !empty($_GET['search']) && $found_search == '0') {
echo '
<ul class="first warring not_found">
<li class="one">'.$lang['not_found'].'</li>
</ul>
';}

if (isset($_GET['search']) && empty($_GET['search'])) { 
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['empty_search'].'</div></div>';
echo $refresh_3;
}


echo'<div class="clear"></div></div>'; //table

} //no empty data file






echo '<div id="add_data" class="add">
<a href="../index.php?reservation" class="iframe_order">
<span class="text"><i class="icon-plus"></i>'.$lang['reservation'].'</span>
</a>
<div class="clear"></div>
</div>'; // ADD BUTTON

echo '</div>'; //============================DIV MAIN

echo'
<script>
window.onload = function()
{
var widthTable = $(data).width() + "px";
$(add_data).css({"width": widthTable});
}
</script>';

} else { // no data file

//=============================CREATE DATA FILE
$line_data_add = '';

$fp_create = fopen($file_name, "w"); // create data file
fwrite($fp_create, "$line_data_add");
fclose ($fp_create);

//echo '<div class="error">'.$lang['no_file'].'</div>';
echo $refresh_0;
}




}// access







echo '
<script>
var ch_actual = document.getElementById("vactual");
var lost_ord = document.getElementsByClassName("lost");
var actual_ord = document.getElementsByClassName("actual");
var all_ord = document.getElementsByClassName("order");
var deck_ch = document.getElementById("title_ac");


function view_actual(){
for(var ilo=0; ilo<lost_ord.length; ilo++) {	
if (ch_actual.checked) {


//deck_ch.removeAttribute("title");
//deck_ch.setAttribute("title","'.$lang['order_more_deck'].'");	

	
lost_ord[ilo].className += \' display_none\';
} else { 

//deck_ch.removeAttribute("title");
//deck_ch.setAttribute("title","'.$lang['order_actual'].'");


lost_ord[ilo].className = lost_ord[ilo].className.replace( /(?:^|\s)display_none(?!\S)/ , \'\' );	
} //checked actual
} //count lost orders


if (ch_actual.checked) {
for(var iao=0; iao<actual_ord.length; iao++) {		
actual_ord[iao].className = actual_ord[iao].className.replace( /(?:^|\s)second(?!\S)/ , \'\' );
actual_ord[iao].className = actual_ord[iao].className.replace( /(?:^|\s)first(?!\S)/ , \'\' );

if (iao % 2 == 0) {actual_ord[iao].className += " first";} else {actual_ord[iao].className += " second";}

} //count actual orders
} else { //checked actual
for(var io=0; io<all_ord.length; io++) {		
all_ord[io].className = all_ord[io].className.replace( /(?:^|\s)second(?!\S)/ , \'\' );
all_ord[io].className = all_ord[io].className.replace( /(?:^|\s)first(?!\S)/ , \'\' );

if (io % 2 == 0) {all_ord[io].className += " first";} else {all_ord[io].className += " second";}	
} //count all orders	
} //checked actual
	
}

</script>
';

include ('footer.php');
?>