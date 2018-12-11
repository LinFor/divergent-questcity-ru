<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;}
//===============PHOTOS

$photos_arr = array();


if (empty($photos_obj) || $photos_obj == '||') {$cal_ph_carousel = 2; echo '<div class="empty_line"></div>';} else {
	
$photos_arr = explode('||',$photos_obj); array_pop($photos_arr);



if(sizeof($photos_arr) > 8) { $cal_ph_carousel = 1; // >8
echo '<div class="full_photo" id="ag_photos">';
echo '<div class="ph_cont slider_on">';

} else {

$cal_ph_carousel = 0;
	
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {
echo '<div class="full_photo" id="ag_photos">';
echo '<div class="ph_cont slider_on">';
} else {	
echo '<div class="full_photo" id="ag_photos">';
echo '<div class="ph_cont">';
}

}

$num_photo = 0;	

foreach ($photos_arr as $k => $v) {
$num_photo++;

//if($num_photo % 4 == 0) {$last_cl = 'nomr';} else {$last_cl = '';} //--

if(sizeof($photos_arr) > 8) { // >8 
if (isset($v) && !empty($v)){

if (file_exists($folder.$psep.$v)) {

echo '<div class="carbl" id="ph_'.$k.'">';
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {echo '<div class="carlk">';} else {
echo '<a href="'.$folder.$psep.$v.'" class="group3 carlk">';}
echo '<img src="'.$folder.$psep.$v.'" alt="'.$org_name.' - '.$name_obj.'" />';
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {echo '</div>';} else {
echo '</a>';}
echo '</div>';

} // file exists photo

} //isset photo

} else { // <8
	
if (isset($v) && !empty($v)){
	
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {
	
if (file_exists($folder.$psep.$v)) {	
echo '<div class="carbl" id="ph_'.$k.'">';
echo '<div class="carlk">';
echo '<img src="'.$folder.$psep.$v.'" alt="'.$name_obj.'" />';
echo '</div>';
echo '</div>';}


} else {	
if (file_exists($folder.$psep.$v)) {
echo '<div class="phbl" id="ph_'.$k.'">';
echo '<a href="'.$folder.$psep.$v.'" class="group3 phlk">';
echo '<img src="'.$folder.$psep.$v.'" alt="'.$org_name.' - '.$name_obj.'" />';
echo '</a>';
echo '</div>';}
}

} //isset photo	
} // <8

} // count photo


if(sizeof($photos_arr) <= 8) {
$ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) {} else {	
echo '<div class="clear"></div>';}
} 
echo '</div>';
echo '</div>';
} //no empty photos


// -----------/photos
?>
