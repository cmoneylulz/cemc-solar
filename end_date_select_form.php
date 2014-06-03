<?php
/**
 * Created by PhpStorm.
 * User: Christopher Wilson
 * Date: 11/8/13
 * Time: 8:45 AM
 */

$month_list = array ("January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December");

$default_date = getdate();
if (!isset($_GET['date'])) {
    $current_day = $default_date['mday'];
    $current_month = $default_date['mon'];
    $current_year = $default_date['year'];
} else {
    $date_array = explode("-", $_GET['date']);
    $current_year = $date_array[0];
    $current_month = $date_array[1];
    $current_day = $date_array[2];
}
?>
        <label for="end-month-select-form" class="select-label">&nbsp;&nbsp;End Date:&nbsp;</label>
        <select name="end_month" id="end-month-select-form" class="select-custom">
            <?php
            foreach ($month_list as $key=>$month) {
                $value = $key + 1;
                if ($current_month == $value){
                    echo("<option value='".$value."' selected='selected'>".$month."</option>");
                } else {
                    echo("<option value='".$value."'>".$month."</option>");
                }
            }
            ?>
        </select>
        <select name="end_day" id="end-day-select-form" class="select-custom">
            <?php
            for($i=1; $i<32; $i++) {
                if ($current_day == $i){
                    echo("<option value='".$i."' selected='selected'>".$i."</option>");
                } else {
                    echo("<option value='".$i."'>".$i."</option>");
                }
            }
            ?>
        </select>
        <select name="end_year" id="end-year-select-form" class="select-custom">
            <?php
            for($i=$default_date['year']; $i>=2000; $i--){
                if ($current_year == $i){
                    echo("<option value='".$i."' selected='selected'>".$i."</option>");
                } else {
                    echo("<option value='".$i."'>".$i."</option>");
                }
            }
            ?>
        </select>