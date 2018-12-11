<?php
if (!isset($payment_settings)) {die;}
include ('../payment/paypal/config.php');

$file_name_paypal_config = '../payment/paypal/config.php';

$module_name[$index_module] = 'PayPal'; // Name module
$module_description[$index_module] = 'Настройки оплаты через PayPal'; // Description module (optional)
$module_img[$index_module] = '<a href="https://www.paypal.com" target="_blank"><img src="../payment/paypal/PayPal-Logo.png" alt="paypal" /></a>';

if (isset($paypal_active)) { $add_paypal_active = $paypal_active; } else { $paypal_active = '0'; }	
if (isset($paypal_mail)) { $add_paypal_mail = $paypal_mail; } else { $paypal_mail = ''; }
if (isset($paypal_sendbox)) { $add_paypal_sendbox = $paypal_sendbox; } else { $paypal_sendbox = '0'; }



if (isset($_POST['paypal_active'])) { $add_paypal_active = '1'; } else { $add_paypal_active = '0'; }
if ($add_paypal_active == '1' || $paypal_active == '1') { $paypal_active_checked = 'checked="checked"';} else { $paypal_active_checked = '';}

if (isset($_POST['paypal_mail'])) {
$_POST['paypal_mail'] = str_replace(array('"', "'", '\"', "\'"), '', trim($_POST['paypal_mail']));
$add_paypal_mail = $_POST['paypal_mail'];
}

if (isset($_POST['paypal_sandbox'])) { $add_paypal_sendbox = '1'; } else { $add_paypal_sendbox = '0'; }
if ($add_paypal_sendbox == '1' || $paypal_sendbox == '1') { $paypal_sendbox_checked = 'checked="checked"';} else { $paypal_sendbox_checked = '';}




//==============================CONFIG VALUES	
$paypal_config_data = '
<?php
$paypal_active = "'.$add_paypal_active.'";
$paypal_mail = "'.$add_paypal_mail.'";
$paypal_sendbox = "'.$add_paypal_sendbox.'";
?>
';	
//-----------------------------/config values	

if (isset($_POST['paypal_config_replace'])) {
$fp_create_paypal_config = fopen($file_name_paypal_config, "w"); // create config file
fwrite($fp_create_paypal_config, "$paypal_config_data");
fclose ($fp_create_paypal_config);

echo '<script>
var anc_rep = window.location.hash;
document.location.href="'. $script_name .'?rand='. $rnd_num .'"+anc_rep;
</script>
<noscript><meta http-equiv="refresh" content="0; url='. $script_name .'"></noscript>';	


unset ($_POST['paypal_active']);	
unset ($_POST['paypal_mail']);
unset ($_POST['paypal_sandbox']);
}


//=================================================Settings form
$module_body[$index_module] = '<table><form action="" method="post">';

$module_body[$index_module] .= '<tr><td>Активировать модуль:</td><td><input type="checkbox" name="paypal_active" value="1" '.$paypal_active_checked.'/></td></tr>';
$module_body[$index_module] .= '<tr><td>PayPal E-mail:</td><td><input type="email" name="paypal_mail" value="'.$add_paypal_mail.'" /></td></tr>';
$module_body[$index_module] .= '<tr><td>Режим Sandbox:</td><td><input type="checkbox" name="paypal_sandbox" value="1" '.$paypal_sendbox_checked.'/></td></tr>';
$module_body[$index_module] .= '<tr><td></td><td><input type="hidden" name="paypal_config_replace" value="1" /><button>Применить</button></td></tr>';

$module_body[$index_module] .= '</form></table>';
?>