<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)



?>



<?php if (isset($_GET['edit']) || isset($_GET['reservation']) || isset($_GET['confirm'])) { } else { ?>
<!-- <div id="ag_footer"><a href="<?php echo $folder.$psep; ?>apanel/"><?php echo $lang['admin_title']; ?></a></div> -->
<?php } ?>


<?php
//======================================ADAPTIVE STYLE WIDTH & HEIGHT SERVICES BLOCKS JS

echo '<script>';

echo' 
function adaptive() {
	
var wb = document.getElementById("ag_main").clientWidth;
var wr = document.getElementById("ag_wrapper");

if (wb < 900) {wr.style.width = "100%";}
else if (wb > 1600) {wr.style.width = "50%";} 
else {wr.removeAttribute("style");}';

if(!isset($obj)) {
echo '	
var ws = document.getElementsByClassName("serv")[0].clientWidth;
var wb = ws - 14;
var hwb = wb + 28;
var all_ws = document.getElementsByClassName("serv");
var sb = document.getElementsByClassName("serv_block");
var all_ph = document.getElementsByClassName("one_photo");
var img = document.getElementsByClassName("serv_img");
var hts = document.getElementsByClassName("hts");
var all_count = all_ph.length;	
var pp = ws*9/16.8;
var h_img = Math.round(pp);
var h_sb = h_img+159;
var h_serv = h_sb+14;
var fb = document.getElementsByClassName("front_button");

var title_bl = document.getElementsByClassName("title_serv");
var desc_bl = document.getElementsByClassName("desc_serv");

var h_title;
var h_desc;
setTimeout (function() {
for(var t=0; t<all_ph.length; t++) {
h_title = title_bl[t].clientHeight;
h_desc = 108 - h_title + 50;
desc_bl[t].setAttribute("style","height:"+h_desc+"px;");	
}
}, 240);

for(var i=0; i<all_count; i++) {

all_ph[i].setAttribute("style","height:"+h_img+"px;");
img[i].setAttribute("style","min-height:"+h_img+"px;");
sb[i].setAttribute("style","height:"+h_sb+"px; width:"+wb+"px;");
all_ws[i].setAttribute("style","height:"+h_serv+"px;");
if (ws < 180) {hts[i].setAttribute("style","font-size:16px;"); fb[i].setAttribute("style","text-align:center;");} 
else {hts[i].removeAttribute("style"); fb[i].removeAttribute("style");}';

if (isset($num_links_menu)) {  

if ($num_links_menu < 2) { //---------------count links in cat menu
echo '
var db = document.getElementById("ag_main");
db.setAttribute("style","margin-top:0px;");';

if(!isset($obj) && !isset($cat)) {	
echo '
var men = document.getElementById("cat_menu");
men.setAttribute("style","display:none; visibility:hidden;");
';}

} else { //---------------count links in cat menu 
echo '	
var mh = document.getElementById("cat_menu").clientHeight;
var db = document.getElementById("ag_main");
var men = document.getElementById("cat_menu");
var nav = document.getElementsByTagName("nav")[0].clientWidth+14;
var dbw = db.clientWidth;

var lk = document.getElementsByClassName("scrollto");
var count_lk = lk.length;	
var navw = 0;
for(var l=0; l<count_lk; l++) {
navw += lk[l].clientWidth;
}

//document.getElementById("log").innerHTML = navw+" / "+dbw;
if (navw > dbw) {
men.setAttribute("style","visibility:hidden;");
db.setAttribute("style","margin-top:0px;");} 
else {
men.setAttribute("style","visibility:visible;");
db.setAttribute("style","margin-top:"+mh+"px;");}
';}
} //num links menu

echo '}';





} else { //----------------------get (select service)



if ($cal_ph_carousel == 0) {
echo '
//single obj photos

var phbl = document.getElementsByClassName("phbl");
var phlk = document.getElementsByClassName("phlk");
var wphbl = document.getElementsByClassName("phbl")[0].clientWidth;	
var h_ph = Math.round(wphbl*9/16.8);
var h_lk = h_ph - 7;

for(var p=0; p<phbl.length; p++) {
phbl[p].setAttribute("style","height:"+h_ph+"px;");
phlk[p].setAttribute("style","height:"+h_lk+"px;");
}

//return false;  
';	} // >8


}

echo '}';

//============================================================ resize window

echo '
window.onresize = function(){
adaptive();
}
window.onbeforeunload = adaptive(); 
';
echo '</script>';
?>



<?php



//=============NAVIGATION SCROLL CATEGORYS MENU JS



if(!isset($obj)) { ?>

<?php if($display_head == '1') { ?>
<script>
$(document).ready(function(){

$(".scrollto").on("click", function (event) {
var hm = $("#cat_menu").height();	

		event.preventDefault();
		var id  = $(this).attr("href"),
	    top = $(id).offset().top-hm-14; 
		$('html, body').animate( {scrollTop: top}, 400);
		$(".scrollto").removeClass("this_menu");
		$(".scrollto").removeClass("this");
		$(this).addClass("this_menu");
        setTimeout(function(){$(".this_menu").addClass("this");}, 430);

return false;	
});

});

$(window).scroll(function() { 
$(".this").removeClass("this_menu");
$(".this").removeClass("this");
});
</script>
<?php } ?>

<?php } else { //=============//NAVIGATION SCROLL CATEGORYS JS ?>

<?php } ?>



</body>
</html>