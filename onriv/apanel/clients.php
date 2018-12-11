<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)


if ($id_prefix == 'logbook') {


$clients_arr = array();
$clients_mail_arr = array();
$clients_phone_arr = array();
$cl_arr = array();

$cl_name_str = '';
$cl_mail_str = '';
$cl_phone_str = '';

$clients_arr = explode ('||', $clients_str); array_pop ($clients_arr);
//$clients_arr = array_reverse($clients_arr);

$clients_mail_arr = explode ('||', $clients_mail_str); array_pop ($clients_mail_arr);
$clients_phone_arr = explode ('||', $clients_phone_str); array_pop ($clients_phone_arr);

if (isset($_GET['phone'])) { $cl_arr = $clients_phone_arr; $p_class = 'cid'; $m_class = '';} else { $cl_arr = $clients_mail_arr; $p_class = ''; $m_class = 'cid'; }



$arrcl1 = $cl_arr;
$arrcl2 = $cl_arr; 


$diff_cl = array_intersect($arrcl1, $arrcl2); 
$diff_cl = array_count_values($diff_cl);


echo '<div class="statistic">';

echo '<h3>'.$lang['statistics'].' '.$lang['in'].' '.$day_cl.' '.$lang_monts_r[$m_cl].' '.$y_cl.'</h3>';

echo '<table class="clients">';
echo '<tr>
<th>'.$lang['clients'].'</th>
<th><i class="icon-mail-2 '.$m_class.'"></i><a href="logbook.php#tab3" class="'.$m_class.'" title="'.$lang['identify_mail'].'">'.$lang['mail'].'</a></th>
<th><i class="icon-phone-2 '.$p_class.'"></i><a href="logbook.php?phone#tab3" class="'.$p_class.'" title="'.$lang['identify_phone'].'">'.$lang['phone'].'</a></th>
<th>'.$lang['count_orders'].'</th>
</tr>';

arsort($diff_cl);
foreach ($diff_cl  as $k=>$v) {





echo '<tr>';

if (empty($k)) {

echo '<td></td>';
if (isset($_GET['phone'])) { echo '<td></td>'; } else { echo '<td><span class="gray_text">'.$lang['not_specified'].'</span></td>'; }
if (isset($_GET['phone'])) { echo '<td><span class="gray_text">'.$lang['not_specified'].'</span></td>'; } else { echo '<td></td>'; }
echo '<td><span class="st_count_ord">'.$v.'</span></td>';

} else {


foreach ($clients_arr as $k_cl => $v_cl) {
$v_cl_arr = explode('::', $v_cl);
if (isset($v_cl_arr[0])) {$cl_name = $v_cl_arr[0];} else {$cl_name = 0;}	
if (isset($v_cl_arr[1])) {$cl_phone = $v_cl_arr[1];} else {$cl_phone = 0;}	
if (isset($v_cl_arr[2])) {$cl_mail = $v_cl_arr[2];} else {$cl_mail = 0;}	





if (isset($_GET['phone'])) {
	
if ($k == $cl_phone) {
	
$phone_sear_a = str_replace('+', '', $cl_phone);
	
echo '
<td>'.$cl_name.'</td> 
<td>'.$cl_mail.'</td>
<td><a href="logbook.php?search='.$phone_sear_a.'" title="'.$lang['view_orders'].'">'.$cl_phone.'</a></td>';
break;
}


} else {
	
	
if ($k == $cl_mail) {
$cl_name_str .= $cl_name.'||';
$cl_phone_str .= $cl_phone.'||';
echo '
<td>'.$cl_name.'</td> 
<td><a href="logbook.php?search='.$cl_mail.'" title="'.$lang['view_orders'].'">'.$cl_mail.'</a></td>
<td>'.$cl_phone.'</td>'; 
break;
}
	
}



}


echo '<td><span class="st_count_ord">'.$v.'</span></td>';

} //empty $k

echo '</tr>';




}




echo '</table>';


echo '</div>';





} // id perefix
echo '<div class="clear"></div>'; 


?>