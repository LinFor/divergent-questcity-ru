jQuery(document).ready(function(){
var search_number = 0;
 var search_count = 0;
 var count_text = 0;
 var srch_numb = 0;
function scroll_to_word(){
 var pos = $('#text .selectHighlight').position();
 jQuery.scrollTo(".selectHighlight", 500, {offset:-50});
 }
$('#search_text').bind('keyup oncnange', function() {
 $('#text').removeHighlight();
 txt = $('#search_text').val();
 if (txt == '') return;
 $('#text').highlight(txt);
 search_count = $('#text span.highlight').size() - 1;
 count_text = search_count + 1;
 search_number = 0;
 $('#text').selectHighlight(search_number);
 if ( search_count >= 0 ) scroll_to_word();
 $('#count').html('Найдено: <b>'+count_text+'</b>');
 });
 
 $('#search_text').ready( function() {
 $('#text').removeHighlight();
 txt = $('#search_text').val();
 if (txt == '') return;
 $('#text').highlight(txt);
 search_count = $('#text span.highlight').size() - 1;
 count_text = search_count + 1;
 search_number = 0;
 $('#text').selectHighlight(search_number);
 if ( search_count >= 0 ) scroll_to_word();
 $('#count').html('Найдено: <b>'+count_text+'</b>');
 });
 
 
$('#clear_button').click(function() {
 $('#text').removeHighlight();
 $('#search_text').val('поиск');
 $('#count').html('');
 });
$('#prev_search').click(function() {
 if (search_number == 0) return;
 $('#text .selectHighlight').removeClass('selectHighlight');
 search_number--;
 srch_numb = search_number + 1;
 $('#text').selectHighlight(search_number);
 if ( search_count >= 0 ) {
 scroll_to_word();
 $('#count').html('Показано: <b>'+srch_numb+'</b> из '+$('#text span.highlight').size());
 }
 });
$('#next_search').click(function() {
 if (search_number == search_count) return;
 $('#text .selectHighlight').removeClass('selectHighlight');
 search_number++;
 srch_numb = search_number + 1;
 $('#text').selectHighlight(search_number);
 if ( search_count >= 0 ) {
 scroll_to_word();
 $('#count').html('Показано: <b>'+srch_numb+'</b> из '+$('#text span.highlight').size());
 }
 });
});