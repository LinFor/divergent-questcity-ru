<?php
if (!isset($payment_settings)) {die;}
include ('../payment/qiwi/config.php');

$file_name_qiwi_config = '../payment/qiwi/config.php';

$module_name[$index_module] = 'Qiwi'; // Name module
$module_description[$index_module] = 'Настройки оплаты через qiwi'; // Description module (optional)
$module_img[$index_module] = '<a href="https://ishop.qiwi.com" target="_blank"><img src="../payment/qiwi/qiwi_logo.png" alt="qiwi" /></a>';

if (isset($qiwi_active)) { $add_qiwi_active = $qiwi_active; } else { $qiwi_active = '0'; }	
if (isset($qiwi_from)) { $add_qiwi_from = $qiwi_from; } else { $qiwi_from = ''; }




if (isset($_POST['qiwi_active'])) { $add_qiwi_active = '1'; } else { $add_qiwi_active = '0'; }
if ($add_qiwi_active == '1' || $qiwi_active == '1') { $qiwi_active_checked = 'checked="checked"';} else { $qiwi_active_checked = '';}

if (isset($_POST['qiwi_from'])) {
$_POST['qiwi_from'] = str_replace(array('"', "'", '\"', "\'"), '', trim($_POST['qiwi_from']));
$add_qiwi_from = $_POST['qiwi_from'];
}






//==============================CONFIG VALUES	
$qiwi_config_data = '
<?php
$qiwi_active = "'.$add_qiwi_active.'";
$qiwi_from = "'.$add_qiwi_from.'";
?>
';	
//-----------------------------/config values	

if (isset($_POST['qiwi_config_replace'])) {
$fp_create_qiwi_config = fopen($file_name_qiwi_config, "w"); // create config file
fwrite($fp_create_qiwi_config, "$qiwi_config_data");
fclose ($fp_create_qiwi_config);

echo '<script>
var anc_rep = window.location.hash;
document.location.href="'. $script_name .'?rand='. $rnd_num .'"+anc_rep;
</script>
<noscript><meta http-equiv="refresh" content="0; url='. $script_name .'"></noscript>';	


unset ($_POST['qiwi_active']);	
unset ($_POST['qiwi_from']);
}


//=================================================Settings form
$module_body[$index_module] = '<table><form action="" method="post">';

$module_body[$index_module] .= '<tr><td>Активировать модуль:</td><td><input type="checkbox" name="qiwi_active" value="1" '.$qiwi_active_checked.'/></td></tr>';
$module_body[$index_module] .= '<tr><td>ID проекта:</td><td><input type="text" name="qiwi_from" value="'.$add_qiwi_from.'" /></td></tr>';
$module_body[$index_module] .= '<tr><td></td><td><input type="hidden" name="qiwi_config_replace" value="1" /><button>Применить</button></td></tr>';

$module_body[$index_module] .= '</form></table>';
?>