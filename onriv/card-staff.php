<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
$product = 'OnRiv';
$psep = '';
if (!isset($folder)) {$folder = '';} else {$psep = '/';}

include ($folder.$psep.'data/config.php');



//---Lang
if (!isset($language)) { include ($folder.$psep.'lang/ru_RU.php'); } else {

if (file_exists($folder.$psep.'lang/'.$language)) {
include ($folder.$psep.'lang/'.$language); } else { 
die('<div class="shadow_back"><div class="error" style="color:#ff0000; font-size:24px;">Not language file!</div></div>'); }
}
//---/Lang

$script_name = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; 
$host_name = $_SERVER['HTTP_HOST'];
$host_name = str_replace('www.','',$host_name);
include ($folder.$psep.'inc/Ag_Mobile_Detect/Ag_Mobile_Detect.php');

$refresh_0 = '<script>var delay = 0;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'"></noscript>';

$file_name_staff = $folder.$psep.'data/staff.dat'; 

$found_st = 0;

$apanel = '';
if (isset($_GET['apanel'])) {$apanel = '1';}

if (isset($_GET['view'])) { ?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=0.7, user-scalable=no" />
<meta name="robots" content="noindex, nofollow" />
<meta name="author" content="Максим Argentum Шаклеин" />

<link rel="stylesheet" href="css/fontello.css" />
<link rel="stylesheet" href="css/animation.css" />
<link rel="stylesheet" type="text/css" href="css/main.css?ver=<?php echo date('d.m'); ?>" />
<link rel="stylesheet" type="text/css" href="css/colorbox.css" />


<!-- MOBILE STYLE -->
<?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { ?>
<link rel="stylesheet" type="text/css" href="css/mob.css?ver=<?php echo date('d.m'); ?>" />
<style>

</style>
<?php } ?>

<!--if IE 7
    link(rel="stylesheet", href="css/fontello-ie7.css")
<![endif]-->

<!--[if lte IE 8]><link href="css/ie.css?ver=<?php echo date('d_m'); ?>" 
    rel="stylesheet" type="text/css" /><![endif]-->

<!--if lt IE 9
    script(src="js/html5.js").    
<![endif]-->		

<script src="js/jquery-1.11.3.min.js"></script>

<!-- CUSTOM COLOR -->
<?php
$light_color1 = '#f7f7f9';
$dark_color1 = '';

if (isset($color1) && !empty($color1)) {
function hex1rgb($hex1)
{
    return array(
            hexdec(substr($hex1,1,2)),
            hexdec(substr($hex1,3,2)),
            hexdec(substr($hex1,5,2))
        );
}
$rgbc1 = hex1rgb($color1);

$percentageChange1 = 210;

//светлее 
$light1 = Array(
255-(255-$rgbc1[0]) + $percentageChange1,
255-(255-$rgbc1[1]) + $percentageChange1,
255-(255-$rgbc1[2]) + $percentageChange1
);

//темнее			
$dark1 = Array(
$rgbc1[0] - $percentageChange1,
$rgbc1[1] - $percentageChange1,
$rgbc1[2] - $percentageChange1
);		
$light_color1 = 'rgb('.$light1[0].','.$light1[1].','.$light1[2].')';
$dark_color1 = 'rgb('.$dark1[0].','.$dark1[1].','.$dark1[2].')';
}	 	 
?>



<style>
#ag_main a, #ag_main a:visited { color:<?php echo $color1; ?>; }
#ag_main a:hover { color:<?php echo $color2; ?>; }

#ag_content_staff_card .title_staff_card {background:<?php echo $light_color1; ?>;}

#cboxClose, button.close_window_iframe { color:<?php echo $color1; ?>!important; }
#cboxClose:hover, button.close_window_iframe:hover { color:#fff!important; background:<?php echo $color1; ?>; }

</style>
<!-- /CUSTOM COLOR -->




<?php
//=================================== READ BD STAFF
if (file_exists($file_name_staff)) {	
$file_staff = fopen($file_name_staff, "rb"); 
if (filesize($file_name_staff) != 0) { // !0
flock($file_staff, LOCK_SH); 
$lines_staff = preg_split("~\r*?\n+\r*?~", fread($file_staff,filesize($file_name_staff)));
flock($file_staff, LOCK_UN); 
fclose($file_staff); 

} //file size
}//file exists
//---------------/read bd staff



for ($lst = 0; $lst < sizeof($lines_staff); ++$lst) { 
if (!empty($lines_staff[$lst])) { 
$data_staff = explode("::", $lines_staff[$lst]);

if (isset($data_staff[0])) {$id_staff = $data_staff[0];} else {$id_staff = '';}
if (isset($data_staff[1])) {$login_staff = $data_staff[1];} else {$login_staff = '';}
if (isset($data_staff[2])) {$sapas_staff = $data_staff[2];} else {$sapas_staff = '';}
if (isset($data_staff[3])) {$passw_staff = $data_staff[3];} else {$passw_staff = '';}
if (isset($data_staff[4])) {$access_staff = $data_staff[4];} else {$access_staff = '';}


if (isset($data_staff[5])) {$name_staff = $data_staff[5];} else {$name_staff = '';}
if (isset($data_staff[6])) {$email_staff = $data_staff[6];} else {$email_staff = '';}
if (isset($data_staff[7])) {$email_display_staff = $data_staff[7];} else {$email_display_staff = '';}
if (isset($data_staff[8])) {$phone_staff = $data_staff[8];} else {$phone_staff = '';}
if (isset($data_staff[9])) {$phone_display_staff = $data_staff[9];} else {$phone_display_staff = '';}
if (isset($data_staff[10])) {$post_staff = $data_staff[10];} else {$post_staff = '';}
if (isset($data_staff[11])) {$description_staff = $data_staff[11];} else {$description_staff = '';}
if (isset($data_staff[12])) {$photo_staff = $data_staff[12];} else {$photo_staff = '';}
if (isset($data_staff[13])) {$photo_display_staff = $data_staff[13];} else {$photo_display_staff = '';}
if (isset($data_staff[14])) {$active_staff = $data_staff[14];} else {$active_staff = '';}


if ($apanel == '1') {$phone_display_staff = 'yes'; $photo_display_staff = 'yes'; $email_display_staff = 'yes';}


if ($_GET['view'] == $id_staff) { $found_st = 1; ?>


<meta name="title" content="<?php echo $name_staff.' - '.$org_name; ?>" />
<title><?php echo $name_staff.' - '.$org_name; ?></title>
</head>
<body>	

<?php	//=============================================DISPLAY CARD STAFF

echo '<button type="button" onclick="closeIframe()" class="close_window_iframe" title="'.$lang['close'].'"><i class="icon-cancel-1"></i></button>';
echo '
<script>
window.parent.document.getElementById("cboxClose").style.visibility=\'hidden\';
function closeIframe() {
var delay = 200;
setTimeout(window.parent.document.getElementById("cboxClose").click(), delay);
}
</script>';



echo '<div id="ag_main">';
echo '<div id="ag_content_staff_card">';

echo '<table><tbody><tr>';
echo '<td class="staff_ph">';
if (!empty($photo_staff) && $photo_display_staff == 'yes') {
if(file_exists($photo_staff)) {
echo '<img src="'.$folder.$psep.$photo_staff.'" alt="'.$name_staff.'" />';
} else {echo '<img src="'.$folder.$psep.'img/no_photo.jpg" alt="'.$name_staff.'" />';}
} else {	
echo '<img src="'.$folder.$psep.'img/no_photo.jpg" alt="'.$name_staff.'" />';}
echo '</td>';

echo '<td class="staff_inf">';
echo '<h3 class="title_staff_card">'.$name_staff.'</h3>';
echo '<ul>';
if ($email_display_staff == 'yes' && !empty($email_staff)) {echo '<li><i class="icon-mail-2" title="'.$lang['mail'].'"></i><span><a href="mailto:'.$email_staff.'" title="'.$lang['mail'].'">'.$email_staff.'</a></span><div class="clear"></div></li>';}
if ($phone_display_staff == 'yes' && !empty($phone_staff)) {echo '<li><i class="icon-phone-2" title="'.$lang['phone'].'"></i><span title="'.$lang['phone'].'">'.$phone_staff.'</span><div class="clear"></div></li>';}
if (!empty($post_staff)) {
echo '<li><i class="icon-tag-1" title="'.$lang['staff_post'].'"></i><span title="'.$lang['staff_post'].'">'.$post_staff.'</span><div class="clear"></div></li>';}

echo '</ul>';
echo '</td>';

echo '</tr></tbody></table>';

echo '<div class="clear"></div>';

if (!empty($description_staff)) {
echo '<div class="staff_desc"><div>';
echo htmlspecialchars_decode($description_staff, ENT_NOQUOTES);
echo '<div class="clear"></div></div></div>';
}


echo '</div>'; //content
echo '</div>'; //main
} //no empty bd
} //count staff
} // get = id

if($found_st == 0) { // not found staff ?>

<meta name="title" content="<?php echo $lang['not_found']; ?>" />
<title><?php echo $lang['not_found']; ?></title>
</head>
<body>	
<h2><?php echo $lang['not_found']; ?></h2>


<?php }	//not found
echo 
'</body>
</html>';
}// get view

?>
