<?php
/**
 * Created by PhpStorm.
 * User: Christopher Wilson
 * Date: 11/8/13
 * Time: 8:45 AM
 */

    $month_list = array ("January", "February", "March", "April", "May", "June",
                         "July", "August", "September", "October", "November", "December");
    $date = getdate();

    $current_day = $date['mday'];
    $current_month = $date['mon'];
    $current_year = $date['year'];

    $default_date = date('Y-m-d', strtotime('today - 30 days'));
    $date_array = explode("-", $default_date);
    $default_day = $date_array[2];
    $default_month = $date_array[1];
    $default_year = $date_array[0];
?>

    <label for="month-select-form" class="select-label">Start Date:&nbsp;</label>
    <select name="start_month" id="month-select-form" class="select-custom">
    <?php
        foreach ($month_list as $key=>$month) {
            $value = $key + 1;
            if ($value == $default_year){
                echo("<option value='".$value."' selected='selected'>".$month."</option>");
            } else {
                echo("<option value='".$value."'>".$month."</option>");
            }
        }
    ?>
    </select>

    <select name="start_day" id="day-select-form" class="select-custom">
    <?php
        for($i=1; $i<32; $i++) {
            if($i == $default_day){
                echo("<option value='".$i."' selected='selected'>".$i."</option>");
            } else {
                echo("<option value='".$i."'>".$i."</option>");
            }
        }
    ?>
    </select>

    <select name="start_year" id="year-select-form" class="select-custom">
    <?php
        for($i=2012; $i<=$current_year; $i++){
            if($i == $default_year) {
                echo("<option value='".$i."' selected='selected'>".$i."</option>");
            } else {
                echo("<option value='".$i."'>".$i."</option>");
            }
        }
    ?>
    </select>
