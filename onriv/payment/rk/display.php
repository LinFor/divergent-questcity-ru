<?php
$md_dir = $_SERVER['PHP_SELF'];
$md_dir = str_replace('payment/rk/display.php', '', $md_dir);
$retrun_url_ym = 'http://'.$_SERVER['SERVER_NAME'].$md_dir.'index.php'; // url for done payment and change order status



if (isset($_POST['shp_id'])) {

$payment_confirm = $_POST['shp_id'];
$payment_system = 'Робокасса';
$folder = '../../'; $psep = '';
include ('../../index.php');	

die;	
}


if (!isset($payment_display)) {die;}
include ($folder.$psep.'payment/rk/config.php');


if ($rk_active == '1' && !empty($rk_login) && !empty($rk_pass)) {
$display_module[$index_module] = '1';
echo '<label title="Робокасса">';
echo '<input type="radio" name="payment" value="'.$index_module.'" '.$checked_module[$index_module].' onclick="ag_select_type()" />';
echo '<div>';
echo '<img src="'.$folder.$psep.'payment/rk/rk_logo.png" alt="rk" />';
echo '<div class="clear"></div>';
echo '</div>';
echo '</label>';
}

//===================================================
if (isset($_POST['booking']) && !isset($ERROR) && !isset($_GET['edit']) && $stop_booking == '0') {
if (isset($_POST['payment_online']) && isset($_POST['payment']) && $_POST['payment'] == $index_module) {
	

  
//==============================================
// регистрационная информация (Идентификатор магазина, пароль #1)
// registration info (Merchant ID, password #1)
$mrh_login = $rk_login;
$mrh_pass1 = $rk_pass;

// номер заказа
// number of order
//$number_order
$inv_id = $number_order;

// описание заказа
// order description
$inv_desc = $name_obj_done;

// сумма заказа
// sum of order
//$add_price.'00';
if (preg_match("/./u", $add_price)) {
$out_summ_arr = explode('.', $add_price);
if (isset($out_summ_arr[0])) {$f_pr = $out_summ_arr[0];} else {$f_pr = '0';}
if (isset($out_summ_arr[1])) {$s_pr = $out_summ_arr[1];} else {$s_pr = '00';}
if (strlen($s_pr) == 1) {$s_pr = $s_pr.'0';}
$out_summ = $f_pr.'.'.$s_pr;
} else {$out_summ = $add_price.'00';}



//--------------
$shp_id = $id;
// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "BANKOCEAN2R";

// язык
// language
$culture = "ru";

// кодировка
// encoding
$encoding = "utf-8"; 

// Адрес электронной почты покупателя
// E-mail
$Email = $add_mail;


// Валюта счёта
// OutSum Currency
$OutSumCurrency = '';
if ($add_currency != 'RUB'){$OutSumCurrency = $add_currency;}


// формирование подписи
// generate signature
if ($add_currency != 'RUB') {
$crc = md5("$mrh_login:$out_summ:$inv_id:$OutSumCurrency:$mrh_pass1:shp_id=$shp_id"); 
} else {
$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:shp_id=$shp_id");
}


// форма оплаты товара
// payment form

echo '<form action="https://auth.robokassa.ru/Merchant/Index.aspx" method="POST">';
echo '<input type="hidden" name="MrchLogin" value="'.$mrh_login.'" />';
echo '<input type="hidden" name="OutSum" value="'.$out_summ.'" />';
echo '<input type="hidden" name="InvId" value="'.$inv_id.'" />';
echo ' <input type="hidden" name="Desc" value="'.$inv_desc.'" />';
echo '<input type="hidden" name="SignatureValue" value="'.$crc.'" />';
echo '<input type="hidden" name="shp_id" value="'.$shp_id.'" />';
   //echo '<input type="hidden" name="IncCurrLabel" value="'.$in_curr.'" />';
echo '<input type="hidden" name="Culture" value="'.$culture.'" />';
echo '<input type="hidden" name="Email" value="'.$Email.'" />';
if ($add_currency != 'RUB') { echo '<input type="hidden" name="OutSumCurrency" value="'.$OutSumCurrency.'" />'; }

echo '<button class="ag_no_view" id="pay_submit"></button>';
echo '</form>';

if ($stop_booking == '0') {
echo '
<script>
var pay_button = document.getElementById("pay_submit");
setTimeout (function() { pay_button.click(); }, 5000);	
</script>
';	
}
	
}

}








?>