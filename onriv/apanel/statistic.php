<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)

$names_obj_str = '';
$names_obj_arr = array();

$names_lost_obj_str = '';
$names_lost_obj_arr = array();

$names_obj_ord_str = '';
$names_obj_ord_arr = array();

$ord_str = '';
$ord_arr = array();

$lost_ord_str = '';
$lost_ord_arr = array();

$total_count_ord = 0;
$total_count_lost_ord = 0;

$money_ord_str = '';
$money_ord_arr = array();

$curr_ord_str = '';
$curr_ord_arr = array();


$clients_str = '';
$clients_mail_str = '';
$clients_phone_str = '';

$file_name = '../data/history.dat';
$file_name_category = '../data/category.dat';
$file_name_ord_obj = '../data/object.dat'; 

if ($id_prefix == 'logbook') {

echo '<div class="statistic">';


echo '<h3>'.$lang['statistics'].' '.$lang['in'].' '.$day_cl.' '.$lang_monts_r[$m_cl].' '.$y_cl.'</h3>';

//=====================================COUNT NAME OBJ

if (file_exists($file_name_ord_obj)) {
$data_file_obj = fopen($file_name_ord_obj, "rb"); 
if (filesize($file_name_ord_obj) != 0) {
flock($data_file_obj, LOCK_SH); 
$lines_obj = preg_split("~\r*?\n+\r*?~", fread($data_file_obj,filesize($file_name_ord_obj))); 
flock($data_file_obj, LOCK_UN); 
fclose($data_file_obj); 

for ($cobj = 0; $cobj < sizeof($lines_obj); ++$cobj) { 

$obj_data = explode('::', $lines_obj[$cobj]); 
if (isset($obj_data[0])) {$id_st_obj = $obj_data[0];} else {$id_st_obj = '';}
if (isset($obj_data[1])) {$nm_st_obj = $obj_data[1];} else {$nm_st_obj = '';}
if (isset($obj_data[3])) { $category_obj = $obj_data[3]; } else {$category_obj = '';}

$name_cat_disp = '';
$found_cat = '0';
if (empty($category_obj)) { $name_cat_disp = '<small>('.$lang['no_category'].')</small>'; } else {
$found_cat = '0';
if (file_exists($file_name_category)) {	
$file_category = fopen($file_name_category, "rb"); 
if (filesize($file_name_category) != 0) { // !0
flock($file_category, LOCK_SH); 
$lines_category_display = preg_split("~\r*?\n+\r*?~", fread($file_category,filesize($file_name_category)));
flock($file_category, LOCK_UN); 
fclose($file_category); 
for ($lcd = 0; $lcd < sizeof($lines_category_display); ++$lcd) { 
if (!empty($lines_category_display[$lcd])) {
$data_categories_disp = explode('::', $lines_category_display[$lcd]); 
$id_cat_disp = $data_categories_disp[0];

if ($category_obj == $id_cat_disp) {$name_cat_disp = '<small>('.$data_categories_disp[1].')</small>'; $found_cat = '1';} // display cat
} //no empty lines cat
} //count cat
} //else { echo '<span class="red_text">'.$lang['category_empty'].' </span>';} //filesize cat
} //file_exists cat
if ($found_cat == '0') { $name_cat_disp = '<small>(<span class="orange_text">'.$lang['category_not_found'].'</span>)</small>';}
} // category no empty




$names_obj_str .= $id_st_obj.'::'.$nm_st_obj.' '.$name_cat_disp.'||'; 

} // count lines obj
} // check file size !=0
} // file exsits obj
//====================================/count obj



$summ_ord = 0;



if (file_exists($file_name)) { // keep data file 
if (filesize($file_name) != 0) {
for ($ls = 0; $ls < sizeof($lines_data); ++$ls) { 
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

$nm_obj_arr = explode('&&', $name_ord_obj);
if (isset($nm_obj_arr[0])) {$lnm = $nm_obj_arr[0];} else {$lnm = '';}
if (isset($nm_obj_arr[1])) {$lcm = '<small>('.$nm_obj_arr[1].')</small>';} else {$lcm = '';}

$names_obj_ord_str .= $id_obj_obj.'::'.$lnm.' '.$lcm.'||'; //=======================================
if($price_ord_obj != '0.0999') {
$money_ord_str .= $cur_obj.'::'.$price_ord_obj.'||';
}
$curr_ord_str .= $cur_obj.'::';

//==================for clients

$clients_str .= $client_name_ord_obj.'::'.$phone_client_obj.'::'.$mail_client_obj.'||';
$clients_mail_str .= $mail_client_obj.'||';
$clients_phone_str .= $phone_client_obj.'||';


} //no empty
} //count lines
} //!=0
} //file exsits












$names_obj_arr = explode('||', $names_obj_str); 
array_pop($names_obj_arr);


$names_obj_ord_arr = explode('||', $names_obj_ord_str); 
array_pop($names_obj_ord_arr);




foreach ($names_obj_arr as $kobj => $vobj) {
$vobj_arr = explode('::',$vobj);
if (isset($vobj_arr[0])) {$ido = $vobj_arr[0];} else {$ido = '';}
if (isset($vobj_arr[1])) {$nmo = $vobj_arr[1];} else {$nmo = '';}

foreach ($names_obj_ord_arr as $kor => $vor) {
$vor_arr = explode('::',$vor);
if (isset($vor_arr[0])) {$idor = $vor_arr[0];} else {$idor = '';}
if (isset($vor_arr[1])) {$nmor = $vor_arr[1];} else {$nmor = '';}

if ($ido == $idor) { $ord_str .= $nmo.'||';  } 

}

}


$id_str1 = '';
foreach ($names_obj_ord_arr as $kor => $vor) {
$vor_arr = explode('::',$vor);
if (isset($vor_arr[0])) {$idor = $vor_arr[0];} else {$idor = '';}
if (isset($vor_arr[1])) {$nmor = $vor_arr[1];} else {$nmor = '';}
$id_str1 .= $idor.'||';
}


$id_str2 = '';
foreach ($names_obj_arr as $kobj => $vobj) {
$vobj_arr = explode('::',$vobj);
if (isset($vobj_arr[0])) {$ido = $vobj_arr[0];} else {$ido = '';}
if (isset($vobj_arr[1])) {$nmo = $vobj_arr[1];} else {$nmo = '';}
$id_str2 .= $ido.'||';
}



//======================LOST OBJ
$id_arr1 = explode('||', $id_str1); array_pop($id_arr1);

$id_arr2 = explode('||', $id_str2); array_pop($id_arr2);

$result = array_diff($id_arr1, $id_arr2);
//======================LOST OBJ






$ord_arr = explode('||', $ord_str); array_pop($ord_arr);




$ms1 = $ord_arr;
$ms2 = $ord_arr;


$diffz = array_intersect($ms1, $ms2); 
$diffz = array_count_values($diffz);

echo '<table>';
echo '<tr><th>'.$lang['services'].'</th><th>'.$lang['count_orders'].'</th></tr>';

arsort($diffz);
foreach ($diffz  as $k=>$v) {
echo '<tr><td>'.$k.'</td><td><span class="st_count_ord">'.$v.'</span></td></tr>';	
$total_count_ord += $v;
}

echo '</table>';









//======================LOST OBJ
if (sizeof($result) > 0) {
	
$msl1 = $result;
$msl2 = $result;


$diffzl = array_intersect($msl1, $msl2); 
$diffzl = array_count_values($diffzl);

echo '<table class="lost_obj">';
//echo '<tr><th colspan="2">LOST OBJ:</th></tr>';


arsort($diffzl);
foreach ($diffzl  as $k=>$v) {
	
foreach ($names_obj_ord_arr as $kor => $vor) {
$vor_arr = explode('::',$vor);
if (isset($vor_arr[0])) {$idor = $vor_arr[0];} else {$idor = '';}
if (isset($vor_arr[1])) {$nmor = $vor_arr[1];} else {$nmor = '';}
if ($k == $idor) {$lnamor = $nmor;}	
}

echo '<tr><td>'.$lnamor.' <i class="icon-trash-2"></i></td><td><span class="st_count_ord">'.$v.'</span></td></tr>';

$total_count_lost_ord += $v;
}

echo '</table>';
}
//======================TOTAL
echo '<table>';
echo '<tr class="st_total_orders">';
echo '<td>'.$lang['total_count_orders'].':</td><td><span class="st_count_ord">'.($total_count_ord + $total_count_lost_ord).'</span></td>';
echo '</tr>';
echo '</table>';



//===============================================MONEY
$currency_name_arr = explode('::', $currency_name); array_pop($currency_name_arr);


if (isset($_GET['currency'])) {$gcurr = $_GET['currency'];} else {$gcurr = $currency_name_arr[0];}

$money_ord_arr = explode('||', $money_ord_str); array_pop($money_ord_arr);





	
foreach ($money_ord_arr	as $km => $vm) {

$vm_arr = explode('::', $vm);
if (isset($vm_arr[0])) { $curr = $vm_arr[0]; } else {$curr = '';}	
if (isset($vm_arr[1])) { $summ = $vm_arr[1]; } else {$summ = '';}		
	
if ($curr == $gcurr) {
$summ_ord += $summ; 	
}

} //foreach $money_ord_arr	
	




$curr_ord_arr = explode('::', $curr_ord_str); array_pop($curr_ord_arr);
$all_curr_arr = $currency_name_arr + $curr_ord_arr;
$all_curr_arr = array_unique($all_curr_arr);


echo '<table class="sel_curr"><tr>';

echo '<td><span class="left">'.$lang['total_count_summ_currency'].': </span>';

echo '<form action="" method="get"><select name="currency" id="curr_sel" onchange="curr_filter()">';
foreach ($all_curr_arr as $kcr => $vcr) {
echo '<option value="'.$vcr.'"'; if($vcr == $gcurr) {echo ' selected="selected"';} echo '>'.$vcr.'</option>';	
}
echo '</select></form>';

echo '</td>';

echo '<td><span class="st_count_summ">'.$summ_ord.' '.$gcurr.'</span></td>';


echo '</tr></table>';

echo '
<script>
function curr_filter() {
var cselc = document.getElementById("curr_sel");
var cvalc = cselc.options[cselc.selectedIndex].value;

document.location.href="'.$script_name.'?currency="+cvalc+"#tab2";	
}
</script>
';







echo '</div>';

} // id perefix

echo '<div class="clear"></div>'; 


?>