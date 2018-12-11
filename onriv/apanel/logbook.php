<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
include ('header.php');
if (!empty($access) && $access == 'yes') {
	
echo '<div id="main">';		
	
echo '<div id="settings">';	

echo '<div><ul id="tabs_menu">
  <li><a id="tab_link_1" class="tab_link" href="#tab1" onclick="ag_select_tab(1)" title="'.$lang['history_desc'].'">'.$lang['history'].'</a></li>
  <li><a id="tab_link_2" class="tab_link" href="#tab2" onclick="ag_select_tab(2)" title="'.$lang['statistics_desc'].'">'.$lang['statistics'].'</a></li>
  <li><a id="tab_link_3" class="tab_link" href="#tab3" onclick="ag_select_tab(3)" title="'.$lang['clients_desc'].'">'.$lang['clients'].'</a></li>
  <li class="clear"></li>
</ul></div>';

echo '<div id="tabs_body">';  


echo '<div id="tabs_content">'; 

//==============================================TAB1
echo '<div id="tab_1" class="tab_block">';  
include('history.php');  
echo '</div>';

//==============================================TAB2	
echo '<div id="tab_2" class="tab_block">';	
include('statistic.php');
echo '</div>';


//==============================================TAB3	
echo '<div id="tab_3" class="tab_block">';	
include('clients.php');
echo '</div>';
 
echo '</div>'; //tabs_content 

echo '</div>'; //tabs_body

echo '</div>'; //id settings

echo '</div>'; //main
} ?>

<script>
var anc = window.location.hash.replace("#tab","");
if (anc == "") {
document.getElementById("tab_1").className += " current_tab";
document.getElementById("tab_link_1").className += " current_tab_link";
} else {
document.getElementById("tab_"+anc).className += " current_tab";
document.getElementById("tab_link_"+anc).className += " current_tab_link";
}

var tabs = document.getElementsByClassName("tab_block");
var tabs_links = document.getElementsByClassName("tab_link");

function ag_select_tab(sel_ind) {
	
var current_sel_ind = 0;	
for(var t=0; t<tabs.length; t++) {
current_sel_ind = t+1;
if (sel_ind == current_sel_ind) {
tabs[t].className += " current_tab";
tabs_links[t].className += " current_tab_link";
} else {
tabs[t].className = tabs[t].className.replace( /(?:^|\s)current_tab(?!\S)/ , "" );
tabs_links[t].className = tabs_links[t].className.replace( /(?:^|\s)current_tab_link(?!\S)/ , "" );
}//current	
}//count
reheight();
} //func
</script>


<?php include ('footer.php');?>