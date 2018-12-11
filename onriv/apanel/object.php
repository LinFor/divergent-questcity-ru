<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
include ('header.php');

if (!empty($access) && $access == 'yes') {
if(!isset($onriv_take)) {die();}
$file_name = '../data/'.$id_prefix.'.dat'; 
$file_name_category = '../data/category.dat';

$new_line = '';

if (file_exists($file_name)) { // keep data file 

$cmod_file = substr(sprintf('%o', fileperms($file_name)), -4);
if ($cmod_file !='0644') {chmod ($file_name, 0644);}
//echo $cmod_file;


if(!isset($_GET['id'])) {$_GET['id'] = '';}

//==========================================================ADD


if (isSet($_GET['add']) == true) {	

$add_name = $lang['new_service'];
$add_description = '';
$add_category = '';
$add_provide = 'hourly';
$add_always_free = '0';
//============== UNITS TIME ADD
$add_staff_services = '';

$add_hours_start = '';
$add_minutes_start = '';
$add_hours_end = '';
$add_minutes_end = '';
$add_total_spots = '';
$add_min_spots = '';
$add_max_spots = '';
$add_count_spots = '';
$add_prices = '';
$add_currency = '';
if (!empty($currency_name)) {
$add_cur_arr = explode('::', $currency_name);
} else { $add_cur_arr = array('RUB','EUR','USD'); }
$add_currency = $add_cur_arr[0];


//============= PROVIDE DAILY
$add_allow_today = '0';
$add_daily_total_spots = '0';
$add_daily_min_spots = '1';
$add_daily_max_spots = '0';
$add_daily_count_spots = '1';
$add_daily_price = '0';
$add_daily_staff = '';


//============= WORK DAYS
$add_Monday = '1&&0&&0';
$add_Tuesday = '1&&0&&0';
$add_Wednesday = '1&&0&&0';
$add_Thursday = '1&&0&&0';
$add_Friday = '1&&0&&0';
$add_Saturday = '1&&0&&0';
$add_Sunday = '1&&0&&0';
$add_working_days = $add_Monday.'||'.$add_Tuesday.'||'.$add_Wednesday.'||'.$add_Thursday.'||'.$add_Friday.'||'.$add_Saturday.'||'.$add_Sunday;

$add_custom_date = '';
$add_active_two_monts = '0';
$add_fix_price = '';
$add_discount = '';
$add_only_pay = '0';
$add_only_row = '1';
$add_all_spots = '0';
$add_queue = '0';
$add_photos = '';
$add_wording = '0';
$add_active = 'off';
$change_time = $new_add_time;

$line_data_add = $id.'::'.$add_name.'::'.$add_description.'::'.$add_category.'::'.$add_provide.'::'.$add_currency.'::'.$add_staff_services.'::'.$add_hours_start.'::'.$add_minutes_start.'::'.$add_hours_end.'::'.$add_minutes_end.'::'.$add_total_spots.'::'.$add_min_spots.'::'.$add_max_spots.'::'.$add_count_spots.'::'.$add_prices.'::'.$add_allow_today.'::'.$add_daily_total_spots.'::'.$add_daily_min_spots.'::'.$add_daily_max_spots.'::'.$add_daily_count_spots.'::'.$add_daily_price.'::'.$add_daily_staff.'::'.$add_working_days.'::'.$add_custom_date.'::'.$add_active_two_monts.'::'.$add_fix_price.'::'.$add_discount.'::'.$add_only_row.'::'.$add_all_spots.'::'.$add_queue.'::'.$add_photos.'::'.$add_wording.'::'.$add_active.'::'.$add_who.'::'.$change_time.'::'.$add_who.'::'.$add_only_pay.'::'.$add_always_free.'::';

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
    setTimeout(\"document.location.href='".$script_name."?edit=".$_GET['add']."&id=".$_GET['id']."#line".$ancor_line."'\", delay);
    </script><noscript><meta http-equiv=\"refresh\" content=\"0; url=".$script_name."?edit=".$_GET['add']."&id=".$_GET['id']."#line".$ancor_line."\"></noscript>";
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

} //======================================== /get delet



//========================REPLACE LINE
$ancor_line_replace = '';
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
if(empty($_POST['title'])) {$_POST['title'] = $lang['new_service'];} else
if(strlen($_POST['title'])<2) {$_POST['title'] = $lang['new_service'];}


//-----------Description
$_POST['description'] = htmlspecialchars($_POST['description'],ENT_QUOTES);
$_POST['description'] = str_replace(array('::', '||', '**'), '', trim($_POST['description']));
$_POST['description'] = str_replace("\'",'',$_POST['description']);
$_POST['description'] = str_replace("'",'',$_POST['description']);
$_POST['description'] = preg_replace('/\\\\+/','',$_POST['description']); 
$_POST['description'] = preg_replace("|[\r\n]+|", "<br />", $_POST['description']); 
$_POST['description'] = preg_replace("|[\n]+|", "<br />", $_POST['description']); 

//-----------Category
$_POST['category'] = htmlspecialchars($_POST['category'],ENT_QUOTES);
$_POST['category'] = str_replace(array('::', '||', '**'), '', trim($_POST['category']));



//-----------Staff
$add_select_staff = '';	
if (isset($_POST['staff'])) {
	
if (empty($_POST['staff'])) { $add_select_staff = '0-'.$add_who.'&&';
echo'<script>alert(\''.$lang['empty_staff'].'\');</script>';

} else {


if (sizeof($_POST['hours_start']) != sizeof($_POST['staff'])) { //check counts staff / units
foreach ($_POST['hours_start'] as $key => $value) {
$add_select_staff .= $key.'-'.$add_who.'&&';	
}
echo'<script>alert(\''.$lang['empty_staff'].'\');</script>';	

} else { // counts ==

foreach ($_POST['staff'] as $key1 => $value1) {
	
if (is_array($value1)==true && sizeof($value1) > 1) {	
$value1 = array_diff($value1, array(''));	
$value1 = array_unique($value1);
} 
	
foreach ($value1 as $key => $value) {
$value = htmlspecialchars($value,ENT_QUOTES);	
$add_select_staff .= $key1.'-'.$value.'&&';		
} 
}
 
$add_select_staff = str_replace(array('::', '**', '||'), '', trim($add_select_staff));
} //check counts staff / units
} // empty post staff
} // isSet post staff
 else {
$add_select_staff = '0-'.$add_who.'&&';
echo'<script>alert(\''.$lang['empty_staff'].'\');</script>';}


// currency
$add_currency = '';
if (isset($_POST['currency'])) {
$add_currency = $_POST['currency'];	
$add_currency = str_replace(array('::', '**', '||'), '', trim($add_currency));
} 


//============== UNITS TIME
$add_hours_start = '';
$add_minutes_start = '';
$add_hours_end = '';
$add_minutes_end = '';
$add_total_spots = '';
$add_min_spots = '';
$add_max_spots = '';
$add_count_spots = '';
$add_prices = '';



// hours start 
if (isset($_POST['hours_start'])) {
foreach ($_POST['hours_start'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '00';}	
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_hours_start .= $value.'||';
}
$add_hours_start = str_replace(array('::', '**'), '', trim($add_hours_start));
} else {$add_hours_start = '00||';}

// minutes start 
if (isset($_POST['minutes_start'])) {
foreach ($_POST['minutes_start'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '00';}	
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_minutes_start .= $value.'||';
}
$add_minutes_start = str_replace(array('::', '**'), '', trim($add_minutes_start));
} else {$add_minutes_start = '00||';}

// hours end 
if (isset($_POST['hours_end'])) {
foreach ($_POST['hours_end'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]XX/", $value)) {$value = '00';}	
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_hours_end .= $value.'||';
}
$add_hours_end = str_replace(array('::', '**'), '', trim($add_hours_end));
} else {$add_hours_end = '00||';}

// minutes end
if (isset($_POST['minutes_end'])) {
foreach ($_POST['minutes_end'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '00';}		
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_minutes_end .= $value.'||';
}
$add_minutes_end = str_replace(array('::', '**'), '', trim($add_minutes_end));
} else {$add_minutes_end = '00||';}

// total spots
if (isset($_POST['total_spots'])) {
foreach ($_POST['total_spots'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '0';}		
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_total_spots .= $value.'||';
}
$add_total_spots = str_replace(array('::', '**'), '', trim($add_total_spots));
} 

// min spots
if (isset($_POST['min_spots'])) {
foreach ($_POST['min_spots'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '1';}	
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_min_spots .= $value.'||';
}
$add_min_spots = str_replace(array('::', '**'), '', trim($add_min_spots));
} 

// max spots
if (isset($_POST['max_spots'])) {
foreach ($_POST['max_spots'] as $key => $value) {
	
if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '0';}		
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_max_spots .= $value.'||';
}
$add_max_spots = str_replace(array('::', '**'), '', trim($add_max_spots));
} 

// count spots
if (isset($_POST['count_spots'])) {
foreach ($_POST['count_spots'] as $key => $value) {

if (empty($value) || preg_match("/[^0-9]/", $value)) {$value = '0';}		
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_count_spots .= $value.'||';
}
$add_count_spots = str_replace(array('::', '**'), '', trim($add_count_spots));
} 

// prices
if (isset($_POST['price'])) {
foreach ($_POST['price'] as $key => $value) {
	
$value = str_replace(array(','), '.', $value);
if (empty($value) || preg_match("/[^0-9.,-]/", $value)) {$value = '0';}		
$value = htmlspecialchars($value,ENT_QUOTES);
	
$add_prices .= $value.'||';
}
$add_prices = str_replace(array('::', '**'), '', trim($add_prices));
} 


//check spots counts
if (isset($_POST['total_spots']) && isset($_POST['min_spots']) && isset($_POST['max_spots'])) {
foreach ($_POST['total_spots'] as $key_ts => $value_ts) {
$hs = $_POST['hours_start'][$key_ts];	
$ms = $_POST['minutes_start'][$key_ts];
$he = $_POST['hours_end'][$key_ts];
$me = $_POST['minutes_end'][$key_ts];
$check_min_s = $_POST['min_spots'][$key_ts];	
$check_max_s = $_POST['max_spots'][$key_ts];
if ($value_ts > 0) {
if ($value_ts < $check_max_s || $value_ts < $check_min_s || $check_max_s > 0 && $check_min_s > $check_max_s) 
{echo '<script>alert("'.$lang['error_counts_spots'].' '.$lang['unit_time'].': '.$hs.':'.$ms.' - '.$he.':'.$me.'");</script>';}
}
}
}

//=========================

//============= PROVIDE DAILY
$add_allow_today = '';
$add_daily_total_spots = '';
$add_daily_min_spots = '';
$add_daily_max_spots = '';
$add_daily_count_spots = '';
$add_daily_price = '';
$add_daily_staff = '';
$add_provide = 'hourly';

//---------------

$add_photos = '';

//-----------Provide
if (isset($_POST['provide'])==true) {
if (empty($_POST['provide'])) {$add_provide = 'hourly';} else {
if ($_POST['provide'] == 'hourly') {$add_provide = 'hourly';} else if ($_POST['provide'] == 'daily') {$add_provide = 'daily';} 
} 
} 

//daily staff
if (isset($_POST['daily_staff'])) {
	
if (is_array($_POST['daily_staff'])==true && sizeof($_POST['daily_staff']) > 1) {	
$_POST['daily_staff'] = array_diff($_POST['daily_staff'], array(''));	
$_POST['daily_staff'] = array_unique($_POST['daily_staff']);
}

foreach ($_POST['daily_staff'] as $key => $value) {
$add_daily_staff .= $value.'||';
$add_daily_staff = str_replace(array('::', '**'), '', trim($add_daily_staff));}

} else {$add_daily_staff = $add_who.'||'; 
echo'<script>alert(\''.$lang['empty_staff'].'\');</script>';
}

//daily allow today
if (isset($_POST['allow_today'])) {
$add_allow_today = '1';	
} else {$add_allow_today = '0';}

//daily total spots
if (isset($_POST['daily_total_spots'])) {
$add_daily_total_spots = $_POST['daily_total_spots'];
if (empty($add_daily_total_spots) || preg_match("/[^0-9]/", $add_daily_total_spots)) {$add_daily_total_spots = '0';}		
$add_daily_total_spots = str_replace(array('::', '**', '||'), '', trim($add_daily_total_spots));	
}

//daily min spots
if (isset($_POST['daily_min_spots'])) {
$add_daily_min_spots = $_POST['daily_min_spots'];
if (empty($add_daily_min_spots) || preg_match("/[^0-9]/", $add_daily_min_spots)) {$add_daily_min_spots = '1';}		
$add_daily_min_spots = str_replace(array('::', '**', '||'), '', trim($add_daily_min_spots));	
}

//daily max spots
if (isset($_POST['daily_max_spots'])) {
$add_daily_max_spots = $_POST['daily_max_spots'];
if (empty($add_daily_max_spots) || preg_match("/[^0-9]/", $add_daily_max_spots)) {$add_daily_max_spots = '0';}		
$add_daily_max_spots = str_replace(array('::', '**', '||'), '', trim($add_daily_max_spots));	
}

//daily count spots
if (isset($_POST['daily_count_spots'])) {
$add_daily_count_spots = $_POST['daily_count_spots'];
if (empty($add_daily_count_spots) || preg_match("/[^0-9]/", $add_daily_count_spots)) {$add_daily_max_spots = '0';}			
$add_daily_count_spots = str_replace(array('::', '**', '||'), '', trim($add_daily_count_spots));	
}

//daily price
if (isset($_POST['daily_price'])) {
$add_daily_price = $_POST['daily_price'];
if (empty($add_daily_price) || preg_match("/[^0-9.,-]/", $add_daily_price)) {$add_daily_price = '0';}			
$add_daily_price = str_replace(array('::', '**', '||'), '', trim($add_daily_price));
$add_daily_price = str_replace(array(',', '/'), '.', trim($add_daily_price));
}


//check daily spots counts
if (isset($_POST['daily_total_spots']) && isset($_POST['daily_min_spots']) && isset($_POST['daily_max_spots'])) {
$check_min_ds = $_POST['daily_min_spots'];	
$check_max_ds = $_POST['daily_max_spots'];
if ($_POST['daily_total_spots'] > 0) {
if ($_POST['daily_total_spots'] < $check_max_ds || $_POST['daily_total_spots'] < $check_min_ds || $check_max_ds > 0 && $check_min_ds > $check_max_ds) 
{echo '<script>alert("'.$lang['error_counts_spots'].'");</script>';}
}
}


//=====================================================================//


//-----------work days

$mon_sw =''; //-----------------monday swing price
if (isset($_POST['mon_swing'])) {
if (empty($_POST['mon_swing']) && $_POST['mon_swing'] != '0' && $_POST['mon_swing'] != '+' && $_POST['mon_swing'] != '-') {$mon_sw = '0';} else {$mon_sw = $_POST['mon_swing'];}

$mon_sw = str_replace(array('::', '**', '||'), '', trim($mon_sw));	
}
$mon_pr ='';
if (isset($_POST['mon_price'])) {
if (empty($_POST['mon_price']) || preg_match("/[^0-9.,]/", $_POST['mon_price'])) {$mon_pr = '0';}
else {$mon_pr = $_POST['mon_price'];}
$mon_pr = str_replace(array('::', '**', '||'), '', trim($mon_pr));
$mon_pr = str_replace(array(',', '/'), '.', trim($mon_pr));	
} //---------

$tue_sw =''; //-----------------tuesday swing price
if (isset($_POST['tue_swing'])) {
if (empty($_POST['tue_swing']) && $_POST['tue_swing'] != '0' && $_POST['tue_swing'] != '+' && $_POST['tue_swing'] != '-') {$tue_sw = '0';} 
else {$tue_sw = $_POST['tue_swing'];}
$tue_sw = str_replace(array('::', '**', '||'), '', trim($tue_sw));	
}
$tue_pr ='';
if (isset($_POST['tue_price'])) {
if (empty($_POST['tue_price']) || preg_match("/[^0-9.,]/", $_POST['tue_price'])) {$tue_pr = '0';}
else {$tue_pr = $_POST['tue_price'];}
$tue_pr = str_replace(array('::', '**', '||'), '', trim($tue_pr));
$tue_pr = str_replace(array(',', '/'), '.', trim($tue_pr));	
} //---------

$wed_sw =''; //-----------------wednesday swing price
if (isset($_POST['wed_swing'])) {
if (empty($_POST['wed_swing']) && $_POST['wed_swing'] != '0' && $_POST['wed_swing'] != '+' && $_POST['wed_swing'] != '-') {$wed_sw = '0';} 
else {$wed_sw = $_POST['wed_swing'];}
$wed_sw = str_replace(array('::', '**', '||'), '', trim($wed_sw));	
}
$wed_pr ='';
if (isset($_POST['wed_price'])) {
if (empty($_POST['wed_price']) || preg_match("/[^0-9.,]/", $_POST['wed_price'])) {$wed_pr = '0';}
else {$wed_pr = $_POST['wed_price'];}
$wed_pr = str_replace(array('::', '**', '||'), '', trim($wed_pr));
$wed_pr = str_replace(array(',', '/'), '.', trim($wed_pr));	
} //---------

$thu_sw =''; //-----------------thursday swing price
if (isset($_POST['thu_swing'])) {
if (empty($_POST['thu_swing']) && $_POST['thu_swing'] != '0' && $_POST['thu_swing'] != '+' && $_POST['thu_swing'] != '-') {$thu_sw = '0';} 
else {$thu_sw = $_POST['thu_swing'];}
$thu_sw = str_replace(array('::', '**', '||'), '', trim($thu_sw));	
}
$thu_pr ='';
if (isset($_POST['thu_price'])) {
if (empty($_POST['thu_price']) || preg_match("/[^0-9.,]/", $_POST['thu_price'])) {$thu_pr = '0';}
else {$thu_pr = $_POST['thu_price'];}
$thu_pr = str_replace(array('::', '**', '||'), '', trim($thu_pr));
$thu_pr = str_replace(array(',', '/'), '.', trim($thu_pr));	
} //---------

$fri_sw =''; //-----------------friday swing price
if (isset($_POST['fri_swing'])) {
if (empty($_POST['fri_swing']) && $_POST['fri_swing'] != '0' && $_POST['fri_swing'] != '+' && $_POST['fri_swing'] != '-') {$fri_sw = '0';} 
else {$fri_sw = $_POST['fri_swing'];}
$fri_sw = str_replace(array('::', '**', '||'), '', trim($fri_sw));	
}
$fri_pr ='';
if (isset($_POST['fri_price'])) {
if (empty($_POST['fri_price']) || preg_match("/[^0-9.,]/", $_POST['fri_price'])) {$fri_pr = '0';}
else {$fri_pr = $_POST['fri_price'];}
$fri_pr = str_replace(array('::', '**', '||'), '', trim($fri_pr));
$fri_pr = str_replace(array(',', '/'), '.', trim($fri_pr));	
} //---------

$sat_sw =''; //-----------------saturday swing price
if (isset($_POST['sat_swing'])) {
if (empty($_POST['sat_swing']) && $_POST['sat_swing'] != '0' && $_POST['sat_swing'] != '+' && $_POST['sat_swing'] != '-') {$sat_sw = '0';} 
else {$sat_sw = $_POST['sat_swing'];}
$sat_sw = str_replace(array('::', '**', '||'), '', trim($sat_sw));	
}
$sat_pr ='';
if (isset($_POST['sat_price'])) {
if (empty($_POST['sat_price']) || preg_match("/[^0-9.,]/", $_POST['sat_price'])) {$sat_pr = '0';}
else {$sat_pr = $_POST['sat_price'];}
$sat_pr = str_replace(array('::', '**', '||'), '', trim($sat_pr));
$sat_pr = str_replace(array(',', '/'), '.', trim($sat_pr));	
} //---------

$sun_sw =''; //-----------------sunday swing price
if (isset($_POST['sun_swing'])) {
if (empty($_POST['sun_swing']) && $_POST['sun_swing'] != '0' && $_POST['sun_swing'] != '+' && $_POST['sun_swing'] != '-') {$sun_sw = '0';} 
else {$sun_sw = $_POST['sun_swing'];}
$sun_sw = str_replace(array('::', '**', '||'), '', trim($sun_sw));	
}
$sun_pr ='';
if (isset($_POST['sun_price'])) {
if (empty($_POST['sun_price']) || preg_match("/[^0-9.,]/", $_POST['sun_price'])) {$sun_pr = '0';}
else {$sun_pr = $_POST['sun_price'];}
$sun_pr = str_replace(array('::', '**', '||'), '', trim($sun_pr));
$sun_pr = str_replace(array(',', '/'), '.', trim($sun_pr));	
} //---------


if (isset($_POST['Monday'])) {$add_Monday = '1&&'.$mon_sw.'&&'.$mon_pr;} else {$add_Monday = '0&&0&&0';}
if (isset($_POST['Tuesday'])) {$add_Tuesday = '1&&'.$tue_sw.'&&'.$tue_pr;} else {$add_Tuesday = '0&&0&&0';}
if (isset($_POST['Wednesday'])) {$add_Wednesday = '1&&'.$wed_sw.'&&'.$wed_pr;} else {$add_Wednesday = '0&&0&&0';}
if (isset($_POST['Thursday'])) {$add_Thursday = '1&&'.$thu_sw.'&&'.$thu_pr;} else {$add_Thursday = '0&&0&&0';}
if (isset($_POST['Friday'])) {$add_Friday = '1&&'.$fri_sw.'&&'.$fri_pr;} else {$add_Friday = '0&&0&&0';}
if (isset($_POST['Saturday'])) {$add_Saturday = '1&&'.$sat_sw.'&&'.$sat_pr;} else {$add_Saturday = '0&&0&&0';}
if (isset($_POST['Sunday'])) {$add_Sunday = '1&&'.$sun_sw.'&&'.$sun_pr;} else {$add_Sunday = '0&&0&&0';}
$add_working_days = $add_Monday.'||'.$add_Tuesday.'||'.$add_Wednesday.'||'.$add_Thursday.'||'.$add_Friday.'||'.$add_Saturday.'||'.$add_Sunday;


//-----------custom dates
$add_custom_date ='';

$add_mday ='';
$add_dp ='';
$add_pm ='';
$add_cprices ='';	
//-- dates
if (isset($_POST['mday'])) {
	
if (is_array($_POST['mday'])==true && sizeof($_POST['mday']) > 1) {	
$_POST['mday'] = array_diff($_POST['mday'], array(''));	
$_POST['mday'] = array_unique($_POST['mday']);
}

foreach ($_POST['mday'] as $key => $value) {

$add_mday .= $value.'&&';
$add_mday = str_replace(array('::', '**', '||'), '', trim($add_mday));

// disabled day or shift price
if (isset($_POST['disabled_price'][$key])) {
$check_dp = $_POST['disabled_price'][$key];
$check_dp = htmlspecialchars($check_dp,ENT_QUOTES);
$check_dp = str_replace(array('::', '**', '||'), '', trim($check_dp));
$add_dp .= $check_dp.'&&'; }

// plus minus
if (isset($_POST['plus_minus'][$key])) { $check_pm = $_POST['plus_minus'][$key]; } else { $check_pm = '+'; }

$check_pm = htmlspecialchars($check_pm,ENT_QUOTES);
$check_pm = str_replace(array('::', '**', '||'), '', trim($check_pm));
$add_pm .= $check_pm.'&&';

// custom prices
if (isset($_POST['c_price'][$key])) {$check_cprice = $_POST['c_price'][$key];} else { $check_cprice = '0'; }

$check_cprice = str_replace(array(','), '.', $check_cprice);
if (empty($check_cprice) || preg_match("/[^0-9.,]/", $check_cprice)) {$check_cprice = '0';}		
$check_cprice = htmlspecialchars($check_cprice,ENT_QUOTES);
$check_cprice = str_replace(array('::', '**', '||'), '', trim($check_cprice));
$add_cprices .= $check_cprice.'&&';

} 

} $add_custom_date = $add_mday.'||'.$add_dp.'||'.$add_pm.'||'.$add_cprices; //=== /dates


//-----------fix price
$add_sum_fp = '';
if (isset($_POST['fix_price'])) {
$add_sum_fp = $_POST['fix_price'];
if (empty($add_sum_fp) || preg_match("/[^0-9.,-]/", $add_sum_fp)) {$add_sum_fp = '0';}			
$add_sum_fp = str_replace(array('::', '**', '||'), '', trim($add_sum_fp));
$add_sum_fp = str_replace(array(',', '/'), '.', trim($add_sum_fp));
}
$add_fix_price = $add_sum_fp;


$add_discount = '';
$dis_cd = '';
$dis_pr = '';
$dis_ct = '';
if (isset($_POST['discount_code'])) {
$dis_cd = $_POST['discount_code'];
$dis_cd = str_replace(array('::', '**', '||'), '', trim($dis_cd));
}

if (isset($_POST['discount_price'])) {	
$dis_pr = $_POST['discount_price'];
if (preg_match("/[^0-9.,-]/", $dis_pr)) {$dis_pr = '0';}
$dis_pr = str_replace(array('::', '**', '||'), '', trim($dis_pr));		
}

if (isset($_POST['discount_count'])) {
$dis_ct = $_POST['discount_count'];
$dis_ct = str_replace(array('::', '**', '||'), '', trim($dis_ct));	
}
$add_discount = $dis_cd.'||'.$dis_pr.'||'.$dis_ct;

//-----------Select only pay
if (isset($_POST['only_pay'])==true) {$add_only_pay = '1';} else {$add_only_pay= '0';}

//-----------Select only row
if (isset($_POST['only_row'])==true) {$add_only_row = '1';} else {$add_only_row = '0';}


//-----------Queue
if (isset($_POST['queue'])==true) {$add_queue = '1';} else {$add_queue = '0';}


//-----------Active two monts
if (isset($_POST['active_two_monts'])==true) {$add_active_two_monts = '1';} else {$add_active_two_monts = '0';}



//-----------All spots
$add_all_spots = '0';
if (isset($_POST['all_spots'])==true) {
$add_all_spots = $_POST['all_spots'];
if (preg_match("/[^0-9.,-]/", $add_all_spots)) {$add_all_spots = '0';}
$add_all_spots = str_replace(array('::', '**', '||'), '', trim($add_all_spots));
} 

//-----------Photos
if (isset($_POST['photos'])) {
	
if (is_array($_POST['photos'])==true && sizeof($_POST['photos']) > 1) {	
$_POST['photos'] = array_diff($_POST['photos'], array(''));	
$_POST['photos'] = array_unique($_POST['photos']);
}

foreach ($_POST['photos'] as $key => $value) {
$add_photos .= $value.'||';
$add_photos = str_replace(array('::', '**'), '', trim($add_photos));}
}

// Wording
$add_wording = '';
if (isset($_POST['wording'])) {
$add_wording = $_POST['wording'];	
$add_wording = str_replace(array('::', '**', '||'), '', trim($add_wording));
} 


//-----------Active
if (isset($_POST['obj_active'])==true) {$obj_active = 'yes';} else {$obj_active = '';}


//-----------Always free
if (isset($_POST['always_free'])==true) {$add_always_free = '1';} else {$add_always_free = '0';}


//-----------Check input data
$id_line = $_POST['id_line'];
$add_name = $_POST['title'];
$add_description = $_POST['description'];
$add_category = $_POST['category'];
//==
$add_active = $obj_active;
$who_add = $_POST['who'];
$change_time = $_POST['change'];
$change_who = $add_who;


$line_data_r = $id_line.'::'.$add_name.'::'.$add_description.'::'.$add_category.'::'.$add_provide.'::'.$add_currency.'::'.$add_select_staff.'::'.$add_hours_start.'::'.$add_minutes_start.'::'.$add_hours_end.'::'.$add_minutes_end.'::'.$add_total_spots.'::'.$add_min_spots.'::'.$add_max_spots.'::'.$add_count_spots.'::'.$add_prices.'::'.$add_allow_today.'::'.$add_daily_total_spots.'::'.$add_daily_min_spots.'::'.$add_daily_max_spots.'::'.$add_daily_count_spots.'::'.$add_daily_price.'::'.$add_daily_staff.'::'.$add_working_days.'::'.$add_custom_date.'::'.$add_active_two_monts.'::'.$add_fix_price.'::'.$add_discount.'::'.$add_only_row.'::'.$add_all_spots.'::'.$add_queue.'::'.$add_photos.'::'.$add_wording.'::'.$add_active.'::'.$who_add.'::'.$change_time.'::'.$change_who.'::'.$add_only_pay.'::'.$add_always_free;

//---------------/check


} //isset line 

//===========================================================================replace process

if (array_key_exists('line',$_POST)){

if (isset($ERROR) && is_array($ERROR)) { echo ''; } else {


	
$nl = $_POST['line'];
$nd = $nl+1;




if ($access_level == 'staff'){ //=============Staff
$ERROR['staff_mail_invalid']['text'] = $lang['error_access'];
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
echo '<div class="shadow_back"><div class="error modal_mess textleft">'.$lang['error_found_replace'].' (№ <b>'.$nd.'</b>)
<div class="conf_but"><a href="'.$script_name.'">'.$lang['yes'].' <i class="icon-right-open"></i></a></div>
</div></div>';
//echo $refresh_3;	
}
 
} //-- admin access
//unset($_POST); 
} //---- no errors

}//==============================================/replace
	
	
	
	
	
//====================================================DISPLAY	

$horus_arr = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','XX');

$minutes_arr = array('00','05','10','15','20','25','30','35','40','45','50','55');



echo '<div id="main">';
	
echo'<div id="data" class="table"><ul class="th">';

echo '<li class="tools"><i class="icon-sort"></i></li>';
echo '<li class="tools"><i class="icon-list-numbered"></i></li>';


echo '<li class="three"><i class="icon-ok-circled" style="margin:0 14px 0 0;"></i>'.$lang['title'].'</li>';
echo '<li class="three">'.$lang['category'].'</li>';
echo '<li class="three">'.$lang['provide'].'</li>';


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
//================================== LIST
$data_services = explode("::", $lines_data[$ls]);

if (isset($data_services[0])) { $id_obj = $data_services[0]; } else {$id_obj = '';}
if (isset($data_services[1])) { $name_obj = $data_services[1]; } else {$name_obj = '';}
if (isset($data_services[2])) { $description_obj = $data_services[2]; } else {$description_obj = '';}
if (isset($data_services[3])) { $category_obj = $data_services[3]; } else {$category_obj = '';}
if (isset($data_services[4])) { $provide_obj = $data_services[4]; } else {$provide_obj = '';}
if (isset($data_services[5])) { $currency_obj = $data_services[5]; } else {$currency_obj = '';}
//-- units time
if (isset($data_services[6])) { $staff_obj = $data_services[6]; } else {$staff_obj = '';}
if (isset($data_services[7])) { $hours_start_obj = $data_services[7]; } else {$hours_start_obj = '';}
if (isset($data_services[8])) { $minutes_start_obj = $data_services[8]; } else {$minutes_start_obj = '';}
if (isset($data_services[9])) { $hours_end_obj = $data_services[9]; } else {$hours_end_obj = '';}
if (isset($data_services[10])) { $minutes_end_obj = $data_services[10]; } else {$minutes_end_obj = '';}
if (isset($data_services[11])) { $total_spots_obj = $data_services[11]; } else {$total_spots_obj = '';}
if (isset($data_services[12])) { $min_spots_obj = $data_services[12]; } else {$min_spots_obj = '';}
if (isset($data_services[13])) { $max_spots_obj = $data_services[13]; } else {$max_spots_obj = '';}
if (isset($data_services[14])) { $count_spots_obj = $data_services[14]; } else {$count_spots_obj = '';}
if (isset($data_services[15])) { $prices_obj = $data_services[15]; } else {$prices_obj = '';}
//------------- daily
if (isset($data_services[16])) { $allow_today_obj = $data_services[16]; } else {$allow_today_obj = '';}
if (isset($data_services[17])) { $daily_total_spots_obj = $data_services[17]; } else {$daily_total_spots_obj = '';}
if (isset($data_services[18])) { $daily_min_spots_obj = $data_services[18]; } else {$daily_min_spots_obj = '';}
if (isset($data_services[19])) { $daily_max_spots_obj = $data_services[19]; } else {$daily_max_spots_obj = '';}
if (isset($data_services[20])) { $daily_count_spots_obj = $data_services[20]; } else {$daily_count_spots_obj = '';}
if (isset($data_services[21])) { $daily_price_obj = $data_services[21]; } else {$daily_price_obj = '';}
if (isset($data_services[22])) { $daily_staff_obj = $data_services[22]; } else {$daily_staff_obj = '';}
//-------------
if (isset($data_services[23])) { $working_days_obj = $data_services[23]; } else {$working_days_obj = '';}
if (isset($data_services[24])) { $custom_date_obj = $data_services[24]; } else {$custom_date_obj = '';}
if (isset($data_services[25])) { $active_two_monts_obj = $data_services[25]; } else {$active_two_monts_obj = '';}
if (isset($data_services[26])) { $fix_price_obj = $data_services[26]; } else {$fix_price_obj = '';}
if (isset($data_services[27])) { $discount_obj = $data_services[27]; } else {$discount_obj = '';}
if (isset($data_services[28])) { $only_row_obj = $data_services[28]; } else {$only_row_obj = '';}
if (isset($data_services[29])) { $all_spots_obj = $data_services[29]; } else {$all_spots_obj = '';}
if (isset($data_services[30])) { $queue_obj = $data_services[30]; } else {$queue_obj = '';}
if (isset($data_services[31])) { $photos_obj = $data_services[31]; } else {$photos_obj = '';}
if (isset($data_services[32])) { $wording_obj = $data_services[32]; } else {$wording_obj = '';}
if (isset($data_services[33])) { $active_obj = $data_services[33]; } else {$active_obj = '';}
//------------- add info
if (isset($data_services[34])) { $add_who_obj = $data_services[34]; } else {$add_who_obj = '';}
if (isset($data_services[35])) { $time_change_obj = $data_services[35];} else {$time_change_obj = '';}
if (isset($data_services[36])) { $who_change_obj = $data_services[36];} else {$who_change_obj = '';}
//-------------- new
if (isset($data_services[37])) { $only_pay_obj = $data_services[37]; } else {$only_pay_obj = '';}	
if (isset($data_services[38])) { $always_free_obj = $data_services[38]; } else {$always_free_obj = '';}	

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
<span><a href="'.$script_name.'?moves='.$ls.'&where=1" title="'.$lang['moove'].' '.$lang['up'].'"><i class="icon-up-circled"></i>'.$lang['up'].'</a>
</span>';} 
if ($ls != sizeof($lines_data)-1) { echo '
<span><a href="'.$script_name.'?moves='.$ls.'&where=0" title="'.$lang['moove'].' '.$lang['down'].'"><i class="icon-down-circled"></i>'.$lang['down'].'</a>
</span>';}
echo '</div></li>';
}

echo '<li class="tools">'.$number_line.'</li>';

echo '<li class="three">';

echo'<div class="hidden_info" tabindex="1">';
if ($active_obj == 'yes') {
echo '<i class="icon-ok-circled yes"></i><div><span>'.$lang['active_yes'].'</span></div>';	
} else {
echo '<i class="icon-block no"></i><div><span>'.$lang['active_no'].'</span></div>';	
}
echo '</div>';

echo '<span class="str_left">'.$name_obj.'</span>';
echo'<div class="clear"></div></li>';

//=========================category
echo '<li class="three">';

if (empty($category_obj)) {echo $lang['no_category'];} else {
$found_cat = '0';
if (file_exists($file_name_category)) {	
$file_category = fopen($file_name_category, "rb"); 
if (filesize($file_name_category) != 0) { // !0
flock($file_category, LOCK_SH); 
$lines_category_display = preg_split("~\r*?\n+\r*?~", fread($file_category,filesize($file_name_category)));
flock($file_category, LOCK_UN); 
fclose($file_category); 
for ($lcd = 0; $lcd < sizeof($lines_category_display); ++$lcd) { 
if (!empty($lines_category_display[$lcd])) {
$data_categories_disp = explode('::', $lines_category_display[$lcd]); 
$id_cat_disp = $data_categories_disp[0];
$name_cat_disp =  $data_categories_disp[1];
if ($category_obj == $id_cat_disp) {echo $name_cat_disp; $found_cat = '1';} // display cat
} //no empty lines cat
} //count cat
} //else { echo '<span class="red_text">'.$lang['category_empty'].' </span>';} //filesize cat
} //file_exists cat
if ($found_cat == '0') { echo '<span class="orange_text">'.$lang['category_not_found'].'</span>';}
} // category no empty
echo'</li>';


echo '<li class="three">';
if ($provide_obj == 'hourly') {
echo '<span title="'.$lang['hourly'].'"><i class="icon-clock-3"></i> '.$lang['hourly'].'</span>';
} else {
echo '<span title="'.$lang['daily'].'"><i class="icon-calendar"></i> '.$lang['daily'].'</span>';}
echo '</li>';



echo '<li class="tools"><a href="'.$script_name.'?edit='.$ls.'&amp;id='.$id_obj.'" title="'.$lang['edit'].' ('.$name_obj.')" class="edit"><i class="icon-edit-alt"></i></a></li>';

echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'&amp;id='.$id_obj.'" title="'.$lang['delete'].' ('.$name_obj.')" class="delete" onclick ="return confirm(\''.$lang['service'].': &quot;'.$name_obj.'&quot; '.$lang['delete_m'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';


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


echo '<div id="bt2" class="ftools">';

echo '<div class="tools_tp"><a href="#navtop" class="scrollto" title="'.$lang['go_top'].'"><i class="icon-up-open"></i></a></div>';

echo '<div class="tools_fp"><a href="#currency" class="scrollto" title="'.$lang['select_currency'].'"><i class="icon-money"></i></a></div>';

echo '<div class="tools_tp"><a href="#units" id="navunits" class="scrollto"><i class="icon-clock-3"></i></a></div>';

echo '<div class="tools_tp"><a href="#always_free" class="scrollto" title="'.$lang['always_free'].'"><i class="icon-lock-open"></i></a></div>';

echo '<div class="tools_tp"><a href="#only_pay" class="scrollto" title="'.$lang['select_only_pay'].'"><i class="icon-hammer"></i></a></div>';

echo '<div class="tools_tp"><a href="#only_row" class="scrollto" title="'.$lang['select_only_row'].'"><i class="icon-layout"></i></a></div>';

echo '<div class="tools_tp"><a href="#all_time_spots" class="scrollto" title="'.$lang['total_spots_all_time'].'"><i class="icon-users-1"></i></a></div>';

echo '<div class="tools_tp" id="queueb"><a href="#queue" class="scrollto" title="'.$lang['queue'].'"><i class="icon-to-end"></i></a></div>';

echo '<div class="tools_wd"><a href="#navworkdays" class="scrollto" title="'.$lang['working_days'].'"><i class="icon-tools"></i></a></div>';

echo '<div class="tools_dp"><a href="#navdwd" class="scrollto" title="'.$lang['settings_month_days_cp'].'"><i class="icon-calendar-1"></i></a></div>';

echo '<div class="tools_dp"><a href="#active_two_monts" class="scrollto" title="'.$lang['active_two_monts'].'"><i class="icon-exchange"></i></a></div>';

echo '<div class="tools_fp"><a href="#navfixprice" class="scrollto" title="'.$lang['fix_price'].'"><i class="icon-pin"></i></a></div>';

echo '<div class="tools_fp"><a href="#promo_code" class="scrollto" title="'.$lang['discount'].'"><i class="icon-calc"></i></a></div>';

echo '<div class="tools_ph"><a href="#navphotos" class="scrollto" title="'.$lang['photos'].'"><i class="icon-camera-3"></i></a></div>';

echo '<div class="tools_tp"><a href="#navbottom" class="scrollto" title="'.$lang['go_bottom'].'"><i class="icon-down-open"></i></a></div>';

echo '</div>';

}
echo '
<script>
window.onbeforeunload = marg_bt(); 
function marg_bt() {	
var bt1 = document.getElementById(\'bt1\');
var bt2 = document.getElementById(\'bt2\');

setTimeout("bt1.className +=\' fadein_tool_bt\'", 200);
setTimeout("bt2.className +=\' fadein_tool_bt\'", 600);
}
</script>';

echo'<div class="edit_window" id="win_edit">
<div class="edit_window_block" id="navtop">';


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
$re_url = $script_name.'?edit='.$_GET['edit'].'&id='.$_GET['id'].'&insearch='.$_GET['insearch'];
} else {
$re_url = $script_name.'?edit='.$_GET['edit'].'&id='.$_GET['id'];
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
echo '<form name="edit'.$ls.'" method="post" action="'.$script_name.'?edit='.$_GET['edit'].'&id='.$_GET['id'].'&insearch='.$_GET['insearch'].'#line'.$anc_sb.'" id="edit_'.$ls.'">';	
} else {
echo '<form name="edit'.$ls.'" method="post" action="'.$script_name.'?edit='.$_GET['edit'].'&id='.$_GET['id'].'#line'.$anc_sb.'" id="edit_'.$ls.'">';
}

echo '<div id="inp_sb"></div>';

//----------TITLE
echo '<div class="input_info">
<div class="input_name">'.$lang['title'].':</div>
<div class="input"><input type="text" name="title" value="'; if(isset($_POST['title'])){echo $_POST['title'];}else{echo $name_obj;} echo'" /></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/title



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




//----------SELECT CATEGORY
echo '<div class="input_info">
<div class="input_name">'.$lang['category'].':</div>
<div class="input">';
echo '<select name="category">';

echo '<option value=""'; if ($category_obj == '') {echo'selected';}  echo'>'.$lang['no_category'].'</option>';

//===========================================READ CATEGORY BD
if (file_exists($file_name_category)) {	
$file_category = fopen($file_name_category, "rb"); 
if (filesize($file_name_category) != 0) { // !0
flock($file_category, LOCK_SH); 
$lines_category = preg_split("~\r*?\n+\r*?~", fread($file_category,filesize($file_name_category)));
flock($file_category, LOCK_UN); 
fclose($file_category); 
for ($lc = 0; $lc < sizeof($lines_category); ++$lc) { 
if (!empty($lines_category[$lc])) {
$data_categories = explode('::', $lines_category[$lc]); 
$id_cat = $data_categories[0];
$name_cat =  $data_categories[1];
echo '<option value="'.$id_cat.'"'; if ($category_obj == $id_cat) {echo'selected';} echo'>'.$name_cat.'</option>';
} //no empty lines cat
} //count cat
} //filesize cat
} //file_exists cat
echo '</select>';
echo '</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/select category



//----------SELECT PROVIDE - DAY / HOURS
echo '<div class="input_info">
<div class="input_name" id="title_provide">'.$lang['provide'].':</div>
<div class="input">';

echo'<label><input type="radio" name="provide" value="hourly" id="hourly"'; if($provide_obj == 'hourly') {echo'checked="checked"';} echo' onclick="switch_provide()" /><span><i class="icon-clock-3"></i>'.$lang['hourly'].'</span></label>';

echo'<label><input type="radio" name="provide" value="daily" id="daily"'; if($provide_obj == 'daily') {echo'checked="checked"';} echo' onclick="switch_provide()" /><span><i class="icon-calendar"></i>'.$lang['daily'].'</span></label>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/day / hours



//----------CURRENCY
$select_currency_opt = '';
if (!empty($currency_name)) {
$cur_arr = explode('::', $currency_name);
} else { $cur_arr = array('RUB','EUR','USD'); }

$select_currency_opt = '';
foreach ($cur_arr as $keyc=>$valuec){ 
if ($valuec != '') {
$select_currency_opt .= '<option value="'.$valuec.'"'; if($currency_obj == $valuec) {$select_currency_opt  .=' selected="selected"';} $select_currency_opt  .='>'.$valuec.'</option>';}
}

echo '<div class="input_info" id="currency">
<div class="input_name"><a href="settings.php#tab3" target="_blank" title="'.$lang['add_currency'].'">'.$lang['select_currency'].'</a>:</div>
<div class="input">';

echo  '<select name="currency" onchange="safe_and_back()">';
echo $select_currency_opt;
echo  '</select>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/currency





//----------------------------------------------------------------------UNITS TIME
echo '<div class="input_info" id="units">
<div class="input_name">'.$lang['operation_mode'].':<br /><small>'.$lang['hourly'].'</small>
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_units_time'].'</div></div>
</div>
<div class="input">';

//--list staff
$staff_list = explode('&&', $staff_obj);

$last_id = count($staff_list) -1;

$option_staff = '';

if (file_exists($file_name_staff)) {	
$file_select_staff = fopen($file_name_staff, "rb"); 
if (filesize($file_name_staff) != 0) { // !0
flock($file_select_staff, LOCK_SH); 
$lines_staff_display = preg_split("~\r*?\n+\r*?~", fread($file_select_staff,filesize($file_name_staff)));
flock($file_select_staff, LOCK_UN); 
fclose($file_select_staff); 
$count_staff = sizeof($lines_staff_display);
for ($lss = 0; $lss < sizeof($lines_staff_display); ++$lss) { 
if (!empty($lines_staff_display[$lss])) {
$data_staff_disp = explode('::', $lines_staff_display[$lss]); 
$id_staff_disp = $data_staff_disp[0];
$name_staff_disp =  $data_staff_disp[5];
$option_staff .= '<option value="'.$id_staff_disp.'"'; if($id_staff_disp == $add_who) {$option_staff .= ' selected="selected" ';} $option_staff .= '>'.$name_staff_disp.'</option>';

} //no empty lines staff
} //count staff
} //filesize staff
} //file_exists staff



//================================================ ADD TIME



$select_hours_opt = '';
foreach ($horus_arr as $key=>$value){ 
$select_hours_opt .= '<option value="'.$value.'">'.$value.'</option>';
}

$select_minutes_opt = '';
foreach ($minutes_arr as $key=>$value){ 
$select_minutes_opt .= '<option value="'.$value.'">'.$value.'</option>';
}



//========================= Last ID Unit
if(!empty($hours_start_obj)) {
$last_id_unit_arr = explode('||',$hours_start_obj);
array_pop ($last_id_unit_arr);
$last_id_unit = sizeof($last_id_unit_arr) -1;
} else { $last_id_unit = '0';}


echo '<script>
var dt = document;
var last_id_time = 0;
//var last_id_time = '.$last_id_unit.';

var index_id_time = last_id_time;

function add_value_t() {
	
var tbody_cl = document.getElementById(\'t_table\').getElementsByTagName(\'tbody\')[0];	
var last_id_time = tbody_cl.rows.length / 13 - 1;
var index_id_time = last_id_time;

	// table
    var tbody_time = dt.getElementById(\'t_table\').getElementsByTagName(\'tbody\')[0];
	
	// create tr
	index_id_time = index_id_time + 1;
	
	var row_time0 = dt.createElement("tr");
    row_time0.id = \'inp_time0_\'+index_id_time;
tbody_time.appendChild(row_time0); // tr 0
setTimeout(function() { dt.getElementById(\'inp_time0_\'+index_id_time).className = "current_unit" }, 0)

var row_time1 = dt.createElement("tr");
    row_time1.id = \'inp_time1_\'+index_id_time;
tbody_time.appendChild(row_time1); // tr 1
setTimeout(function() { dt.getElementById(\'inp_time1_\'+index_id_time).className = "current_unit" }, 0)
	
	var row_time2 = dt.createElement("tr");
    row_time2.id = \'inp_time2_\'+index_id_time;
tbody_time.appendChild(row_time2); // tr 2
setTimeout(function() { dt.getElementById(\'inp_time2_\'+index_id_time).className = "display" }, 20)

    var row_time3 = dt.createElement("tr");
    row_time3.id = \'inp_time3_\'+index_id_time;
tbody_time.appendChild(row_time3); // tr 3
setTimeout(function() { dt.getElementById(\'inp_time3_\'+index_id_time).className = "display" }, 40)

	var row_time4 = dt.createElement("tr");
    row_time4.id = \'inp_time4_\'+index_id_time;
tbody_time.appendChild(row_time4); // tr 4
setTimeout(function() { dt.getElementById(\'inp_time4_\'+index_id_time).className = "display" }, 60)	
	
    var row_time5 = dt.createElement("tr");
	row_time5.id = \'inp_time5_\'+index_id_time;
tbody_time.appendChild(row_time5); // tr 5	
setTimeout(function() { dt.getElementById(\'inp_time5_\'+index_id_time).className = "display" }, 80)

    var row_time6 = dt.createElement("tr");
	row_time6.id = \'inp_time6_\'+index_id_time;
tbody_time.appendChild(row_time6); // tr 6
setTimeout(function() { dt.getElementById(\'inp_time6_\'+index_id_time).className = "display" }, 100)

	var row_time7 = dt.createElement("tr");
	row_time7.id = \'inp_time7_\'+index_id_time;
tbody_time.appendChild(row_time7); // tr 7	
setTimeout(function() { dt.getElementById(\'inp_time7_\'+index_id_time).className = "display" }, 120)	
	
	var row_time8 = dt.createElement("tr");
	row_time8.id = \'inp_time8_\'+index_id_time;
tbody_time.appendChild(row_time8); // tr 8	
setTimeout(function() { dt.getElementById(\'inp_time8_\'+index_id_time).className = "display" }, 140)

    var row_time9 = dt.createElement("tr");
	row_time9.id = \'inp_time9_\'+index_id_time;
tbody_time.appendChild(row_time9); // tr 9	
setTimeout(function() { dt.getElementById(\'inp_time9_\'+index_id_time).className = "display" }, 180)

    var row_time10 = dt.createElement("tr");
	row_time10.id = \'inp_time10_\'+index_id_time;
tbody_time.appendChild(row_time10); // tr 10	
setTimeout(function() { dt.getElementById(\'inp_time10_\'+index_id_time).className = "display" }, 200)

    var row_time11 = dt.createElement("tr");
	row_time11.id = \'inp_time11_\'+index_id_time;
tbody_time.appendChild(row_time11); // tr 11	
setTimeout(function() { dt.getElementById(\'inp_time11_\'+index_id_time).className = "display" }, 220)

    var row_time12 = dt.createElement("tr");
    row_time12.id = \'inp_time12_\'+index_id_time;
tbody_time.appendChild(row_time12); // tr 12
setTimeout(function() { dt.getElementById(\'inp_time12_\'+index_id_time).className = "display" }, 240)


	
	// create th in tr0 ===========================
    var th1_time0 = dt.createElement("th"); th1_time0.setAttribute("colspan","4"); th1_time0.setAttribute("class","th_main_title");
	
	row_time0.appendChild(th1_time0);
	
	
	// create th in tr1 ===========================
    var th1_time1 = dt.createElement("th"); th1_time1.setAttribute("colspan","2"); th1_time1.setAttribute("class","th_title");
	var th2_time1 = dt.createElement("th"); th2_time1.setAttribute("colspan","2"); th2_time1.setAttribute("class","th_title");
	row_time1.appendChild(th1_time1);
	row_time1.appendChild(th2_time1);
	
	// create th in tr2 ===========================
    var th1_time2 = dt.createElement("th"); 
	var th2_time2 = dt.createElement("th"); 
	var th3_time2 = dt.createElement("th"); 
	var th4_time2 = dt.createElement("th"); 
	
	row_time2.appendChild(th1_time2);
	row_time2.appendChild(th2_time2);
	row_time2.appendChild(th3_time2);
	row_time2.appendChild(th4_time2);
	
    // create td in tr3 ===========================
    var td1_time3 = dt.createElement("td"); td1_time3.setAttribute("class","input_td");
    var td2_time3 = dt.createElement("td"); td2_time3.setAttribute("class","input_td");
	var td3_time3 = dt.createElement("td"); td3_time3.setAttribute("class","input_td");
	var td4_time3 = dt.createElement("td"); td4_time3.setAttribute("class","input_td");
		
    row_time3.appendChild(td1_time3);
    row_time3.appendChild(td2_time3);
	row_time3.appendChild(td3_time3);
	row_time3.appendChild(td4_time3);
	
	
	// create th in tr4 ===========================
    var th1_time4 = dt.createElement("th"); th1_time4.setAttribute("colspan","4"); th1_time4.setAttribute("class","th_title");
	
	row_time4.appendChild(th1_time4);
	
	
	// create th in tr5 ===========================
    var th1_time5 = dt.createElement("th"); 
	var th2_time5 = dt.createElement("th"); 
	var th3_time5 = dt.createElement("th"); 
	var th4_time5 = dt.createElement("th"); 
	
	row_time5.appendChild(th1_time5);
	row_time5.appendChild(th2_time5);
	row_time5.appendChild(th3_time5);
	row_time5.appendChild(th4_time5);
	
	
	// create td in tr6 ===========================
    var td1_time6 = dt.createElement("td"); td1_time6.setAttribute("class","input_td");
    var td2_time6 = dt.createElement("td"); td2_time6.setAttribute("class","input_td");
	var td3_time6 = dt.createElement("td"); td3_time6.setAttribute("class","input_td");
	var td4_time6 = dt.createElement("td"); td4_time6.setAttribute("class","input_td");
		
    row_time6.appendChild(td1_time6);
    row_time6.appendChild(td2_time6);
	row_time6.appendChild(td3_time6);
	row_time6.appendChild(td4_time6);
	
	
	// create th in tr7 ===========================
    var th1_time7 = dt.createElement("th"); th1_time7.setAttribute("colspan","4"); th1_time7.setAttribute("class","th_title");
	
	row_time7.appendChild(th1_time7);
	
	
	// create th in tr8 ===========================
    var th1_time8 = dt.createElement("th"); th1_time8.setAttribute("colspan","2");
	var th2_time8 = dt.createElement("th"); th2_time8.setAttribute("colspan","2");
	
	row_time8.appendChild(th1_time8);
    row_time8.appendChild(th2_time8);
	
	
	// create td in tr9 ===========================
    var td1_time9 = dt.createElement("td"); td1_time9.setAttribute("colspan","2"); td1_time9.setAttribute("class","input_half_td");
    var td2_time9 = dt.createElement("td"); td2_time9.setAttribute("colspan","2"); //td2_time9.setAttribute("class","input_half_td");
	
    row_time9.appendChild(td1_time9);
    row_time9.appendChild(td2_time9);
	
	
	
	 // create th in tr10 ==========================
	var th1_time10 = dt.createElement("th"); th1_time10.setAttribute("colspan","4"); th1_time10.setAttribute("class","th_title");
	
	row_time10.appendChild(th1_time10);
	
	
	 // create td in tr11 ==========================
	var td1_time11 = dt.createElement("td"); td1_time11.setAttribute("colspan","4"); td1_time11.setAttribute("class","staff_td");
	
	row_time11.appendChild(td1_time11);
   
	
	 // create td in tr12 ==========================
	var td1_time12 = dt.createElement("td"); td1_time12.setAttribute("colspan","4"); td1_time12.setAttribute("class","sep");
	
	row_time12.appendChild(td1_time12);
 
//================================================= 
	
	last_id_time = last_id_time + 1;

	// add content in tr0 =======================
    th1_time0.innerHTML = \'<span class="unit_time_title"><i class="icon-clock-3"></i>'.$lang['unit_time'].'</span><div id="del_unit_\'+last_id_time+\'" class="button_area"><span class="minus_item" tabindex="1" onclick="delete_value_t(\'+last_id_time+\')"><i class="icon-minus-circled"></i></span></div>\';
		
	// add content in tr1 =======================	
	th1_time1.innerHTML = \''.$lang['time_start'].'\';
	th2_time1.innerHTML = \''.$lang['time_end'].'\';
				
	// add content in tr2 =======================	
    th1_time2.innerHTML = \''.$lang['hours'].'\';
	th2_time2.innerHTML = \''.$lang['minutes'].'\';
	th3_time2.innerHTML = \''.$lang['hours'].'\';
	th4_time2.innerHTML = \''.$lang['minutes'].'\';
		
	// add content in tr3 =======================
    td1_time3.innerHTML = \'<select name="hours_start[\'+last_id_time+\']" class="select_time">'.$select_hours_opt.'</select>\';	
    td2_time3.innerHTML = \'<select name="minutes_start[\'+last_id_time+\']" class="select_time">'.$select_minutes_opt.'</select>\';	
    td3_time3.innerHTML = \'<select name="hours_end[\'+last_id_time+\']" class="select_time">'.$select_hours_opt.'</select>\';	
	td4_time3.innerHTML = \'<select name="minutes_end[\'+last_id_time+\']" class="select_time">'.$select_minutes_opt.'</select>\';
		
	// add content in tr4 =======================	
    th1_time4.innerHTML = \''.$lang['spots'].'\';
		
	// add content in tr5 =======================	
    th1_time5.innerHTML = \''.$lang['total_spots'].'\';
	th2_time5.innerHTML = \''.$lang['min_spots'].'\';
	th3_time5.innerHTML = \''.$lang['max_spots'].'\';
	th4_time5.innerHTML = \''.$lang['count_spots_order'].'\';
		
	// add content in tr6 =======================
    td1_time6.innerHTML = \'<input type="number" name="total_spots[\'+last_id_time+\']" value="0" min="0" />\';	
    td2_time6.innerHTML = \'<input type="number" name="min_spots[\'+last_id_time+\']" value="1" min="1" />\';	
    td3_time6.innerHTML = \'<input type="number" name="max_spots[\'+last_id_time+\']" value="0" min="0" />\';	
	td4_time6.innerHTML = \'<select name="count_spots[\'+last_id_time+\']" class="select_time"><option value="1">'.$lang['yes'].'</option><option value="0">'.$lang['no'].'</option></select>\';
		
	// add content in tr7 =======================	
    th1_time7.innerHTML = \''.$lang['pay'].'\';
		
	// add content in tr8 =======================	
    th1_time8.innerHTML = \''.$lang['price'].'\';
	th2_time8.innerHTML = \''.$lang['currency'].'\';
	
	// add content in tr9 =======================
    td1_time9.innerHTML = \'<input type="text" name="price[\'+last_id_time+\']" class="inp_bold" value="0" />\';	
    td2_time9.innerHTML = \''.$currency_obj.' <a href="#currency" class="scrollto" title="'.$lang['select_currency'].'"><i class="icon-money"></i></a>\';	
	
	// add content in tr10 =======================	
    th1_time10.innerHTML = \''.$lang['select_staff'].'\';
	
	// add content in tr11 =======================
	var last_id_first = 0;
		
    td1_time11.innerHTML = \'<table id="v_table\'+last_id_time+\'"><tbody><tr id="inp\'+last_id_time+\'_\'+last_id_first+\'"><td><select name="staff[\'+last_id_time+\'][\'+last_id_first+\']">'.$option_staff.'</select><div class="button_area"><span class="minus_item disabled_minus" tabindex="1"><i class="icon-minus-circled"></i></span></div></td></tr></tbody></table><table class="add_button_s"><tbody><tr><td><span class="add_staff" id="add_button_staff\'+last_id_time+\'" tabindex="1" title="'.$lang['add_staff'].'" onclick="add_value_p(\'+last_id_time+\')"><i class="icon-plus-circled"></i></span></td></tr></tbody></table>\';	
	
var id_remove_del = last_id_time - 1;
    document.getElementById(\'del_unit_\'+id_remove_del).style.display = \'none\';	
}


//remove tr
function delete_value_t(inpid_t) {
	
var idTr_time0 = "inp_time0_"+inpid_t;	
var idTr_time1 = "inp_time1_"+inpid_t;
var idTr_time2 = "inp_time2_"+inpid_t;
var idTr_time3 = "inp_time3_"+inpid_t;
var idTr_time4 = "inp_time4_"+inpid_t;
var idTr_time5 = "inp_time5_"+inpid_t;
var idTr_time6 = "inp_time6_"+inpid_t;
var idTr_time7 = "inp_time7_"+inpid_t;
var idTr_time8 = "inp_time8_"+inpid_t;
var idTr_time9 = "inp_time9_"+inpid_t;
var idTr_time10 = "inp_time10_"+inpid_t;
var idTr_time11 = "inp_time11_"+inpid_t;
var idTr_time12 = "inp_time12_"+inpid_t;

var elem_t0 = document.getElementById(idTr_time0);
var elem_t1 = document.getElementById(idTr_time1);
var elem_t2 = document.getElementById(idTr_time2);
var elem_t3 = document.getElementById(idTr_time3);
var elem_t4 = document.getElementById(idTr_time4);
var elem_t5 = document.getElementById(idTr_time5);
var elem_t6 = document.getElementById(idTr_time6);
var elem_t7 = document.getElementById(idTr_time7);
var elem_t8 = document.getElementById(idTr_time8);
var elem_t9 = document.getElementById(idTr_time9);
var elem_t10 = document.getElementById(idTr_time10);
var elem_t11 = document.getElementById(idTr_time11);
var elem_t12 = document.getElementById(idTr_time12);

setTimeout(function() { elem_t0.parentNode.removeChild(elem_t0) }, 240)
setTimeout(function() { elem_t1.parentNode.removeChild(elem_t1) }, 220)
setTimeout(function() { elem_t2.parentNode.removeChild(elem_t2) }, 200)
setTimeout(function() { elem_t3.parentNode.removeChild(elem_t3) }, 180)
setTimeout(function() { elem_t4.parentNode.removeChild(elem_t4) }, 160)
setTimeout(function() { elem_t5.parentNode.removeChild(elem_t5) }, 140)
setTimeout(function() { elem_t6.parentNode.removeChild(elem_t6) }, 120)
setTimeout(function() { elem_t7.parentNode.removeChild(elem_t7) }, 100)
setTimeout(function() { elem_t8.parentNode.removeChild(elem_t8) }, 80)
setTimeout(function() { elem_t9.parentNode.removeChild(elem_t9) }, 60)
setTimeout(function() { elem_t10.parentNode.removeChild(elem_t10) }, 40)
setTimeout(function() { elem_t11.parentNode.removeChild(elem_t11) }, 20)
setTimeout(function() { elem_t12.parentNode.removeChild(elem_t12) }, 0)

var count_unitsl = inpid_t - 1;
if (count_unitsl == 0) 
{document.getElementById(\'del_unit_\'+count_unitsl).style.display = \'none\';} 
else {document.getElementById(\'del_unit_\'+count_unitsl).style.display = \'block\';}
}

</script>';



//================================================ ADD STAFF

echo '<script>
var d = document;



function add_value_p(tIndex) {
	var last_id = 0;
	// table
    var tbody = d.getElementById(\'v_table\'+tIndex).getElementsByTagName(\'tbody\')[0];
	
	
	if (tbody.rows.length > 1) {last_id = tbody.rows.length - 1;} 
		//alert(tIndex);
		
	var index_id = last_id;
	
	// create tr
    var row = d.createElement("tr");
	index_id = index_id + 1;
    row.id = \'inp\'+tIndex+\'_\'+index_id;
    row.setAttribute("class","display");
	
	tbody.appendChild(row);
	

    // create td in tr
    var td1 = d.createElement("td");
    
	
    row.appendChild(td1);
   
	
	last_id = last_id + 1;

	// add input in td
	
    td1.innerHTML = \'<select name="staff[\'+tIndex+\'][\'+last_id+\']">'.$option_staff.'</select><div id="remove_st_\'+tIndex+\'_\'+last_id+\'" class="button_area"><span class="minus_item" tabindex="1" onclick="delete_value_p(\'+last_id+\',\'+tIndex+\')"><i class="icon-minus-circled"></i></span></div>\';
		
    

//remove add button
var allCount = '.$count_staff.';
var addButton = document.getElementById("add_button_staff"+tIndex);
var addCount = tbody.rows.length;

if (allCount <= addCount) {
addButton.style.display = \'none\';
document.getElementById("addts").style.display = \'none\';
} 

return delete_last_button(tIndex, last_id);
}

//remove tr
function delete_value_p(inpid, tsIndex) {
var tsIndex;
var idTr = "inp"+tsIndex+"_"+inpid;
var elem = document.getElementById(idTr);
elem.parentNode.removeChild(elem);

//button
document.getElementById("add_button_staff"+tsIndex).style.display = \'block\';
document.getElementById("addts").style.display = \'block\';

setTimeout(function() { re_last_button(tsIndex, inpid); }, 30)

//call check empty staff
fname = \'check_empty_staff_\'+tsIndex;
return (window[fname])(); 
return false;

}

function delete_last_button(tsIndex, inpid) {
if (inpid != 0 || inpid != 1) {
last_ind = inpid - 1;
var minusButton = document.getElementById(\'remove_st_\'+tsIndex+\'_\'+last_ind);
//minusButton.style.display = \'none\';

minusButton.innerHTML = \'<span class="minus_item disabled_minus" tabindex="1"><i class="icon-minus-circled"></i></span>\';
}
}

function re_last_button(tdIndex, inpidd) {
if (inpidd != 0 || inpidd != 1) {
last_indr = inpidd - 1;
var minusButtonr = document.getElementById(\'remove_st_\'+tdIndex+\'_\'+last_indr);
//minusButtonr.style.display = \'block\';

minusButtonr.innerHTML = \'<span class="minus_item" tabindex="1" onclick="delete_value_p(\'+last_indr+\',\'+tdIndex+\')"><i class="icon-minus-circled"></i></span>\';

}
}

</script>';



//=================================/


if (empty($hours_start_obj)) {
	

echo '<table id="t_table" class="units_table"><tbody>';

echo '
<tr class="current_unit"><th colspan="4" class="th_main_title"><span class="unit_time_title"><i class="icon-clock-3"></i>'.$lang['unit_time'].'</span></th></tr>';

echo'<tr class="current_unit"><th colspan="2" class="th_title">'.$lang['time_start'].'</th><th colspan="2" class="th_title">'.$lang['time_end'].'</th></tr>';

echo'<tr class="current_unit"><th>'.$lang['hours'].'</th><th>'.$lang['minutes'].'</th><th>'.$lang['hours'].'</th><th>'.$lang['minutes'].'</th></tr>';	
	
echo '
<tr class="current_unit">
<td class="input_td"><select name="hours_start[0]" class="select_time">'.$select_hours_opt.'</select></td>
<td class="input_td"><select name="minutes_start[0]" class="select_time">'.$select_minutes_opt.'</select></td>
<td class="input_td"><select name="hours_end[0]" class="select_time">'.$select_hours_opt.'</select></td>
<td class="input_td"><select name="minutes_end[0]" class="select_time">'.$select_minutes_opt.'</select></td>
</tr>
'; 
	
echo '<tr class="current_unit"><th colspan="4" class="th_title">'.$lang['spots'].'</th></tr>';	
echo '<tr class="current_unit"><th>'.$lang['total_spots'].'</th><th>'.$lang['min_spots'].'</th><th>'.$lang['max_spots'].'</th><th>'.$lang['count_spots_order'].'</th></tr>';	

echo '
<tr class="current_unit">
<td class="input_td"><input type="number" name="total_spots[0]" value="0" min="0" /></td>
<td class="input_td"><input type="number" name="min_spots[0]" value="1" min="1" /></td>
<td class="input_td"><input type="number" name="max_spots[0]" value="0" min="0" /></td>
<td class="input_td"><select name="count_spots[0]" class="select_time"><option value="1">'.$lang['yes'].'</option><option value="0">'.$lang['no'].'</option></td>
</tr>
';

echo '<tr class="current_unit"><th colspan="4" class="th_title">'.$lang['pay'].'</th></tr>';
echo'<tr class="current_unit"><th colspan="2">'.$lang['price'].'</th><th colspan="2">'.$lang['currency'].'</th></tr>';

echo '
<tr class="current_unit">
<td colspan="2" class="input_half_td"><input type="text" name="price[0]" class="inp_bold" value="0" /></td>
<td colspan="2">'.$currency_obj.' <a href="#currency" class="scrollto" title="'.$lang['select_currency'].'"><i class="icon-money"></i></a></td>
</tr>';


echo '<tr class="current_unit"><th colspan="4" class="th_title">'.$lang['select_staff'].'</th></tr>';

	
//---------------------------------- staff tr
echo '<tr class="current_unit"><td colspan="4" class="staff_td">

<table id="v_table0"><tbody><tr class="current_unit"><td>
<select name="staff[0][0]">
'.$option_staff.'
</select><div class="button_area"><span class="minus_item disabled_minus" tabindex="1"><i class="icon-minus-circled"></i></span></div>
</td></tr></tbody></table>

<table class="add_button_s"><tbody><tr class="current_unit"><td><span id="addts" class="text">'.$lang['add_staff'].'  &#8594;</span>
<span class="add_staff" id="add_button_staff0" tabindex="1" title="'.$lang['add_staff'].'" onclick="add_value_p(0)"><i class="icon-plus-circled"></i></span>
</td></tr></tbody></table>

</td></tr>'; //-------------------- end Staff

echo '<tr class="current_unit"><td colspan="4" class="sep"></td></tr>';

echo '</tbody></table>';
echo '<span class="add_time" id="add_button_time" tabindex="1" title="'.$lang['add_staff'].'" onclick="add_value_t()"><i class="icon-plus-circled"></i>'.$lang['add_unit_time'].'</span>';








} else { //======================================== CURRENT UNITS TIME LIST ===========================================








echo '<table id="t_table" class="units_table"><tbody>';


//units arrays

$hours_start_arr = explode('||',$hours_start_obj); array_pop ($hours_start_arr);

$minutes_start_arr = explode('||',$minutes_start_obj); array_pop ($minutes_start_arr);

$hours_end_arr = explode('||',$hours_end_obj); array_pop ($hours_end_arr);

$minutes_end_arr = explode('||',$minutes_end_obj); array_pop ($minutes_end_arr);

$total_spots_arr = explode('||',$total_spots_obj); array_pop ($total_spots_arr);

$min_spots_arr = explode('||',$min_spots_obj); array_pop ($min_spots_arr);

$max_spots_arr = explode('||',$max_spots_obj); array_pop ($max_spots_arr);

$count_spots_arr = explode('||',$count_spots_obj); array_pop ($count_spots_arr);

$prices_arr = explode('||',$prices_obj); array_pop ($prices_arr);
//-----------





for ($its = 0; $its < sizeof($hours_start_arr); ++$its) { // ====================== count units time =========================

if (empty($hours_start_arr[$its])) {$hours_start_arr[$its] = '00';}
if (empty($minutes_start_arr[$its])) {$minutes_start_arr[$its] = '00';}
if (empty($hours_end_arr[$its])) {$hours_end_arr[$its] = '00';}
if (empty($minutes_end_arr[$its])) {$minutes_end_arr[$its] = '00';}

if (empty($total_spots_arr[$its])) {$total_spots_arr[$its] = '0';}
if (empty($min_spots_arr[$its])) {$min_spots_arr[$its] = '1';}
if (empty($max_spots_arr[$its])) {$max_spots_arr[$its] = '0';}
if (isset($count_spots_arr[$its])) {if (empty($count_spots_arr[$its]) && $count_spots_arr[$its] != '0') {$count_spots_arr[$its] = '1';}} else {$count_spots_arr[$its] = '0';}

if (empty($prices_arr[$its])) {$prices_arr[$its] = '0';}


echo '
<tr class="current_unit" id="inp_time0_'.$its.'"><th colspan="4" class="th_main_title"><span class="unit_time_title"><i class="icon-clock-3"></i>'.$hours_start_arr[$its].':'.$minutes_start_arr[$its];
if ($hours_end_arr[$its] != 'XX') {echo ' - '.$hours_end_arr[$its].':'.$minutes_end_arr[$its];}
echo '</span>';

echo '<div id="del_unit_'.$its.'" class="button_area"'; if($its == sizeof($hours_start_arr) - 1 && $its != 0) { echo' style="display:block;"';} else { echo' style="display:none;"';} echo'>';

if ($its == 0) {echo '';} else {echo '<span class="minus_item" onclick="delete_value_t('.$its.')">';}
echo '<i class="icon-minus-circled"></i></span></div></th></tr>';

echo'<tr class="current_unit" id="inp_time1_'.$its.'"><th colspan="2" class="th_title">'.$lang['time_start'].'</th><th colspan="2" class="th_title">'.$lang['time_end'].'</th></tr>';

echo '<tr class="current_unit" id="inp_time2_'.$its.'"><th>'.$lang['hours'].'</th><th>'.$lang['minutes'].'</th><th>'.$lang['hours'].'</th><th>'.$lang['minutes'].'</th></tr>';


$select_hours_start_opt = '';
foreach ($horus_arr as $key=>$value){ 
$select_hours_start_opt .= '<option value="'.$value.'"'; if($hours_start_arr[$its] == $value) {$select_hours_start_opt .=' selected="selected"';} $select_hours_start_opt .='>'.$value.'</option>';
}

$select_minutes_start_opt = '';
foreach ($minutes_arr as $key=>$value){ 
$select_minutes_start_opt .= '<option value="'.$value.'"'; if($minutes_start_arr[$its] == $value) {$select_minutes_start_opt .=' selected="selected"';} $select_minutes_start_opt .='>'.$value.'</option>';
}

$select_hours_end_opt = '';
foreach ($horus_arr as $key=>$value){ 
$select_hours_end_opt .= '<option value="'.$value.'"'; if($hours_end_arr[$its] == $value) {$select_hours_end_opt .=' selected="selected"';} $select_hours_end_opt .='>'.$value.'</option>';
}

$select_minutes_end_opt = '';
foreach ($minutes_arr as $key=>$value){ 
$select_minutes_end_opt .= '<option value="'.$value.'"'; if($minutes_end_arr[$its] == $value) {$select_minutes_end_opt .=' selected="selected"';} $select_minutes_end_opt .='>'.$value.'</option>';
}

$select_count_spots_opt = '<select name="count_spots['.$its.']" class="select_time">
<option value="1"'; if($count_spots_arr[$its] == '1') {$select_count_spots_opt .=' selected="selected"';} $select_count_spots_opt .='>'.$lang['yes'].'</option>
<option value="0"'; if($count_spots_arr[$its] == '0') {$select_count_spots_opt .=' selected="selected"';} $select_count_spots_opt .='>'.$lang['no'].'</option>
</select>';


echo '
<tr class="current_unit" id="inp_time3_'.$its.'">
<td class="input_td"><select name="hours_start['.$its.']" class="select_time">'.$select_hours_start_opt.'</select></td>
<td class="input_td"><select name="minutes_start['.$its.']" class="select_time">'.$select_minutes_start_opt.'</select></td>
<td class="input_td"><select name="hours_end['.$its.']" class="select_time">'.$select_hours_end_opt.'</select></td>
<td class="input_td"><select name="minutes_end['.$its.']" class="select_time">'.$select_minutes_end_opt.'</select></td>
</tr>
'; 
	
echo '<tr class="current_unit" id="inp_time4_'.$its.'"><th colspan="4" class="th_title">'.$lang['spots'].'</th></tr>';	
echo '<tr class="current_unit" id="inp_time5_'.$its.'"><th>'.$lang['total_spots'].'</th><th>'.$lang['min_spots'].'</th><th>'.$lang['max_spots'].'</th><th>'.$lang['count_spots_order'].'</th></tr>';	

echo '
<tr class="current_unit" id="inp_time6_'.$its.'">
<td class="input_td"><input type="number" name="total_spots['.$its.']" value="'.$total_spots_arr[$its].'" min="0" /></td>
<td class="input_td"><input type="number" name="min_spots['.$its.']" value="'.$min_spots_arr[$its].'" min="1" /></td>
<td class="input_td"><input type="number" name="max_spots['.$its.']" value="'.$max_spots_arr[$its].'" min="0" /></td>
<td class="input_td">'.$select_count_spots_opt.'</td>
</tr>
';

echo '<tr class="current_unit" id="inp_time7_'.$its.'"><th colspan="4" class="th_title">'.$lang['pay'].'</th></tr>';
echo'<tr class="current_unit" id="inp_time8_'.$its.'"><th colspan="2">'.$lang['price'].'</th><th colspan="2">'.$lang['currency'].'</th></tr>';

echo '
<tr class="current_unit" id="inp_time9_'.$its.'">
<td colspan="2" class="input_half_td"><input type="text" name="price['.$its.']" class="inp_bold" value="'.$prices_arr[$its].'" /></td>
<td colspan="2">'.$currency_obj.' <a href="#currency" class="scrollto" title="'.$lang['select_currency'].'"><i class="icon-money"></i></a></td>
</tr>';


echo '<tr class="current_unit" id="inp_time10_'.$its.'"><th colspan="4" class="th_title">'.$lang['select_staff'].'</th></tr>';

//===========================/time


echo '<tr class="current_unit" id="inp_time11_'.$its.'"><td colspan="4" class="staff_td">'; //===== staff tr

echo '<table id="v_table'.$its.'"><tbody>';



//======================================================= display current staff


for ($st = 0; $st < sizeof($staff_list); ++$st) { 

if (!empty($staff_list[$st])) {
	
$ind_staff = explode('-',$staff_list[$st]);		
$unit_number_staff = $ind_staff[0];
$unit_id_staff = $ind_staff[1];	

if ($unit_number_staff == $its) { // unit number = staff number

$id_staff_arr = array ($unit_number_staff => $unit_id_staff);




foreach ($id_staff_arr as $s => $id_curr_staff) { // count current staff

$name_staff_cur = $id_curr_staff;


echo '<tr class="current_unit"><td>'; //=============== start display list staff

$found_staff = '0';


for ($lssd = 0; $lssd < sizeof($lines_staff_display); ++$lssd) { 
if (!empty($lines_staff_display[$lssd])) {
$count_add_staff = sizeof($lines_staff_display);
$current_staff_disp = explode('::', $lines_staff_display[$lssd]); 
$id_staff_cur = $current_staff_disp[0];
$name_staff_cur =  $current_staff_disp[5]; 


if ($id_staff_cur == $unit_id_staff) {

$found_staff = '1';


echo'<label id="'.$unit_number_staff.'_'.$unit_id_staff.'"></label>'; 

echo '
<script>
window.onbeforeunload = disp_checkbox_'.$unit_number_staff.'_'.$unit_id_staff.'(); 
function disp_checkbox_'.$unit_number_staff.'_'.$unit_id_staff.'() {
var sinp = document.getElementById("'.$unit_number_staff.'_'.$unit_id_staff.'");
var tId = document.getElementById("v_table'.$its.'");
var CountLabels = tId.rows.length - 1;
sinp.innerHTML = \'<input type="checkbox" name="staff['.$unit_number_staff.'][\'+CountLabels+\']" value="'.$unit_id_staff.'" checked="checked"  class="check'.$its.'" onclick="check_empty_staff_'.$its.'()" /><span style="margin:0 0 0 0;">'.$name_staff_cur.'</span>\';
}
</script>
';


}

}} // id name staff

if ($found_staff == '0') {
echo'<label><input type="checkbox" name="" value="" class="check'.$its.'" disabled="disabled" />
<span style="margin:0 0 0 0;">';
echo '<i class="red_text">'.$lang['staff_not_found'].'</i>';
echo '</span>
</label>
'; }
echo '
</td></tr>'; 

} // count current staff

} // unit number = staff number
} //no empty staff

} // count all staff

echo '
</tbody>
</table>';

echo '<table class="add_button_s"><tbody><tr class="current_unit"><td>'; 

echo '<span class="add_staff" id="add_button_staff'.$its.'" tabindex="1" title="'.$lang['add_staff'].'" onclick="add_value_p('.$its.')"><i class="icon-plus-circled"></i></span>';

echo '
<script>
window.onbeforeunload = hidden_button_'.$its.'()
function hidden_button_'.$its.'() {
var tId = document.getElementById("v_table'.$its.'");
var CountTr = tId.rows.length;	
//document.write(CountTr);
var button_add = document.getElementById("add_button_staff'.$its.'");
if ('.$count_staff.' <= CountTr) {button_add.style.display = \'none\';}
}

function check_empty_staff_'.$its.'() {
	
var tb = document.getElementById("v_table'.$its.'");
var cc = tb.rows.length;

var all = document.getElementsByClassName(\'check'.$its.'\');
if (all != \'null\' || all != \'\') {	
var all_count = all.length;	

var check_no = 1;	
for(var i=0; i<all.length; i++) {
if (all[i].checked == false || all[all.length].checked == false) {
check_no = 0;
} else {check_no = 1;}	
}

if (check_no == 0 && all_count >= cc) { 
for (var i = 0; i < all.length; i++)
if (all[i].disabled == true) {all[i].checked = false;}	
else {all[i].checked = true;}	
alert( \''.$lang['empty_staff_checkbox'].'\'); 
} else {}	
  
}
}
</script>
';

echo '</td></tr></tbody></table>';

echo '</td></tr>'; //=====end staff tr

echo '<tr class="current_unit" id="inp_time12_'.$its.'"><td colspan="4" class="sep"></td></tr>';

} //----------------------------------- /count units time

echo '</tbody></table>';




//=================================/

echo '<span class="add_time" id="add_button_time" tabindex="1" title="'.$lang['add_unit_time'].'" onclick="add_value_t()"><i class="icon-plus-circled"></i>'.$lang['add_unit_time'].'</span>';

//=================================/



} // no empty time








echo '
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//---------------------------------------------------------------------/time units






//----------DAILY


//================================================ ADD STAFF DAILY 
$daily_staff_arr = explode('||',$daily_staff_obj); array_pop ($daily_staff_arr);

echo '<script>
var d = document;
var last_id = 0;
function add_value_d() {
	

	// table
    var tbody = d.getElementById(\'vs_table_d\').getElementsByTagName(\'tbody\')[0];
	
	
	if (tbody.rows.length > 0) {last_id = tbody.rows.length - 1;}
		
	var index_id = last_id;
	
	// create tr
    var row = d.createElement("tr");
	index_id = index_id + 1;
    row.id = \'inp_\'+index_id;
    row.setAttribute("class","display");
	
	tbody.appendChild(row);
	

    // create td in tr
    var td1 = d.createElement("td");
    
	
    row.appendChild(td1);
   
	
	last_id = last_id + 1;

	// add input in td
	
    td1.innerHTML = \'<select name="daily_staff[\'+last_id+\']">'.$option_staff.'</select><div class="button_area" id="remove_st_\'+last_id+\'"><span class="minus_item" tabindex="1" onclick="delete_value_d(\'+last_id+\')"><i class="icon-minus-circled"></i></span></div>\';
		
   

//remove add button
var allCount = '.$count_staff.';
var addButton = document.getElementById("add_button_staff_d");
var addCount = tbody.rows.length;

if (allCount <= addCount) {
addButton.style.display = \'none\';
document.getElementById("addts").style.display = \'none\';
} 

delete_last_button_d(last_id);
}

//remove tr
function delete_value_d(inpid) {
var tsIndex;
var idTr = "inp_"+inpid;
var elem = document.getElementById(idTr);
elem.parentNode.removeChild(elem);

setTimeout(function() { re_last_button_d(inpid); }, 30)

//button
document.getElementById("add_button_staff_d").style.display = \'block\';
document.getElementById("addts").style.display = \'block\';
//call check empty staff
return dcheck_empty_staff();
}

function delete_last_button_d(inpid) {
if (inpid != 0 || inpid != 1) {
last_ind = inpid - 1;
var minusButton = document.getElementById(\'remove_st_\'+last_ind);
//minusButton.style.display = \'none\';

minusButton.innerHTML = \'<span class="minus_item disabled_minus" tabindex="1"><i class="icon-minus-circled"></i></span>\';
}
}

function re_last_button_d(inpidd) {
if (inpidd != 0 || inpidd != 1) {
last_indr = inpidd - 1;
var minusButtonr = document.getElementById(\'remove_st_\'+last_indr);
//minusButtonr.style.display = \'block\';

minusButtonr.innerHTML = \'<span class="minus_item" tabindex="1" onclick="delete_value_d(\'+last_indr+\')"><i class="icon-minus-circled"></i></span>\';

}
}
</script>';



//=================================/



echo '<div class="input_info" id="daily_provide">
<div class="input_name">'.$lang['settings'].':<br /><small>'.$lang['daily'].'</small>
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_daily'].'</div></div>
</div>
<div class="input">';


echo '<table id="d_table" class="units_table"><tbody>';

echo '
<tr class="current_unit"><th colspan="4" class="th_main_title"><span class="unit_time_title"><i class="icon-calendar"></i>'.$lang['daily'].'</span></th></tr>';
echo '
<tr class="current_unit"><th colspan="4">'.$lang['allow_today'].'</th></tr>';

echo'<tr class="current_unit"><td class="input_td" colspan="4">';

echo'<label>';
if (isset($_POST['allow_today'])==true) { 
echo '<input type="checkbox" value="1" name="allow_today" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['allow_today'])==false) { 
echo '<input type="checkbox" value="1" name="allow_today" />'; } 
else if($allow_today_obj == '1' && isset($_POST['allow_today'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="allow_today" checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="allow_today" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['yes'].' / '.$lang['no'].'</span>';
echo'</label>';

echo '</td></tr>';
	
echo '<tr class="current_unit"><th colspan="4" class="th_title">'.$lang['spots'].'</th></tr>';	
echo '<tr class="current_unit"><th>'.$lang['total_spots'].'</th><th>'.$lang['min_spots'].'</th><th>'.$lang['max_spots'].'</th><th>'.$lang['count_spots_order'].'</th></tr>';	

echo '
<tr class="current_unit">
<td class="input_td"><input type="number" name="daily_total_spots" value="'.$daily_total_spots_obj.'" min="0" /></td>
<td class="input_td"><input type="number" name="daily_min_spots" value="'.$daily_min_spots_obj.'" min="1" /></td>
<td class="input_td"><input type="number" name="daily_max_spots" value="'.$daily_max_spots_obj.'" min="0" /></td>
<td class="input_td"><select name="daily_count_spots" class="select_time">
<option value="1"'; if($daily_count_spots_obj == '1') {echo' selected="selected"';} echo'>'.$lang['yes'].'</option>
<option value="0"'; if($daily_count_spots_obj == '0') {echo' selected="selected"';} echo'>'.$lang['no'].'</option>
</td>
</tr>
';

echo '<tr class="current_unit"><th colspan="4" class="th_title">'.$lang['pay'].'</th></tr>';
echo'<tr class="current_unit"><th colspan="2">'.$lang['price'].'</th><th colspan="2">'.$lang['currency'].'</th></tr>';



echo '
<tr class="current_unit">
<td colspan="2" class="input_half_td"><input type="text" name="daily_price" class="inp_bold" value="'.$daily_price_obj.'" /></td>
<td colspan="2">'.$currency_obj.' <a href="#currency" class="scrollto" title="'.$lang['select_currency'].'"><i class="icon-money"></i></a></td>
</tr>';


echo '<tr class="current_unit"><th colspan="4" class="th_title">'.$lang['select_staff'].'</th></tr>';


//---------------------------------- staff tr
echo '<tr class="current_unit"><td colspan="4" class="staff_td">

<table id="vs_table_d"><tbody>';

$count_add_daily_staff = sizeof($lines_staff_display);

if (empty($daily_staff_obj)) {
echo '
<tr id="inp_0" class="current_unit"><td>
<select name="daily_staff[0]">'.$option_staff.'</select>
<div class="button_area"><span class="minus_item disabled_minus" tabindex="1"><i class="icon-minus-circled"></i></span></div>
</td></tr>';

} else { 




for ($std = 0; $std < sizeof($daily_staff_arr); ++$std) { 
if (!empty($daily_staff_arr[$std])) {
	
$found_daily_staff = '0';	

//============read data staff	

for ($lstd = 0; $lstd < sizeof($lines_staff_display); ++$lstd) { 
if (!empty($lines_staff_display[$lstd])) {

$current_daily_staff_disp = explode('::', $lines_staff_display[$lstd]); 
$id_daily_staff_cur = $current_daily_staff_disp[0];
$name_daily_staff_cur =  $current_daily_staff_disp[5]; 


if ($id_daily_staff_cur == $daily_staff_arr[$std]) {

$found_daily_staff = '1';	

echo '<tr class="current_unit"><td>';
echo'<label>
<input type="checkbox" name="daily_staff['.$std.']" value="'.$id_daily_staff_cur.'" checked="checked"  class="dcheck" onclick="dcheck_empty_staff()" /><span style="margin:0 0 0 0;">'.$name_daily_staff_cur.'</span>
</label>'; 
echo '</td></tr>';
}
}// no empty staff data

} //count staff data

if ($found_daily_staff == '0') {
echo '<tr class="current_unit"><td>';
echo'<label><input type="checkbox" name="" value="" class="dcheck" disabled="disabled" />
<span style="margin:0 0 0 0;">';
echo '<i class="red_text">'.$lang['staff_not_found'].'</i>';
echo '</span></label>'; 
echo '</td></tr>';}



//======================================

echo '<script>
function dcheck_empty_staff() {
	
var tb = document.getElementById("vs_table_d");
var cc = tb.rows.length;

var all = document.getElementsByClassName(\'dcheck\');
if (all != \'null\' || all != \'\') {	
var all_count = all.length;	

var check_no = 1;	
for(var i=0; i<all.length; i++) {
if (all[i].checked == false || all[all.length].checked == false) {
check_no = 0;
} else {check_no = 1;}	
}

if (check_no == 0 && all_count >= cc) { 
for (var i = 0; i < all.length; i++)
if (all[i].disabled == true) {all[i].checked = false;}	
else {all[i].checked = true;}	
alert( \''.$lang['empty_staff_checkbox'].'\'); 
} else {}	
  
}
}
</script>';

} //no empty staff
} //count staff
} // staff from data

echo '</tbody></table>';


if (sizeof($daily_staff_arr) >= $count_add_daily_staff) {} else {
echo'
<table class="add_button_s"><tbody><tr class="current_unit"><td><span id="addts" class="text">'.$lang['add_staff'].'  &#8594;</span>
<span class="add_staff" id="add_button_staff_d" tabindex="1" title="'.$lang['add_staff'].'" onclick="add_value_d()"><i class="icon-plus-circled"></i></span>
</td></tr></tbody></table>'; }

echo '</td></tr>'; //-------------------- end Staff

echo '<tr class="current_unit"><td colspan="4" class="sep"></td></tr>';

echo '</tbody></table>';



echo '</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/daily


//----------SELECT ALWAYS FREE
echo '<div class="input_info" id="always_free">
<div class="input_name">'.$lang['always_free'].'
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_always_free'].'</div></div>
</div>
<div class="input"><div class="one_inp">';

echo'<label>';
if (isset($_POST['always_free'])==true) { 
echo '<input type="checkbox" value="1" name="always_free" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['always_free'])==false) { 
echo '<input type="checkbox" value="1" name="always_free" />'; } 
else if($always_free_obj == '1' && isset($_POST['always_free'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="always_free" checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="always_free" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';
echo'</label>';

echo'</div></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/select always free


//----------SELECT ONLY PAY
echo '<div class="input_info" id="only_pay">
<div class="input_name">'.$lang['select_only_pay'].'
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_only_pay'].'</div></div>
</div>
<div class="input"><div class="one_inp">';

echo'<label>';
if (isset($_POST['only_pay'])==true) { 
echo '<input type="checkbox" value="1" name="only_pay" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['only_pay'])==false) { 
echo '<input type="checkbox" value="1" name="only_pay" />'; } 
else if($only_pay_obj == '1' && isset($_POST['only_pay'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="only_pay" checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="only_pay" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';
echo'</label>';

echo'</div></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/select only pay





//----------SELECT ONLY ROW
echo '<div class="input_info" id="only_row">

<div class="input_name">'.$lang['select_only_row'].'</div>

<div class="input"><div class="one_inp">';

echo'<label>';
if (isset($_POST['only_row'])==true) { 
echo '<input type="checkbox" value="1" name="only_row" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['only_row'])==false) { 
echo '<input type="checkbox" value="1" name="only_row" />'; } 
else if($only_row_obj == '1' && isset($_POST['only_row'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="only_row" checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="only_row" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';
echo'</label>';

echo'</div></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/select only row



//----------ALL TIME SPOTS
echo '<div class="input_info" id="all_time_spots">
<div class="input_name">'.$lang['total_spots_all_time'].':
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_total_spots_all_time'].'</div></div>
</div>
<div class="input">';

echo '<div class="one_inp"><input type="number" name="all_spots" value="'.$all_spots_obj.'" min="0"></div>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/all time spots







//----------QUEUE
echo '<div class="input_info" id="queue">
<div class="input_name">'.$lang['queue'].':
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_queue'].'</div></div>
</div>
<div class="input"><div class="one_inp">';

echo'<label>';
if (isset($_POST['queue'])==true) { 
echo '<input type="checkbox" value="1" name="queue" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['queue'])==false) { 
echo '<input type="checkbox" value="1" name="queue" />'; } 
else if($queue_obj == '1' && isset($_POST['queue'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="queue" checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="queue" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';
echo'</label>';

echo'</div></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/queue




//----------WORK DAYS
$Mon = '1&&0&&0';
$Tue = '1&&0&&0';
$Wed = '1&&0&&0';
$Thu = '1&&0&&0';
$Fri = '1&&0&&0';
$Sat = '1&&0&&0';
$Sun = '1&&0&&0';

$working_days_arr = explode('||',$working_days_obj); 
if (isset($working_days_arr[0])) {$Mon = $working_days_arr[0];} 
if (isset($working_days_arr[1])) {$Tue = $working_days_arr[1];}
if (isset($working_days_arr[2])) {$Wed = $working_days_arr[2];}
if (isset($working_days_arr[3])) {$Thu = $working_days_arr[3];}
if (isset($working_days_arr[4])) {$Fri = $working_days_arr[4];}
if (isset($working_days_arr[5])) {$Sat = $working_days_arr[5];}
if (isset($working_days_arr[6])) {$Sun = $working_days_arr[6];}

if (empty($working_days_arr[0])) {$Mon = '1&&0&&0';} 
if (empty($working_days_arr[1])) {$Tue = '1&&0&&0';}
if (empty($working_days_arr[2])) {$Wed = '1&&0&&0';}
if (empty($working_days_arr[3])) {$Thu = '1&&0&&0';}
if (empty($working_days_arr[4])) {$Fri = '1&&0&&0';}
if (empty($working_days_arr[5])) {$Sat = '1&&0&&0';}
if (empty($working_days_arr[6])) {$Sun = '1&&0&&0';}


$monarr = explode('&&',$Mon);
$tuearr = explode('&&',$Tue);
$wedarr = explode('&&',$Wed);
$thuarr = explode('&&',$Thu);
$friarr = explode('&&',$Fri);
$satarr = explode('&&',$Sat);
$sunarr = explode('&&',$Sun);

if (!isset($monarr[0])) {$monarr[0] = '1';} 
if (!isset($tuearr[0])) {$tuearr[0] = '1';} 
if (!isset($wedarr[0])) {$wedarr[0] = '1';} 
if (!isset($thuarr[0])) {$thuarr[0] = '1';} 
if (!isset($friarr[0])) {$friarr[0] = '1';} 
if (!isset($satarr[0])) {$satarr[0] = '1';} 
if (!isset($sunarr[0])) {$sunarr[0] = '1';} 

if (!isset($monarr[1])) {$monarr[1] = '0';} 
if (!isset($tuearr[1])) {$tuearr[1] = '0';} 
if (!isset($wedarr[1])) {$wedarr[1] = '0';} 
if (!isset($thuarr[1])) {$thuarr[1] = '0';} 
if (!isset($friarr[1])) {$friarr[1] = '0';} 
if (!isset($satarr[1])) {$satarr[1] = '0';} 
if (!isset($sunarr[1])) {$sunarr[1] = '0';} 

if (!isset($monarr[2])) {$monarr[2] = '0';} 
if (!isset($tuearr[2])) {$tuearr[2] = '0';} 
if (!isset($wedarr[2])) {$wedarr[2] = '0';} 
if (!isset($thuarr[2])) {$thuarr[2] = '0';} 
if (!isset($friarr[2])) {$friarr[2] = '0';} 
if (!isset($satarr[2])) {$satarr[2] = '0';} 
if (!isset($sunarr[2])) {$sunarr[2] = '0';} 


echo '<div class="input_info" id="navworkdays">
<div class="input_name">'.$lang['working_days'].':
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_working_days'].'</div></div>
</div>
<div class="input">';


echo'<div class="sw_day"><label>'; //Monday
if (isset($_POST['Monday'])==true) { 
echo '<input type="checkbox" value="1" name="Monday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Monday'])==false) { 
echo '<input type="checkbox" value="1" name="Monday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($monarr[0] == '1' && isset($_POST['Monday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Monday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Monday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['1'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="mon_swing" class="select_time">
<option value="0"'; if($monarr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($monarr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($monarr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="mon_price" class="inp_bold" value="'.$monarr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';


echo'<div class="sw_day"><label>'; //Tuesday
if (isset($_POST['Tuesday'])==true) { 
echo '<input type="checkbox" value="1" name="Tuesday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Tuesday'])==false) { 
echo '<input type="checkbox" value="1" name="Tuesday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($tuearr[0] == '1' && isset($_POST['Tuesday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Tuesday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Tuesday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['2'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="tue_swing" class="select_time">
<option value="0"'; if($tuearr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($tuearr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($tuearr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="tue_price" class="inp_bold" value="'.$tuearr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';

echo'<div class="sw_day"><label>'; //Wednesday
if (isset($_POST['Wednesday'])==true) { 
echo '<input type="checkbox" value="1" name="Wednesday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Wednesday'])==false) { 
echo '<input type="checkbox" value="1" name="Wednesday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($wedarr[0] == '1' && isset($_POST['Wednesday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Wednesday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Wednesday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['3'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="wed_swing" class="select_time">
<option value="0"'; if($wedarr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($wedarr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($wedarr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="wed_price" class="inp_bold" value="'.$wedarr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';


echo'<div class="sw_day"><label>'; //Thursday
if (isset($_POST['Thursday'])==true) { 
echo '<input type="checkbox" value="1" name="Thursday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Thursday'])==false) { 
echo '<input type="checkbox" value="1" name="Thursday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($thuarr[0] == '1' && isset($_POST['Thursday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Thursday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Thursday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['4'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="thu_swing" class="select_time">
<option value="0"'; if($thuarr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($thuarr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($thuarr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="thu_price" class="inp_bold" value="'.$thuarr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';


echo'<div class="sw_day"><label>'; //Friday
if (isset($_POST['Friday'])==true) { 
echo '<input type="checkbox" value="1" name="Friday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Friday'])==false) { 
echo '<input type="checkbox" value="1" name="Friday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($friarr[0] == '1' && isset($_POST['Friday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Friday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Friday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['5'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="fri_swing" class="select_time">
<option value="0"'; if($friarr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($friarr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($friarr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="fri_price" class="inp_bold" value="'.$friarr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';


echo'<div class="sw_day"><label>'; //Saturday
if (isset($_POST['Saturday'])==true) { 
echo '<input type="checkbox" value="1" name="Saturday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Saturday'])==false) { 
echo '<input type="checkbox" value="1" name="Saturday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($satarr[0] == '1' && isset($_POST['Saturday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Saturday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Saturday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['6'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="sat_swing" class="select_time">
<option value="0"'; if($satarr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($satarr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($satarr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="sat_price" class="inp_bold" value="'.$satarr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';


echo'<div class="sw_day"><label>'; //Sunday
if (isset($_POST['Sunday'])==true) { 
echo '<input type="checkbox" value="1" name="Sunday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['Sunday'])==false) { 
echo '<input type="checkbox" value="1" name="Sunday" class="checkd" onclick="dcheck_empty_days()"  checked="checked />'; } 
else if($sunarr[0] == '1' && isset($_POST['Sunday'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="Sunday" class="checkd" onclick="dcheck_empty_days()"  checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="Sunday" class="checkd" onclick="dcheck_empty_days()" />'; }
echo'<span>'.$lang_days['7'].'</span>';
echo'</label>';

echo '<table class="units_table"><tbody>';
echo '<tr class="current_unit"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';
echo '<tr class="current_unit">
<td class="input_half_td">
<select name="sun_swing" class="select_time">
<option value="0"'; if($sunarr[1] == '0') {echo' selected="selected"';} echo'>'.$lang['no_use'].'</option>
<option value="+"'; if($sunarr[1] == '+') {echo' selected="selected"';} echo'>'.$lang['to_plus'].'</option>
<option value="-"'; if($sunarr[1] == '-') {echo' selected="selected"';} echo'>'.$lang['to_minus'].'</option>
</select>
</td>
<td class="input_half_td"><input type="text" name="sun_price" class="inp_bold" value="'.$sunarr[2].'" /></td>
</tr>';
echo '</tbody></table></div>';

echo '<script>
function dcheck_empty_days() {
	
var cd = 7;

var alld = document.getElementsByClassName(\'checkd\');

var alld_count = alld.length;	

var checkd_no = 1;	
for(var i=0; i<alld.length; i++) {
if (alld[i].checked == false || alld[alld.length].checked == false) {
checkd_no = 0;
} else {checkd_no = 1;}	
}

if (checkd_no == 0 && alld_count >= cd) { 
for (var i = 0; i < alld.length; i++)
if (alld[i].disabled == true) {alld[i].checked = false;}	
else {alld[i].checked = true;}	
alert( \''.$lang['empty_days_checkbox'].'\'); 
} else {}	
  

}
</script>';


echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/work days




//----------LIST DISABLED DAYS & CHANGE PRICE DAYS

$date_arr = '';
$dp_arr = '';
$pm_arr = '';
$cprices_arr = '';

if(empty($custom_date_obj) || $custom_date_obj == '&&') {
	
} else {		

$custom_date_arr = explode('||', $custom_date_obj);

if (isset($custom_date_arr[0])) {$date_arr = explode('&&', $custom_date_arr[0]); array_pop($date_arr);}
if (isset($custom_date_arr[1])) {$dp_arr = explode('&&', $custom_date_arr[1]);}
if (isset($custom_date_arr[2])) {$pm_arr = explode('&&', $custom_date_arr[2]);}
if (isset($custom_date_arr[3])) {$cprice_arr = explode('&&', $custom_date_arr[3]);}
}


echo '<div class="input_info" id="navdwd">
<div class="input_name">'.$lang['settings_month_days_cp'].':
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_dis_days_cp'].'</div></div>
</div>
<div class="input">';


//=========================JS

echo '<script>
var dt = document;
var last_id_date = 0;


var index_id_date = last_id_date;

function add_value_date() {
	
var tbody_dt = document.getElementById(\'dt_table\').getElementsByTagName(\'tbody\')[0];	
var last_id_date = tbody_dt.rows.length / 5 - 1;
var index_id_date = last_id_date;

	// table
    var tbody_time = dt.getElementById(\'dt_table\').getElementsByTagName(\'tbody\')[0];
	
	// create tr
	index_id_date = index_id_date + 1;
	
	var row_date1 = dt.createElement("tr");
    row_date1.id = \'inp_date1_\'+index_id_date;
tbody_time.appendChild(row_date1); // tr 1
setTimeout(function() { dt.getElementById(\'inp_date1_\'+index_id_date).className = "current_unit" }, 0)
	
	var row_date2 = dt.createElement("tr");
    row_date2.id = \'inp_date2_\'+index_id_date;
tbody_time.appendChild(row_date2); // tr 2
setTimeout(function() { dt.getElementById(\'inp_date2_\'+index_id_date).className = "display" }, 20)


var row_date3 = dt.createElement("tr");
    row_date3.id = \'inp_date3_\'+index_id_date;
tbody_time.appendChild(row_date3); // tr 3
setTimeout(function() { dt.getElementById(\'inp_date3_\'+index_id_date).className = "display" }, 40)


var row_date4 = dt.createElement("tr");
    row_date4.id = \'inp_date4_\'+index_id_date;
tbody_time.appendChild(row_date4); // tr 4
setTimeout(function() { dt.getElementById(\'inp_date4_\'+index_id_date).className = "display" }, 60)   


var row_date5 = dt.createElement("tr");
    row_date5.id = \'inp_date5_\'+index_id_date;
tbody_time.appendChild(row_date5); // tr 5
setTimeout(function() { dt.getElementById(\'inp_date5_\'+index_id_date).className = "display" }, 80)   
	
	
	// create th in tr1 ===========================
    var th1_date1 = dt.createElement("th"); th1_date1.setAttribute("colspan","2"); th1_date1.setAttribute("class","th_main_title");
	
	row_date1.appendChild(th1_date1);
	
	
	// create td in tr2 ===========================
    var td1_date2 = dt.createElement("td"); td1_date2.setAttribute("class","input_half_td");
	var td2_date2 = dt.createElement("td"); td2_date2.setAttribute("class","input_half_td");
	
	row_date2.appendChild(td1_date2);
	row_date2.appendChild(td2_date2);
 
    // create th in tr3 ===========================
    var th1_date3 = dt.createElement("th"); 
	var th2_date3 = dt.createElement("th"); 
	
	row_date3.appendChild(th1_date3); 
	row_date3.appendChild(th2_date3);
	
	// create td in tr4 ===========================
    var td1_date4 = dt.createElement("td"); td1_date4.setAttribute("class","input_half_td");
	var td2_date4 = dt.createElement("td"); td2_date4.setAttribute("class","input_half_td");
	
	row_date4.appendChild(td1_date4);
	row_date4.appendChild(td2_date4);
	
	// create td in tr5 ===========================
   var td1_date5 = dt.createElement("td"); td1_date5.setAttribute("colspan","2"); td1_date5.setAttribute("class","sep");
	
	row_date5.appendChild(td1_date5);
	
//================================================= 
	
	last_id_date = last_id_date + 1;


	// add content in tr1 =======================	
    th1_date1.innerHTML = \'<span class="unit_time_title"><i class="icon-calendar"></i>'.$lang['date'].'</span><div id="del_dt_\'+last_id_date+\'" class="button_area"><span class="minus_item" tabindex="1" onclick="delete_value_dt(\'+last_id_date+\')"><i class="icon-minus-circled"></i></span></div>\';
	
		
	// add content in tr2 =======================	
    td1_date2.innerHTML = \'<input maxlength="5" name="mday[\'+last_id_date+\']" type="text" value="" readonly="readonly" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" />\';
	
	td2_date2.innerHTML = \'<select name="disabled_price[\'+last_id_date+\']" class="select_time" id="sdp\'+last_id_date+\'" onchange="disinp(\'+last_id_date+\')"><option value="0" id="sdp\'+last_id_date+\'1" selected="selected">'.$lang['disabled_day'].'</option><option value="1" id="sdp\'+last_id_date+\'2">'.$lang['change_price'].'</option></select>\';
	
	
	// add content in tr3 =======================
    th1_date3.innerHTML = \''.$lang['shift_prise'].'\';	
    th2_date3.innerHTML = \''.$lang['in_sum'].'\';	
   

	// add content in tr4 =======================	
    td1_date4.innerHTML = \'<select name="plus_minus[\'+last_id_date+\']" class="select_time" id="spm\'+last_id_date+\'"><option value="+">'.$lang['to_plus'].'</option><option value="-">'.$lang['to_minus'].'</option></select>\';
	
	td2_date4.innerHTML = \'<input type="text" name="c_price[\'+last_id_date+\']" class="inp_bold" value="" id="cprice\'+last_id_date+\'" />\';
	
	// add content in tr5 =======================	
    td1_date5.innerHTML = \'\';
	
	
//var id_btd = last_id_date - 1;
// document.getElementById(\'del_dt_\'+id_btd).style.display = \'none\';	
	
setTimeout(function() { return disinp(last_id_date); }, 20)	
return delete_last_button_dt(last_id_date);
}


//remove tr
function delete_value_dt(inpid_dt) {
	
var idTr_date1 = "inp_date1_"+inpid_dt;
var idTr_date2 = "inp_date2_"+inpid_dt;
var idTr_date3 = "inp_date3_"+inpid_dt;
var idTr_date4 = "inp_date4_"+inpid_dt;
var idTr_date5 = "inp_date5_"+inpid_dt;

var elem_dt1 = document.getElementById(idTr_date1);
var elem_dt2 = document.getElementById(idTr_date2);
var elem_dt3 = document.getElementById(idTr_date3);
var elem_dt4 = document.getElementById(idTr_date4);
var elem_dt5 = document.getElementById(idTr_date5);

setTimeout(function() { elem_dt1.parentNode.removeChild(elem_dt1) }, 120)
setTimeout(function() { elem_dt2.parentNode.removeChild(elem_dt2) }, 100)
setTimeout(function() { elem_dt3.parentNode.removeChild(elem_dt3) }, 80)
setTimeout(function() { elem_dt4.parentNode.removeChild(elem_dt4) }, 60)
setTimeout(function() { elem_dt5.parentNode.removeChild(elem_dt5) }, 40)

//var count_dt = inpid_dt - 1;
//if (count_dt == 0){document.getElementById(\'del_dt_\'+count_dt).style.display = \'none\';} 
//else {document.getElementById(\'del_dt_\'+count_dt).style.display = \'block\';}

setTimeout(function() { re_last_button_dt(inpid_dt); }, 20)
}
//=================================================================================

function delete_last_button_dt(indate) {
if (indate != 0) {
last_indt = indate - 1;
var minusButton_dt = document.getElementById(\'del_dt_\'+last_indt);
minusButton_dt.innerHTML = \'\';
}
}

function re_last_button_dt(indate) {
//if (indate != 0 || indate != 1) {
last_indtr = indate - 1;
var minusButton_dtr = document.getElementById(\'del_dt_\'+last_indtr);

minusButton_dtr.innerHTML = \'<span class="minus_item" tabindex="1" onclick="delete_value_dt(\'+last_indtr+\')"><i class="icon-minus-circled"></i></span>\';

//}
}

</script>';



echo '<table id="dt_table" class="units_table"><tbody>';



//----------------- DATE UNIT
if(empty($custom_date_obj) || empty($date_arr[0])) {
echo'<tr class="current_unit" id="inp_date1_0"><th colspan="2" class="th_main_title"><span class="unit_time_title"><i class="icon-calendar"></i>'.$lang['date'].'</span><div id="del_dt_0" class="button_area"><span class="minus_item" tabindex="1" onclick="delete_value_dt(0)"><i class="icon-minus-circled"></i></span></div></th></tr>';	
echo '
<tr class="current_unit" id="inp_date2_0">
<td class="input_half_td">

<input maxlength="5" name="mday[0]" type="text" value="" readonly="readonly" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" />

</td>
<td class="input_half_td">
<select name="disabled_price[0]" class="select_time" id="sdp0" onchange="disinp0()">
<option value="0" id="sdp01">'.$lang['disabled_day'].'</option>
<option value="1" id="sdp02">'.$lang['change_price'].'</option>
</select>
</td>
</tr>';

echo'<tr class="current_unit" id="inp_date3_0"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';	
echo'<tr class="current_unit" id="inp_date4_0">
<td class="input_half_td"><select name="plus_minus[0]" class="select_time" id="spm0">
<option value="+">'.$lang['to_plus'].'</option>
<option value="-">'.$lang['to_minus'].'</option></select>
</td>
<td class="input_half_td"><input type="text" name="c_price[0]" class="inp_bold" value="" id="cprice0" /></td>
</tr>'; 
echo'<tr class="current_unit"><td colspan="2" class="sep"></td></tr>';

echo '<script>
window.onbeforeunload = disinp0()
function disinp0() {
var sdp = document.getElementById("sdp0");
var sdp1 = document.getElementById("sdp01");	
var sdp2 = document.getElementById("sdp02");	
var spm = document.getElementById("spm0");
var cprice = document.getElementById("cprice0");

if(sdp1.selected == true) {
cprice.setAttribute("disabled","disabled");
spm.setAttribute("disabled","disabled");
} else {
spm.removeAttribute("disabled");
cprice.removeAttribute("disabled");
}
}

</script>';


} else { //========================================== Current custom dates

for ($cdt = 0; $cdt < sizeof($date_arr); ++$cdt) { 	
	
if (!empty($date_arr[$cdt])) {$md_arr = explode('.',$date_arr[$cdt]);} else {$md_arr[1] = '';}
	
if ($dp_arr[$cdt] == '0') {$day_status = $lang['disabled_day'];} else {$day_status = $lang['change_price'];}
	
if ($cprice_arr[$cdt] == '0') {$pr_val = '';} else {$pr_val = $cprice_arr[$cdt];}	

if ($dp_arr[$cdt] == '0') {$dp_sel = '';} else {$dp_sel = 'selected="selected"';}	

if ($pm_arr[$cdt] == '+') {$pm_sel = '';} else {$pm_sel = 'selected="selected"';}	

	
echo'<tr class="current_unit" id="inp_date1_'.$cdt.'">
<th colspan="2" class="th_main_title">
<span class="unit_time_title"><i class="icon-calendar"></i>'.$md_arr[0].' '.$lang_monts_r[$md_arr[1]].' ('.$day_status.')</span>';

if ($cdt == sizeof($date_arr) -1) {
echo'<div id="del_dt_'.$cdt.'" class="button_area"><span class="minus_item" tabindex="1" onclick="delete_value_dt('.$cdt.')"><i class="icon-minus-circled"></i></span></div>';} else { echo '<div id="del_dt_'.$cdt.'" class="button_area"></div>'; }

echo'
</tr>';	
echo '
<tr class="current_unit" id="inp_date2_'.$cdt.'">
<td class="input_half_td">

<input maxlength="5" name="mday['.$cdt.']" type="text" value="'.$date_arr[$cdt].'" readonly="readonly" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" />

</td>
<td class="input_half_td">
<select name="disabled_price['.$cdt.']" class="select_time" id="sdp'.$cdt.'" onchange="disinp'.$cdt.'()">
<option value="0" id="sdp'.$cdt.'1">'.$lang['disabled_day'].'</option>
<option value="1" id="sdp'.$cdt.'2" '.$dp_sel.'>'.$lang['change_price'].'</option>
</select>
</td>
</tr>';

echo'<tr class="current_unit" id="inp_date3_'.$cdt.'"><th>'.$lang['shift_prise'].'</th><th>'.$lang['in_sum'].'</th></tr>';	
echo'<tr class="current_unit" id="inp_date4_'.$cdt.'">
<td class="input_half_td"><select name="plus_minus['.$cdt.']" class="select_time" id="spm'.$cdt.'">
<option value="+">'.$lang['to_plus'].'</option>
<option value="-" '.$pm_sel.'>'.$lang['to_minus'].'</option></select>
</td>
<td class="input_half_td"><input type="text" name="c_price['.$cdt.']" class="inp_bold" value="'.$pr_val.'" id="cprice'.$cdt.'" /></td>
</tr>'; 
echo'<tr class="current_unit" id="inp_date5_'.$cdt.'"><td colspan="2" class="sep"></td></tr>';	
	
	
echo '<script>
window.onbeforeunload = disinp'.$cdt.'()
function disinp'.$cdt.'() {
var sdp = document.getElementById("sdp'.$cdt.'");
var sdp1 = document.getElementById("sdp'.$cdt.'1");	
var sdp2 = document.getElementById("sdp'.$cdt.'2");	
var spm = document.getElementById("spm'.$cdt.'");
var cprice = document.getElementById("cprice'.$cdt.'");

if(sdp1.selected == true) {
cprice.setAttribute("disabled","disabled");
spm.setAttribute("disabled","disabled");
} else {
spm.removeAttribute("disabled");
cprice.removeAttribute("disabled");
}
}

</script>';	
	
} //count dates	
} // no empty custom date obj

//--/DATE UNIT



echo '<script>
function disinp(idin) {

var sdp = document.getElementById(\'sdp\'+idin);
var sdp1 = document.getElementById(\'sdp\'+idin+\'1\');	
var sdp2 = document.getElementById(\'sdp\'+idin+\'2\');	
var spm = document.getElementById(\'spm\'+idin);
var cprice = document.getElementById(\'cprice\'+idin);

if(sdp1.selected == true) {
cprice.setAttribute("disabled","disabled");
spm.setAttribute("disabled","disabled");
} else {
spm.removeAttribute("disabled");
cprice.removeAttribute("disabled");
}
}

</script>';



echo '</tbody></table>';

echo '<span class="add_time" id="add_button_date" tabindex="1" title="'.$lang['add_date'].'" onclick="add_value_date()"><i class="icon-plus-circled"></i>'.$lang['add_date'].'</span>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/disabled days & price change





//----------ACTIVE TWO MONTS
echo '<div class="input_info" id="active_two_monts">
<div class="input_name">'.$lang['active_two_monts'].':

</div>
<div class="input"><div class="one_inp">';

echo'<label>';
if (isset($_POST['active_two_monts'])==true) { 
echo '<input type="checkbox" value="1" name="active_two_monts" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['active_two_monts'])==false) { 
echo '<input type="checkbox" value="1" name="active_two_monts" />'; } 
else if($active_two_monts_obj == '1' && isset($_POST['active_two_monts'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="1" name="active_two_monts" checked="checked" />'; }
else { echo '<input type="checkbox" value="1" name="active_two_monts" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';
echo'</label>';

echo'</div></div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/active two monts








//----------FIX PRICE
$sum_fp = '';

if (empty($fix_price_obj)) { $sum_fp = ''; } else { $sum_fp = $fix_price_obj; }




echo '<div class="input_info" id="navfixprice">
<div class="input_name">'.$lang['fix_price'].':
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_fix_price'].'</div></div>
</div>
<div class="input">';

echo '<table class="units_table"><tbody>';

echo '<tr class="current_unit"><th>'.$lang['sum'].'</th><th>'.$lang['currency'].'</th></tr>';

echo '<tr class="current_unit">
<td class="input_half_td"><input type="text" name="fix_price" class="inp_bold" value="'.$sum_fp.'" /></td>
<td>'.$currency_obj.' <a href="#currency" class="scrollto" title="'.$lang['select_currency'].'"><i class="icon-money"></i></a></td>
</tr>';

echo '</tbody></table>';



echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

//----------/fix price





//----------PROMO CODE
$d_code = '';
$d_price = '';
$d_count = '';

if (!empty($discount_obj)) {
$discount_arr = explode('||', $discount_obj);	
if (isset($discount_arr[0])) { $d_code = $discount_arr[0]; }
if (isset($discount_arr[1])) { $d_price = $discount_arr[1]; }
if (isset($discount_arr[2])) { $d_count = $discount_arr[2]; }
} 

echo '<div class="input_info" id="promo_code">
<div class="input_name">'.$lang['discount'].':
<div class="help_obj" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_promo_code'].'</div></div></div>
<div class="input">';


echo '<table class="units_table"><tbody>';

echo '<tr class="current_unit"><th colspan="2">'.$lang['promo_code'].'</th></tr>';

echo '<tr class="current_unit"><td colspan="2" class="input_full_td"><input type="text" name="discount_code" value="'.$d_code.'" /></td></tr>';

echo '<tr class="current_unit"><th>'.$lang['discount'].'</th><th>'.$lang['discount_count'].'</th></tr>';

echo '<tr class="current_unit">
<td class="input_half_td"><input type="text" name="discount_price" class="inp_bold" value="'.$d_price.'" /></td>
<td class="input_half_td">
<select name="discount_count">
<option value="%"'; if($d_count == '%'){echo ' selected="selected"';} echo'>'.$lang['discount_percent'].'</option>
<option value="="'; if($d_count == '='){echo ' selected="selected"';} echo'>'.$lang['discount_sum'].'</option>
</select></td>
</tr>';

echo '</tbody></table>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/promo code


//----------PHOTOS
$photos_arr = explode('||',$photos_obj); array_pop ($photos_arr);

echo '<script>
var d = document;
var last_ph = 0;

function add_ph() {
	
var ph_cc = d.getElementById(\'pharr\').getElementsByTagName(\'tbody\')[0];
if (ph_cc.rows.length > 0) {last_ph = ph_cc.rows.length - 1;} 
	
	// table
    var tbody = d.getElementById(\'pharr\').getElementsByTagName(\'tbody\')[0];
	
	
	
		
	var index_id = last_ph;
	
	// create tr
    var row = d.createElement("tr");
	index_id = index_id + 1;
    row.id = \'phinp_\'+index_id;
   
	tbody.appendChild(row);
	

    // create td in tr
    var td_ph = d.createElement("td");
    
    row.appendChild(td_ph);
   
	last_ph = last_ph + 1;

	// add input in td
	
    td_ph.innerHTML = \'<div class="photo_block"><div class="innerPhoto"><span class="minus_item ph_minus" tabindex="1" onclick="delete_ph(\'+last_ph+\')"><i class="icon-minus-circled"></i></span><a onclick="ifr(\'+last_ph+\')" href="#" id="selectPhoto_\'+last_ph+\'" title="'.$lang['select'].' '.$lang['photo'].'"></a><div class="photo_tools"><a href="#" onclick="resetImg(\'+last_ph+\')"><i class="icon-block"></i>'.$lang['reset'].'</a><a href="#" class="iframe" onclick="ifr(\'+last_ph+\')"><i class="icon-picture"></i>'.$lang['select'].'</a><div class="clear"></div></div></div></div><input type="hidden" id="photoInput_\'+last_ph+\'" name="photos[\'+last_ph+\']" value="" />\';

return oninputImg(last_ph);
}

//remove tr
function delete_ph(inpid) {
var tsIndex;
var idTr = "phinp_"+inpid;
var dtr = document.getElementById(idTr);
var cleanInp = document.getElementById(\'photoInput_\'+inpid);
var stre = \'\';
cleanInp.value=stre;

setTimeout(function() { dtr.className = "fadeout" }, 20)
//setTimeout(function() { dtr.parentNode.removeChild(dtr) }, 220)
setTimeout(function() { dtr.style.display = \'none\'; }, 220)

}
</script>';



echo '<div class="input_info" id="navphotos">
<div class="input_name">'.$lang['photos'].':</div>
<div class="input">';



echo '<table id="pharr" class="ph_table"><tbody>';

//------------photo block

if (empty($photos_obj) || $photos_obj == '||') {
echo '<tr id="phinp_0"><td>
<div class="photo_block">
<div class="innerPhoto">
<span class="minus_item ph_minus" tabindex="1" onclick="delete_ph(0)"><i class="icon-minus-circled"></i></span>
<a class="iframe" href="photos.php?iframe&img=0" id="selectPhoto_0" title="'.$lang['select'].' '.$lang['photo'].'"></a>
<div class="photo_tools">
<a href="#" onclick="resetImg_empty()"><i class="icon-block"></i>'.$lang['reset'].'</a>
<a class="iframe" href="photos.php?iframe&img=0"><i class="icon-picture"></i>'.$lang['select'].'</a> 
<div class="clear"></div>
</div>
</div>
</div>
<input type="hidden" id="photoInput_0" name="photos[0]" value="" />';
echo '</td></tr>';

echo '<script>

window.onbeforeunload = oninputImg_empty() 

function oninputImg_empty() {
var photoFile = document.getElementById(\'photoInput_0\').value;
if (photoFile != \'\') {document.getElementById(\'selectPhoto_0\').innerHTML = \'<img src="../\'+photoFile+\'" />\';}
else {document.getElementById(\'selectPhoto_0\').innerHTML = \'<img src="../img/no_photo.jpg" />\';}
}
function resetImg_empty() {
var Nullstr = \'\';	
var InpReset=document.getElementById(\'photoInput_0\');
InpReset.value=Nullstr;
document.getElementById(\'selectPhoto_0\').innerHTML = \'<img src="../img/no_photo.jpg" />\';
}

function ifr(num) {
$.colorbox({iframe:true, transition:"elastic", width:"874", height:"80%", opacity:"100", href:"photos.php?iframe&img="+num});	
}
</script>';



} else { //============================current photo 

for ($ph = 0; $ph < sizeof($photos_arr); ++$ph) { 
if (!empty($photos_arr[$ph])) {
echo '<tr id="phinp_'.$ph.'"><td>
<div class="photo_block">
<div class="innerPhoto">
<span class="minus_item ph_minus" tabindex="1" onclick="delete_ph('.$ph.')"><i class="icon-minus-circled"></i></span>
<a class="iframe" href="photos.php?iframe&img='.$ph.'" id="selectPhoto_'.$ph.'" title="'.$lang['select'].' '.$lang['photo'].'"></a>
<div class="photo_tools">
<a href="#" onclick="resetImg_'.$ph.'()"><i class="icon-block"></i>'.$lang['reset'].'</a>
<a class="iframe" href="photos.php?iframe&img='.$ph.'"><i class="icon-picture"></i>'.$lang['select'].'</a> 
<div class="clear"></div>
</div>
</div>
</div>';
echo '<input type="hidden" id="photoInput_'.$ph.'" name="photos['.$ph.']" value="'; if(isset($_POST['photos'][$ph])){echo $_POST['photos'][$ph];}else{if(file_exists('../'.$photos_arr[$ph])){echo $photos_arr[$ph];}else{echo'';}} echo '" />';


echo '<script>

window.onbeforeunload = oninputImg_'.$ph.'() 

function oninputImg_'.$ph.'() {
var photoFile = document.getElementById(\'photoInput_'.$ph.'\').value;
if (photoFile != \'\') {document.getElementById(\'selectPhoto_'.$ph.'\').innerHTML = \'<img src="../\'+photoFile+\'?rand='.$ph.$rnd_num.'" />\';}
else {document.getElementById(\'selectPhoto_'.$ph.'\').innerHTML = \'<img src="../img/no_photo.jpg" />\';}
}
function resetImg_'.$ph.'() {
var Nullstr = \'\';	
var InpReset=document.getElementById(\'photoInput_'.$ph.'\');
InpReset.value=Nullstr;
document.getElementById(\'selectPhoto_'.$ph.'\').innerHTML = \'<img src="../img/no_photo.jpg" />\';

}

</script>';


echo '</td></tr>';
} //no empty
}//count photo

}
//------------/photo block

echo '</tbody></table>';

echo '<script>

window.onbeforeunload = oninputImg() 

function oninputImg(ntr) {
var photoFile = document.getElementById(\'photoInput_\'+ntr).value;
if (photoFile != \'\') {document.getElementById(\'selectPhoto_\'+ntr).innerHTML = \'<img src="../\'+photoFile+\'" />\';}
else {document.getElementById(\'selectPhoto_\'+ntr).innerHTML = \'<img src="../img/no_photo.jpg" />\';}
}
function resetImg(ntr) {
var Nullstr = \'\';	
var InpReset=document.getElementById(\'photoInput_\'+ntr);
InpReset.value=Nullstr;
document.getElementById(\'selectPhoto_\'+ntr).innerHTML = \'<img src="../img/no_photo.jpg" />\';

}

function ifr(num) {
$.colorbox({iframe:true, transition:"elastic", width:"874", height:"80%", opacity:"100", href:"photos.php?iframe&img="+num});	
}
</script>';





echo '<span class="add_time" tabindex="1" title="'.$lang['add_photo'].'" onclick="add_ph()"><i class="icon-plus-circled"></i>'.$lang['add_photo'].'</span>';



echo '</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/photos


//----------BOOKING OR ORDER WORDING
echo '<div class="input_info">
<div class="input_name">'.$lang['wording'].':</div>
<div class="input">';

echo '<select name="wording">
<option value="0"'; if($wording_obj == '0') {echo' selected="selected"';} echo'>'.$lang['booking_go'].'</option>
<option value="1"'; if($wording_obj == '1') {echo' selected="selected"';} echo'>'.$lang['order_go'].'</option>
</select>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';
//----------/Booking or order



//----------ACTIVE
if ($access_level == 'staff') { echo '';} else {
echo '<div class="input_info" id="active">
<div class="input_name">'.$lang['active'].':</div>
<div class="input">';

echo'<label>';
if (isset($_POST['obj_active'])==true) { 
echo '<input type="checkbox" value="yes" name="obj_active" checked="checked" />';}
else if (isset($_POST['line'])==true && isset($_POST['obj_active'])==false) { 
echo '<input type="checkbox" value="yes" name="obj_active" />'; } 
else if($active_obj == 'yes' && isset($_POST['obj_active'])==false && isset($_POST['line'])==false) {
echo '<input type="checkbox" value="yes" name="obj_active" checked="checked" />'; }
else { echo '<input type="checkbox" value="yes" name="obj_active" />'; }
echo'<span style="margin:0 0 0 0;">'.$lang['on_off'].'</span>';
echo'</label>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';

} //staff access
//----------/active



//----------Link ID

echo '<div class="input_info" id="link_id">
<div class="input_name">'.$lang['id_link'].':</div>
<div class="input">';

$obj_link = $script_name;
$obj_link = str_replace('apanel/object.php','',$obj_link);
$obj_link = $obj_link.'index.php?obj='.$id_obj.'';

echo '<div class="id_link"><a href="'.$obj_link.'" target="_blank">'.$id_obj.'</a></div>';

echo'</div>
<div class="clear"></div>
</div>
<div class="clear"></div>';


//----------/Link ID




//----------SUBMIT & INFO WHO ADD/CHANGE
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
<div id="navbottom" class="input_info last_block">

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
//----------/submit


echo '</form></div>';

// SWITCH PROVIDE
echo '
<script>
window.onbeforeunload = switch_provide(); 
function switch_provide() {
var units_block = document.getElementById(\'units\');
var radio_daily	= document.getElementById(\'daily\');
var radio_hourly = document.getElementById(\'hourly\');	
var daily_block = document.getElementById(\'daily_provide\');
//var queue_block	= document.getElementById(\'queue\');
//var queue_link	= document.getElementById(\'queueb\');
var link_nav = document.getElementById(\'navunits\');
daily_block.style.display = \'none\';
if (radio_daily.checked == true) { 
units_block.style.display = \'none\'; 
//queue_block.style.display = \'none\'; 
//queue_link.style.display = \'none\';
daily_block.style.display = \'block\';
link_nav.setAttribute("href","#daily_provide");	
link_nav.setAttribute("title","'.$lang['settings'].' ('.$lang['daily'].')");
link_nav.innerHTML = \'<i class="icon-cog"></i>\';
} else {
units_block.style.display = \'block\';
//queue_block.style.display = \'block\'; 
//queue_link.style.display = \'block\';
daily_block.style.display = \'none\';
link_nav.setAttribute("href","#units");	
link_nav.setAttribute("title","'.$lang['operation_mode'].' ('.$lang['hourly'].')");	
link_nav.innerHTML = \'<i class="icon-clock-3"></i>\';
}
}
</script>
';

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

	
	
for ($ls = 0; $ls < sizeof($lines_data); ++$ls) { //=========== SEARCH COUNT
$data_search_list = explode('::', $lines_data[$ls]); 

$search_line = $ls+1;
$data_search_name = '';
$data_search_cat = '';

if (isset($data_search_list[1])) {$data_search_name = mb_strtolower($data_search_list[1], 'utf8');}
if (isset($data_search_list[3])) {$data_search_cat = mb_strtolower($data_search_list[3], 'utf8');}

//============================== CATEGORY NAME SEARCH
if (file_exists($file_name_category)) {	
$file_category = fopen($file_name_category, "rb"); 
if (filesize($file_name_category) != 0) { // !0
flock($file_category, LOCK_SH); 
$lines_category_display = preg_split("~\r*?\n+\r*?~", fread($file_category,filesize($file_name_category)));
flock($file_category, LOCK_UN); 
fclose($file_category); 
for ($lcd = 0; $lcd < sizeof($lines_category_display); ++$lcd) { 
if (!empty($lines_category_display[$lcd])) {
$data_categories_disp = explode('::', $lines_category_display[$lcd]); 
$id_cat_sear = $data_categories_disp[0];
$name_cat_sear =  $data_categories_disp[1];
if ($name_cat_sear == $_GET['search']) {$query = $id_cat_sear;} // display cat
} //no empty lines cat
} //count cat
} //else { echo '<span class="red_text">'.$lang['category_empty'].' </span>';} //filesize cat
} //file_exists cat
//============================== /CATEGORY NAME SEARCH


$data_search = $data_search_name. ' ' .$data_search_cat;

if (preg_match('/'.$query.'/i', $data_search)) {
$found = 'yes';






echo '<ul class="list_inc">
<li class="small">'.$search_line.'</li>
<li class="cat_list_filter">'.$data_search_list[1].'</li>
<li></li> 
<li></li>
<li></li>';

echo '<li class="tools"><a href="'.$script_name.'?edit='.$ls.'&amp;id='.$data_search_list[0].'&amp;insearch='.$_GET['search'].'" title="'.$lang['edit'].' ('.$data_search_list[1].')" class="edit"><i class="icon-edit-alt"></i></a></li>';

echo '<li class="tools"><a href="'.$script_name.'?delete='.$ls.'&amp;id='.$data_search_list[0].'&amp;insearch='.$_GET['search'].'" title="'.$lang['delete'].' ('.$data_search_list[1].')" class="delete" onclick ="return confirm(\''.$lang['service'].': &quot;'.$data_search_list[1].'&quot; '.$lang['delete_m'].'. '.$lang['continue'].'?\');"><i class="icon-trash-2"></i></a></li>';


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
?>



<?php include ('footer.php');?>



