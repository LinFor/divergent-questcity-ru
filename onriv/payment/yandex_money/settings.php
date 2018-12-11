<?php
if (!isset($payment_settings)) {die;}
include ('../payment/yandex_money/config.php');

$file_name_yandex_money_config = '../payment/yandex_money/config.php';

$md_dir = $_SERVER['PHP_SELF'];
$md_dir = str_replace('apanel/settings.php', '', $md_dir);
$retrun_url_ym = 'https://'.$_SERVER['SERVER_NAME'].$md_dir.'payment/yandex_money/display.php'; // url for done payment and change order status

$module_name[$index_module] = 'Яндекс деньги'; // Name module
$module_description[$index_module] = 'Настройки оплаты через Яндекс деньги'; // Description module (optional)
$module_img[$index_module] = '<a href="https://money.yandex.ru" target="_blank"><img src="../payment/yandex_money/yandex_money_logo.png" alt="Яндекс деньги" /></a>';

if (isset($yandex_money_active)) { $add_yandex_money_active = $yandex_money_active; } else { $yandex_money_active = '0'; }	
if (isset($yandex_money_receiver)) { $add_yandex_money_receiver = $yandex_money_receiver; } else { $yandex_money_receiver = ''; }




if (isset($_POST['yandex_money_active'])) { $add_yandex_money_active = '1'; } else { $add_yandex_money_active = '0'; }
if ($add_yandex_money_active == '1' || $yandex_money_active == '1') { $yandex_money_active_checked = 'checked="checked"';} else { $yandex_money_active_checked = '';}

if (isset($_POST['yandex_money_receiver'])) {
$_POST['yandex_money_receiver'] = str_replace(array('"', "'", '\"', "\'"), '', trim($_POST['yandex_money_receiver']));
$add_yandex_money_receiver = $_POST['yandex_money_receiver'];
}






//==============================CONFIG VALUES	
$yandex_money_config_data = '
<?php
$yandex_money_active = "'.$add_yandex_money_active.'";
$yandex_money_receiver = "'.$add_yandex_money_receiver.'";
?>
';	
//-----------------------------/config values	

if (isset($_POST['yandex_money_config_replace'])) {
$fp_create_yandex_money_config = fopen($file_name_yandex_money_config, "w"); // create config file
fwrite($fp_create_yandex_money_config, "$yandex_money_config_data");
fclose ($fp_create_yandex_money_config);

echo '<script>
var anc_rep = window.location.hash;
document.location.href="'. $script_name .'?rand='. $rnd_num .'"+anc_rep;
</script>
<noscript><meta http-equiv="refresh" content="0; url='. $script_name .'"></noscript>';	


unset ($_POST['yandex_money_active']);	
unset ($_POST['yandex_money_receiver']);
}


//=================================================Settings form
$module_body[$index_module] = '<table><form action="" method="post">';

$module_body[$index_module] .= '<tr><td>Активировать модуль:</td><td><input type="checkbox" name="yandex_money_active" value="1" '.$yandex_money_active_checked.'/></td></tr>';
$module_body[$index_module] .= '<tr><td>Номер счёта (кошелька):</td><td><input type="text" name="yandex_money_receiver" value="'.$add_yandex_money_receiver.'" /></td></tr>';
$module_body[$index_module] .= '<tr><td>Адрес возврата данных о платеже:</td>
<td><span class="sett_url">'.$retrun_url_ym .'</span>
<span class="sett_url_desc"><small>Скопируйте этот адрес и укажите в настройках "<a href="https://money.yandex.ru/myservices/online.xml" target="_blank" title="откроется в новой вкладке">Информирование</a>", в поле "<b>HTTP-уведомления</b>".</small></span></td></tr>';
$module_body[$index_module] .= '<tr><td></td><td><input type="hidden" name="yandex_money_config_replace" value="1" /><button>Применить</button></td></tr>';

$module_body[$index_module] .= '</form></table>';
?>