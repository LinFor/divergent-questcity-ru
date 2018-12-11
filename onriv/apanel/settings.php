<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
include ('header.php');
if (!empty($access) && $access == 'yes') {
	
	
	

$file_name = '../data/config.php'; 	
$lang_dir = '../lang/';  	
	
$crs_arr = array();	
$add_currency_name = 'RUB::USD::EUR::';	
$add_currency_simb = '<i class="icon-rouble"></i>::<i class="icon-dollar"></i>::<i class="icon-euro"></i>::';
$add_currency_position = 'r::l::l::';
	

if(!isset($onriv_take)) {die();}	
if (isset($language)) { $add_language = $language; } else { $add_language = 'ru_RU.php'; }	
if (isset($org_name)) { $add_org_name = $org_name; } else { $add_org_name = ''; }
if (isset($org_description)) { $add_org_description = $org_description; } else { $add_org_description = ''; }
if (isset($org_phone)) { $add_org_phone = $org_phone; } else {$add_org_phone = '';}
if (isset($org_mail)) { $add_org_mail = $org_mail; } else {$add_org_mail = '';}
if (isset($sent_mail)) { $add_sent_mail = $sent_mail; } else { $add_sent_mail = '1'; }
if (isset($sent_in_org_mail)) { $add_sent_in_org_mail = $sent_in_org_mail; } else { $add_sent_in_org_mail = '1'; }
if (isset($sent_mail_status)) { $add_sent_mail_status = $sent_mail_status; } else { $add_sent_mail_status = '1'; }
if (isset($confirm_mail)) { $add_confirm_mail = $confirm_mail; } else { $add_confirm_mail = '1'; }

if (isset($conf_form)) { $add_conf_form = $conf_form; } else { $add_conf_form = '0'; }
if (isset($captcha)) { $add_captcha = $captcha; } else { $add_captcha = '1'; }

if (isset($color1)) { $add_color1 = $color1; } else { $add_color1 = '#FC8F1A'; }	
if (isset($color2)) { $add_color2 = $color2; } else { $add_color2 = '#FF4D00'; }	

if (isset($custom_css)) { $add_custom_css = $custom_css; } else { $add_custom_css = ''; }	
if (isset($custom_header)) { $add_custom_header = $custom_header; } else { $add_custom_header = ''; }	
if (isset($custom_footer)) { $add_custom_footer = $custom_footer; } else { $add_custom_footer = ''; }	


$add_custom_header = str_replace(':kv1:', "'", $add_custom_header);	
$add_custom_header = str_replace(':kv2:', '"', $add_custom_header);	
//$add_custom_header = htmlspecialchars($add_custom_header,ENT_QUOTES);

$add_custom_footer = str_replace(':kv1:', "'", $add_custom_footer);	
$add_custom_footer = str_replace(':kv2:', '"', $add_custom_footer);	
//$add_custom_footer = htmlspecialchars($add_custom_footer,ENT_QUOTES);

unset($ERROR);	
	
	
if (isset($_POST['currency_name'])) { //currency

$add_currency_name = '';
$add_currency_simb = '';
$add_currency_position = '';

$crs_arr = $_POST['currency_name'];
foreach ($_POST['currency_name'] as $kcn => $vcn) { 

$vcn = preg_replace("/ +/", "", $vcn);


if (isset($_POST['delete_currency'][$kcn])) {$vcn = '';}

if (!empty($vcn)) {
	

	
if (empty($_POST['currency_simb'][$kcn]) || $_POST['currency_simb'][$kcn] == ' ') {$ERROR['curr_simb'] = $lang['error_empty_curr_simbol'];}

$vcn = str_replace('::', '' , $vcn);
$_POST['currency_simb'][$kcn] = str_replace('::', '' , $_POST['currency_simb'][$kcn]);
$_POST['currency_pos'][$kcn] = str_replace('::', '' , $_POST['currency_pos'][$kcn]);



$add_currency_name .= $vcn .'::';
$add_currency_simb .= $_POST['currency_simb'][$kcn] .'::';
$add_currency_position .= $_POST['currency_pos'][$kcn] .'::';

}// no empty curr name
}// count curr name


$add_currency_simb = str_replace('"', '' , $add_currency_simb);
$add_currency_simb = str_replace('\"', '' , $add_currency_simb);

$add_currency_simb = str_replace('<i class=', '<i class="' , $add_currency_simb);
$add_currency_simb = str_replace('></i>', '"></i>' , $add_currency_simb);

$add_currency_simb = str_replace("\'", '', $add_currency_simb);
$add_currency_simb = str_replace("'", '', $add_currency_simb);
} //isset curr name

//=================================== LANGUAGE
if (isset($_POST['language'])) { 
$add_language = $_POST['language'];
}


//=================================== ORG NAME
if (isset($_POST['org_name'])) { 
$_POST['org_name'] = str_replace(array('::', '|', '&&'), '', trim($_POST['org_name']));
$_POST['org_name'] = str_replace("\'",'',$_POST['org_name']);
$_POST['org_name'] = str_replace("'",'',$_POST['org_name']);
$_POST['org_name'] = preg_replace('/\\\\+/','',$_POST['org_name']); 
$_POST['org_name'] = preg_replace("|[\r\n]+|", " ", $_POST['org_name']); 
$_POST['org_name'] = preg_replace("|[\n]+|", " ", $_POST['org_name']); 
$_POST['org_name'] = htmlspecialchars($_POST['org_name'],ENT_QUOTES);
if (empty($_POST['org_name']) || $_POST['org_name'] == ' ') {$ERROR['org_name'] = $lang['error_empty_input']. ': "'. $lang['inp_org_name'] .'"';}
$add_org_name = $_POST['org_name'];
}	
//=================================== ORG DESCRIPTION
if (isset($_POST['org_desc'])) { 
$_POST['org_desc'] = str_replace(array('::', '|', '&&'), '', trim($_POST['org_desc']));
$_POST['org_desc'] = str_replace("\'",'',$_POST['org_desc']);
$_POST['org_desc'] = str_replace("'",'',$_POST['org_desc']);
$_POST['org_desc'] = preg_replace('/\\\\+/','',$_POST['org_desc']); 
$_POST['org_desc'] = preg_replace("|[\r\n]+|", " ", $_POST['org_desc']); 
$_POST['org_desc'] = preg_replace("|[\n]+|", " ", $_POST['org_desc']); 
$_POST['org_desc'] = htmlspecialchars($_POST['org_desc'],ENT_QUOTES);

$add_org_description = $_POST['org_desc'];
}		
	
//=================================== ORG PHONE
if (isset($_POST['org_phone'])) { 
$_POST['org_phone'] = str_replace(array('::', '|', '&&'), '', trim($_POST['org_phone']));
$_POST['org_phone'] = str_replace("\'",'',$_POST['org_phone']);
$_POST['org_phone'] = str_replace("'",'',$_POST['org_phone']);
$_POST['org_phone'] = preg_replace('/\\\\+/','',$_POST['org_phone']); 
$_POST['org_phone'] = preg_replace("|[\r\n]+|", " ", $_POST['org_phone']); 
$_POST['org_phone'] = preg_replace("|[\n]+|", " ", $_POST['org_phone']); 
$_POST['org_phone'] = htmlspecialchars($_POST['org_phone'],ENT_QUOTES);

$add_org_phone = $_POST['org_phone'];
}	

//=================================== ORG MAIL
if (isset($_POST['org_mail'])) { 
$_POST['org_mail'] = str_replace(array('::', '|', '&&'), '', trim($_POST['org_mail']));
$_POST['org_mail'] = str_replace("\'",'',$_POST['org_mail']);
$_POST['org_mail'] = str_replace("'",'',$_POST['org_mail']);
$_POST['org_mail'] = preg_replace('/\\\\+/','',$_POST['org_mail']); 
$_POST['org_mail'] = preg_replace("|[\r\n]+|", " ", $_POST['org_mail']); 
$_POST['org_mail'] = preg_replace("|[\n]+|", " ", $_POST['org_mail']); 
$_POST['org_mail'] = htmlspecialchars($_POST['org_mail'],ENT_QUOTES);

$add_org_mail = $_POST['org_mail'];
}			
	
//=================================== SENT MAIL
if (isset($_POST['sent_mail'])) { 	
$add_sent_mail = '1'; $val_sent_mail = '1';
} else {$add_sent_mail = '0'; $val_sent_mail = $sent_mail;}	
	

if (isset($_POST['org_sent_mail'])) { 	
$add_sent_in_org_mail = '1'; $val_sent_in_org_mail = '1';
} else {$add_sent_in_org_mail = '0'; $val_sent_in_org_mail = $sent_in_org_mail;}		
	
	
if (isset($_POST['mail_status'])) { 	
$add_sent_mail_status = '1'; $val_sent_mail_status = '1';
} else {$add_sent_mail_status = '0'; $val_sent_mail_status = $sent_mail_status;}		
	
	
if (isset($_POST['confirm_mail'])) { 	
$add_confirm_mail = '1'; $val_confirm_mail = '1';
} else {$add_confirm_mail = '0'; $val_confirm_mail = $confirm_mail;}			
	
	
//=================================== FORM
	
if (isset($_POST['conf_form'])) { 	
$add_conf_form = $_POST['conf_form']; $val_conf_form = $_POST['conf_form'];
} else {$add_conf_form = $conf_form; $val_conf_form = $conf_form;}	

if (isset($_POST['captcha'])) { 	
$add_captcha = '1'; $val_captcha = '1';
} else {$add_captcha = '0'; $val_captcha = $captcha;}		
	
	
//==================================== DESIGN	

if (isset($_POST['color1'])) { 
$add_color1 = $_POST['color1'];
}
	
if (isset($_POST['color2'])) { 
$add_color2 = $_POST['color2'];
}	


if (isset($_POST['reset_colors'])) { 
$add_color1 = 'FC8F1A'; 
$add_color2 = 'FF4D00'; 
$add_color1_2_text = 'ffffff';
}		
	

//=================================== CUSTOM CSS
if (isset($_POST['custom_css'])) { 
$_POST['custom_css'] = str_replace(array('::', '|', '&&'), '', trim($_POST['custom_css']));
$_POST['custom_css'] = str_replace("\'",'',$_POST['custom_css']);
$_POST['custom_css'] = str_replace("'",'',$_POST['custom_css']);
$_POST['custom_css'] = str_replace('\"','',$_POST['custom_css']);
$_POST['custom_css'] = str_replace('"','',$_POST['custom_css']);
$_POST['custom_css'] = preg_replace('/\\\\+/','',$_POST['custom_css']); 
//$_POST['custom_css'] = preg_replace("|[\r\n]+|", " ", $_POST['custom_css']); 
//$_POST['custom_css'] = preg_replace("|[\n]+|", " ", $_POST['custom_css']); 
$_POST['custom_css'] = htmlspecialchars($_POST['custom_css'],ENT_QUOTES);
$add_custom_css = $_POST['custom_css'];
}		
	

//=================================== CUSTOM HEADER
if (isset($_POST['custom_header'])) { 
$_POST['custom_header'] = str_replace(array('::', '|', '&&'), '', trim($_POST['custom_header']));
$_POST['custom_header'] = str_replace("\'",':kv1:',$_POST['custom_header']);
$_POST['custom_header'] = str_replace("'",':kv1:',$_POST['custom_header']);
$_POST['custom_header'] = str_replace('\"',':kv2:',$_POST['custom_header']);
$_POST['custom_header'] = str_replace('"',':kv2:',$_POST['custom_header']);
$_POST['custom_header'] = preg_replace('/\\\\+/','',$_POST['custom_header']); 
//$_POST['custom_header'] = preg_replace("|[\r\n]+|", " ", $_POST['custom_header']); 
//$_POST['custom_header'] = preg_replace("|[\n]+|", " ", $_POST['custom_header']); 
$_POST['custom_header'] = htmlspecialchars($_POST['custom_header'],ENT_QUOTES);
$add_custom_header = $_POST['custom_header'];
}		

//=================================== CUSTOM FOOTER
if (isset($_POST['custom_footer'])) { 
$_POST['custom_footer'] = str_replace(array('::', '|', '&&'), '', trim($_POST['custom_footer']));
$_POST['custom_footer'] = str_replace("\'",':kv1:',$_POST['custom_footer']);
$_POST['custom_footer'] = str_replace("'",':kv1:',$_POST['custom_footer']);
$_POST['custom_footer'] = str_replace('\"',':kv2:',$_POST['custom_footer']);
$_POST['custom_footer'] = str_replace('"',':kv2:',$_POST['custom_footer']);
$_POST['custom_footer'] = preg_replace('/\\\\+/','',$_POST['custom_footer']); 
//$_POST['custom_footer'] = preg_replace("|[\r\n]+|", " ", $_POST['custom_footer']); 
//$_POST['custom_footer'] = preg_replace("|[\n]+|", " ", $_POST['custom_footer']); 
$_POST['custom_footer'] = htmlspecialchars($_POST['custom_footer'],ENT_QUOTES);
$add_custom_footer = $_POST['custom_footer'];
}		

if ($access_level != 'super_admin' && isset($_POST['config'])) { $ERROR['access'] = $lang['error_access']; }
	
	
//==============================CONFIG VALUES	
$config_data = '
<?php
$language = "'. $add_language .'";
$org_name = "'. $add_org_name .'";
$org_description = "'. $add_org_description .'";
$org_phone = "'. $add_org_phone .'";
$org_mail = "'. $add_org_mail .'";
$sent_mail = "'. $add_sent_mail .'";
$sent_in_org_mail = "'. $add_sent_in_org_mail .'";
$sent_mail_status = "'. $add_sent_mail_status .'";
$confirm_mail = "'. $add_confirm_mail .'";
$currency_name = "'. $add_currency_name .'";
$currency_simbol = \''. $add_currency_simb .'\';
$currency_position = "'. $add_currency_position .'";
$conf_form = "'. $add_conf_form .'";
$captcha = "'.  $add_captcha .'";
$color1 = "#'. $add_color1 .'";
$color2 = "#'. $add_color2 .'";
$custom_css = "'. $add_custom_css .'";
$custom_header = "'. $add_custom_header .'";
$custom_footer = "'. $add_custom_footer .'";
?>
';	
//-----------------------------/config values	
	
	
//=============================REPLACE PROCESS	

if (!isset($ERROR) && isset($_POST['config'])) {
	
if ($access_level == 'super_admin') {	
	
$fp_create_config = fopen($file_name, "w"); // create config file
fwrite($fp_create_config, "$config_data");
fclose ($fp_create_config);

unset ($_POST['config']);	
unset ($_POST['reset_colors']);
	
echo '<script>
var anc_rep = window.location.hash;
document.location.href="'. $script_name .'?rand='. $rnd_num .'"+anc_rep;
</script>
<noscript><meta http-equiv="refresh" content="0; url='. $script_name .'"></noscript>';	

} 

}

	
//------------------------------------replace	






	
echo '<div id="main">';	
	
echo '<div id="settings">';	

echo '<form method="post" id="settings_form">';

echo '<script>
var sanc = window.location.hash.replace("#tab","");
var anc_act = window.location.hash.replace("#","");
var form = document.getElementById("settings_form");

function ancor_switch(index) {
anc_act = "tab"+index; //alert(anc_act);
form.setAttribute("action","'. $script_name .'#"+anc_act);
}
</script>';

echo '<div><ul id="tabs_menu">
  <li><a id="tab_link_1" class="tab_link" href="#tab1" onclick="this_tab(1)">'. $lang['common_settings'] .'</a></li>
  <li><a id="tab_link_2" class="tab_link" href="#tab2" onclick="this_tab(2)">'. $lang['form_settings'] .'</a></li>
  <li><a id="tab_link_3" class="tab_link" href="#tab3" onclick="this_tab(3)">'. $lang['curr_code_sett'] .'</a></li>
  <li><a id="tab_link_4" class="tab_link" href="#tab4" onclick="this_tab(4)">'. $lang['mail_settings'] .'</a></li>
  <li><a id="tab_link_5" class="tab_link" href="#tab5" onclick="this_tab(5)">'. $lang['design_settings'] .'</a></li>';
if ($access_level == 'super_admin') {
  echo '<li><a id="tab_link_6" class="tab_link" href="#tab6" onclick="this_tab(6)">'. $lang['payment'] .'</a></li>'; }
echo '<li class="clear"></li>
</ul></div>';



echo '<div id="tabs_body">';  



if (isset($ERROR)) {
echo '<div class="settings_block_mess">';
echo '<div>';	
echo '<div class="error"><ul>';	
foreach ($ERROR as $erk => $erv) {echo '<li>'. $erv .'</li>';}
echo '</ul></div>';
echo '</div>'; //div
echo '</div>'; //settings_block
}

if (isset($_GET['rand']) && !isset($ERROR)) {

echo '<div class="settings_block_mess" id="done_mess">';
echo '<div class="done">'. $lang['done'] .'</div>';
echo '</div>';
echo '<script>
var dm = document.getElementById("done_mess");
var reanc = window.location.hash.replace("#","");
setTimeout(function() { dm.className +=" sett_hidd_done"; },2500);
setTimeout(function() { dm.setAttribute("style","overflow:hidden; height:51px; line-height:51px;"); },3000);
setTimeout(function() { dm.setAttribute("style","overflow:hidden; height:0px; line-height:0px; padding:0; margin:0;"); },3050);
setTimeout(function() { document.location.href="'.$script_name.'#"+reanc; },3300);
</script>';		
}

echo '<div id="tabs_content">'; 


//========================================================COMMON
echo '<div id="tab_1" class="tab_block">';
echo '<div class="settings_block">';
echo '<div>';


echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_org_name'] .'</span></div>';
echo '<div class="sett_full"><input type="text" name="org_name" value="'. $add_org_name .'" /></div>';

echo '<div class="sett_sep"></div>';

echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_org_desc'] .'</span></div>';
echo '<div class="sett_full"><input type="text" name="org_desc" value="'. $add_org_description .'" /></div>';

echo '<div class="sett_sep"></div>';

echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_org_phone'] .'</span></div>';
echo '<div class="sett_full"><input type="text" name="org_phone" value="'. $add_org_phone .'" /></div>';

echo '<div class="sett_sep"></div>';




function getFileList($dir)
  {
    // massive return
    $retval = array();

    // add slash to end
    if(substr($dir, -1) != "/") $dir .= "/";

    // path to dir and read file
    $d = @dir($dir) or die(' <span class="red_text">Error language directory open</span> ');
    while(false !== ($entry = $d->read())) {

      // skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
        $retval[] = array(
          "name" => "$dir$entry/",
          "size" => 0,
          "lastmod" => filemtime("$dir$entry")
        );
      } elseif(is_readable("$dir$entry")) {
if(!preg_match("/\index.php$/", "$dir$entry")) { //not include Index.php
        $retval[] = array(
          "name" => "$dir$entry",
          "size" => filesize("$dir$entry"),
          "lastmod" => filemtime("$dir$entry")
        );
} //index.php
      }
    }
    $d->close();

    return $retval;
}
  

  
$dirlist = getFileList($lang_dir);

//==================================LANGUAGE

echo '<div class="sett_full t_set"><span class="dblock">'. $lang['language'] .'</span></div>';
echo '<div class="sett_full">';
echo '<select name="language">';

foreach($dirlist as $file) {
	
//include($file['name']);	

$lang_n_arr = array();  
$lang_n_arr = file($file['name']);  
  
if (isset($lang_n_arr[1])) { $lang_n = trim($lang_n_arr[1]); } else {$lang_n = '';} 

$lang_n = str_replace('$lang_name = \'',"",$lang_n);
$lang_n = str_replace("';","",$lang_n);




$lang_opt_val = str_replace($lang_dir,'',$file['name']);

echo '<option value="'.$lang_opt_val.'"'; if ($lang_opt_val == $add_language) {echo 'selected="selected"';} echo '>'.$lang_n.'</option>';	 
}

echo '</select>';
echo '</div>';


//----------------------------------/language


echo '</div>'; //div
echo '</div>'; //settings_block
echo '</div>'; //tab1
//--------------------------------------------------------/common





//========================================================FORM	
echo '<div id="tab_2" class="tab_block">';
echo '<div class="settings_block">';
echo '<div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_conf_form0'] .'</span></div>';
if ($val_conf_form == '0') {$checked_cf0 = 'checked="checked"';} else {$checked_cf0 = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="radio" name="conf_form" value="0" '. $checked_cf0 .' /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_conf_form1'] .'</span></div>';
if ($val_conf_form == '1') {$checked_cf1 = 'checked="checked"';} else {$checked_cf1 = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="radio" name="conf_form" value="1" '. $checked_cf1 .' /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_conf_form2'] .'</span></div>';
if ($val_conf_form == '2') {$checked_cf2 = 'checked="checked"';} else {$checked_cf2 = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="radio" name="conf_form" value="2" '. $checked_cf2 .' /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';
//echo '<div class="sett_sep"></div>';


echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_captcha'] .'</span></div>';
if ($val_captcha == '1') {$checked_cp = 'checked="checked"';} else {$checked_cp = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="checkbox" name="captcha" value="1" '. $checked_cp .' /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';

echo '</div>'; //div
echo '</div>'; //settings_block
echo '</div>'; //tab1
//--------------------------------------------------------/form




//========================================================CURRENCY	
echo '<div id="tab_3" class="tab_block">';
echo '<div class="settings_block">';
echo '<div>';

$currency_name_arr = explode('::', $currency_name);
$currency_simbol_arr = explode('::', $currency_simbol);
$currency_position_arr = explode('::', $currency_position);

echo '<div class="sett_left t_set"><span class="dblock">'. $lang['curr_code_sett'] .'</span></div>';
echo '<div class="sett_curr_simb t_set"><span class="selcurr">'. $lang['curr_simb_sett'] .'</span></div>';
echo '<div class="sett_left t_set"><span class="dblock">'. $lang['curr_pos_sett'] .'</span></div>';
echo '<div class="sett_curr_simb t_set"><span class="selcurr">'. $lang['delete'] .'</span></div>';
echo '<div class="clear"></div>';

foreach ($currency_name_arr as $kc => $vc) {

if ($kc == '0' || $kc == '1' || $kc == '2') {

echo '<div class="sett_left"><span class="dblock">'. $vc .'</span>
<input type="hidden" name="currency_name['. $kc .']" value="'. $vc .'" />
</div>';

$currency_simbol_arr[$kc] = str_replace('<i class="', '' , $currency_simbol_arr[$kc]);
$currency_simbol_arr[$kc] = str_replace('"></i>', '' , $currency_simbol_arr[$kc]);

$currency_simbol_arr[$kc] = htmlspecialchars($currency_simbol_arr[$kc],ENT_QUOTES);

echo '<div class="sett_curr_simb">
<span class="selcurr"><i class="'. $currency_simbol_arr[$kc] .'"></i></span>
<input type="hidden" name="currency_simb['. $kc .']" value="<i class='. $currency_simbol_arr[$kc] .'></i>" />
</div>';

echo '<div class="sett_left"><span class="dblock">';
echo '<input type="hidden" name="currency_pos['. $kc .']" value="'. $currency_position_arr[$kc] .'" />';
if($currency_position_arr[$kc] == 'l') {echo $lang['curr_left_sett'];} else {echo $lang['curr_right_sett'];}
echo '</span></div>';

echo '<div class="sett_curr_simb"><span class="selcurr"><i class="icon-block-1"></i></span></div>';

echo '<div class="clear"></div>';





} else { //=================CUSTOM CURRENCY



if ($vc != '') {


$val_cm_cn = $vc;
if(isset($crs_arr[$kc])) {$val_cm_cn = $crs_arr[$kc];}	

echo '<div class="sett_left"><input type="text" name="currency_name['. $kc .']" value="'. $val_cm_cn .'" /></div>';

if (isset($_POST['currency_simb'][$kc])) {$currency_simbol_arr[$kc] = $_POST['currency_simb'][$kc];}

$currency_simbol_val = str_replace('"', '' , $currency_simbol_arr[$kc]);

//$currency_simbol_arr[$kc] = htmlspecialchars($currency_simbol_arr[$kc],ENT_QUOTES);


echo '<div class="sett_curr_simb">
<span class="selcurr" id="selcurr_'. $kc .'">'. $currency_simbol_arr[$kc] .'</span>
<input type="hidden" id="post_simb_'. $kc .'" name="currency_simb['. $kc .']" value="'. $currency_simbol_val .'" />


<div class="simb_list">
<ul>
<li onclick="in_curr_'. $kc .'(this.innerHTML)"><i class="icon-pound"></i></li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)"><i class="icon-yen"></i></li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)"><i class="icon-shekel"></i></li>
<li class="clear"></li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)"><i class="icon-try"></i></li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)"><i class="icon-rupee"></i></li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)"><i class="icon-won"></i></li>
<li class="clear"></li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)">&#8372;</li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)">&#8355;</li>
<li onclick="in_curr_'. $kc .'(this.innerHTML)">&#8356;</li>
<li class="clear"></li>
<li class="inp_simb"><input type="text" name="custom_curr_code" value="" onkeyup="in_curr_'. $kc .'(this.value)" oninput="in_curr_'. $kc .'(this.value)" /></li>
</ul>
</div>

<script>
var inpcurrc'. $kc .' = "";
var incurblc'. $kc .' = document.getElementById("selcurr_'. $kc .'");
var pssimbc'. $kc .' = document.getElementById("post_simb_'. $kc .'");
function in_curr_'. $kc .'(currc'. $kc .') {
inpcurrc'. $kc .' = currc'. $kc .'. replace(new RegExp(\'"\',\'g\'),"");	
incurblc'. $kc .'. innerHTML = currc'. $kc .';
pssimbc'. $kc .'. value = inpcurrc'. $kc .';	
}
</script>

</div>';


echo '<div class="sett_left">
<select name="currency_pos['. $kc .']">';

if(isset($_POST['currency_pos'][$kc])) {
	
echo '<option value="l" '; if($_POST['currency_pos'][$kc] == 'l') {echo 'selected="selected"';} echo '>'. $lang['curr_left_sett'] .'</option>';
echo '<option value="r" '; if($_POST['currency_pos'][$kc] == 'r') {echo 'selected="selected"';} echo '>'. $lang['curr_right_sett'] .'</option>';

} else {

echo '<option value="l" '; if($currency_position_arr[$kc] == 'l') {echo 'selected="selected"';} echo '>'. $lang['curr_left_sett'] .'</option>';
echo '<option value="r" '; if($currency_position_arr[$kc] == 'r') {echo 'selected="selected"';} echo '>'. $lang['curr_right_sett'] .'</option>';
}

echo '</select>
</div>';

echo '<div class="sett_curr_simb"><label title="'. $lang['delete'] .'">
<input type="checkbox" name="delete_currency['. $kc .']" value="1" /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';	
	
	
}
}// no empty
} //count currency
echo '<div class="clear"></div>';





//==========================================ADD CURRENCY

$val_add_cn = '';
$val_add_sm = '';
$sm_add_sm = '<i class="icon-help-1"></i>';

if (isset($_POST['currency_simb'][$kc+1])) {
$val_add_sm = $_POST['currency_simb'][$kc+1];
$val_add_sm = str_replace('"', '' , $val_add_sm);
if(!empty($_POST['currency_simb'][$kc+1])) {$sm_add_sm = $_POST['currency_simb'][$kc+1];}
}

echo '<div class="title_sett"><h5>'. $lang['add_currency'] .'</h5></div>';
echo '<div class="clear"></div>';

if(isset($crs_arr[$kc+1])) {$val_add_cn = $crs_arr[$kc+1];}

echo '<div class="sett_left"><input type="text" name="currency_name['. ($kc+1) .']" value="'. $val_add_cn .'" /></div>';


echo '<div class="sett_curr_simb" tabindex="1">
<span class="selcurr" id="selcurr">'. $sm_add_sm .'</span>
<input type="hidden" id="post_simb" name="currency_simb['. ($kc+1) .']" value="'. $val_add_sm .'" />

<div class="simb_list">
<ul>
<li onclick="in_curr(this.innerHTML)"><i class="icon-pound"></i></li>
<li onclick="in_curr(this.innerHTML)"><i class="icon-yen"></i></li>
<li onclick="in_curr(this.innerHTML)"><i class="icon-shekel"></i></li>
<li class="clear"></li>
<li onclick="in_curr(this.innerHTML)"><i class="icon-try"></i></li>
<li onclick="in_curr(this.innerHTML)"><i class="icon-rupee"></i></li>
<li onclick="in_curr(this.innerHTML)"><i class="icon-won"></i></li>
<li class="clear"></li>
<li onclick="in_curr(this.innerHTML)">&#8372;</li>
<li onclick="in_curr(this.innerHTML)">&#8355;</li>
<li onclick="in_curr(this.innerHTML)">&#8356;</li>
<li class="clear"></li>
<li class="inp_simb"><input type="text" name="custom_curr_code" value="" onkeyup="in_curr(this.value)" oninput="in_curr(this.value)" /></li>
</ul>
</div>

<script>
var inpcurr = "";
var incurbl = document.getElementById("selcurr");
var pssimb = document.getElementById("post_simb");
function in_curr(curr) {
inpcurr = curr.replace(new RegExp(\'"\',\'g\'),"");	
incurbl.innerHTML = curr;
pssimb.value = inpcurr;	
}
</script>

</div>';

echo '<div class="sett_left">
<select name="currency_pos['. ($kc+1) .']">';
echo '<option value="r" '; if(isset($_POST['currency_pos'][$kc+1]) && $_POST['currency_pos'][$kc+1] == 'r') {echo 'selected="selected"';} echo '>'. $lang['curr_right_sett'] .'</option>';
echo '<option value="l" '; if(isset($_POST['currency_pos'][$kc+1]) && $_POST['currency_pos'][$kc+1] == 'l') {echo 'selected="selected"';} echo '>'. $lang['curr_left_sett'] .'</option>';
echo '</select>
</div>';

echo '<div class="sett_curr_simb"><span class="selcurr"><i class="icon-block-1"></i></span></div>';

echo '<div class="clear"></div>';	


echo '</div>'; //div
echo '</div>'; //settings_block
echo '</div>'; //tab2

//--------------------------------------------------------/currency







//========================================================MAIL	
echo '<div id="tab_4" class="tab_block">';
echo '<div class="settings_block">';
echo '<div>';

echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_org_mail'] .'</span></div>';
echo '<div class="sett_full"><input type="email" name="org_mail" value="'. $add_org_mail .'" /></div>';

echo '<div class="sett_sep"></div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_onoff_sent_mail'] .'</span></div>';

if ($val_sent_mail == '1') {$checked_sm = 'checked="checked"';} else {$checked_sm = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="checkbox" id="chsm" name="sent_mail" value="1" '. $checked_sm .' onclick="onoff_mbl()" /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';

echo '<div id="onof_sm">';//===============HIDD

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_org_sent_mail'] .'</span></div>';
if ($val_sent_in_org_mail == '1') {$checked_som = 'checked="checked"';} else {$checked_som = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="checkbox" name="org_sent_mail" value="1" '. $checked_som .' /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_mail_status'] .'</span></div>';
if ($val_sent_mail_status == '1') {$checked_sm = 'checked="checked"';} else {$checked_sm = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="checkbox" name="mail_status" value="1" '. $checked_sm .' /><span class="sett_chbx"></span>
</label></div>';


echo '<div class="clear"></div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['inp_confirm_mail'] .'</span></div>';
if ($val_confirm_mail == '1') {$checked_cm = 'checked="checked"';} else {$checked_cm = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['on_off'] .'">
<input type="checkbox" name="confirm_mail" value="1" '. $checked_cm .' /><span class="sett_chbx"></span>
</label></div>';

echo '</div>';//=========================

echo '
<script>
var mch = document.getElementById("chsm");
var osb = document.getElementById("onof_sm");

function onoff_mbl() {
if (mch.checked) {osb.className = osb.className.replace( /(?:^|\s)sett_hidd_done(?!\S)/ , \'\' );} else {osb.className = "sett_hidd_done";}
}
window.onbeforeunload = onoff_mbl();
</script>
';

echo '<div class="clear"></div>';

echo '</div>'; //div
echo '</div>'; //settings_block
echo '</div>'; //tab3
//--------------------------------------------------------/mail



$add_custom_header = str_replace(':kv1:', "'", $add_custom_header);	
$add_custom_header = str_replace(':kv2:', '"', $add_custom_header);	
//$add_custom_header = htmlspecialchars($add_custom_header,ENT_QUOTES);

$add_custom_footer = str_replace(':kv1:', "'", $add_custom_footer);	
$add_custom_footer = str_replace(':kv2:', '"', $add_custom_footer);	
//$add_custom_footer = htmlspecialchars($add_custom_footer,ENT_QUOTES);



//========================================================DESIGN		
echo '<div id="tab_5" class="tab_block">';
echo '<div class="settings_block">';
echo '<div>';

echo '<script src="../js/jscolor/jscolor.js"></script>';

echo '<div class="sett_full t_set"><span class="dblock">'. $lang['active_colors'] .'</span></div>';

//------------color1
echo '<div class="sett_half"><span class="dblock">'.$lang['color1'].'</span></div>';
echo '<div class="sett_half sett_half_two">
<input type="text" name="color1" value="'. $add_color1 .'" class="jscolor { mode:\'HVS\', width:313, height:200, position:\'bottom\', borderWidth:\'0\', insetWidth:\'0\', borderColor:\'#FFF #fff #fff #FFF\', insetColor:\'#fff #FFF #FFF #fff\', backgroundColor:\'#f3f3f5\', borderRadius:false,  shadowBlur:\'14\', shadowColor:\'rgba(0,0,0,0.05)\'}" />
</div>';

echo '<div class="clear"></div>';

//------------color2
echo '<div class="sett_half"><span class="dblock">'.$lang['color2'].'</span></div>';
echo '<div class="sett_half sett_half_two">
<input type="text" name="color2" value="'. $add_color2 .'" class="jscolor { mode:\'HVS\', width:313, height:200, position:\'bottom\', borderWidth:\'0\', insetWidth:\'0\', borderColor:\'#FFF #fff #fff #FFF\', insetColor:\'#fff #FFF #FFF #fff\', backgroundColor:\'#f3f3f5\', borderRadius:false,  shadowBlur:\'14\', shadowColor:\'rgba(0,0,0,0.05)\'}" />
</div>';

echo '<div class="clear"></div>';



//-----------------------------------------------Reset colors
echo '<div class="clear"></div>';
echo '<div class="sett_sep"></div>';

echo '<div class="sett_left_ch"><span class="dblock">'. $lang['reset_colors'] .'</span></div>';
if (isset($_POST['reset_colors'])) {$checked_rc = 'checked="checked"';} else {$checked_rc = '';}
echo '<div class="sett_curr_simb sett_nomarin"><label title="'. $lang['reset'] .'">
<input type="checkbox" name="reset_colors" value="0" '. $checked_rc .' /><span class="sett_chbx"></span>
</label></div>';

echo '<div class="clear"></div>';
echo '<div class="sett_sep"></div>';

//-----------------------------------------------Custom CSS
echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_custom_css'] .'</span></div>';
echo '<div class="sett_full"><textarea id="ccss" name="custom_css">'. $add_custom_css .'</textarea></div>';

echo '<div class="clear"></div>';
echo '<div class="sett_sep"></div>';

//-----------------------------------------------Custom HEADER
echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_custom_header'] .'</span></div>';
echo '<div class="sett_full"><textarea id="cheader" name="custom_header">'. $add_custom_header .'</textarea></div>';

echo '<div class="clear"></div>';
echo '<div class="sett_sep"></div>';

//-----------------------------------------------Custom FOOTER
echo '<div class="sett_full t_set"><span class="dblock">'. $lang['inp_custom_footer'] .'</span></div>';
echo '<div class="sett_full"><textarea id="cfooter" name="custom_footer">'. $add_custom_footer .'</textarea></div>';


echo '</div>'; //div
echo '</div>'; //settings_block
echo '</div>'; //tab5
//--------------------------------------------------------/design 
echo '<input type="hidden" name="config" value="1" />';
echo '</form>';



//========================================================PAYMENT
if ($access_level == 'super_admin') {
echo '<div id="tab_6" class="tab_block">';
echo '<div class="settings_block">';
echo '<div>';

echo '<div class="sett_full t_set"><span class="dblock">'. $lang['payment_modules'] .'</span></div>';
echo '<div class="sett_sep"></div>';

$modules_dir = '../payment';
if(is_dir($modules_dir)) {
function getModulesList($dir)
  {
    // massive return
    $retval = array();

    // add slash to end
    if(substr($dir, -1) != "/") $dir .= "/";

    // path to dir and read file
    $d = dir($dir) or die(' <div class="error"><span class="red_text">read modules error</span></div> ');
    while(false !== ($entry = $d->read())) {

      // skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
        $retval[] = array(
          "name" => "$dir$entry/",
          "size" => 0,
          "lastmod" => filemtime("$dir$entry")
        );
		
      } elseif(is_readable("$dir$entry")) {

        $retval[] = array(
          "name" => "$dir$entry",
          "size" => filesize("$dir$entry"),
          "lastmod" => filemtime("$dir$entry")
        );

      }
    }
    $d->close();

    return $retval;
}
  

  
$dir_modules = getModulesList($modules_dir);



foreach($dir_modules as $index_module => $file_modules) {

if (isset($file_modules)) {
	if (file_exists($file_modules['name'].'/settings.php')) { $payment_settings = '1'; 

	echo '<div class="payment_block">';
	include_once($file_modules['name'].'/settings.php');
//echo $index_module;	

	if (isset($module_name[$index_module]) && !empty($module_name[$index_module])) { echo '<div class="module_name"><h3>'.$module_name[$index_module].'</h3></div>'; }
	if (isset($module_description[$index_module]) && !empty($module_description[$index_module])) { echo '<div class="module_desc">'.$module_description[$index_module].'<div class="clear"></div></div>'; }
	if (isset($module_img[$index_module]) && !empty($module_img[$index_module])) { echo '<div class="module_img">'.$module_img[$index_module].'</div>'; }
	if (isset($module_body[$index_module]) && !empty($module_body[$index_module])) { echo '<div class="module_body">'.$module_body[$index_module].'</div>'; }
	echo '</div>';
	}
} //file settings 
}

} else {echo '<div class="error"><span class="red_text">'.$lang['read_modules_error'].'</span></div>';}// check dir


echo '<div class="clear"></div>';
echo '</div>'; //div
echo '</div>'; //settings_block
echo '</div>'; //tab6
} //super admin access
//--------------------------------------------------------/payment

 

echo '</div>'; //tabs_content
echo '</div>'; //tabs_body



echo '<div class="clear"></div>';
echo '<div class="sett_button" id="submit_settings"><button onClick="document.getElementById(\'settings_form\').submit();"><i class="icon-ok"></i>'. $lang['submit'] .'</button></div>';


echo '<div class="clear"></div>';


echo '</div>'; //id settings

echo '</div>'; //main
} ?>

<script>

var anc = window.location.hash.replace("#tab","");
var ssb = document.getElementById("submit_settings");
if (anc == "") { //anc = 1;
document.getElementById("tab_1").className += " current_tab";
document.getElementById("tab_link_1").className += " current_tab_link";
} else {
document.getElementById("tab_"+anc).className += " current_tab";
document.getElementById("tab_link_"+anc).className += " current_tab_link";
}

var tabs = document.getElementsByClassName("tab_block");
var tabs_links = document.getElementsByClassName("tab_link");

function this_tab(index) {
	
var current_index = 0;	
for(var t=0; t<tabs.length; t++) {
current_index = t+1;
if (index == current_index) {
tabs[t].className = "tab_block current_tab";
tabs_links[t].className = "tab_link current_tab_link";
} else {
tabs[t].className = tabs[t].className.replace( /(?:^|\s)current_tab(?!\S)/ , "" );
tabs_links[t].className = tabs_links[t].className.replace( /(?:^|\s)current_tab_link(?!\S)/ , "" );
}//current	



}//count

if (index == 6) { ssb.className += " display_none"; } else { ssb.className = ssb.className.replace( /(?:^|\s)display_none(?!\S)/ , "" ); }

ancor_switch(index)
reheight();
} //func

if (anc == 6) { ssb.className += " display_none"; } else { ssb.className = ssb.className.replace( /(?:^|\s)display_none(?!\S)/ , "" ); }

</script>


<script>
var editor1 = CodeMirror.fromTextArea(document.getElementById("ccss"), {
      lineNumbers: true,
      mode: "text/css",
      matchBrackets: true
    });	

var editor2 = CodeMirror.fromTextArea(document.getElementById("cheader"), {
      lineNumbers: true,
      mode: "text/html",
      matchBrackets: true
    });
	
var editor3 = CodeMirror.fromTextArea(document.getElementById("cfooter"), {
      lineNumbers: true,
      mode: "text/html",
      matchBrackets: true
    });	
	
	
	
</script>


<?php include ('footer.php');?>