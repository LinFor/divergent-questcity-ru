<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
include ('header.php');

if (!empty($access) && $access == 'yes') {


$file_name = '../data/'.$id_prefix.'.dat'; 

$new_line = '';

if (file_exists($file_name)) { // keep data file 

$cmod_file = substr(sprintf('%o', fileperms($file_name)), -4);
if ($cmod_file !='0644') {chmod ($file_name, 0644);}
//echo $cmod_file;

//==========================================================ADD


if (isSet($_GET['add']) == true) {	

$num_nu = $_GET['add']+1;

$add_login = 'user'.$num_nu;
$add_passsa = '';
$add_pass = '';
$add_access = 'staff';
$add_name = $lang['new_staff'];
$add_mail = 'newstaff@'.$host_name;
$add_display_mail = 'no';
$add_phone = '';
$add_display_phone = 'no';
$add_post = '';
$add_description = '';
$add_photo = '';
$add_display_photo = 'yes';
$add_active = 'off';
$change_time = $new_add_time;


$line_data_add = $id.'::'.$add_login.'::'.$add_passsa.'::'.$add_pass.'::'.$add_access.'::'.$add_name.'::'.$add_mail.'::'.$add_display_mail.'::'.$add_phone.'::'.$add_display_phone.'::'.$add_post.'::'.$add_description.'::'.$add_photo.'::'.$add_display_photo.'::'.$add_active.'::'.$add_who.'::'.$change_time.'::'.$add_who.'::';

//======================Add process

if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; 
echo $refresh_3;
} else {

define('DATAFILE', $file_name);
if (!file_get_contents(DATAFILE))
{

$fp=fopen($file_name, "a+"); 
fputs
($fp, "$line_data_add\r"); 
fclose($fp);

} else {
$file = fopen($file_name,"r") ; 
flock($file,LOCK_SH) ; 
flock($file,LOCK_UN) ; 
fclose($file) ; 

$fp=fopen($file_name, "a+"); 
fputs
($fp, "\n$line_data_add\r"); 
fclose($fp);}

$ancor_line = $_GET['add']+1;

echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';
echo "<script>
    var delay = 800;
    setTimeout(\"document.location.href='".$script_name."?edit=".$_GET['add']."#line".$ancor_line."'\", delay);
    </script><noscript><meta http-equiv=\"refresh\" content=\"0; url=".$script_name."?edit=".$_GET['add']."#line".$ancor_line."\"></noscript>";
}

} //staff access
//=================================== /ADD




define('STAFFDATA', $file_name);
if (!file_get_contents(STAFFDATA)) { //empty data file 
echo '<div class="mess">'.$lang['empty_data'].'</div>';
} else { 


// =====================================BLOCK MOOVES

if(isset($_GET['moves'])) { if ($_GET['moves'] !='' && $_GET['moves'] !=0) {
$move1=$_GET['moves']; $where=$_GET['where']; 
if ($where=="0") $where="-1";
$move2=$move1-$where;

$file=file($file_name);
 

$imax=sizeof($file);


if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;} else {
	
if (($move2>=$imax) or ($move2<"0")) {
echo $refresh_3;
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error'].'</div></div>'; } else { // no error moove


$nl = chr(13).chr(10);

if (isset($_GET['where'])) {if ($_GET['where']==0){$this_line = $_GET['moves']+2;} if ($_GET['where']==1){$this_line = $_GET['moves'];} }

if ($move1 == $imax-1) { //last up!!!
$data1=$file[$move1]; 
$data2=$nl.$file[$move2];
$del_l_line = "?delete_moves=".$imax."&this=line".$this_line."";
} 

else if ($move2 == $imax-1) { //last-1 down!!!
$data1=$nl.$file[$move1]; 
$data2=$file[$move2];
$del_l_line = "?delete_moves=".$imax."&this=line".$this_line."";
}

else {
$data1=$file[$move1]; 
$data2=$file[$move2];
$del_l_line = '#line'.$this_line;
}


$fp=fopen($file_name, "a+"); 
 

flock ($fp,LOCK_EX); 

ftruncate($fp,0);//Delet data in file 
// change position




for ($i=0; $i<$imax; $i++) {


if ($move1==$i) { 
fputs
($fp,$data2); 
} 

else if ($move2==$i) { 
fputs
($fp,$data1); 
}

else { 
fputs
($fp,$file[$i]); 
} 

}
 
 
fflush ($fp);


flock ($fp,LOCK_UN);
fclose($fp);
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';
echo "<script>
    var delay = 800;
    setTimeout(\"document.location.href='".$script_name."".$del_l_line."'\", delay);
    </script><noscript><meta http-equiv=\"refresh\" content=\"0; url=".$script_name."".$del_l_line."\"></noscript>";
}
} // staff access
} else { echo '<div class="shadow_back">'.$error_any.'</div>'.$refresh_3; }//no 0 line
} // no first / no last
//=============================/MOOVES

//======================================================DELET Moves
$crlf = "\n"; 

if (isSet($_GET['delete_moves']) == true) {

if ($_GET['delete_moves'] != 0 ) {
	

$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//delete progress
	
    if (isSet($lines[(integer) $_GET['delete_moves']]) == true) 
    {   unset($lines[(integer) $_GET['delete_moves']]) ; 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 

echo"
<script>
    var delay = 0;
    setTimeout(\"document.location.href='".$script_name."#".$_GET['this']."'\", delay);
    </script>
	<noscript><meta http-equiv=\"refresh\" content=\"0; url=".$script_name."#".$_GET['this']."\"></noscript>
"; } // no 0 line 
}
 //======================delet moves		
	
	
	

//======================================================DELET

$crlf = "\n"; 
if (isSet($_GET['delete']) == true) {

if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;} 

else {


if ($_GET['delete'] != 0 ) {
	
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;
	
//===check access
$check_line = $_GET['delete'];
$stop_delete = '';
$check_access = explode('::', $lines[$check_line]); 
if ($check_access[4] == 'admin' && $access_level != 'super_admin') { $stop_delete = 'stop'; } 
//===/ceck access



//delete process
if ($stop_delete == 'stop') {echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;} else {
    if (isSet($lines[(integer) $_GET['delete']]) == true) 
    {   unset($lines[(integer) $_GET['delete']]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
		
if (isset($_GET['insearch'])){
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';	
echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'?search='.$_GET['insearch'].'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?search='.$_GET['insearch'].'"></noscript>';	
} else {		
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';	
echo $refresh_1; }
		
} }

    flock($file,LOCK_UN) ; 
    fclose($file) ; 


} else { echo '<div class="shadow_back">'.$error_any.'</div>'.$refresh_3; }//no 0 line

} //staff access

} //======================================== get delet



//========================REPLACE LINE
if (isSet($_POST["line"]) == true) {	

unset($ERROR);

$nl = $_POST['line'];
$nd = $nl+1;


//=======================================CHECK ID
$data_file_check = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file_check, LOCK_SH); 
$lines_check = preg_split("~\r*?\n+\r*?~", fread($data_file_check,filesize($file_name))); 
flock($data_file_check, LOCK_UN); 
fclose($data_file_check); 

$check_line = $_POST['line'];	
if (isset($lines_check[$check_line]))	{	

$check_data = explode('::', $lines_check[$check_line]); 

if (!isset($check_data[0]) || $check_data[0] != $_POST['id_line']) 
{
$ERROR['id_line']['text'] = $lang['error_found_replace_swing'];
echo $refresh_3;
}	//== if not found line


//===check access ============================
$stop_delete = '';
if ($check_data[4] == 'admin' && $nl != $number_line && $access_level != 'super_admin') { $stop_delete = 'stop'; } 
if ($check_data[4] == 'staff' && $_POST['staff_access_level'] == 'admin' && $access_level != 'super_admin') { $stop_delete = 'stop'; } 
if ($stop_delete == 'stop') {$ERROR['error_access']['text'] = $lang['error_access']; echo $refresh_3;}
//===/ceck access



//===check login ============================
if (!empty($_POST['staff_login']) && $_POST['staff_login'] != $_POST['check_login']) {
$pattren_check_login = $_POST['staff_login'];
for ($lcl = 0; $lcl < sizeof($lines_check); ++$lcl) { 

$check_data_logins = explode('::', $lines_check[$lcl]);	
if ($check_data_logins[1] == $pattren_check_login) { $ERROR['staff_login']['text'] = $lang['error_found_login']; }	//== if found login
} //count
} //post login
//===/check login ============================

} // isset current line
else {unset($_POST['line']);}
}
//==================================/end check id




if ($access_level != 'super_admin' && $nl == 0){ //=============Super admin
$ERROR['error_access']['text'] = $lang['error_access'];
echo $refresh_3;}


if ($access_level == 'staff' && $_POST['staff_access_level'] == 'admin'){ //=============staff change access
$ERROR['error_access']['text'] = $lang['error_access'];
}

if ($access_level == 'staff' && $nl != $number_line){ //=============Staff
$ERROR['error_access']['text'] = $lang['error_access'];
echo $refresh_3;}

//=============================================





//-----------Login
$_POST['staff_login'] = htmlspecialchars($_POST['staff_login'],ENT_QUOTES);
$_POST['staff_login'] = str_replace(array('::', '|', '*'), '', trim($_POST['staff_login']));
$_POST['staff_login'] = str_replace("\'",'',$_POST['staff_login']);
$_POST['staff_login'] = str_replace("'",'',$_POST['staff_login']);
$_POST['staff_login'] = preg_replace('/\\\\+/','',$_POST['staff_login']); 
$_POST['staff_login'] = preg_replace("|[\r\n]+|", " ", $_POST['staff_login']); 
$_POST['staff_login'] = preg_replace("|[\n]+|", " ", $_POST['staff_login']); 
if(empty($_POST['staff_login'])) {$ERROR['staff_login_empty']['text'] = $lang['error_login_replace_empty'];} else
if(strlen($_POST['staff_login'])<3) {$ERROR['staff_login_number']['text'] = $lang['error_login_replace_number'];}
if(preg_match("/[^a-zA-Z0-9а-яА-Я]/u", $_POST['staff_login'])) {$ERROR['staff_login_symbol']['text'] = $lang['error_login_replace_symbol'];}




//-----------Pass
$_POST['staff_pass'] = htmlspecialchars($_POST['staff_pass'],ENT_QUOTES);
$_POST['staff_pass'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_pass']));
$_POST['staff_pass'] = str_replace("\'",'',$_POST['staff_pass']);
$_POST['staff_pass'] = str_replace("'",'',$_POST['staff_pass']);
$_POST['staff_pass'] = preg_replace('/\\\\+/','',$_POST['staff_pass']); 
$_POST['staff_pass'] = preg_replace("|[\r\n]+|", "", $_POST['staff_pass']); 
$_POST['staff_pass'] = preg_replace("|[\n]+|", "", $_POST['staff_pass']); 
if(empty($_POST['staff_pass'])) {$ERROR['staff_pass_empty']['text'] = $lang['error_pass_replace_empty'];} else
if(strlen($_POST['staff_pass'])<3) {$ERROR['staff_pass_number']['text'] = $lang['error_pass_replace_number'];}
if (preg_match('/::/', $_POST['staff_pass'])) {$ERROR['staff_pass_symbol']['text'] = $lang['error_pass_replace_symbol'];}

//-----------Access
if ($_POST['staff_access_level'] == 'staff' || $_POST['staff_access_level'] == 'admin' || !empty($_POST['staff_access_level'])) {echo'';} 
else {$ERROR['staff_access_level']['text'] = $lang['error'];}

//-----------Name
$_POST['staff_name'] = htmlspecialchars($_POST['staff_name'],ENT_QUOTES);
$_POST['staff_name'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_name']));
$_POST['staff_name'] = str_replace("\'",'',$_POST['staff_name']);
$_POST['staff_name'] = str_replace("'",'',$_POST['staff_name']);
$_POST['staff_name'] = preg_replace('/\\\\+/','',$_POST['staff_name']); 
$_POST['staff_name'] = preg_replace("|[\r\n]+|", "", $_POST['staff_name']); 
$_POST['staff_name'] = preg_replace("|[\n]+|", "", $_POST['staff_name']); 
if(empty($_POST['staff_name'])) {$ERROR['staff_name_empty']['text'] = $lang['error_name_empty'];} 

//-----------Mail
$_POST['staff_mail'] = htmlspecialchars($_POST['staff_mail'],ENT_QUOTES);
$_POST['staff_mail'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_mail']));
$_POST['staff_mail'] = str_replace("\'",'',$_POST['staff_mail']);
$_POST['staff_mail'] = str_replace("'",'',$_POST['staff_mail']);
$_POST['staff_mail'] = preg_replace('/\\\\+/','',$_POST['staff_mail']); 
$_POST['staff_mail'] = preg_replace("|[\r\n]+|", "", $_POST['staff_mail']); 
$_POST['staff_mail'] = preg_replace("|[\n]+|", "", $_POST['staff_mail']); 
if(empty($_POST['staff_mail'])) {$ERROR['staff_mail_empty']['text'] = $lang['error_mail_empty'];} else
if(!preg_match('/.+@.+\..+/i', $_POST['staff_mail'])) {$ERROR['staff_mail_invalid']['text'] = $lang['error_mail_invalid'];}
//-----------Mail display
if (isset($_POST['staff_display_email'])==true) {$staff_display_email = 'yes';} else {$staff_display_email = '';}

//-----------Phone
$_POST['staff_phone'] = htmlspecialchars($_POST['staff_phone'],ENT_QUOTES);
$_POST['staff_phone'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_phone']));
if (preg_match("/[^0-9+()-]/u", $_POST['staff_phone'])) {$ERROR['staff_phone_invalid']['text'] = $lang['error_phone_invalid'];}
//-----------Phone display
if (isset($_POST['staff_display_phone'])==true) {$staff_display_phone = 'yes';} else {$staff_display_phone = '';}

//-----------Post
$_POST['staff_post'] = htmlspecialchars($_POST['staff_post'],ENT_QUOTES);
$_POST['staff_post'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_post']));
$_POST['staff_post'] = str_replace("\'",'',$_POST['staff_post']);
$_POST['staff_post'] = str_replace("'",'',$_POST['staff_post']);
$_POST['staff_post'] = preg_replace('/\\\\+/','',$_POST['staff_post']); 
$_POST['staff_post'] = preg_replace("|[\r\n]+|", "", $_POST['staff_post']); 
$_POST['staff_post'] = preg_replace("|[\n]+|", "", $_POST['staff_post']); 

//-----------Description
$_POST['staff_description'] = htmlspecialchars($_POST['staff_description'],ENT_QUOTES);
$_POST['staff_description'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_description']));
$_POST['staff_description'] = str_replace("\'",'',$_POST['staff_description']);
$_POST['staff_description'] = str_replace("'",'',$_POST['staff_description']);
$_POST['staff_description'] = preg_replace('/\\\\+/','',$_POST['staff_description']); 
$_POST['staff_description'] = preg_replace("|[\r\n]+|", "<br />", $_POST['staff_description']); 
$_POST['staff_description'] = preg_replace("|[\n]+|", "<br />", $_POST['staff_description']); 

//-----------Photo
$_POST['staff_photo'] = htmlspecialchars($_POST['staff_photo'],ENT_QUOTES);
$_POST['staff_photo'] = str_replace(array('::', '||', '**'), '', trim($_POST['staff_photo']));
//-----------Photo display
if (isset($_POST['staff_display_photo'])==true) {$staff_display_photo = 'yes';} else {$staff_display_photo = '';}

//-----------Active
if (isset($_POST['staff_active'])==true) {$staff_active = 'yes';} else {$staff_active = '';}



//-----------Check input data
$id_line = $_POST['id_line'];
$add_login = $_POST['staff_login'];
$add_passsa = sha1($_POST['staff_pass']);
$add_pass = $_POST['staff_pass'];
$add_access = $_POST['staff_access_level'];
$add_name = $_POST['staff_name'];
$add_mail = $_POST['staff_mail'];
$add_display_mail = $staff_display_email;
$add_phone = $_POST['staff_phone'];
$add_display_phone = $staff_display_phone;
$add_post = $_POST['staff_post'];
$add_description = $_POST['staff_description'];
$add_photo = $_POST['staff_photo'];
$add_display_photo = $staff_display_photo;
$add_active = $staff_active;
$who_add = $_POST['who'];
$change_time = $_POST['change'];
$change_who = $add_who;


$line_data_r = $id_line.'::'.$add_login.'::'.$add_passsa.'::'.$add_pass.'::'.$add_access.'::'.$add_name.'::'.$add_mail.'::'.$add_display_mail.'::'.$add_phone.'::'.$add_display_phone.'::'.$add_post.'::'.$add_description.'::'.$add_photo.'::'.$add_display_photo.'::'.$add_active.'::'.$who_add.'::'.$change_time.'::'.$change_who.'::';

//---------------/check


} //isset line 

//---replace process

if (array_key_exists('line',$_POST)){



if (isset($ERROR) && is_array($ERROR)) { echo ''; } else { // check errors



//===================================replace process

$filename = $file_name;
$contents = file_get_contents($filename);
 
 

    $contents = explode("\n", $contents);
   
    if (isset($contents[$nl])) {
        $contents[$nl] = $line_data_r;
       
        if (is_writable($filename)) {
            if (!$handle = fopen($filename, 'wb')) { echo ''; }
                   
            if (fwrite($handle, implode("\n", $contents)) === FALSE) { echo ''; }
//--replace done	
$ancor_line_replace = $nl+1;
if(!isset($_POST['safe_and_back'])) {

if (isset($_GET['insearch'])){
echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'?search='.$_GET['insearch'].'#line'.$ancor_line_replace.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?search='.$_GET['insearch'].'#line'.$ancor_line_replace.'"></noscript>';} else { 
echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'#line'.$ancor_line_replace.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'#line'.$ancor_line_replace.'"></noscript>';}
	
	} 
fclose($handle);
}



} else {
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_found_replace'].' (№ <b>'.$nd.'</b>)</div></div>';
echo $refresh_3;	
} // not found replace line
 

} //---- no errors

}//==============================================/replace
	
	
	
	
	
//====================================================DISPLAY	



echo '<div id="main">';
	
echo'<div id="data" class="table"><ul class="th">';

echo '<li class="tools"><i class="icon-sort"></i></li>';
echo '<li class="tools"><i class="icon-list-numbered"></i></li>';

echo '<li><i class="icon-ok-circled" style="margin:0 14px 0 0;"></i>'.$lang['login'].'</li>';
echo '<li>'.$lang['name'].'</li>';
echo '<li>'.$lang['mail'].'</li>';
echo '<li>'.$lang['phone'].'</li>';
echo '<li>'.$lang['access_level'].'</li>';

echo '<li class="tools"><i class="icon-edit-alt"></i></li>';
echo '<li class="tools"><i class="icon-trash-2"></i></li>';

echo '<div class="clear"></div>';
echo '</ul>';

$found_ls = '';

for ($ls = 0; $ls < sizeof($lines_staff); ++$ls) { 

$number_line = $ls+1;
$new_line = sizeof($lines_staff);



if (!empty($lines_staff[$ls])) {
	
$data_access_list = explode('::', $lines_staff[$ls]); 
array_pop($data_access_list);

$id_staff = $data_access_list[0];
$login_staff = $data_access_list[1];
$sapas_staff = $data_access_list[2];
$passw_staff = $data_access_list[3];
$access_staff = $data_access_list[4];


$name_staff = $data_access_list[5];
$email_staff = $data_access_list[6];
$email_display_staff = $data_access_list[7];
$phone_staff = $data_access_list[8];
$phone_display_staff = $data_access_list[9];
$post_staff = $data_access_list[10];
$description_staff = $data_access_list[11];
$photo_staff = $data_access_list[12];
$photo_display_staff = $data_access_list[13];
$active_staff = $data_access_list[14];
$who_add_staff = $data_access_list[15];
$time_change_staff = $data_access_list[16];
$who_change_staff = $data_access_list[17];

$class_line = '';
if ($ls % 2 == 0) {$class_line = 'first';} else {$class_line = 'second';}


echo '<ul id="position'.$number_line.'" class="'.$class_line.'">';

if ($ls == 0 || sizeof($lines_staff) == 2) {
echo '<li class="tools none_active"><i class="icon-sort"></i></li>';
} else {
echo '<li class="tools list_tools" tabindex="1"><i class="icon-sort"></i>
<div>';	

echo '<div class="display_id" id="line'.$number_line.'"></div>';

if ($ls != 1) { echo '
<span>
<a href="'.$script_name.'?moves='.$ls.'&where=1" title="'.$lang['moove'].' '.$lang['up'].'"><i class="icon-up-circled"></i>'.$lang['up'].'</a>
</span>';} 
if ($ls != sizeof($lines_staff)-1) { echo '
<span>
<a href="'.$script_name.'?moves='.$ls.'&where=0" title="'.$lang['moove'].' '.$lang['down'].'"><i class="icon-down-circled"></i>'.$lang['down'].'</a>
</span>';}
echo '</div></li>';
}

echo '<li class="tools">'.$number_line.'</li>';

echo '<li>';

echo '<div class="hidden_info" tabindex="1">';
if ($active_staff == 'yes') {
echo '<i class="icon-ok-circled yes"></i><div><span>'.$lang['active_yes'].'</span></div>';	
} else {
echo '<i class="icon-block no"></i><div><span>'.$lang['active_no'].'</span></div>';	
}
echo '</div>';

echo '<span class="str_left">'.$login_staff.'</span>';

echo'<div class="clear"></div></li>';



echo '<li class="name" tabindex="1">'.$name_staff;

//-----photo display list
if (!empty($photo_staff)) {
echo'<div class="name_photo">';
if(file_exists('../'.$photo_staff)){
echo'<a href="../'.$photo_staff.'" title="'.$lang['photo'].' ('.$name_staff.')" class="group3"><img src="../'.$photo_staff.'" alt="" /></a></div>';}
else{echo'<a href="'.$script_name.'?edit='.$ls.'#photo'.$ls.'" title="'.$lang['add'].' '.$lang['photo'].' ('.$name_staff.')"><img src="../img/no_photo.jpg" alt="" /></a>';}

} else {echo'<div class="name_photo"><a href="'.$script_name.'?edit='.$ls.'#photo'.$ls.'" title="'.$lang['add'].' '.$lang['photo'].' ('.$name_staff.')"><img src="../img/no_photo.jpg" alt="" /></a></div>';}
//-----/photo display list

echo '</li>';

echo '<li><a href="mailto:'.$email_staff.'">'.$email_staff.'</a></li>';
echo '<li>'.$phone_staff.'</li>';
echo '<li>';
if($ls == '0') {echo $lang['super_admin'];} else {
if($access_staff == 'admin') {echo $lang['admin'];}
if($access_staff == 'staff') {echo $lang['staff'];} }
echo '</li>';

echo '<li class="tools"><a href="'.$script_name.'?edit='.$ls.'" title="'.$lang['edit'].' ('.$name_staff.')" class="edit"><i class="icon-edit-alt"></i></a></li>';

if ($ls == 0) { echo '<li class="tools none_active"><i class="icon-trash-2"></i></li>'; }
	
else {
	
echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'" title="'.$lang['delete'].' ('.$name_staff.')" class="delete" onclick ="return confirm(\''.$lang['user'].': &quot;'.$name_staff.'&quot; '.$lang['delete_m'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';

} 

echo '<div class="clear"></div>';
echo '</ul>';


//========================================EDIT WINDOW

if (isset($_GET['edit']) == true) {
if 	($_GET['edit'] == $ls) {

$anc_sb = $_GET['edit'] + 1;

$found_ls = '1';


echo '<div class="shadow_back">';

if (!isset($_POST['line']) || isset($ERROR)) {
echo '<div id="bt1" class="ftools">';	
echo '<div class="tools_window_close">';
if (isset($_GET['insearch'])){
echo '<a href="'.$script_name.'?search='.$_GET['insearch'].'" title="'.$lang['close'].'" class="close_window"><i class="icon-cancel"></i></a>';
} else {
echo '<a href="'.$script_name.'" title="'.$lang['close'].'" class="close_window"><i class="icon-cancel"></i></a>';}
echo '</div>';
echo '
<div class="tools_window_safe"><a href="#" onclick="safe_and_back()" class="safe_window" title="'.$lang['safe_and_back'].'"><i class="icon-ok"></i></a></div>';
echo '</div>';
}

echo '
<script>
window.onbeforeunload = marg_bt(); 
function marg_bt() {	
var bt1 = document.getElementById(\'bt1\');
var bt2 = document.getElementById(\'bt2\');
setTimeout("bt1.className +=\' fadein_tool_bt\'", 200);
setTimeout("bt2.className +=\' fadein_tool_bt\'", 400);
}
</script>';



echo'<div class="edit_window" id="win_edit">';

echo'<div class="edit_window_block">';

echo '
<div class="title_edit"><h3>'.$name_staff.'</h3>
<div class="clear"></div>
</div>';	



echo '
<script>
function safe_and_back() {
inp_sb = document.getElementById(\'inp_sb\');	
inp_sb.innerHTML = \'<input type="hidden" name="safe_and_back" value="1" />\';
setTimeout(function() { $(\'#edit_'.$ls.'\').submit(); }, 40)	
}
</script>';




//=========DISPLAY ERRORS
if (array_key_exists('line',$_POST)){
	
if (isset($ERROR) && is_array($ERROR)) {
echo '<div class="error edit_error"><ul>';
foreach($ERROR as $key => $value){ echo '<li>'.$ERROR[$key]['text'].'</li>'; }
echo '</ul></div>';
} else { 
if(!isset($_POST['safe_and_back'])) {echo '<div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div>';}
else {echo '<div class="done edit_error"><ul><li>'.$lang['saved'].' <i class="icon-spin5 animate-spin"></i></li></ul></div>';
if (isset($_GET['insearch'])) { 
$re_url = $script_name.'?edit='.$_GET['edit'].'&insearch='.$_GET['insearch'];
} else {
$re_url = $script_name.'?edit='.$_GET['edit'];
}
echo '
<script>
window.onbeforeunload = reload_sb(); 
function reload_sb() {	
setTimeout("document.location.href=\''.$re_url.'\'", 2000);
}
</script>';

}
}

}	
//=============/display errors

	
echo '<div class="edit_form">';

if (isset($_GET['insearch'])) {
echo '<form name="edit'.$ls.'" method="post" action="'.$script_name.'?edit='.$_GET['edit'].'&insearch='.$_GET['insearch'].'#line'.$anc_sb.'" id="edit_'.$ls.'">';	
} else {
echo '<form name="edit'.$ls.'" method="post" action="'.$script_name.'?edit='.$_GET['edit'].'#line'.$anc_sb.'" id="edit_'.$ls.'">';
}

echo '<div id="inp_sb"></div>';

echo '<div class="input_info">
<div class="input_name">'.$lang['login'].':</div>
<div class="input"><input type="text" name="staff_login" value="'; if(isset($_POST['staff_login'])){echo $_POST['staff_login'];}else{echo $login_staff;} echo'" /></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

echo '<div class="input_info">
<div class="input_name">'.$lang['pass'].':</div>';




if ($access_level != 'super_admin' && $ls == 0 || $access_level == 'staff' && $number_line_access != $ls || $access_level == 'admin' && $number_line_access != $ls && $access_staff == 'admin') {
echo '<div class="input"><input type="password" name="staff_pass" value="password" /></div>'; } 
else {
echo '<div class="input"><input type="text" name="staff_pass" value="'.$passw_staff.'" /></div>';}

echo'
<div class="clear"></div>
</div>
<div class="clear"></div>';

echo '<div class="input_info">
<div class="input_name">'.$lang['name'].':</div>
<div class="input"><input type="text" name="staff_name" value="'; if(isset($_POST['staff_name'])){echo $_POST['staff_name'];}else{echo $name_staff;} echo'" /></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

echo '<div class="input_info">
<div class="input_name">'.$lang['mail'].':</div>
<div class="input">
<input type="text" name="staff_mail" value="'; if(isset($_POST['staff_mail'])) {echo $_POST['staff_mail'];} else {echo $email_staff;} echo'" />
<label>';


if (isset($_POST['staff_display_email'])==true) { 
echo '<input type="checkbox" value="yes" name="staff_display_email" checked="checked" />';}
else if (isset($_POST['staff_mail'])==true && isset($_POST['staff_display_email'])==false) { 
echo '<input type="checkbox" value="yes" name="staff_display_email" />'; } 
else if($email_display_staff == 'yes' && isset($_POST['staff_display_email'])==false && isset($_POST['staff_mail'])==false) {
echo '<input type="checkbox" value="yes" name="staff_display_email" checked="checked" />'; }
else { echo '<input type="checkbox" value="yes" name="staff_display_email" />'; }


echo '<span>'.$lang['allow_display'].'</span></label><div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

echo '<div class="input_info">
<div class="input_name">'.$lang['phone'].':</div>
<div class="input"><input type="text" name="staff_phone" value="'; if(isset($_POST['staff_phone'])){echo $_POST['staff_phone'];}else{echo $phone_staff;} echo'" />
<label>';

if (isset($_POST['staff_display_phone'])==true) { 
echo '<input type="checkbox" value="yes" name="staff_display_phone" checked="checked" />';}
else if (isset($_POST['staff_phone'])==true && isset($_POST['staff_display_phone'])==false) { 
echo '<input type="checkbox" value="yes" name="staff_display_phone" />'; } 
else if($phone_display_staff == 'yes' && isset($_POST['staff_display_phone'])==false && isset($_POST['staff_phone'])==false) {
echo '<input type="checkbox" value="yes" name="staff_display_phone" checked="checked" />'; }
else { echo '<input type="checkbox" value="yes" name="staff_display_phone" />'; }

echo '<span>'.$lang['allow_display'].'</span></label><div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

echo '<div class="input_info">
<div class="input_name">'.$lang['staff_post'].':</div>
<div class="input"><input type="text" name="staff_post" value="'; if(isset($_POST['staff_post'])){echo $_POST['staff_post'];}else{echo $post_staff;} echo'" /></div>
<div class="clear"></div>
</div>';


//----------DESCRIPTION
$tg1 = htmlspecialchars('<br>',ENT_QUOTES);
$tg2 = htmlspecialchars('<br />',ENT_QUOTES);
$tgh1 = '<br>';
$tgh2 = '<br />';
$description_staff = str_replace(array($tg1, $tg2, $tgh1, $tgh2), "\n", trim($description_staff));
if(isset($_POST['staff_description'])) {$post_desc = str_replace(array($tg1, $tg2, $tgh1, $tgh2), "\n", trim($_POST['staff_description']));}

echo '<div class="input_info">
<div class="input_name">'.$lang['description'].':<br /><small>'.$lang['allow_html'].'</small></div>
<div class="input"><textarea name="staff_description" id="desc">'; if(isset($_POST['staff_description'])){echo $post_desc;}else{echo $description_staff;} echo'</textarea></div>

<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/description



echo '<div class="input_info">
<div class="input_name">'.$lang['access_level'].':</div>
<div class="input">';

if ($_GET['edit'] == 0) {echo '<div>'.$lang['super_admin'].'</div><input type="hidden" name="staff_access_level" value="admin" />';} else {

if ($access_level == 'super_admin') {
echo'
<select name="staff_access_level" onchange="return alert(\''.$lang['confirm_access'].'\');">
<option value="admin" ';if(isset($_POST['staff_access_level'])){if ($_POST['staff_access_level'] == 'admin'){echo 'selected';}}else{if($access_staff == 'admin') {echo 'selected';}} echo'>'.$lang['admin'].'</option>
<option value="staff" ';if(isset($_POST['staff_access_level'])){if ($_POST['staff_access_level'] == 'staff'){echo 'selected';}}else{if($access_staff == 'staff') {echo 'selected';}} echo'>'.$lang['staff'].'</option>
</select>';
}

else if ($access_staff == 'admin') {echo '<div>'.$lang['admin'].'</div><input type="hidden" name="staff_access_level" value="admin" />';}

else {echo '<div>'.$lang['staff'].'</div><input type="hidden" name="staff_access_level" value="staff" />';}

}

echo'
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';


//==========================photo

echo '<div class="input_info" id="photo'.$ls.'">
<div class="input_name">'.$lang['photo'].':</div>
<div class="input">
<div class="photo_block">
<div class="innerPhoto">
<a href="photos.php?iframe" id="selectPhoto" class="iframe" title="'.$lang['select'].' '.$lang['photo'].'"></a>
<div class="photo_tools">
<a href="#" onclick="resetImg()"><i class="icon-block"></i>'.$lang['reset'].'</a>
<a href="photos.php?iframe" class="iframe"><i class="icon-picture"></i>'.$lang['select'].'</a> 
<div class="clear"></div>
</div>
</div>
</div>
<label>';


if (isset($_POST['staff_display_photo'])==true) { 
echo '<input type="checkbox" value="yes" name="staff_display_photo" checked="checked" />';}
else if (isset($_POST['staff_photo'])==true && isset($_POST['staff_display_photo'])==false) { 
echo '<input type="checkbox" value="yes" name="staff_display_photo" />'; } 
else if($photo_display_staff == 'yes' && isset($_POST['staff_display_photo'])==false && isset($_POST['staff_photo'])==false) {
echo '<input type="checkbox" value="yes" name="staff_display_photo" checked="checked" />'; }
else { echo '<input type="checkbox" value="yes" name="staff_display_photo" />'; }


echo '<span>'.$lang['allow_display'].'</span></label>';
echo '<input type="hidden" id="photoInput" name="staff_photo" value="'; if(isset($_POST['staff_photo'])){echo $_POST['staff_photo'];}else{if(file_exists('../'.$photo_staff)){echo $photo_staff;}else{echo'';}} echo '" />';

echo '<script>
window.onbeforeunload = oninputImg() 
function oninputImg() {
var photoFile = document.getElementById("photoInput").value;
if (photoFile != \'\') {document.getElementById("selectPhoto").innerHTML = \'<img src="../\'+photoFile+\'" />\';}
else {document.getElementById("selectPhoto").innerHTML = \'<img src="../img/no_photo.jpg" />\';}
}
function resetImg(Nullstr) {
var Nullstr = \'\';	
var InpReset=document.getElementById("photoInput");
InpReset.value=Nullstr;
document.getElementById("selectPhoto").innerHTML = \'<img src="../img/no_photo.jpg" />\';
}
</script>';
echo '
</div>
<div class="clear"></div>
</div><div class="clear"></div>';



if ($access_level == 'staff') { 
if($active_staff == 'yes') {echo '<input type="hidden" value="yes" name="staff_active" />';}
} else {

if ($_GET['edit'] == 0) { echo '<input type="hidden" value="yes" name="staff_active" />'; } else {	
echo '<div class="input_info">
<div class="input_name">'.$lang['active'].':</div>
<div class="input">
<label>';

if (isset($_POST['staff_active'])==true) { 
echo '<input type="checkbox" value="yes" name="staff_active" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['staff_active'])==false) { 
echo '<input type="checkbox" value="yes" name="staff_active" />'; } 
else if($active_staff == 'yes' && isset($_POST['staff_active'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="yes" name="staff_active" checked="checked" />'; }
else { echo '<input type="checkbox" value="yes" name="staff_active" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';


echo'</label>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
}
} //staff access



list($per, $day_add, $month_add, $year_add, $hours_add, $minuts_add, $seconds_add) = explode("_", $id_staff);	


if(isset($_POST['change'])){ 
$day_change='--'; $month_change='--'; $year_change='--'; $hours_change='--'; $minuts_change='--'; $seconds_change='--';
} else {
list($day_change, $month_change, $year_change, $hours_change, $minuts_change, $seconds_change) = explode("_", $time_change_staff);	
} 


list(
$day_current, 
$month_current, 
$year_current, 
$hours_current, 
$minuts_current, 
$seconds_current
) = explode("_", $time_current);

echo '
<div class="input_info last_block">

<span class="add_info">
<i>'.$lang['added'].':</i><b>'.$day_add.'.'.$month_add.'.'.$year_add.'</b> <span class="time_add">'.$hours_add.':'.$minuts_add.':'.$seconds_add.'</span>';

$add_user_found = '';
$change_user_found = '';

for ($lsa = 0; $lsa < sizeof($lines_staff); ++$lsa) { 
if (!empty($lines_staff[$lsa])) {
$data_access_info = explode('::', $lines_staff[$lsa]); 
array_pop($data_access_info);
if ($who_add_staff == $data_access_info[0]) {echo ' - <b>'.$data_access_info[5].'</b>'; $add_user_found .= '1';} else {$add_user_found .= '0';}
}}
if ($add_user_found == '0') {echo ' - '.$lang['not_found_user'];}


if ($day_change != '00') {
echo '<br /><i>'.$lang['changed'].':</i><b>'.$day_change.'.'.$month_change.'.'.$year_change.'</b> <span class="time_add">'.$hours_change.':'.$minuts_change.':'.$seconds_change.'</span>';



for ($lsi = 0; $lsi < sizeof($lines_staff); ++$lsi) { 
if (!empty($lines_staff[$lsi])) {
$data_access_info = explode('::', $lines_staff[$lsi]); 
array_pop($data_access_info);
if ($who_change_staff == $data_access_info[0]) {echo ' - <b>'.$data_access_info[5].'</b>'; $change_user_found .= '1';} else {$change_user_found .= '0';}
}} 
if ($change_user_found == '0') {echo ' - '.$lang['not_found_user'];}
} 
echo '</span>';

if ($year_current >= $year_add && $month_current >= $month_add && $day_current >= $day_add && $hours_current >= $hours_add && $minuts_current > $minuts_add + 1 || $year_current >= $year_add && $month_current >= $month_add && $day_current >= $day_add && $hours_current > $hours_add || $year_current >= $year_add && $month_current >= $month_add && $day_current > $day_add || $year_current >= $year_add && $month_current > $month_add || $year_current > $year_add) { 
$val_change = $time_current; } else {$val_change = $new_add_time;}

echo '<input type="hidden" name="change" value="'.$val_change.'" />';
echo '<input type="hidden" name="who" value="'.$who_add_staff.'" />'; 
echo'
<input type="hidden" name="id_line" value="'.$id_staff.'" />
<input type="hidden" name="line" value="'.$_GET['edit'].'" />
<input type="hidden" name="check_login" value="'.$login_staff.'" />

<button title="'.$lang['safe_and_close'].'"><i class="icon-floppy"></i>'.$lang['safe'].'</button>';

echo '
<a class="button_cancel" href="'.$script_name.'" title="'.$lang['cancel'].'" onclick ="return confirm(\''.$lang['confirm_close'].'\');"><i class="icon-cancel"></i></a>';

echo '
<div class="clear"></div>
</div>
<div class="clear"></div>';

echo '</form></div>';

echo '<div class="clear"></div>
</div></div></div>';	
} // get line		
} // get edit true

//========================================/WINDOW 

} //no empty lines 

else { //==============DELETE EMPTY LINES
if (isSet($_GET['delete_moves']) == false) {
$crlf = "\n"; 
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//delete process
	
    if (isSet($lines[(integer) $ls]) == true) 
    {   unset($lines[(integer) $ls]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ;  echo $refresh_0;}
} // delete empty lines


echo'<script>
var anc = window.location.hash.replace("#","");
if (anc=="line'.$number_line.'"){
document.getElementById("position'.$number_line.'").className +=" this_element";
}</script>';


}//count lines


if(!isset($_POST['line']) && isset($_GET['edit']) && $found_ls != '1') {
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_found_replace'].'</div></div>';
echo $refresh_3;	//not found line for edit		
}


//=====================================================================SEARCH WINDOW
if (isset($_GET['search']) == true) {
if (empty($_GET['search'])) { 

echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['empty_search'].'</div></div>';
echo $refresh_3;

	} else {
		
$_GET['search'] = urldecode($_GET['search']);
$query = mb_strtolower($_GET['search'], 'utf8');	
	
$found = 'no';

echo '<script src="../js/search.js"></script>';

echo '<div class="shadow_back">';

echo '<div id="bts" class="ftools">';
echo '<div class="tools_window_close">';
echo '<a href="'.$script_name.'" title="'.$lang['close'].'" class="close_window"><i class="icon-cancel"></i></a>';
echo '</div>';
echo '</div>';

echo '
<script>
window.onbeforeunload = marg_bts(); 
function marg_bts() {	
var bt1 = document.getElementById(\'bts\');
setTimeout("bts.className +=\' fadein_tool_bt\'", 200);
}
</script>';

echo'
<div class="edit_window" id="win_edit">
<div class="edit_window_block">';

echo '
<div class="title_edit"><h3>'.$lang['title_search'].' '.$_GET['search'].'</h3>
<div class="clear"></div>
</div>';
	

echo '
<div id="search_block">
<form name="get_search" method="get" action="'.$script_name.'">
 <button id="prev_search" type="button"><i class="icon-angle-circled-left"></i></button>
 <input id="search_text" name="search" type="text" value="'.$query.'" />
 <button id="next_search" type="button"><i class="icon-angle-circled-right"></i></button>
 <input id="clear_button" type="button" value="Clear" />
<button><i class="icon-search"></i></button>
<div class="clear"></div>
</form> 
<!-- <div id="count" style="font-size:10pt;"></div> -->
 </div>';	
	

echo '
<script>
var delay = 1000;
setTimeout(document.getElementById("search_text").click(), delay);
</script>
';
	
echo '<div id="container">
 <div id="content">
 <div id="text">
';

	
	
for ($ls = 0; $ls < sizeof($lines_staff); ++$ls) { //=========== SEARCH COUNT
$data_search_list = explode('::', $lines_staff[$ls]); 

$search_line = $ls+1;

$search_login = mb_strtolower($data_search_list[1], 'utf8');
$search_name = mb_strtolower($data_search_list[5], 'utf8');
$search_mail = mb_strtolower($data_search_list[6], 'utf8');
$search_phone = $data_search_list[8];

if (preg_match('/'.$query.'/i', $search_login) || preg_match('/'.$query.'/i', $search_name) || preg_match('/'.$query.'/i', $search_mail) || preg_match('/'.$query.'/i', $search_phone)) {
$found = 'yes';






echo '<ul class="list_inc">
<li class="small">'.$search_line.'</li>
<li>'.$data_search_list[1].'</li>
<li>'.$data_search_list[5].'</li> 
<li>'.$search_mail.'</li>
<li>'.$search_phone.'</li>';

echo '<li class="tools"><a href="'.$script_name.'?edit='.$ls.'&insearch='.$_GET['search'].'" title="'.$lang['edit'].' ('.$data_search_list[5].')" class="edit"><i class="icon-edit-alt"></i></a></li>';
if ($ls != 0) {
echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'&insearch='.$_GET['search'].'" title="'.$lang['delete'].' ('.$data_search_list[5].')" class="delete" onclick ="return confirm(\''.$lang['user'].': &quot;'.$data_search_list[5].'&quot; '.$lang['delete_m'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';
} else { echo '<li class="tools none_active"><i class="icon-trash-2"></i></li>'; }

echo '<div class="clear"></div></ul>';				
	

} //found

} // count search

echo '
</div>
</div>
</div>
';

if($found == 'no') {echo '<div class="error">'.$lang['not_found'].' ('.$_GET['search'].')</div>';} //not found







echo '<div class="clear"></div></div></div></div>';	
} // empty get search
} //get search
//--------------------/search





echo'<div class="clear"></div></div>'; //table

} //no empty data file


echo '<div id="add_data" class="add">
<a href="'.$script_name.'?add='.$new_line.'">
<span class="text"><i class="icon-plus"></i>'.$lang['add'].'</span>
</a>
<div class="clear"></div>
</div>'; // ADD BUTTON

echo '</div>'; //============================DIV MAIN

echo'
<script>
window.onload = function()
{
var widthTable = $(data).width() + "px";
$(add_data).css({"width": widthTable});
}
</script>';

} else { // no data file

echo $refresh_0;

}




}// access


include ('footer.php');
?>