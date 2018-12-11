<?php

if (isset($_GET['id_order'])) {
	


$payment_confirm = $_GET['id_order'];
$payment_system = 'Qiwi';

$folder = '../../'; $psep = '';
include ('../../index.php');	
	

	
die;	
}


if (!isset($payment_display)) {die;}
include ($folder.$psep.'payment/qiwi/config.php');


$md_dir = $_SERVER['PHP_SELF'];
$md_dir = str_replace('index.php', '', $md_dir);







if ($qiwi_active == '1' && !empty($qiwi_from)) {
$display_module[$index_module] = '1';
echo '<label title="Qiwi">';
echo '<input type="radio" name="payment" value="'.$index_module.'" '.$checked_module[$index_module].' onclick="ag_select_type()" />';
echo '<div>';
echo '<img src="'.$folder.$psep.'payment/qiwi/qiwi_logo.png" alt="qiwi" />';
echo '<div class="clear"></div>';
echo '</div>';
echo '</label>';
}

//===================================================
if (isset($_POST['booking']) && !isset($ERROR) && !isset($_GET['edit']) && $stop_booking == '0') {
if (isset($_POST['payment_online']) && isset($_POST['payment']) && $_POST['payment'] == $index_module) {
	



$cansel_url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; // cansel url

if (!empty($folder)) { 
$retrun_url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$folder.$psep.'payment/qiwi/display.php?id_order='.$id.''; } else {
$retrun_url = 'http://'.$_SERVER['SERVER_NAME'].$md_dir.'payment/qiwi/display.php?id_order='.$id.''; // url for done payment and change order status
}


$get_url = 'https://w.qiwi.com/order/external/create.action?comm='.$id.'&from='.$qiwi_from.'&summ='.$add_price.'&currency='.$add_currency.'&txn_id='.$number_order.'&successUrl='.$retrun_url.'&failUrl='.$cansel_url.'';	

if ($stop_booking == '0') {
echo '
<script>
setTimeout (function() { document.location.href="'. $get_url .'"; }, 5000);	
</script>
<noscript><meta http-equiv="refresh" content="5; url='. $get_url .'"></noscript>
';	}
	
	
}
}


?>