<?php //OnRiv booking system || JUNE. 2015 || Autor: Шаклеин Максим (Shaklein Maxim) || www.OnRiv.com (c)
if (!isset($index)) {die;}
if(!isset($onriv_take)) {die();}
$data_services = explode("::", $lines_data_services[$ls]);

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
//------------- new
if (isset($data_services[37])) { $pay_only = $data_services[37];} else { $pay_only = ''; }
if (isset($data_services[38])) { $always_free = $data_services[38];} else { $always_free = ''; }

//-----------------/list services
?>