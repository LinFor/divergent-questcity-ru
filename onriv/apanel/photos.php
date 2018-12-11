<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
header("Content-Type: text/html; charset=utf-8"); 
include ('header.php');

echo '<div id="main">';

include ('../inc/translit.php');

$upload_form = '';
$class_thumbs = '';
$dir_name = '';

if (!empty($access) && $access == 'yes') { 

$dir  = 'data/upload_photo'; //====================ROOT UPLOAD

$photo_id = date('d_m_Y_H_i_s');

if (isset($_GET['dir'])===true && empty($_GET['dir'])){
	
echo'
<script>
    var delay = 0;
    setTimeout("document.location.href=\''.$script_name.'?dir='.$dir.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'?dir='.$dir.'"></noscript>
';		
}

$iframe_url = ''; $iframe_url_alt = '';

if (isset($_GET['iframe'])==true) {$iframe_url = '?iframe'; $iframe_url_alt = '&iframe';}

if (isset($_GET['iframe'])==true && isset($_GET['img'])==true) {$iframe_url = '?iframe&img='.$_GET['img']; $iframe_url_alt = '&iframe&img='.$_GET['img'];}  //== IFRAME & #img



//========================DELETE DIR
if (isset($_GET['delete'])==true) {
	
if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; 
echo'
<script>
    var delay = 3000;
    setTimeout("document.location.href=\''.$script_name.$iframe_url.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.$iframe_url.'"></noscript>
';	
} else {	

exec('rm -rf '.'../'.$_GET['delete']);

if (isset($_GET['iframe'])==true) {
echo '<div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div>';}
else {
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';}

echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.$iframe_url.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.$iframe_url.'"></noscript>
';	
} //staff access		
}//-----------------------/delete dir

//========================DELETE IMG FILE

if (isset($_GET['delete_file'])==true) {
	
if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; 
echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'"></noscript>
';	
} else {
	
unlink('../'.$_GET['delete_file']);

if (isset($_GET['iframe'])==true) {
echo '<div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div>';}
else {
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';}

echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'"></noscript>
';	
} //staff access
		
}
//-----------------------/delete img



//================================================IMAGE UPLOAD
include ('class.upload.php');
if (isset($_GET['dir']) == true) {
$dir_dest = (isset($_GET['tdir']) ? $_GET['tdir'] : '../'.$_GET['dir']); 
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

$allow_file_types = array('png', 'jpg', 'jpeg', 'gif', 'bmp');

if ((isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '')) == 'image') {


// check format	
if (isset($_FILES['image_field']['name']) && !empty($_FILES['image_field']['name'])) {
$path_info = pathinfo($_FILES['image_field']['name']);

$path_info['extension'] = mb_strtolower($path_info['extension']); }

if (isset($_FILES['image_field']['name']) && !empty($_FILES['image_field']['name']) && in_array($path_info['extension'], $allow_file_types)) 
{ //============================================================== type file allow

$handle = new upload($_FILES['image_field']);

if ($handle->uploaded) 
{
// ===

$handle->file_new_name_body = 'image_resized';
$handle->image_resize = true;
$handle->image_x = 800;
$handle->image_ratio_y = true;
$handle->process($dir_dest); 



if ($handle->processed) 
{
//===================================== upload done
$no_image_stop = ''; // if this no image!

$path_info_uploated = pathinfo($dir_pics .  "/" . $handle->file_dst_name);


if (!in_array($path_info_uploated['extension'], $allow_file_types)) {$no_image_stop = 'stop';  unlink($dir_pics .  "/" . $handle->file_dst_name);}

if ($no_image_stop != 'stop') { 
$filem = $handle->file_dst_name;
$fm = explode(".", $filem); 
rename ( $dir_pics .  "/" . $handle->file_dst_name, $dir_pics .  "/" . $_POST['imgname'].".".array_pop($fm) );
}

if (isset($_GET['iframe'])==true) {
echo '<div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div>';}
else {
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';}


echo'
<script>
var delay = 500;
setTimeout("document.location.href=\''.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'&img_id='.$_POST['imgname'].'#'.$_POST['imgname'].'\'", delay);
</script>
<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'&img_id='.$_POST['imgname'].'#'.$_POST['imgname'].'"></noscript>';			
}	

			
			
$handle->clean();
} else {
//echo 'error : ' . $handle->error; 
//===================================== upload error

if (isset($_GET['iframe'])==true) {
echo '<div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div>';}
else {
echo '<div class="shadow_back"><div class="modal_mess error">'.$lang['error_upload'].'</div></div>';}

echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'"></noscript>
';			
}			

} //===type file 

else { 
echo '<div class="shadow_back"><div class="modal_mess error">'.$lang['error_upload_type'].'</div></div>';
echo'
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'"></noscript>
';		

} // ceck type file		


} // submit file





$upload_form .= '<div class="fieldset" id="upload_block">
<form name="upload" id="upload_form" enctype="multipart/form-data" method="post" action="'.$script_name.'?dir='.$_GET['dir'].$iframe_url_alt.'" />

            <div class="input_file">
			<span id="select_img" tabindex="1" onclick="selectFile()">'.$lang['select_file'].'</span>
			<input type="file" size="32" name="image_field" value="" id="input_img" onchange="oninputImg()" />
			
			<div id="progress_upload"></div>
<script src="../js/upload_progress.js"></script>  
			</div>';
			
		
		
		
		
$upload_form .= '<div class="button" id="upload_button">
			<input type="hidden" name="action" value="image" />
			<input type="hidden" name="imgname" value="'.$photo_id.'" />
            <button id="upimg"><i class="icon-upload"></i>'.$lang['upload'].'</button></div>
        </form>
<div class="clear"></div>

</div>';

$upload_form .= '<script>
function oninputImg() {
var photoFile = document.getElementById("input_img").value;
if (photoFile != \'\') {
	//var string = \'C:\fakepath\';
photoFile = photoFile.replace(/.+[\\\/]/, "");	
document.getElementById("select_img").innerHTML = photoFile;

var delay = 200;
setTimeout(document.getElementById("upimg").click(), delay);	

}
else {document.getElementById("select_img").innerHTML = \''.$lang['select_file'].'\';}
}

function selectFile() {
document.getElementById("input_img").click();
}
</script>';


}// isset get dir

//--------------------------upload


if (isset($_GET['iframe'])) { 

echo'<div id="false_scrool"></div>';

echo '<div class="title_edit">
<h3>'.$lang['photos'].'</h3>
<div class="clear"></div>';

echo '<button type="button" onclick="closeIframe()" class="close_window_iframe" title="'.$lang['close'].'"><i class="icon-cancel-1"></i></button>';
echo '
<script>
window.parent.document.getElementById("cboxClose").style.visibility=\'hidden\';
function closeIframe() {
var delay = 200;
setTimeout(window.parent.document.getElementById("cboxClose").click(), delay);
}
</script>';
echo '</div>'; 

echo '<div id="photo_list">'; 

} 
else {echo '<div id="photo_list" style="margin: 7px auto 14px auto;">';}




echo'<div class="upload_block">';

if (isset($_GET['dir'])==true) {

$dir_dir = explode('/',$_GET['dir']);

//==============Dir name translite
if ($lang_name == 'Русский') {$current_dir = eng2translit(array_pop($dir_dir));} else {$current_dir = array_pop($dir_dir);}
//-------------/dir name
	

echo'
<div class="top_upload_form">
<i class="icon-folder-open"></i><h3 class="dir_name">'.$current_dir.'</h3>
<a href="photos.php'.$iframe_url.'" class="back" title="'.$lang['back'].'"><i class="icon-reply"></i></a>
<div class="clear"></div>
</div>';

echo'<div class="upload_form">';
echo $upload_form;
echo '</div>';


} else {
	
echo '<div class="top_upload_form">
<i class="icon-folder-close"></i><h3>'.$lang['photo_catalog'].'</h3>
<div class="clear"></div>
</div>';

echo'<div class="upload_form">';

echo '<div class="fieldset">
<form name="crfl" method="post" action="" />
<div class="input_file">
<input type="text" name="create_folder" value="'.$lang['create_new_folder'].'" onblur="if (this.value == \'\')  {this.value = \''.$lang['create_new_folder'].'\';}" onfocus="if (this.value == \''.$lang['create_new_folder'].'\') {this.value = \'\';}"/>
</div>
<div class="button">
<button><i class="icon-folder-close"></i>'.$lang['add_folder'].'</button>
</div>
</form>

<div class="clear"></div>
</div>
';

echo '</div>';
}


echo'<div class="clear"></div></div>';


//===========================================ITERATOR
$path = realpath('../');

if (isset($_GET['dir'])) {
	
	if (strpos($_GET['dir'], '.') === false) {} else { die(); } //!FIX
    $dir = $_GET['dir'] . '/';
	$dir = str_replace('.', '', $dir);
}
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    $file     = new SplFileObject($filePath);
    var_dump($file);
	
}
$path = realpath($path . '/' . $dir);


$allowedExtensions  = array(
    'jpg',
	'jpeg',
	'gif',
    'png',
	'bmp'
);

$excludeDirectories = array(
    '.php'
);

if(is_dir($path)) { //=================== CHECK THIS DIRECTORY

$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CATCH_GET_CHILD);

foreach ($objects as $name => $object) { //==================================/count elements 
	
	

if ($object->isDir() && !in_array($object->getFilename(), $excludeDirectories)) {
if ($object->getFilename()=='..' || $object->getFilename()=='.') continue;



if (isset($_POST['create_folder'])==true) {
$realdir = $object->getFilename();
$realdir = mb_strtolower($realdir);

$adddir = rus2translit($_POST['create_folder']);
$adddir = mb_strtolower($adddir);
if($adddir == $realdir) {$ERROR['create_folder']['text'] = '('.eng2translit($realdir).') '.$lang['error_found_folder'];}	
}



//==============Dir name translite
if ($lang_name == 'Русский') {$dir_name = eng2translit($object->getFilename());} else {$dir_name = $object->getFilename();}
//-------------/dir name

if (isset($_GET['dir_id'])) {
if ($_GET['dir_id'] == $object->getFilename()) {$class_thumbs = 'element_create';} else {$class_thumbs = '';}
}	

echo '<div class="thumbs_block '.$class_thumbs.'" id="'.$object->getFilename().'">';

echo '<div class="display_id" id="position'.$object->getFilename().'"></div>';

echo'<div class="thumbs">';
		
if (isset($_GET['iframe'])==true) {
echo '<a href="'.$iframe_url.'&dir=' . $dir .'/'. $object->getFilename() . '" class="folder"><span><i class="icon-folder-close"></i></span><span class="dir_name">' . $dir_name . '</span></a>';
} else {		
echo '<a href="?dir=' . $dir .'/'. $object->getFilename() . '" class="folder"><span><i class="icon-folder-close"></i></span><span class="dir_name">' . $dir_name . '</span></a>';}



$del_url = '?delete';

if (isset($_GET['iframe'])==true) {	$del_url = '?iframe&delete';}

if (isset($_GET['img'])==true && isset($_GET['iframe'])==true) {$del_url = '?iframe&img='.$_GET['img'].'&delete';} 




echo '<div class="tools_folder">
<a href="'.$del_url.'='.$dir.'/'.$object->getFilename().'" class="delete '.$class_thumbs.'" title="'.$lang['delete'].' '.$lang['to_folder'].' '.$dir_name.'" onclick="return confirm(\''.$lang['delete_folder'].' '.$lang['continue'].'? ('.$lang['delete'].' '.$lang['to_folder'].' '.$dir_name.')\');"><i class="icon-trash-2"></i></a>
</div>
</div></div>';

    } else {
        if (in_array($object->getExtension(), $allowedExtensions)) {
			if ($object->getFilename()=='..' || $object->getFilename()=='.') continue;
			
//============================================================================================display img 

			$id_img = str_replace($allowedExtensions,'',$object->getFilename());
			$id_img = str_replace('.','',$id_img);
		
$arr_id = explode('_', $id_img);

$day_add = $arr_id[0];
$month_add = $arr_id[1];
$year_add = $arr_id[2];
$hours_add = $arr_id[3];
$minuts_add = $arr_id[4];
$seconds_add = $arr_id[5];

if ($day_add == date('d') && $month_add == date('m') && $year_add == date('Y')) {
//echo '<div class="clear"></div>';
} 

if (isset($_GET['img_id'])) {
if ($_GET['img_id'] == $id_img) {$class_thumbs = 'element_create';} else {$class_thumbs = '';}
}	
	

	
echo '<div class="thumbs_block '.$class_thumbs.'">';

echo '<div class="display_id" id="'.$id_img.'"></div>';

echo '<div class="thumbs">';
echo '<div class="dt_add">
<span class="date_add">'.$day_add.'.'.$month_add.'.'.$year_add.'</span>
<span class="time_add"> '.$hours_add.':'.$minuts_add.':'.$seconds_add.'</span>
<div class="clear"></div>
</div>
<div class="dt_add_bottom_line '.$class_thumbs.'"></div>';


if (isset($_GET['img'])==false && isset($_GET['iframe'])==true) {echo '<div class="click_img '.$class_thumbs.'" onclick="OpenWin'.$id_img.'()" id="ins_'.$id_img.'" title="'.$lang['select'].'"><i class="icon-plus-1"></i></div>';} 

if (isset($_GET['img'])==true && isset($_GET['iframe'])==true) {echo '<div class="click_img '.$class_thumbs.'" onclick="OpenWin_array'.$id_img.'('.$_GET['img'].')" id="ins_'.$id_img.'" title="'.$lang['select'].'"><i class="icon-plus-1"></i></div>';}



echo '<a href="../'.$dir.''. $object->getFilename().'" class="group3 shadow_img"><img src="../'.$dir.''. $object->getFilename().'" alt="" /></a>';



$del_url = 'delete_file';

if (isset($_GET['iframe'])==true) {$del_url = 'iframe&delete_file';} else {$del_url = 'delete_file';}

if (isset($_GET['img'])==true && isset($_GET['iframe'])==true) {$del_url = 'iframe&img='.$_GET['img'].'&delete_file';}




echo '<div class="tools_folder">
<a href="?dir='.$_GET['dir'].'&'.$del_url.'='.$dir.$object->getFilename().'" class="delete '.$class_thumbs.'" title="'.$lang['delete'].' '.$lang['photo'].' '.$dir_name.'" onclick ="return confirm(\''.$lang['delete'].' '.$lang['photo'].'?\');"><i class="icon-trash-2"></i></a>
</div>
</div></div>';

$ins_ph = $object->getFilename();


echo '
<script>
function OpenWin'.$id_img.'(str)
{
var str = \''.$dir.''. $ins_ph.'\';	
var Inp=window.parent.document.getElementById("photoInput");
Inp.value=str;
window.parent.document.getElementById("selectPhoto").innerHTML = \'<img src="../\'+str+\'" />\';
var delay = 100;
setTimeout(window.parent.document.getElementById("cboxClose").click(), delay);
}
</script>';


echo '
<script>
function OpenWin_array'.$id_img.'(idPh)
{
var strs = \''.$dir.''. $ins_ph.'\';	
var Inps = window.parent.document.getElementById(\'photoInput_\'+idPh);
Inps.value=strs;
window.parent.document.getElementById(\'selectPhoto_\'+idPh).innerHTML = \'<img src="../\'+strs+\'" />\';
var delay = 100;
setTimeout(window.parent.document.getElementById("cboxClose").click(), delay);
}
</script>';


//====================================INSERT NEW IMG

if (isset($_GET['iframe'])==true && isset($_GET['img_id'])==true) {
echo '
<script>
var delay = 100;
setTimeout(document.getElementById("ins_'.$_GET['img_id'].'").click(), delay);
</script>';
}

//------------------------------------/insert img





        }
    }
} //==================================/count elements 
} // === chesk this directory
//===========================================/ITERATOR
else {
echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_this_dir'].' ('.$_GET['dir'].')</div></div>'; 
echo'
<script>
    var delay = 3000;
    setTimeout("document.location.href=\''.$script_name.$iframe_url.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.$iframe_url.'"></noscript>
';		
}



//==============================CREATE DIR
if (isset($_POST['create_folder'])==true) {
	
if ($access_level == 'staff') { echo '<div class="shadow_back"><div class="error modal_mess">'.$lang['error_access'].'</div></div>'; 
echo'
<script>
    var delay = 3000;
    setTimeout("document.location.href=\''.$script_name.$iframe_url.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.$iframe_url.'"></noscript>
';	
} else {

//unset($ERROR); //=====error create

if (preg_match("/[^a-zA-Z0-9а-яА-Я ]/u", $_POST['create_folder'])) {$ERROR['create_folder']['text'] = $lang['error_symbol_folder'];}
if (empty($_POST['create_folder']) || $_POST['create_folder'] == $lang['create_new_folder']) {$ERROR['create_folder']['text'] = $lang['error_folder_empty'];}




if (isset($ERROR) && is_array($ERROR)) {
	
if (isset($_GET['iframe'])==true) {		
echo '<div class="modal_mess error"><ul>';
foreach($ERROR as $key => $value){ echo '<li>'.$ERROR[$key]['text'].'</li>'; }
echo '</ul></div>'; 
} else {
echo '<div class="shadow_back"><div class="modal_mess error"><ul>';
foreach($ERROR as $key => $value){ echo '<li>'.$ERROR[$key]['text'].'</li>'; }
echo '</ul></div></div>'; }

echo'
<script>
var delay = 3000;
setTimeout("document.location.href=\''.$script_name.$iframe_url.'\'", delay);
</script>
<noscript><meta http-equiv="refresh" content="3; url='.$script_name.$iframe_url.'"></noscript>'; 
	
} else {

$folder_id = rus2translit($_POST['create_folder']);
$folder_id = mb_strtolower($folder_id);
chdir ('../'.$dir); //path
mkdir ($folder_id, 0755); //name & attr

if (isset($_GET['iframe'])==true) {
echo '<div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div>';
echo' 
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.$iframe_url.'&dir_id='.$folder_id.'#'.$folder_id.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.$iframe_url.'&dir_id='.$folder_id.'#'.$folder_id.'"></noscript>';		

} else {
echo '<div class="shadow_back"><div class="modal_wait"><i class="icon-spin5 animate-spin"></i></div></div>';
echo' 
<script>
    var delay = 1000;
    setTimeout("document.location.href=\''.$script_name.$iframe_url.'?dir_id='.$folder_id.'#position'.$folder_id.'\'", delay);
    </script>
	<noscript><meta http-equiv="refresh" content="1; url='.$script_name.$iframe_url.'?dir_id='.$folder_id.'#position'.$folder_id.'"></noscript>';	
}

	
}

} //staff access
 
} //===== post new folder
 

//-----------------------------cerate dir




} // access

echo '<div class="clear"></div></div>';

echo '<div class="clear"></div>
</div>'; //main

include ('footer.php');
?>