<?php

if (isset($_POST['payer_email']) && isset($_POST['payment_status']) && isset($_POST['custom'])) {
	


$payment_confirm = $_POST['custom'];
$payment_system = 'PayPal';
if ($_POST['payment_status'] == 'Pending') {$payment_system = 'PayPal - платёж не зачислен!';}
if ($_POST['payment_status'] == 'Completed') {$payment_system = 'PayPal';}

$folder = '../../'; $psep = '';
include ('../../index.php');	
	

	
die;	
}


if (!isset($payment_display)) {die;}
include ($folder.$psep.'payment/paypal/config.php');

if ($paypal_sendbox == '1') { $action_paypal_form = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; } else { $action_paypal_form = 'https://www.paypal.com/cgi-bin/webscr'; } // action form

$md_dir = $_SERVER['PHP_SELF'];
$md_dir = str_replace('index.php', '', $md_dir);

$cansel_url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; // cansel url
if (!empty($folder)) { $retrun_url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$folder.$psep.'payment/paypal/display.php'; } else {
$retrun_url = 'http://'.$_SERVER['SERVER_NAME'].$md_dir.'payment/paypal/display.php'; // url for done payment and change order status
}

$ag_detect = new Ag_Mobile_Detect; if ( $ag_detect->isMobile()) {$paypal_active = '0'; }


if ($paypal_active == '1' && !empty($paypal_mail)) {
$display_module[$index_module] = '1';
echo '<label title="PayPal">';
echo '<input type="radio" name="payment" value="'.$index_module.'" '.$checked_module[$index_module].' onclick="ag_select_type()" />';
echo '<div>';
echo '<img src="'.$folder.$psep.'payment/paypal/PayPal-Logo.png" alt="paypal" />';
echo '<div class="clear"></div>';
echo '</div>';
echo '</label>';
}

//===================================================
if (isset($_POST['booking']) && !isset($ERROR) && !isset($_GET['edit']) && $stop_booking == '0') {
if (isset($_POST['payment_online']) && isset($_POST['payment']) && $_POST['payment'] == $index_module) {
	

echo '<form action="'.$action_paypal_form.'" method="post" id="paypal">';
 echo '<input name="cmd" type="hidden" value="_xclick" />';
 echo '<input name="business" type="hidden" value="'.$paypal_mail.'" />';
 echo '<input name="item_name" type="hidden" value="'.$name_obj_done.'" />';
 echo '<input name="item_number" type="hidden" value="'.$number_order.'" />';
 echo '<input name="amount" type="hidden" value="'.$add_price.'" />';
 echo '<input name="no_shipping" type="hidden" value="0" />';
 echo '<input name="rm" type="hidden" value="2" />';
 echo '<input name="return" type="hidden" value="'.$retrun_url.'" />';
 echo '<input name="cancel_return" type="hidden" value="'.$cansel_url.'" />';
 echo '<input name="currency_code" type="hidden" value="'.$add_currency.'" />';
 echo '<input name="notify_url" type="hidden" value="" />';
 echo '<input name="custom" type="hidden" value="'.$id.'" />';
echo '<button class="ag_no_view" id="pay_submit"></button>';
echo '</form>';

if ($stop_booking == '0') {
echo '
<script>
var pay_button = document.getElementById("pay_submit");
setTimeout (function() { pay_button.click(); }, 5000);	
</script>
';	}
	
	
}
}


?>