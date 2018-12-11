<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
$index = 1;
$product = 'OnRiv';
$psep = '';
if (!isset($folder)) {$folder = '';} else {$psep = '/';}

include ($folder.$psep.'inc/header.php');

//====================================CUSTOM HEADER

echo '<div id="ag_main">';

if (isset($custom_header)) {
$custom_header = str_replace(':kv1:', "'", $custom_header);	
$custom_header = str_replace(':kv2:', '"', $custom_header);	
echo htmlspecialchars_decode($custom_header, ENT_NOQUOTES);
}

echo '<div id="ag_wrapper">';
echo '<div id="ag_content">';

$file_temp = $folder.$psep.'inc/custom_color.php';
if (file_exists($file_temp)) { 
include_once($file_temp);
} 	 

include ($folder.$psep.'inc/select_obj.php');


echo '</div>';
echo '</div>';

if (isset($custom_footer)) {
$custom_footer = str_replace(':kv1:', "'", $custom_footer);	
$custom_footer = str_replace(':kv2:', '"', $custom_footer);	
echo htmlspecialchars_decode($custom_footer, ENT_NOQUOTES);
}

echo '</div>'; //ag_main

include ($folder.$psep.'inc/footer.php');
?>