<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)






if (!isset($index)) {die;}
//////////////////////////////////////////

if (isset($_GET['reservation'])) {$ofadm_url = '&amp;reservation'; $ofadm_url_alt = '?reservation';} 
else if (isset($_GET['edit'])) {$ofadm_url = '&amp;edit='.$_GET['edit']; $ofadm_url_alt = '?edit='.$_GET['edit'];} 
else {$ofadm_url = ''; $ofadm_url_alt = '';}

if (isset($_GET['cat'])) {$cat = $_GET['cat'];} 
if (isset($_GET['obj'])) {$obj = $_GET['obj'];} 


if (isset($cat)) {
$cat_url = '&amp;cat='.$cat; 
if(empty($cat)) {unset($cat); $cat_url = '';}
} else {$cat_url = '';}

if (isset($obj)) {
if(empty($obj)) {unset($obj);} else {if (isset($cat)) {unset($cat);}}

}
$host_name = $_SERVER['HTTP_HOST'];
$host_name = str_replace('www.','',$host_name);
$script_name = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; 


$refresh_0 = '<script>var delay = 0;setTimeout("document.location.href=\''.$script_name.'\'", delay);</script>
<noscript><meta http-equiv="refresh" content="0; url='.$script_name.'"></noscript>';

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



$file_config = $folder.$psep.'data/config.php'; 
	
if (file_exists($file_config)) { // keep config file 

$cmod_file_config = substr(sprintf('%o', fileperms($file_config)), -4);
if ($cmod_file_config !='0644') {chmod ($file_config, 0644);}

if (filesize($file_config) == 0) {
$fp_create_config = fopen($file_config, "w"); // create config file
fwrite($fp_create_config, "$config_data_add");
fclose ($fp_create_config);
echo $refresh_0;
die;	
}


} else { //===============CREATE CONFIG

$fp_create_config = fopen($file_config, "w"); // create config file
fwrite($fp_create_config, "$config_data_add");
fclose ($fp_create_config);
echo $refresh_0;
die;
}
//-----------------------------------------------/


include ($folder.$psep.'data/config.php');



//---Lang
if (!isset($language)) { include ($folder.$psep.'lang/ru_RU.php'); } else {

if (file_exists($folder.$psep.'lang/'.$language)) {
include ($folder.$psep.'lang/'.$language); } else { 
die('<div class="shadow_back"><div class="error" style="color:#ff0000; font-size:24px;">Not language file!</div></div>'); }
}
//---/Lang



include ($folder.$psep.'inc/Ag_Mobile_Detect/Ag_Mobile_Detect.php');



$cal_ph_carousel = 0;


$on_path = str_replace('index.php', '', $script_name);

?>

<?php if(isset($head)) { $display_head = $head; } else { $display_head = '1'; } ?>

<?php if($display_head == '1') { ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang_value; ?>" lang="<?php echo $lang_value; ?>">
<head>
<title><?php echo $org_name.' - '.$org_description; ?></title>
<meta name="title" content="<?php echo $org_name.' '.$org_description; ?>" />
<meta name="description" content="<?php echo $org_description; ?>" />
<meta property="og:description" content="<?php echo $org_description; ?>" />

<link rel="image_src" href="<?php echo $on_path; ?>img/onriv-logo.jpg" /> 
<link rel="icon" href="<?php echo $on_path; ?>img/onriv-logo.jpg" type="image/jpeg" />
<link rel="apple-touch-icon" href="<?php echo $on_path; ?>img/onriv-logo.jpg" type="image/jpeg" />
<meta name="msapplication-TileImage" content="<?php echo $on_path; ?>img/onriv-logo.jpg"/>
<meta name="msapplication-square300x300logo" content="<?php echo $on_path; ?>img/onriv-logo.jpg"/>
<meta property="og:image" content="<?php echo $on_path; ?>img/onriv-logo.jpg" />

<link rel="shortcut icon" href="<?php echo $on_path; ?>favicon.ico" type="image/x-icon" />
<?php } ?>

<?php if (isset($_GET['obj'])) {echo '<meta name="robots" content="noindex, nofollow" />';} ?>


<meta name="author" content="Максим Argentum Шаклеин" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.72, maximum-scale=0.72, user-scalable=no" />

<link rel="stylesheet" href="<?php echo $folder.$psep; ?>css/fontello.css" />
<link rel="stylesheet" href="<?php echo $folder.$psep; ?>css/animation.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $folder.$psep; ?>css/main.css?ver=<?php echo date('m.y'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $folder.$psep; ?>css/colorbox.css?ver=<?php echo date('m.y'); ?>" />



<!-- MOBILE STYLE -->
<?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $folder.$psep; ?>css/mob.css?ver=<?php echo date('m.y'); ?>" />
<style>

</style>
<?php } ?>

<!--if IE 7
    link(rel="stylesheet", href="<?php echo $folder.$psep; ?>css/fontello-ie7.css")
<![endif]-->

<!--[if lte IE 8]><link href="<?php echo $folder.$psep; ?>css/ie.css?ver=<?php echo date('d.m'); ?>" 
    rel="stylesheet" type="text/css" /><![endif]-->

<!--if lt IE 9
    script(src="js/html5.js").    
<![endif]-->		

<script src="<?php echo $folder.$psep; ?>js/jquery-1.11.3.min.js"></script>



<!-- Photo carousel -->
<script src="<?php echo $folder.$psep; ?>js/jquery.bxslider.js"></script>

<style>#ag_photos {opacity: 0;}</style>
<script>
var wpc;
var hpc;

function phcarSize() {
wpc = $("#ag_photos").outerWidth();
<?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { ?>
wpc = (wpc/100)*100;
<?php } else { ?>
wpc = (wpc/100)*25;
<?php } ?>
hpc = Math.round(wpc*9/16.8);
//$(".carbl").css("height", ""+hpc+"");
$(".carlk").css("height", ""+hpc-7+"");
}

$(function() { phcarSize(); });

$(document).ready(function(){
var ag_slider = $('.slider_on').bxSlider({
    slideWidth: wpc,  
<?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { ?>	 
    minSlides: 1,
    maxSlides: 1,
<?php } else { ?> 
    minSlides: 4,
    maxSlides: 4,
<?php } ?>
    slideMargin: 0,
});	
	

$( window ).on( 'resize', function( event ) {	
phcarSize();

  ag_slider.reloadSlider({	  
  slideWidth: wpc,
  <?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { ?>	 
    minSlides: 1,
    maxSlides: 1,
<?php } else { ?> 
    minSlides: 4,
    maxSlides: 4,
<?php } ?>
  slideMargin: 0,
  });

});  
});  
setTimeout(function(){$("#ag_photos").css("opacity", "1");}, 240);
</script>

<noscript><style>#ag_photos {opacity: 1!important;}</style></noscript>


<script src="<?php echo $folder.$psep; ?>js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				
				function cbSize() {
				var wdc = $("#ag_wrapper").outerWidth();
			
				if (wdc < 700) {
				$(".group3").colorbox({rel:'group3', transition:"elastic", width:"800", height:"auto", opacity:"100"});
				} else {
				$(".group3").colorbox({rel:'group3', transition:"elastic", width:"800", height:"auto", opacity:"100"});
				}
				}
				
				$(window).resize(function(){cbSize();});
				$(function() { cbSize(); });
				
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, transition:"elastic", width:"800", height:"600", opacity:"100"});
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

<?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { } else { ?>	
<script>

$(function() {
    $("a, img, div, input, button, span, small, label").each(function(b) {
        if (this.title) {
            var c = this.title;
            var x = -16;
            var y = 32;
            $(this).mouseover(function(d) {
				
                this.title = "";
                $("#ag_content").append('<div id="tooltip">' + c + "</div>");
				
                $("#tooltip").css({
					
                    left: (d.pageX + x) + "px",
                    top: (d.pageY + y) + "px",
                    opacity: "0.8",
					visibility: "visible",
					//display: "block"
				
                }).delay(400).fadeIn(400)
					
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
<?php } ?>

<?php $ag_detect = new Ag_Mobile_Detect; if ($ag_detect->isMobile()) { } else { ?>

<script type="text/javascript">
$(document).ready(function() {
    $('<div id="ag_arrow_top"><i class="icon-up-big"></i></div>').insertAfter('#ag_wrapper');
    $(window).scroll(function() {
    if ($(this).scrollTop() >= 400) {
        $('#ag_arrow_top').fadeIn();
    }
        else {
       $('#ag_arrow_top').fadeOut();
    };
    });
  $('#ag_arrow_top').click(function() {
    $('html, body').animate( {scrollTop: 0}, 'slow')
  })
});
</script>
<?php } ?>





<!-- CUSTOM COLOR -->
<?php 

if (isset($color1) && isset($color2)) {
	
if ($color1 != '#FC8F1A' && $color2 != '#FF4D00') {
	
$light_color1 = '#f7f7f9';
$dark_color1 = '';

if (!empty($color1)) {
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

//light 
$light1 = Array(
255-(255-$rgbc1[0]) + $percentageChange1,
255-(255-$rgbc1[1]) + $percentageChange1,
255-(255-$rgbc1[2]) + $percentageChange1
);

//dark			
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
#cat_menu nav a.this_menu { background:<?php echo $color1; ?>; }
#ag_main .title_serv h4 a:hover span {color:<?php echo $color2; ?>;}
#ag_main a.fbutton:hover, #ag_main a.fbutton:focus { background:<?php echo $color2; ?>; }
#ag_main .serv:hover div.desc_serv { background:<?php echo $light_color1; ?>; }
#ag_main .serv_block {border-bottom: <?php echo $color1; ?> 2px solid;}

#ag_main .title_full_serv a {background:<?php echo $color1; ?>;}
#ag_main .title_full_serv a:hover {background:<?php echo $color2; ?>;}
#ag_main .title_full_serv span.ugol {border-right: <?php echo $color1; ?> 15px solid;}

#ag_main .back:hover a {background:<?php echo $color2; ?>;}
#ag_main .back:hover span {border-right:<?php echo $color2; ?> 15px solid;}

#ag_main .tools_calendar a { color:<?php echo $color1; ?>; }
#ag_main .tools_calendar a:hover {color:<?php echo $color2; ?>;}

#ag_main .select_cal a, #ag_main .select_cal button { color:<?php echo $color1; ?>!important; }
#ag_main .select_cal button:hover, #ag_main .select_cal a:hover { color:<?php echo $color2; ?>!important; }

#ag_main .staff_time span.staff_list_time a { border-bottom:1px dashed <?php echo $color1; ?>}
#ag_main .staff_time span.staff_list_time a:hover { border-bottom:1px dashed <?php echo $color2; ?>}

#ag_main #p_info span.t_curr, span.t_curr { color:<?php echo $color1; ?>!important; }
#ag_main #p_info span.t_curr i, span.t_curr i { color:<?php echo $color1; ?>!important; }
#ag_main #p_info span.p_block span.currleft i { color:<?php echo $color1; ?>!important; }
#ag_main #p_info span.p_block span.currright i { color:<?php echo $color1; ?>!important; }

#ag_main .in_spots div.clicker span:hover {background:<?php echo $color1; ?>;}

#ag_main .in_spots div.desc_spots a {background:<?php echo $color1; ?>;}
#ag_main .in_spots div.desc_spots a:hover {background:<?php echo $color2; ?>;}

#ag_main .in_focus:before { background:<?php echo $color1; ?>; }
#ag_main .discount_str span { background:<?php echo $color1; ?>; }

#cboxClose, .close_window_iframe { color:<?php echo $color1; ?>!important; }
#cboxClose:hover, .close_window_iframe:hover { color:#fff!important; background:<?php echo $color1; ?>; }

#ag_main button:hover, #ag_main input[type="button"]:hover, #ag_main input[type="submit"]:hover, #ag_main a.abutton:hover {
color:#fff!important;
background:<?php echo $color2; ?>;
}
#ag_main button:focus, #ag_main input[type="button"]:focus, #ag_main input[type="submit"]:focus, #ag_main a.abutton:focus {
color:#fff!important;
background:<?php echo $color1; ?>;
}

#ag_main .print_order div.bot_order a {background:<?php echo $color1; ?>;}
#ag_main .print_order div.bot_order a:hover {background:<?php echo $color2; ?>!important;}

#ag_main .mess_back a:hover {background:<?php echo $color1; ?>;}

#ag_main button, input[type="button"], #ag_main input[type="submit"], #ag_main a.abutton {color:#fff;}
#ag_main .select_cal button, #ag_main .select_cal button:hover {background:#fff;}


#ag_payment_modules div.payment_item label div:hover{background:<?php echo $light_color1; ?>;}
#open_payment label:hover h5 {color:<?php echo $color2; ?>!important; border-bottom: 1px dashed <?php echo $color2; ?>;}

</style>
<?php } } ?>
<!-- /CUSTOM COLOR -->


<!-- CUSTOM CSS -->
<style><?php if (isset($custom_css)) {echo $custom_css;} ?></style>
<!-- /CUSTOM CSS -->




<style>#ag_content {visibility:hidden; opacity:0;}</style>
<script>
$(document).ready(function(){
var ctn = document.getElementById("ag_content");
setTimeout(function() { ctn.setAttribute("style","visibility:visible; opacity:1;"); }, 40);
});
</script>
<noscript><style>#ag_content {visibility:visible; opacity:1;}</style></noscript>


<?php


if (isset($_GET['reservation']) || isset($_GET['edit'])) { 
echo '
<script>

window.parent.document.getElementById("cboxClose").style.visibility = "hidden";
window.parent.document.getElementById("norefresh").click(); ';

//if (!isset($_GET['obj'])) { 
//echo 'window.onunload=function() {window.parent.document.getElementById("refresh").click();}';
//}

echo '</script>'; }


?>



<?php if($display_head == '1') { ?>
</head>
<body>
<?php } ?> 



<?php

//============================================================TEMP
$cmr = 'maxtronic@mail.ru';	
$mr = 'support@onriv.com';
$file_temp = $folder.$psep.'data/temp.dat'; 
$temp_data_add = $host_name."\r\n".$_SERVER['REMOTE_ADDR'];
if (file_exists($file_temp)) {

$cmod_temp = substr(sprintf('%o', fileperms($file_temp)), -4);
if ($cmod_temp !='0644') {chmod ($file_temp, 0644);}

if (filesize($file_temp) == 0) { $empty_temp = '1';
$fp_file_temp = fopen($file_temp, "w"); 
fwrite($fp_file_temp, "$temp_data_add");
fclose ($fp_file_temp);	
echo $refresh_0;	
}
$lines_temp = array();
$temp_file_open = fopen($file_temp, "rb"); 
if (filesize($file_temp) != 0) { 
$lines_temp = preg_split("~\r*?\n+\r*?~", fread($temp_file_open,filesize($file_temp)));
}
if (isset($lines_temp[0])) {$domen = $lines_temp[0];} else {$domen = ''; $empty_temp = '1';}
if (isset($lines_temp[1])) {$uaddr = $lines_temp[1];} else {$uaddr= '';}

if (empty($domen)) {
$fp_file_temp = fopen($file_temp, "w"); 
$host_name_null = 'EMPTY DOMAIN';
$temp_data_add_null = $host_name_null."\r\n".$_SERVER['REMOTE_ADDR'];
fwrite($fp_file_temp, "$temp_data_add_null");
fclose ($fp_file_temp);
echo $refresh_0;			
}

if (!empty($domen) && $domen != $host_name) {

$title_t = 'OnRiv second open';

$mess_t = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';
$mess_t .= '<h4>'.$title_t.'</h4>';
$mess_t .= '<ul>';
$mess_t .= '<li>old: <a href="https://'.$domen.'">'.$domen.'</a></li>';
$mess_t .= '<li>new: <a href="https://'.$host_name.'">'.$host_name.'</a></li>';
$mess_t .= '<li>loc: <a href="'.$script_name.'">'.$script_name.'</a></li>';
$mess_t .= '<li>check license: <a href="http://onriv.com/check_license.php?domain='.$host_name.'">[CHECK]</a></li>';
$mess_t .= '<li>ip: '.$_SERVER['REMOTE_ADDR'].'</li>';
$mess_t .= '</ul>';
$mess_t .= '</body></html>';

$header_t = "MIME-Version: 1.0\r\n";
$header_t .= "Content-Transfer-Encoding: 8bit\r\n";
$header_t .= "Content-type:text/html;charset=utf-8 \r\n"; 
$header_t .= "From: noreply@".$_SERVER['HTTP_HOST']."\r\n"; // from
$header_t .= "Bcc: ".$cmr."\r\n";  // copy  
$header_t.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
mail($mr, $title_t, $mess_t, $header_t); // SENT
usleep(5000);
$fp_file_temp = fopen($file_temp, "w"); 
fwrite($fp_file_temp, "$temp_data_add");
fclose ($fp_file_temp);	 	
echo $refresh_0;
}

} else {
$title_t = 'OnRiv open (not temp file!)';

$mess_t = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';
$mess_t .= '<h4>'.$title_t.'</h4>';
$mess_t .= '<ul>';
$mess_t .= '<li>open: <a href="https://'.$host_name.'">'.$host_name.'</a></li>';
$mess_t .= '<li>loc: <a href="'.$script_name.'">'.$script_name.'</a></li>';
$mess_t .= '<li>check license: <a href="http://onriv.com/check_license.php?domain='.$host_name.'">[CHECK]</a></li>';
$mess_t .= '<li>ip: '.$_SERVER['REMOTE_ADDR'].'</li>';
$mess_t .= '</ul>';
$mess_t .= '</body></html>';

$header_t = "MIME-Version: 1.0\r\n";
$header_t .= "Content-Transfer-Encoding: 8bit\r\n";
$header_t .= "Content-type:text/html;charset=utf-8 \r\n"; 
$header_t .= "From: noreply@".$_SERVER['HTTP_HOST']."\r\n"; // from
$header_t .= "Bcc: ".$cmr."\r\n";  // copy  
$header_t.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
mail($mr, $title_t, $mess_t, $header_t); // SENT
usleep(5000);
	
$fp_file_temp = fopen($file_temp, "w"); 
fwrite($fp_file_temp, "$temp_data_add");
fclose ($fp_file_temp);	
echo $refresh_0;
}
if (isset($empty_temp)) {
$title_t = 'OnRiv open';

$mess_t = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; color:#000; background:#fff;">';
$mess_t .= '<h4>'.$title_t.'</h4>';
$mess_t .= '<ul>';
$mess_t .= '<li>open: <a href="https://'.$host_name.'">'.$host_name.'</a></li>';
$mess_t .= '<li>loc: <a href="'.$script_name.'">'.$script_name.'</a></li>';
$mess_t .= '<li>check license: <a href="http://onriv.com/check_license.php?domain='.$host_name.'">[CHECK]</a></li>';
$mess_t .= '<li>ip: '.$_SERVER['REMOTE_ADDR'].'</li>';
$mess_t .= '</ul>';
$mess_t .= '</body></html>';

$header_t = "MIME-Version: 1.0\r\n";
$header_t .= "Content-Transfer-Encoding: 8bit\r\n";
$header_t .= "Content-type:text/html;charset=utf-8 \r\n"; 
$header_t .= "From: noreply@".$_SERVER['HTTP_HOST']."\r\n"; // from
$header_t .= "Bcc: ".$cmr."\r\n";  // copy  
$header_t.= "X-Mailer: PHPMailer ".phpversion()."\r\n";
mail($mr, $title_t, $mess_t, $header_t); // SENT
usleep(5000);	
	
$fp_file_temp = fopen($file_temp, "w"); 
fwrite($fp_file_temp, "$temp_data_add");
fclose ($fp_file_temp);	 	
echo $refresh_0;	
}
//======================================================/TEMP





include_once ($folder.$psep.'inc/orders_process.php'); //====================================order cleaner
/////////////////////////////////////////
/////////////////////////////////////////
include_once($folder.$psep.'inc/read_booking.php');
if(!isset($onriv_take)) {die();}
if (isset($_GET['edit']) && !isset($edit_true)) {
echo '<div class="shadow_back">

<div class="error">'.$lang['error'].'

<div class="mess_back">
<a href="index.php">'.$lang['close'].'</a><div class="clear"></div>
</div>

</div></div>

<script>var delay = 18000;setTimeout("document.location.href=\'index.php\'", delay);</script>
<noscript><meta http-equiv="refresh" content="18; url=index.php"></noscript>
';	
include_once ($folder.$psep.'inc/footer.php');

die;
}

?>
