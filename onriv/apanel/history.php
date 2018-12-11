<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)


if ($id_prefix == 'logbook') {




$file_name = '../data/history.dat'; 
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
$display_order = '0';

$str_search = '';
$found_search = '0';

$actual_u = '';
$actual_u_alt = '';

$count_summ_str = '';
$currency_str = '';

if(isset($_GET['search'])) {$actual_u = '?search='.$_GET['search'].''; $actual_u_alt = '&search='.$_GET['search'].'';}

$num_ord = 0;

if (file_exists($file_name)) { // keep data file 

$cmod_file = substr(sprintf('%o', fileperms($file_name)), -4);
if ($cmod_file !='0644') {chmod ($file_name, 0644);}
//echo $cmod_file;




define('DATA', $file_name);
if (!file_get_contents(DATA)) { //empty data file 
echo '<br /><div class="mess">'.$lang['empty_data'].'</div><div class="clear"></div><br />';
if(!empty($_GET) || !empty($_POST)) {
	echo $refresh_0;
}
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



if (!isset($_GET['page'])) {$page=1;} else {$page=$_GET['page']; if (!$page) {$page=1;} if ($page<1) $page=1;}



// ================PAGES COUNT
$slimit = '10';

if (isset($_POST['limit'])) {
$_SESSION['limit'] = $_POST['limit'];
}

if (isset($_SESSION['limit'])) {
$slimit = $_SESSION['limit'];
}
//----------------/PAGES COUNT





	
	
	
//====================================================DISPLAY	



echo '<div id="main">';
	
echo'<div id="data" class="table"><ul class="th">';

echo '<li class="tools"><i class="icon-ok"></i></li>';
echo '<li class="tools"><i class="icon-list-numbered"></i></li>';


echo '<li class="four">'.$lang['services_order'].'</li>';
echo '<li class="four">'.$lang['date'].' / '.$lang['time'].'</li>';
echo '<li class="four">'.$lang['total_price'].': '.$lang['c_spots'].' / '.$lang['price'].'</li>';
echo '<li class="four">'.$lang['client'].' / '.$lang['added'].'</li>';
//echo '<li>'.$lang['status_order'].'</li>';

//echo '<li class="tools"><i class="icon-edit-alt"></i></li>';
echo '<li class="tools"><i class="icon-trash-2"></i></li>';

echo '<div class="clear"></div>';
echo '</ul>';




$found_ls = '';
$data_file = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file, LOCK_SH); 
$lines_data = preg_split("~\r*?\n+\r*?~", fread($data_file,filesize($file_name))); 
flock($data_file, LOCK_UN); 
fclose($data_file); 

$lines_data = array_reverse($lines_data);

//=================================PAGES
$ln = count($lines_data);

if (empty($slimit)) {

if ($ln <= 30) {$limit=10;}
else if ($ln >= 50) {$limit=25;}
else {$limit=25;}

} else {
$limit = $slimit;
}
if ($limit<1) $limit=1;


$maxpage = ceil($ln/$limit); if ($page > $maxpage) {$page = $maxpage;}

$numpageblock = null; 

$numpageblock.='<div id="count">
<table><tr>
<td class="pagest">'.$lang['pages'].':</td>
<td class="pages">
<div class="pagesl">';


$f1=$maxpage; $f2=1;

for($i=$f2; $i<=$f1; $i++) {
if ($page==$i) {$numpageblock.='<B>'.$i.'</B>';} else {
$numpageblock.='<a href="'.$script_name.'?page='.$i.'">'.$i.'</a>';
}
}


$numpageblock.='<div class="clear"></div></div></td>
<td><div class="triangle-left"></div></td>
<td class="count_select">';

//---SELECT COUNT



if (isset($page)) {
if (empty($slimit)) {
$numpageblock.='

<div>
<form name="count_list" method="post" action="'.$script_name.'?page='.$page.'">';
$numpageblock.='<nobr>'.$lang['view_count_l'].' <select name="limit" onChange="this.form.submit()">';
$numpageblock.='<option value="5"'; if($limit == 5) {$numpageblock.="selected ";} $numpageblock.='>5</option>';
$numpageblock.='<option value="10"'; if($limit == 10) {$numpageblock.="selected ";} $numpageblock.='>10</option>';
$numpageblock.='<option value="25"'; if($limit == 25) {$numpageblock.="selected ";} $numpageblock.='>25</option>';
$numpageblock.='<option value="50"'; if($limit == 50) {$numpageblock.="selected ";} $numpageblock.='>50</option>';
$numpageblock.='</select> '.$lang['view_count_r'].'</nobr>
</form>
</div>';

} else {
	 
$numpageblock.='
<div>
<form name="count_list" method="post" action="'.$script_name.'?page='.$page.'">';
$numpageblock.='<nobr>'.$lang['view_count_l'].' <select name="limit" onChange="this.form.submit()">';
$numpageblock.='<option value="5"'; if($slimit == 5) {$numpageblock.="selected ";} $numpageblock.='>5</option>';
$numpageblock.='<option value="10"'; if($slimit == 10) {$numpageblock.="selected ";} $numpageblock.='>10</option>';
$numpageblock.='<option value="25"'; if($slimit == 25) {$numpageblock.="selected ";} $numpageblock.='>25</option>';
$numpageblock.='<option value="50"'; if($limit == 50) {$numpageblock.="selected ";} $numpageblock.='>50</option>';
$numpageblock.='</select> '.$lang['view_count_r'].'</nobr>
</form>
</div>';

} //select

$numpageblock.='</div><div class="clear"></td></tr></table></div>';
}

$fm = $ln-$limit*($page-1); if ($fm < '0') {$fm = $limit;}
$lm = $fm-$limit; if ($lm < '1') {$lm = '0';} 

$ind = $ln-$lm-$limit; 
$end = $ln-$lm;

//================================================/PAGES	




//====================================================== GET DELET
$id_del_l = 'none';
$crlf = "\n"; 

if (isset($_GET['delete'])) {

if ($access_level == 'super_admin') {	



if (isset($_GET['id'])) {$id_del_l = $_GET['id'];}

//$ID_str
//if ($id_del_l == $id_order_obj) {

if (!preg_match('/'.$id_del_l.'/i', $ID_str)) {$swing_line = '1'; $act_done = '0';} else {$act_done = '1';}	

if ($act_done == '1') {
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//DELET
	
    if (isSet($lines[(integer) $_GET['delete']]) == true) 
    {   unset($lines[(integer) $_GET['delete']]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 
} //act done

	
} //access

} //======================================== /get delet












//=========================================================FORM ORDER
echo '<form method="post" id="order" action="'.$script_name.'?page='.$page.'">';

if (isset($_GET['search'])) { $ind = 0; $end = sizeof($lines_data); }

for ($ls = $ind ; $ls < $end; ++$ls) { 



	
$number_line = $ls - sizeof($lines_data);
$number_line = $number_line * -1;
$n_pr = $number_line-1;
//$n_pr = $ls;


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
if (isset($data_ord[17])) {$payment_sys = $data_ord[17];} else {$payment_sys = '';}

$number_order_arr = explode('_',$id_order_obj);
if(isset($number_order_arr[5]) && isset($number_order_arr[6]) && isset($number_order_arr[7]))
{$number_order = $number_order_arr[5].$number_order_arr[6].$number_order_arr[7];} else {$number_order = '';}


$order_staff_obj_arr = explode('&&', $order_staff_obj);
if (isset($order_staff_obj_arr[0])) {$sear_id_staff = $order_staff_obj_arr[0];} else {$sear_id_staff = '';}


$obj_nms_arr = explode('&&', $name_ord_obj);
if (!isset($obj_nms_arr[0])) {$obj_nms_arr[0] = '';}
if (!isset($obj_nms_arr[1])) {$obj_nms_arr[1] = '';}




if ($date_obj == '0') {
$time_obj_sear_arr = explode('.', $time_obj); 	
if (isset($time_obj_sear_arr[1])) {$m_sear = $time_obj_sear_arr[1];} else {$m_sear = '';}
if (isset($time_obj_sear_arr[2])) {$y_sear = $time_obj_sear_arr[2];} else {$y_sear = '';}
} else {
$date_obj_sear_arr = explode('.', $date_obj);	
if (isset($date_obj_sear_arr[1])) {$m_sear = $date_obj_sear_arr[1];} else {$m_sear = '';}
if (isset($date_obj_sear_arr[2])) {$y_sear = $date_obj_sear_arr[2];} else {$y_sear = '';}
}
$month_sear = $m_sear.'.'.$y_sear;

$phone_client_sear_obj = str_replace('+', '', $phone_client_obj);

$str_search = '::'.$obj_nms_arr[0].'::'.$obj_nms_arr[1].'::'.$date_obj.'::'.$time_obj.'::'.$client_name_ord_obj.'::'.$phone_client_sear_obj.'::'.$mail_client_obj.'::'.$sear_id_staff.'::'.$number_order.'::'.$month_sear.'::'.$add_ip_obj;

$str_search = mb_strtolower($str_search, 'utf8');
$str_search = str_replace(array('||', '&&'), '::', trim($str_search));






//=====================================================================SEARCH 
if (isset($_GET['search']) == true) {
if (empty($_GET['search'])) { 

	} else {
		
$_GET['search'] = urldecode($_GET['search']);
$query = mb_strtolower($_GET['search'], 'utf8');	
$query = str_replace('+', '', $query);



//echo $str_search;
if (preg_match('/::'.$query.'/i', $str_search)) {$actual = '1'; $found_search = '1';} else {$actual = '0';}



	}
}
//==================================================================/SEARCH














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


$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//DELET

if ($access_level == 'super_admin') {	
	
if (isSet($lines[(integer) $n_pr]) == true) 
    {   unset($lines[(integer) $n_pr]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 
	
} 

if ($num_del_lines != $n_pr) {$swing_line = '1'; $act_done = '0';}//num lines	

} else {
if (!preg_match('/'.$id_del_lines.'/i', $ID_str)) {$swing_line = '1'; $act_done = '0';}
}//Check ID


}//count del lines



}//post #order		
}//post delet




$cl_actual = 'all';



if (isset($_GET['search'])) {
if ($actual == '1') {$display_order = '1';} else {$display_order = '0';} //display actual orders
} else {$display_order = '1';}


if ($display_order == '1') {
$num_ord++;

if($price_ord_obj != '0.0999') {
$count_summ_str .= $price_ord_obj.'::'.$cur_obj.'||';
}
$currency_str .= $cur_obj.'||';

$class_line = '';
if ($num_ord % 2 == 0) {$class_line = 'first';} else {$class_line = 'second';}


echo '<ul id="position'.$number_line.'" class="'.$class_line.' '.$cl_actual.'">';

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
echo '<label><input type="checkbox" name="check_order['.$n_pr.']" value="'.$n_pr.'&&'.$id_order_obj.'" id="cho'.$n_pr.'" class="chord" onclick="ch_order('.$n_pr.')" /><span></span></label>';}

echo '</div>
<div class="clear"></div>
</li>';






echo '<li class="tools">'.$number_line.' <div class="display_id" id="line'.$number_line.'"></div></li>';

echo '<li class="four">'; //================================== NAME OBJ
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


if (isset($_GET['search']) && $_GET['search'] == $vds_arr[0]) {
echo '<li class="this_user"><i class="icon-right-big"></i> '.$vds_arr[1].'</li>'; } 
else { echo '<li><i class="icon-user"></i> '.$vds_arr[1].'</li>'; }	

	

}
echo '</ul>';
echo '</div>';
//-----------------------------------------------/display staff


if(!empty($number_order)){
echo '<span class="order_number">'.$lang['order_number'].': <b>'.$number_order.'</b></span>'; }



echo '<div class="clear"></div></li>';// =====/NAME OBJ


echo '<li class="four">'; //==========================DATE / TIME
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
echo '<li class="four"><span class="disp_date">'.$spots_ord_obj.'</span>';
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

echo '<li class="four">
<span class="disp_date name_client">'.$client_name_ord_obj.'</span>';

//---------------------------------contacts info
if(!empty($phone_client_obj)) {
echo'<span class="ord_cont_info"><i class="icon-phone"></i>'.$phone_client_obj.' <a href="skype:'.$phone_client_obj.'"><i class="icon-skype"></i></a></span>';}

if(!empty($mail_client_obj)) {
echo'<span class="ord_cont_info"><i class="icon-mail-3"></i><a href="mailto:'.$mail_client_obj.'">'.$mail_client_obj.'</a></span>';}


if(!empty($phone_client_obj) || !empty($mail_client_obj)) {echo'<span class="ord_cont_info_bott"></span>';}
//---------------------------------/contacts info

if (!empty($comment_client_obj)) { echo '<div class="help_obj comment_client" tabindex="1"><i class="icon-comment-1"></i><div>'.$comment_client_obj.'</div></div>'; }

echo '<span class="disp_date_list_add">'.$add_date_obj.'</span>
<span class="disp_date_list"><small>IP: '.$add_ip_obj.'</small></span>';

if ($status_obj == '2') {
echo '<span class="ord_cont_info_bott"></span>';
if (!empty($payment_sys)) {echo '<div class="st_txt">'.$lang['payment_way'].': '.$payment_sys.'</div>';} else {echo '<div class="st_txt">'.$lang['payment_way'].': '.$lang['payment_fact'].'</div>';}
}

echo '</li>'; //==========================/CLIENT / ADD



//==========================/STATUS
//echo '<li>';
//'.$status_obj.'


$select_status_opt = '';


$ic_st = '';
$status_t = '';
if ($status_obj == '0') {$status_t = $status_arr[0]; $ic_st = '<i class="icon-bell-off iorange"></i>';}
if ($status_obj == '1') {$status_t = $status_arr[1]; $ic_st = '<i class="icon-bell-alt iblue"></i>'; }
if ($status_obj == '2') {$status_t = $status_arr[2]; $ic_st = '<i class="icon-ok-1 igreen"></i>'; }
//if ($status_obj == '3') {$status_t = $status_arr[3]; $ic_st = '<i class="icon-right-big"></i>'; }


//echo '<div class="sl_block">';

//echo '<div class="st_ind" title="'.$status_t.'">'.$ic_st.'</div>';

//echo '<div class="sel_st">';
//echo '<select name="status'.$ls.'" id="cst'.$ls.'" onChange="change_status('.$ls.')" class="sels">'.$select_status_opt.'</select>';
//echo '</div>';

//echo '<div class="clear"></div>';

//echo '<div class="st_txt">'.$status_t.'</div>';

//echo '</div>';

//echo '</li>'; //==========================/STATUS


//echo '<li class="tools"><a href="" title="'.$lang['edit'].' '.$lang['order'].' '.$lang['in'].' &quot;'.$disp_obj_cat_arr[0].'&quot;" class="edit"><i class="icon-edit-alt"></i></a></li>';



echo '<li class="tools"><a href="'.$script_name.'?delete='.$n_pr.'&id='.$id_order_obj.'&page='.$page.'" title="'.$lang['delete'].' '.$lang['order'].' '.$lang['in'].' &quot;'.$disp_obj_cat_arr[0].'&quot;" class="delete" onclick ="return confirm(\''.$lang['order'].' '.$lang['in'].' &quot;'.$disp_obj_cat_arr[0].'&quot; '.$lang['delete_m'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';


echo '<div class="clear"></div>';
echo '</ul>';


} //DISPLAY ORDER


















} //no empty lines 

else { //==============DELETE EMPTY LINES

$crlf = "\n"; 
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//delete process
if (empty($lines[$n_pr])) {
    if (isSet($lines[(integer) $n_pr]) == true) 
    {   unset($lines[(integer) $n_pr]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file);  
	//echo $refresh_0; 
}
	
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
<input type="checkbox" name="act_ord" value="del" class="act_ch" onclick="action_order()" />
<span class="fleft"></span><div class="name_ch_tools fleft">'.$lang['delete'].'</div>
</label><div class="clear"></div></div>';

//echo '<div class="ch_bl flno"><label>
//<input type="radio" name="act_ord" value="chs" class="act_ch" id="chsel" onclick="action_order()" />
//<span class="fleft"></span><div class="name_ch_tools fleft">'.$lang['change_status'].'</div>
//</label><div class="clear"></div></div>';


$select_status_m = '';
foreach ($status_arr as $kstm => $vstm){ 
$select_status_m .= '<option value="'.$kstm.'">'.$vstm.'</option>';
}
echo '<div id="selm"><select name="statusm" class="sels">'.$select_status_m.'</select></div>';




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
	
if ($access_level == 'super_admin') { //access	
	
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';
	
echo '<script>
var delay = 1000;setTimeout("document.location.href=\''.$script_name.'?act=done'.$actual_u_alt.'&page='.$page.'\'", delay);
</script>
<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?act=done'.$actual_u_alt.'&page='.$page.'"></noscript>';

} else { 
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;
} //access	

}

if (isset($_GET['delete']) && $access_level != 'super_admin') {
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;	
} //access	


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




//=====================================SEARCH INFO



$count_summ_arr = explode('||', $count_summ_str); array_pop($count_summ_arr);
$currency_arr = explode('||', $currency_str); array_pop($currency_arr);
$currency_arr = array_unique($currency_arr);



if (isset($_GET['search'])) {
echo '<div class="search_info">';	

echo '<table>';

echo '<tr>';
echo '<td>'.$lang['found_order'].':</td><td><span class="st_count_ord"><b>'.$num_ord.'</b></span></td>';	
echo '</tr>';


//echo '<tr class="total_cr">';
//echo '<td colspan="2">'.$lang['total_count_summ_currency'].':</td>';	
//echo '</tr>';


foreach($currency_arr as $kcr => $vcr) {
echo '<tr>';
echo '<td>'.$vcr.':</td><td><span class="st_count_ord"><span id="'.$vcr.'"></span></span></td>';

echo '<script>';
echo '
var bl_'.$vcr.' = document.getElementById("'.$vcr.'");
var total_'.$vcr.' = 0;

total_'.$vcr.' = ';foreach($count_summ_arr as $kcs => $vcs) {$vcs_arr = explode('::', $vcs);if (isset($vcs_arr[0])) {  $s_pr = $vcs_arr[0]; } else {$s_pr = '0';}if (isset($vcs_arr[1])) {$s_cr = $vcs_arr[1];} else {$s_cr = '';}if ($s_cr == $vcr) { echo $s_pr.'+';  } } echo '0;';
echo 'bl_'.$vcr.'.innerHTML = total_'.$vcr.';';
echo '</script>';

echo '</tr>';
}


echo '</table>';

echo '</div>'; //search_info
}





echo '</div>'; //============================DIV MAIN
} //no empty data file






//echo '<div id="add_data" class="add">
//<a href="../index.php" class="iframe">
//<span class="text"><i class="icon-plus"></i>'.$lang['add'].'</span>
//</a>
//<div class="clear"></div>
//</div>'; // ADD BUTTON





} else { // no data file

//=============================CREATE DATA FILE
$line_data_add = '';

$fp_create = fopen($file_name, "w"); // create data file
fwrite($fp_create, "$line_data_add");
fclose ($fp_create);

//echo '<div class="error">'.$lang['no_file'].'</div>';
echo $refresh_0;
}


if (!isset($_GET['search'])) {
if (isset($numpageblock)) { echo $numpageblock; }
}

}// access



?>