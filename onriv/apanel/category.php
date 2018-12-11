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

$add_name = $lang['new_category'];
$add_description = '';
$add_active = 'off';
$change_time = $new_add_time;

$line_data_add = $id.'::'.$add_name.'::'.$add_description.'::'.$add_active.'::'.$add_who.'::'.$change_time.'::'.$add_who.'::';

//======================Add process

if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;} else {

define('ADD_LINE', $file_name);
if (!file_get_contents(ADD_LINE))
{

$_GET['add'] = 0;

$fp=fopen($file_name, "a+"); 
fputs
($fp, "$line_data_add"); 
fclose($fp);

} else {
$file = fopen($file_name,"rb") ; 
flock($file,LOCK_SH) ; 
flock($file,LOCK_UN) ; 
fclose($file) ; 

$fp=fopen($file_name, "a+"); 
fputs
($fp, "\n$line_data_add"); 
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




define('DATA', $file_name);
if (!file_get_contents(DATA)) { //empty data file 
echo '<div class="mess">'.$lang['empty_data'].'</div>';
} else { 


// =====================================BLOCK MOOVES

if(isset($_GET['moves'])) { if ($_GET['moves'] !='') {
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
";
}
 //======================delet moves		
	
	
	

//======================================================DELET

$crlf = "\n"; 
if (isSet($_GET['delete']) == true) {

if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; echo $refresh_3;} else {



	
$file = fopen($file_name,"r+") ; 
    flock($file,LOCK_EX) ; 
    $lines = preg_split("~\r*?\n+\r*?~",fread($file,filesize($file_name))) ;	

//Убиваем
	
    if (isSet($lines[(integer) $_GET['delete']]) == true) 
    {   unset($lines[(integer) $_GET['delete']]); 
        fseek($file,0) ; 
        $data_size = 0 ; 
        ftruncate($file,fwrite($file,implode($crlf,$lines))) ; 
        fflush($file) ; 
    } 

    flock($file,LOCK_UN) ; 
    fclose($file) ; 

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



} //staff access

} //======================================== get delet






//========================REPLACE LINE
if (isSet($_POST["line"]) == true) {	

unset($ERROR);


//=======================================CHECK ID
$data_file_check = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file_check, LOCK_SH); 
$lines_check = preg_split("~\r*?\n+\r*?~", fread($data_file_check,filesize($file_name))); 
flock($data_file_check, LOCK_UN); 
fclose($data_file_check); 

$check_line = $_POST["line"];	
if (isset($lines_check[$check_line]))	{	

$check_data = explode('::', $lines_check[$check_line]); 

if (!isset($check_data[0]) || $check_data[0] != $_POST['id_line']) 
{$ERROR['id_line']['text'] = $lang['error_found_replace_swing'];
echo $refresh_3;
}	//== if not found line

} // isset current line
}
//==================================/end check id




//-----------Name
$_POST['title'] = htmlspecialchars($_POST['title'],ENT_QUOTES);
$_POST['title'] = str_replace(array('::', '||', '**'), '', trim($_POST['title']));
$_POST['title'] = str_replace("\'",'',$_POST['title']);
$_POST['title'] = str_replace("'",'',$_POST['title']);
$_POST['title'] = preg_replace('/\\\\+/','',$_POST['title']); 
$_POST['title'] = preg_replace("|[\r\n]+|", " ", $_POST['title']); 
$_POST['title'] = preg_replace("|[\n]+|", " ", $_POST['title']); 
if(empty($_POST['title'])) {$ERROR['name_empty']['text'] = $lang['error_title_empty'];} else
if(strlen($_POST['title'])<3) {$ERROR['title_number']['text'] = $lang['error_title_number'];}
if(preg_match("/[^a-zA-Z0-9а-яА-Я-.,:() ]/u", $_POST['title'])) {$ERROR['title_symbol']['text'] = $lang['error_title_symbol'];}



//-----------Description
$_POST['description'] = htmlspecialchars($_POST['description'],ENT_QUOTES);
$_POST['description'] = str_replace(array('::', '||', '**'), '', trim($_POST['description']));
$_POST['description'] = str_replace("\'",'',$_POST['description']);
$_POST['description'] = str_replace("'",'',$_POST['description']);
$_POST['description'] = preg_replace('/\\\\+/','',$_POST['description']); 
$_POST['description'] = preg_replace("|[\r\n]+|", "<br />", $_POST['description']); 
$_POST['description'] = preg_replace("|[\n]+|", "<br />", $_POST['description']); 



//-----------Active
if (isset($_POST['obj_active'])==true) {$obj_active = 'yes';} else {$obj_active = '';}



//-----------Check input data
$id_line = $_POST['id_line'];
$add_name = $_POST['title'];
$add_description = $_POST['description'];
$add_active = $obj_active;
$who_add = $_POST['who'];
$change_time = $_POST['change'];
$change_who = $add_who;


$line_data_r = $id_line.'::'.$add_name.'::'.$add_description.'::'.$add_active.'::'.$who_add.'::'.$change_time.'::'.$change_who;

//---------------/check


} //isset line 

//---replace process

if (array_key_exists('line',$_POST)){

if (isset($ERROR) && is_array($ERROR)) { echo ''; } else {


	
$nl = $_POST['line'];
$nd = $nl+1;




if ($access_level == 'staff'){ //=============Staff
$ERROR['staff_access']['text'] = $lang['error_access'];
echo $refresh_3;


} else { //===================================admin

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
}
 
} //-- admin access
//unset($_POST); 
} //---- no errors

}//==============================================/replace
	
	
	
	
	
//====================================================DISPLAY	



echo '<div id="main">';
	
echo'<div id="data" class="table"><ul class="th">';

echo '<li class="tools"><i class="icon-sort"></i></li>';
echo '<li class="tools"><i class="icon-list-numbered"></i></li>';


echo '<li><i class="icon-ok-circled" style="margin:0 14px 0 0;"></i>'.$lang['title'].'</li>';
echo '<li></li>';
echo '<li></li>';
echo '<li></li>';
echo '<li></li>';

echo '<li class="tools"><i class="icon-edit-alt"></i></li>';
echo '<li class="tools"><i class="icon-trash-2"></i></li>';

echo '<div class="clear"></div>';
echo '</ul>';





$found_ls = '';
$data_file = fopen($file_name, "rb"); 
if (filesize($file_name) != 0) {
flock($data_file, LOCK_SH); 
$lines_data = preg_split("~\r*?\n+\r*?~", fread($data_file,filesize($file_name))); 
flock($data_file, LOCK_UN); 
fclose($data_file); 



for ($ls = 0; $ls < sizeof($lines_data); ++$ls) { 

$number_line = $ls+1;
$new_line = sizeof($lines_data);



if (!empty($lines_data[$ls])) {
$data_cat = explode('::', $lines_data[$ls]);	
if (isset($data_cat[0])) {$id_obj = $data_cat[0];} else {$id_obj = '';}
if (isset($data_cat[1])) {$name_obj = $data_cat[1];} else {$name_obj = '';}
if (isset($data_cat[2])) {$description_obj = $data_cat[2];} else {$description_obj = '';}
if (isset($data_cat[3])) {$active_obj = $data_cat[3];} else {$active_obj = '';}
if (isset($data_cat[4])) {$add_who_obj = $data_cat[4];} else {$add_who_obj = '';}
if (isset($data_cat[5])) {$time_change_obj = $data_cat[5];} else {$time_change_obj = '';}
if (isset($data_cat[6])) {$who_change_obj = $data_cat[6];} else {$who_change_obj = '';}
	

$class_line = '';
if ($ls % 2 == 0) {$class_line = 'first';} else {$class_line = 'second';}




echo '<ul id="position'.$number_line.'" class="'.$class_line.'">';

if (sizeof($lines_data) == 1) {
echo '<li class="tools none_active"><i class="icon-sort"></i></li>';
} else {
echo '<li class="tools list_tools" tabindex="1"><i class="icon-sort"></i>
<div>';	

echo '<div class="display_id" id="line'.$number_line.'"></div>';

if ($ls != 0) { echo '
<span>
<a href="'.$script_name.'?moves='.$ls.'&where=1" title="'.$lang['moove'].' '.$lang['up'].'"><i class="icon-up-circled"></i>'.$lang['up'].'</a>
</span>';} 
if ($ls != sizeof($lines_data)-1) { echo '
<span>
<a href="'.$script_name.'?moves='.$ls.'&where=0" title="'.$lang['moove'].' '.$lang['down'].'"><i class="icon-down-circled"></i>'.$lang['down'].'</a>
</span>';}
echo '</div></li>';
}

echo '<li class="tools">'.$number_line.'</li>';

echo '<li class="one">';

echo'<div class="hidden_info" tabindex="1">';
if ($active_obj == 'yes') {
echo '<i class="icon-ok-circled yes"></i><div><span>'.$lang['active_yes'].'</span></div>';	
} else {
echo '<i class="icon-block no"></i><div><span>'.$lang['active_no'].'</span></div>';	
}
echo '</div>';

$cat_link = $script_name;
$cat_link = str_replace('apanel/category.php','',$cat_link);

$cat_link = $cat_link.'index.php?cat='.$id_obj.'';


echo '<span class="str_left">'.$name_obj.'</span>';

echo '<div class="help_obj cat_link" tabindex="1" title="'.$lang['cat_link'].'">
<i class="icon-link"></i>
<div><a id="catlink'.$id_obj.'" href="'.$cat_link.'" class="catlink" target="_blank">'.$cat_link.'</a></div>
</div>';

echo '<div class="clear"></div></li>';




//echo '<li></li>';
//echo '<li></li>';
//echo '<li></li>';
//echo '<li></li>';


echo '<li class="tools"><a href="'.$script_name.'?edit='.$ls.'" title="'.$lang['edit'].' ('.$name_obj.')" class="edit"><i class="icon-edit-alt"></i></a></li>';

echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'" title="'.$lang['delete'].' ('.$name_obj.')" class="delete" onclick ="return confirm(\''.$lang['category'].': &quot;'.$name_obj.'&quot; '.$lang['delete_f'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';


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
setTimeout("bt1.className +=\' fadein_tool_bt\'", 200);
}
</script>';


echo'<div class="edit_window" id="win_edit">
<div class="edit_window_block">';


echo '
<div class="title_edit"><h3>'.$name_obj.'</h3>

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
if (isset($_POST)) {
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
 //location.reload();
}
</script>';
}
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
<div class="input_name">'.$lang['title'].':</div>
<div class="input"><input type="text" name="title" value="'; if(isset($_POST['title'])){echo $_POST['title'];}else{echo $name_obj;} echo'" /></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';



//----------DESCRIPTION
$tg1 = htmlspecialchars('<br>',ENT_QUOTES);
$tg2 = htmlspecialchars('<br />',ENT_QUOTES);
$tgh1 = '<br>';
$tgh2 = '<br />';
$description_obj = str_replace(array($tg1, $tg2, $tgh1, $tgh2), "\n", trim($description_obj));
if(isset($_POST['description'])) {$post_desc = str_replace(array($tg1, $tg2, $tgh1, $tgh2), "\n", trim($_POST['description']));}

echo '<div class="input_info">
<div class="input_name">'.$lang['description'].':<br /><small>'.$lang['allow_html'].'</small></div>
<div class="input"><textarea name="description" id="desc">'; if(isset($_POST['description'])){echo $post_desc;}else{echo $description_obj;} echo'</textarea></div>

<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/description



if ($access_level == 'staff') { echo '';} else {


echo '<div class="input_info">
<div class="input_name">'.$lang['active'].':</div>
<div class="input">
<label>';

if (isset($_POST['obj_active'])==true) { 
echo '<input type="checkbox" value="yes" name="obj_active" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['obj_active'])==false) { 
echo '<input type="checkbox" value="yes" name="obj_active" />'; } 
else if($active_obj == 'yes' && isset($_POST['obj_active'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="yes" name="obj_active" checked="checked" />'; }
else { echo '<input type="checkbox" value="yes" name="obj_active" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';


echo'</label>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

} //staff access




//----------Link ID

echo '<div class="input_info" id="link_id">
<div class="input_name">'.$lang['id_cat_link'].':</div>
<div class="input">';

$obj_link = $script_name;
$obj_link = str_replace('apanel/category.php','',$obj_link);
$obj_link = $obj_link.'index.php?cat='.$id_obj.'';

echo '<div class="id_link"><a href="'.$obj_link.'" target="_blank">'.$id_obj.'</a></div>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';


//----------/Link ID





list($per, $day_add, $month_add, $year_add, $hours_add, $minuts_add, $seconds_add) = explode("_", $id_obj);	

if(isset($_POST['change'])){ 
$day_change='--'; $month_change='--'; $year_change='--'; $hours_change='--'; $minuts_change='--'; $seconds_change='--';
} else {
list($day_change, $month_change, $year_change, $hours_change, $minuts_change, $seconds_change) = explode("_", $time_change_obj);	
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
$change_user_found ='';

for ($lsa = 0; $lsa < sizeof($lines_staff); ++$lsa) { 
if (!empty($lines_staff[$lsa])) {
$data_access_info = explode('::', $lines_staff[$lsa]); 
array_pop($data_access_info);
if ($add_who_obj == $data_access_info[0]) {echo ' - <b>'.$data_access_info[5].'</b>';  $add_user_found .= '1';} else {$add_user_found .= '0';}
}}
if ($add_user_found == '0') {echo ' - '.$lang['not_found_user'];}



if ($day_change != '00') {
echo '<br /><i>'.$lang['changed'].':</i><b>'.$day_change.'.'.$month_change.'.'.$year_change.'</b> <span class="time_add">'.$hours_change.':'.$minuts_change.':'.$seconds_change.'</span>';



for ($lsi = 0; $lsi < sizeof($lines_staff); ++$lsi) { 
if (!empty($lines_staff[$lsi])) {
$data_access_info = explode('::', $lines_staff[$lsi]); 
array_pop($data_access_info);
if ($who_change_obj == $data_access_info[0]) {echo ' - <b>'.$data_access_info[5].'</b>'; $change_user_found .= '1';} else {$change_user_found .= '0'; }
}}
if ($change_user_found == '0') {echo ' - '.$lang['not_found_user'];}

} 

echo '</span>';






if ($year_current >= $year_add && $month_current >= $month_add && $day_current >= $day_add && $hours_current >= $hours_add && $minuts_current > $minuts_add + 1 || $year_current >= $year_add && $month_current >= $month_add && $day_current >= $day_add && $hours_current > $hours_add || $year_current >= $year_add && $month_current >= $month_add && $day_current > $day_add || $year_current >= $year_add && $month_current > $month_add || $year_current > $year_add) { 
$val_change = $time_current; } else {$val_change = $new_add_time;}

echo '<input type="hidden" name="change" value="'.$val_change.'" />';
echo '<input type="hidden" name="who" value="'.$add_who_obj.'" />'; 
echo '
<input type="hidden" name="id_line" value="'.$id_obj.'" />
<input type="hidden" name="line" value="'.$_GET['edit'].'" />

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

} //file size !=0


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


echo '<div class="edit_window" id="win_edit">
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

	
	
for ($ls = 0; $ls < sizeof($lines_data); ++$ls) { //=========== SEARCH COUNT
$data_search_list = explode('::', $lines_data[$ls]); 

$search_line = $ls+1;

$data_search_list[1] = mb_strtolower($data_search_list[1], 'utf8');

if (preg_match('/'.$query.'/i', $data_search_list[1])) {
$found = 'yes';






echo '<ul class="list_inc">
<li class="small">'.$search_line.'</li>
<li>'.$data_search_list[1].'</li>
<li></li> 
<li></li>
<li></li>';

echo '<li class="tools"><a href="'.$script_name.'?edit='.$ls.'&insearch='.$_GET['search'].'" title="'.$lang['edit'].' ('.$data_search_list[1].')" class="edit"><i class="icon-edit-alt"></i></a></li>';

echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'&insearch='.$_GET['search'].'" title="'.$lang['delete'].' ('.$data_search_list[1].')" class="delete" onclick ="return confirm(\''.$lang['category'].': &quot;'.$data_search_list[1].'&quot; '.$lang['delete_f'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';


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

//=============================CREATE DATA FILE
$line_data_add = '';

$fp_create = fopen($file_name, "w"); // create data file
fwrite($fp_create, "$line_data_add");
fclose ($fp_create);

//echo '<div class="error">'.$lang['no_file'].'</div>';
echo $refresh_0;
}




}// access


include ('footer.php');
?>