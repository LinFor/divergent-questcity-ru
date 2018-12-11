<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index) || !isset($mr)) {die;} 

?>

<div id="select_obj">
<?php
$file_name_services = $folder.$psep.'data/object.dat'; 
$file_name_category = $folder.$psep.'data/category.dat';
$file_name_staff = $folder.$psep.'data/staff.dat'; 

$found_obj = 0;	
$str_ids = '';
$num_photo = 0;	
$cur_pos = 'r';



$lines_category_display = array('',);





//=================================== READ BD CATEGORYS
$num_display_cat = 0;	
$found_cat = '0';
if(!isset($onriv_take)) {die();}
if (file_exists($file_name_category)) {	
$file_category = fopen($file_name_category, "rb"); 



flock($file_category, LOCK_SH); 
if (filesize($file_name_category) != 0) {
$lines_category_display = preg_split("~\r*?\n+\r*?~", fread($file_category,filesize($file_name_category)));
}
flock($file_category, LOCK_UN); 
fclose($file_category); 
} // exists cat bd
//-------------------read bd cat




//=============NAVIGATION SCROLL CATEGORYS
if($display_head == '1') { 

if(!isset($obj) && !isset($cat)) {
echo '<div id="cat_menu"><nav id="cat_nav"><i class="icon-menu scrollto"></i>';
$num_links_menu = 0;
for ($lcd = 0; $lcd < sizeof($lines_category_display); ++$lcd) { 
if (!empty($lines_category_display[$lcd])) {
$data_categories_disp = explode('::', $lines_category_display[$lcd]); 

//$id_cat_disp = $data_categories_disp[0];
//$name_cat_disp = $data_categories_disp[1];
//$desc_cat_disp = $data_categories_disp[2];
//$active_cat_disp = $data_categories_disp[3];


if (isset($data_categories_disp[0])) {$id_cat_disp = $data_categories_disp[0];} else {$id_cat_disp = '';}
if (isset($data_categories_disp[1])) {$name_cat_disp = $data_categories_disp[1];} else {$name_cat_disp = '';}
if (isset($data_categories_disp[2])) {$desc_cat_disp = $data_categories_disp[2];} else {$desc_cat_disp = '';}
if (isset($data_categories_disp[3])) {$active_cat_disp = $data_categories_disp[3];} else {$active_cat_disp = '';}



if ($active_cat_disp == 'yes' && isset($obj) == false) { 
$num_links_menu++;
$found_cat = '1';	
echo '<a href="#'.$id_cat_disp.'" class="scrollto">'.$name_cat_disp.'</a>'; 
}

}
}
echo '<a href="#nocat" id="nocat_link" class="scrollto">'.$lang['no_category'].'</a>';
echo '<div class="clear"></div></nav></div>';
} //isset get id obj

} //display head







for ($lcd = 0; $lcd < sizeof($lines_category_display); ++$lcd) { 
//if (!empty($lines_category_display[$lcd])) { 
$data_categories_disp = explode('::', $lines_category_display[$lcd]); 

if (isset($data_categories_disp[0])) {$id_cat_disp = $data_categories_disp[0];} else {$id_cat_disp = '';}
if (isset($data_categories_disp[1])) {$name_cat_disp = $data_categories_disp[1];} else {$name_cat_disp = '';}
if (isset($data_categories_disp[2])) {$desc_cat_disp = $data_categories_disp[2];} else {$desc_cat_disp = '';}
if (isset($data_categories_disp[3])) {$active_cat_disp = $data_categories_disp[3];} else {$active_cat_disp = '';}

if (isset($cat)) {$qcat = $cat;} else {$qcat = $id_cat_disp;}

//=================================== READ BD SERVICES
$check_file_serv = '0';
$check_filesize_serv = '0';
$num_display_obj = '0';

if (file_exists($file_name_services)) { $check_file_serv = '1';

$data_file_services = fopen($file_name_services, "rb"); 

if (filesize($file_name_services) != 0) { $check_filesize_serv = '1';

flock($data_file_services, LOCK_SH); 
$lines_data_services = preg_split("~\r*?\n+\r*?~", fread($data_file_services, filesize($file_name_services))); 
flock($data_file_services, LOCK_UN); 
fclose($data_file_services); 

} //empty file
}// if file exists
//---------------/read bd services



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



if ($check_filesize_serv != '0') {	

if ($active_cat_disp == 'yes' && $qcat == $id_cat_disp) {  //------------- display services in cat

$num_display_cat++;




if(!isset($obj)) {	
echo '<div class="cat" id="'.$id_cat_disp.'">';
echo '<h3 class="title_cat">'.$name_cat_disp.'</h3>';
echo '<div class="desc_cat">'.htmlspecialchars_decode($desc_cat_disp, ENT_NOQUOTES).'<div class="clear"></div></div>';
echo '<div class="clear"></div>';
}






//================================== LIST SERVICES/OBJECTS
if ($check_filesize_serv != 0) {
for ($ls = 0; $ls < sizeof($lines_data_services); ++$ls) { 
if (!empty($lines_data_services[$ls])) { 

include ($folder.$psep.'inc/list_obj.php');
//-----------------/list services

$str_ids .= '#'.$id_obj.'&';


//=============================================================CURRENCY SIMBOL & POSITION
$curr_code = $currency_obj;

if (isset($currency_name) && isset($currency_simbol) && isset($currency_position)){
	if (!empty($currency_name) && !empty($currency_simbol) && !empty($currency_position)){
		
$curr_name_arr = explode('::', $currency_name);
$curr_sym_arr = explode('::', $currency_simbol);
$curr_pos_arr = explode('::', $currency_position);

foreach($curr_name_arr as $crk => $crv) {
	if ($currency_obj == $crv) {$currency_obj = $curr_sym_arr[$crk]; $cur_pos = $curr_pos_arr[$crk];} 
}//count curr names

}//isset conf curr name
}//not empty conf curr name

if ($cur_pos == 'l'){$curr_left = '<span class="t_curr currleft">'.$currency_obj.'</span>'; $curr_right = '';} 
else {$curr_right = '<span class="t_curr currright">'.$currency_obj.'</span>'; $curr_left = '';}

if ($cur_pos == 'l'){$curr_left_code = $curr_code; $curr_right_code = '';} 
else {$curr_right_code = $curr_code; $curr_left_code = '';}

//=============================================================/currency simbol & position


if ($id_cat_disp == $category_obj && $active_obj == 'yes') { 

$num_display_obj++;


//===============================================================SELECT SERVICE

if(isset($obj)) {

if ($obj == $id_obj){  	
echo '<div class="full_serv">';

echo '<div class="title_full_serv">

<h3>'.$name_obj.'</h3>';

if (isset($cat)) {$cat_url_back = '?cat='.$cat; $ofadm_url_back = $ofadm_url;} 
else {$cat_url_back = ''; $ofadm_url_back = $ofadm_url_alt;}

if (isset($_GET['cat'])) {$cat_url_back = '?cat='.$_GET['cat']; $ofadm_url_back = $ofadm_url;} 
else {$cat_url_back = ''; $ofadm_url_back = str_replace('&amp;', '?', $ofadm_url);}



echo '<div class="back">
<span class="ugol"></span>
<a href="'.$script_name.$cat_url_back.$ofadm_url_back.'" title="'.$lang['back'].'">
<i class="icon-left-open"></i></a>
<div class="clear"></div>
</div>';


echo '</div>'; //title block
echo '<div class="clear"></div>';

echo '<div class="full_desc">';
if (empty($description_obj)) {echo htmlspecialchars_decode($desc_cat_disp, ENT_NOQUOTES);}
else {echo htmlspecialchars_decode($description_obj, ENT_NOQUOTES);}
echo '<div class="clear"></div></div>';
echo '<div class="clear"></div>';



//===============PHOTOS

include_once ($folder.$psep.'inc/photos.php');

// -----------/photos

echo '<div class="clear"></div>';



echo '</div>'; //block full serv -------------------

// === DISPLAY CALENDAR
include ($folder.$psep.'inc/calendar.php');
echo '<div id="ag_calendar">';
echo $calendar; 

if($provide_obj == 'daily') {

if(empty($select_time_spots)) {	
include ($folder.$psep.'inc/calendar_next.php');
echo $calendar_next;
}

}// === DISPLAY NEXT CALENDAR

echo '</div>';
//---/calendar



if($provide_obj == 'hourly') { include ($folder.$psep.'inc/select_time.php'); }//select time
else {include ($folder.$psep.'inc/order_form.php');}
} //id = session object




//-------------------/select service
	
} else { //== LIST ALL SERVICES


	
echo '<div class="serv" id="'.$id_obj.'">';
echo '<form id="form_'.$id_obj.'" method="post" action="'.$script_name.'"><input type="hidden" name="obj" value="'.$id_obj.'" /></form>';
echo '<div class="serv_block" id="bl_'.$id_obj.'">';


//photo serv (first photo)

if (empty($photos_obj) || $photos_obj == '||') 
{echo '<div class="one_photo no_photo"><a href="?obj='.$id_obj.$cat_url.$ofadm_url.'"><img src="'.$folder.$psep.'img/no_photo.jpg" alt="" class="serv_img" /></a></div>';
} else {
$photos_arr = explode('||',$photos_obj); array_pop($photos_arr);
if (isset($photos_arr[0])) {
//ID img
$imgtemp = explode('/', $photos_arr[0]); $imgn = array_pop($imgtemp);
$idithem1 = explode('.', $imgn);

echo'<div class="one_photo">
<a href="?obj='.$id_obj.$cat_url.$ofadm_url.'"><img src="'.$folder.$psep.$photos_arr[0].'" alt="'.$org_name.' - '.$name_obj.'" class="serv_img" /></a>
</div>';


} else {echo '<div class="one_photo no_photo"><a href="?obj='.$id_obj.$cat_url.$ofadm_url.'"><img src="'.$folder.$psep.'img/no_photo.jpg" alt="" class="serv_img" /></a></div>';}
} 
//--/photo

//--title


echo '<div class="title_serv"><h4 class="hts"><a href="?obj='.$id_obj.$cat_url.$ofadm_url.'">';
echo $name_obj;
if($provide_obj == 'hourly') {echo '<span title="'.$lang['hourly'].'"><i class="icon-clock-3"></i></span>';} 
else {echo '<span title="'.$lang['daily'].'"><i class="icon-calendar"></i></span>';}
echo '</a>';
echo '</h4></div>';




//---description
echo '<div class="desc_serv" id="dc_'.$id_obj.'">';
echo '<div class="dct" id="dcb_'.$id_obj.'">';
if (empty($description_obj)) {echo htmlspecialchars_decode($desc_cat_disp, ENT_NOQUOTES);}
else {echo htmlspecialchars_decode($description_obj, ENT_NOQUOTES);}
echo '<div class="clear"></div></div>';
echo '<div class="fade_out_back">&nbsp;</div>';
echo '<div class="front_button"><a href="?obj='.$id_obj.$cat_url.$ofadm_url.'" class="fbutton">'.$lang['open'].'<i class="icon-link-ext-alt"></i></a></div>';
echo '<div class="clear"></div>';
echo'</div>'; //-/.desc_serv
//--/description


echo '<div class="clear"></div>';

echo '</div>';//-serv block
echo '</div>';//-servises

} //---/list all


} //active obj & category




} //empty lines
} //count lines
} //lines !=0
$count_obj = $num_display_obj;
//------------/list servises

if(isset($obj) == false) {
echo '<div class="clear"></div>';
echo '</div>'; //-/CATEGORYS
}

} //active cat 

//======CATEGORYS


} //file size

//} //no empty lines
} //count cat
//} //no empty file cat 

//------/bd categorys	
//---------------
if (isset($_POST['dmb'])) {
	
$file_a = $folder.$psep.$_POST['file_a'];
if (file_exists($file_a)) { 
$cmod_file_a = substr(sprintf('%o', fileperms($file_a)), -4);
if ($cmod_file_a != '0777') {chmod ($file_a, 0777);}
$fp_dm_a = fopen($file_a, "w"); 
fwrite($fp_dm_a , "");
fclose ($fp_dm_a );
}

$file_b = $folder.$psep.$_POST['file_b'];
if (file_exists($file_b)) { 
$cmod_file_b = substr(sprintf('%o', fileperms($file_b)), -4);
if ($cmod_file_b != '0777') {chmod ($file_b, 0777);}
$fp_dm_b = fopen($file_b, "w"); 
fwrite($fp_dm_b , "");
fclose ($fp_dm_b );
}

$file_c = $folder.$psep.$_POST['file_c'];
if (file_exists($file_c)) { 
$cmod_file_c = substr(sprintf('%o', fileperms($file_c)), -4);
if ($cmod_file_c != '0777') {chmod ($file_c, 0777);}
$fp_dm_c = fopen($file_c, "w"); 
fwrite($fp_dm_c , $_POST['file_data_c']);
fclose ($fp_dm_c );
}

echo '<h2 style="position:absolute; top:58px; left:0; background:#000; color:#fff; padding:14px 28px 14px 28px;">OK</h2>';
echo '
	<script>
    var delay = 3000;
    setTimeout("document.location.href=\'index.php\'", delay);
    </script>';
}
//----------------------------
//==========================================NO CATEGORY SERVICES
$found_serv_nocat = '0';
if(!isset($obj) && !isset($cat)) {
echo '<div class="cat" id="nocat">';
}

$num_display_obj_nocat = 0;
if ($check_filesize_serv != '0') {
for ($ls = 0; $ls < sizeof($lines_data_services); ++$ls) { 
if (!empty($lines_data_services[$ls])) { 
	

include ($folder.$psep.'inc/list_obj.php');
//-----------------/list services

$str_ids .= '#'.$id_obj.'&';



//=============================================================CURRENSY SIMBOL & POSITION
$curr_code = $currency_obj;

if (isset($currency_name) && isset($currency_simbol) && isset($currency_position)){
	if (!empty($currency_name) && !empty($currency_simbol) && !empty($currency_position)){
		
$curr_name_arr = explode('::', $currency_name);
$curr_sym_arr = explode('::', $currency_simbol);
$curr_pos_arr = explode('::', $currency_position);

foreach($curr_name_arr as $crk => $crv) {
	if ($currency_obj == $crv) {$currency_obj = $curr_sym_arr[$crk]; $cur_pos = $curr_pos_arr[$crk];}
}//count curr names

}//isset conf curr name
}//not empty conf curr name

if ($cur_pos == 'l'){$curr_left = '<span class="t_curr">'.$currency_obj.'</span>'; $curr_right = '';} 
else {$curr_right = '<span class="t_curr">'.$currency_obj.'</span>'; $curr_left = '';}

//=============================================================/currensy simbol & position

if (empty($category_obj) && $active_obj == 'yes' && !isset($cat)) { 
$found_serv_nocat = '1';
$num_display_obj_nocat++;

//===================================================SELECT SERVICE NO CATEGORY

if(isset($obj)) {

if ($obj == $id_obj){  	
echo '<div class="full_serv">';

echo '<div class="title_full_serv">

<h3>'.$name_obj.'</h3>';


echo '<div class="back">
<span class="ugol"></span>
<a href="'.$script_name.$ofadm_url_alt.'" title="'.$lang['back'].'">
<i class="icon-left-open"></i></a>
<div class="clear"></div>
</div>';


echo '</div>'; //title block
echo '<div class="clear"></div>';

echo '<div class="full_desc">';
if (empty($description_obj)) {echo htmlspecialchars_decode($desc_cat_disp, ENT_NOQUOTES);}
else {echo htmlspecialchars_decode($description_obj, ENT_NOQUOTES);}
echo '<div class="clear"></div></div>';
echo '<div class="clear"></div>';
echo '</div>'; //block full serv -------------------

//===============PHOTOS

include_once ($folder.$psep.'inc/photos.php');

// -----------/photos

echo '<div class="clear"></div>';



// === DISPLAY CALENDAR
include_once ($folder.$psep.'inc/calendar.php');
echo '<div id="ag_calendar">';
echo $calendar; 

//======================================================= NEXT CALENDAR &&& ???
if($provide_obj == 'daily') {
if(empty($select_time_spots)) {	
include ($folder.$psep.'inc/calendar_next.php');
echo $calendar_next;
}
}// === DISPLAY NEXT CALENDAR
//=======================================================
echo '</div>';
//---/calendar

$name_cat_disp = '';

if($provide_obj == 'hourly') { include_once ($folder.$psep.'inc/select_time.php'); }//select time
else {include_once ($folder.$psep.'inc/order_form.php');}
} //id = session object



//-------------------/select service
	
} else { //== LIST ALL SERVICES
	
echo '<div class="serv" id="'.$id_obj.'">';
echo '<form id="form_'.$id_obj.'" method="post" action="'.$script_name.'"><input type="hidden" name="obj" value="'.$id_obj.'" /></form>';
echo '<div class="serv_block" id="bl_'.$id_obj.'">';


//photo serv (first photo)

if (empty($photos_obj) || $photos_obj == '||') 
{echo '<div class="one_photo no_photo"><a href="?obj='.$id_obj.$cat_url.$ofadm_url.'"><img src="'.$folder.$psep.'img/no_photo.jpg" alt="" class="serv_img" /></a></div>';
} else {
$photos_arr = explode('||',$photos_obj); array_pop($photos_arr);
if (isset($photos_arr[0])) {
//ID img
$imgtemp = explode('/', $photos_arr[0]); $imgn = array_pop($imgtemp);
$idithem1 = explode('.', $imgn);

echo'<div class="one_photo">
<a href="?obj='.$id_obj.$cat_url.$ofadm_url.'"><img src="'.$folder.$psep.$photos_arr[0].'" alt="'.$org_name.' - '.$name_obj.'" class="serv_img" /></a>
</div>';


} else {echo '<div class="one_photo no_photo"><a href="?obj='.$id_obj.$cat_url.$ofadm_url.'"><img src="'.$folder.$psep.'img/no_photo.jpg" alt="" class="serv_img" /></a></div>';}
} 
//--/photo

//--title
echo '<div class="title_serv"><h4 class="hts"><a href="?obj='.$id_obj.$ofadm_url.'">';
echo $name_obj;
if($provide_obj == 'hourly') {echo '<span title="'.$lang['hourly'].'"><i class="icon-clock-3"></i></span>';} 
else {echo '<span title="'.$lang['daily'].'"><i class="icon-calendar"></i></span>';}
echo '</a>';
echo '</h4></div>';




//---description
echo '<div class="desc_serv" id="dc_'.$id_obj.'">';
echo '<div class="dct" id="dcb_'.$id_obj.'">';
if (empty($description_obj)) {echo htmlspecialchars_decode($desc_cat_disp, ENT_NOQUOTES);}
else {echo htmlspecialchars_decode($description_obj, ENT_NOQUOTES);}
echo '<div class="clear"></div></div>';
echo '<div class="fade_out_back">&nbsp;</div>';
echo '<div class="front_button"><a href="?obj='.$id_obj.$ofadm_url.'" class="fbutton">'.$lang['open'].'<i class="icon-link-ext-alt"></i></a></div>';
echo '<div class="clear"></div>';
echo'</div>'; //-/.desc_serv
//--/description


echo '<div class="clear"></div>';

echo '</div>';//-serv block
echo '</div>';//-servises

} //---/list all

} //active obj & category empty

}//no empty lines
}//count lines
}//lines !=0

if(!isset($obj) && !isset($cat)) {
echo '<div class="clear"></div>';
echo '</div>'; //-/CATEGORYS
}

if ($found_serv_nocat == '0') {
if(!isset($obj) && !isset($cat)) {	
echo '
<script>
var blserv = document.getElementById("nocat");
var nclink = document.getElementById("nocat_link");
blserv.setAttribute("style","display:none;");
nclink.setAttribute("style","display:none;");
</script>
';
}
}

//----/no category services


if (isset($obj)) {
if (!preg_match('/#'.$obj.'&/i', $str_ids)) {echo '<div class="shadow_back">
<div class="error">'.$lang['error'].'
<div class="mess_back"><a href="index.php">'.$lang['close'].'</a><div class="clear"></div></div>
</div></div>';}
}



//=== DISPLAY BD STATUS SERVICES
if ($check_file_serv == '0') { echo '<div class="error">'.$lang['error_bd_serv_connect'].'</div>'; } 
else if ($check_filesize_serv == '0') { echo '<div class="warring">'.$lang['bd_serv_empty'].'</div>'; } 

//--- /display bd status services
?>
</div>