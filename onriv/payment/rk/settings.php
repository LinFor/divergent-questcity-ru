<?php
if (!isset($payment_settings)) {die;}
include ('../payment/rk/config.php');

$file_name_rk_config = '../payment/rk/config.php';

$md_dir = $_SERVER['PHP_SELF'];
$md_dir = str_replace('apanel/settings.php', '', $md_dir);
$retrun_url_ym = 'http://'.$_SERVER['SERVER_NAME'].$md_dir.'payment/rk/display.php'; // url for done payment and change order status

$module_name[$index_module] = 'Робокасса'; // Name module
$module_description[$index_module] = 'Настройки оплаты через Робокассу'; // Description module (optional)
$module_img[$index_module] = '<a href="http://www.robokassa.ru/" target="_blank"><img src="../payment/rk/rk_logo.png" alt="Робокасса" /></a>';

if (isset($rk_active)) { $add_rk_active = $rk_active; } else { $rk_active = '0'; }	
if (isset($rk_login)) { $add_rk_login = $rk_login; } else { $rk_login = ''; }
if (isset($rk_pass)) { $add_rk_pass = $rk_pass; } else { $rk_pass = ''; }

if (isset($_POST['rk_active'])) { $add_rk_active = '1'; } else { $add_rk_active = '0'; }
if ($add_rk_active == '1' || $rk_active == '1') { $rk_active_checked = 'checked="checked"';} else { $rk_active_checked = '';}

if (isset($_POST['rk_login'])) {
$_POST['rk_login'] = str_replace(array('"', "'", '\"', "\'"), '', trim($_POST['rk_login']));
$add_rk_login = $_POST['rk_login'];
}
if (isset($_POST['rk_pass'])) {
$_POST['rk_pass'] = str_replace(array('"', "'", '\"', "\'"), '', trim($_POST['rk_pass']));
$add_rk_pass = $_POST['rk_pass'];
}





//==============================CONFIG VALUES	
$rk_config_data = '
<?php
$rk_active = "'.$add_rk_active.'";
$rk_login = "'.$add_rk_login.'";
$rk_pass = "'.$add_rk_pass.'";
?>
';	
//-----------------------------/config values	

if (isset($_POST['rk_config_replace'])) {
$fp_create_rk_config = fopen($file_name_rk_config, "w"); // create config file
fwrite($fp_create_rk_config, "$rk_config_data");
fclose ($fp_create_rk_config);

echo '<script>
var anc_rep = window.location.hash;
document.location.href="'. $script_name .'?rand='. $rnd_num .'"+anc_rep;
</script>
<noscript><meta http-equiv="refresh" content="0; url='. $script_name .'"></noscript>';	


unset ($_POST['rk_active']);	
unset ($_POST['rk_login']);
}


//=================================================Settings form
$module_body[$index_module] = '<table><form action="" method="post">';

$module_body[$index_module] .= '<tr><td>Активировать модуль:</td><td><input type="checkbox" name="rk_active" value="1" '.$rk_active_checked.'/></td></tr>';
$module_body[$index_module] .= '<tr><td>Наименование магазина (Идентификатор):</td><td><input type="text" name="rk_login" value="'.$add_rk_login.'" /></td></tr>';
$module_body[$index_module] .= '<tr><td>Пароль #1:</td><td><input type="text" name="rk_pass" value="'.$add_rk_pass.'" /></td></tr>';
$module_body[$index_module] .= '<tr><td>Адрес возврата данных о платеже:</td>
<td><span class="sett_url">'.$retrun_url_ym .'</span>
<span class="sett_url_desc"><small>Укажите этот адрес в поле "<b>Result Url</b>", в <a href="https://partner.robokassa.ru/Shops" target="_blank" title="откроется в новой вкладке">технических настройках</a> вашего магазина. Поле "<b>Алгоритм расчета хеша</b>" должно содержать <b>MD5</b>.</small></span>
</td></tr>';
$module_body[$index_module] .= '<tr><td></td><td><input type="hidden" name="rk_config_replace" value="1" /><button>Применить</button></td></tr>';

$module_body[$index_module] .= '</form></table>';
?>