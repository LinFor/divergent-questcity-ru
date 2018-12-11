<?php
$md_dir = $_SERVER['PHP_SELF'];
$md_dir = str_replace('payment/yandex_money/display.php', '', $md_dir);
$retrun_url_ym = 'https://'.$_SERVER['SERVER_NAME'].$md_dir.'index.php'; // url for done payment and change order status

if (isset($_POST['ag_paymentType'])) {$ag_pt = $_POST['ag_paymentType'];} else {$ag_pt = '';}

if (isset($_POST['label'])) {

$payment_confirm = $_POST['label'];
$payment_system = 'Яндекс Деньги';
$folder = '../../'; $psep = '';
include ('../../index.php');	

die;	
}


if (!isset($payment_display)) {die;}
include ($folder.$psep.'payment/yandex_money/config.php');


if ($yandex_money_active == '1' && !empty($yandex_money_receiver)) {
$display_module[$index_module] = '1';
echo '<div>';
echo '<label title="Яндекс Деньги">';
echo '<input type="radio" id="ag_ymch" name="payment" value="'.$index_module.'" '.$checked_module[$index_module].' onclick="ag_select_type()" />';
echo '<div>';
echo '<img src="'.$folder.$psep.'payment/yandex_money/yandex_money_logo.png" alt="yandex_money" />';
echo '<div class="clear"></div>';
echo '</div>';
echo '</label>';

echo '<div id="ag_ympt">';
echo '<div>';

echo '<label><input type="radio" name="ag_paymentType" value="AC"'; if(isset($_POST['ag_paymentType']) && $_POST['ag_paymentType'] == 'AC') {echo ' checked="checked"';} if(!isset($_POST['ag_paymentType'])) {echo ' checked="checked"';} echo ' />банковской картой</label>';

echo '<label><input type="radio" name="ag_paymentType" value="PC"'; if(isset($_POST['ag_paymentType']) && $_POST['ag_paymentType'] == 'PC') {echo ' checked="checked"';} echo ' />оплата из кошелька</label>'; 

echo '<label><input type="radio" name="ag_paymentType" value="MC"'; if(isset($_POST['ag_paymentType']) && $_POST['ag_paymentType'] == 'MC') {echo ' checked="checked" ';} echo ' />с баланса мобильного</label>';

echo '<div class="clear"></div>';
echo '</div>'; 
echo '</div>'; 

echo '</div>'; 


echo '
<script>
var ymch = document.getElementById("ag_ymch");
var ymbl = document.getElementById("ag_ympt");
ymbl.setAttribute("style","visibility: hidden; opacity: 0;");

setTimeout (function() {
if (ymch.checked) {ymbl.removeAttribute("style");} 
}, 100);

function ag_select_type() {
if (ymch.checked) {ymbl.removeAttribute("style");} else {ymbl.setAttribute("style","visibility: hidden; opacity: 0;");}		
}
</script>
';


}

//===================================================
if (isset($_POST['booking']) && !isset($ERROR) && !isset($_GET['edit']) && $stop_booking == '0') {
if (isset($_POST['payment_online']) && isset($_POST['payment']) && $_POST['payment'] == $index_module) {
	
echo '<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"> ';
    echo '<input type="hidden" name="receiver" value="'.$yandex_money_receiver.'" />'; 
    echo '<input type="hidden" name="formcomment" value="'.$name_obj_done.'" />'; 
    echo '<input type="hidden" name="short-dest" value="'.$name_obj_done.'" />'; 
    echo '<input type="hidden" name="label" value="'.$id.'" />'; 
    echo '<input type="hidden" name="quickpay-form" value="donate" />'; 
    echo '<input type="hidden" name="targets" value="транзакция '.$number_order.'" />'; 
    echo '<input type="hidden" name="sum" value="'.$add_price.'" data-type="number" />'; 
    echo '<input type="hidden" name="comment" value="'.$add_comment.'" />'; 
    echo '<input type="hidden" name="need-fio" value="true" />'; 
    echo '<input type="hidden" name="need-email" value="true" />'; 
    echo '<input type="hidden" name="need-phone" value="false" />'; 
    echo '<input type="hidden" name="need-address" value="false" />'; 
	
    echo '<input type="hidden" name="paymentType" value="'.$ag_pt.'" />'; 
    
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