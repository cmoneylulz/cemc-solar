<?php
/**
 * Created by PhpStorm.
 * User: cwilson
 * Date: 1/3/14
 * Time: 8:24 AM
 */

$connection = odbc_connect('TWACS','DCSI','DCSI');

if (!$connection)
{
    exit("Connection Failed: " . $connection);
}

if (!isset($_POST['start_date'])){
    $start_date = date('Y-m-d', strtotime('today - 30 days'));
} else {
    $start_date = $_POST['start_date'];
}

if (!isset($_POST['end_date'])){
    $date = getdate();
    $current_year = $date['year'];
    $end_date = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
} else {
    $end_date = $_POST['end_date'];
}

$query = "SELECT * FROM DCSI.METERACCTSMIT WHERE METERMITREADDT between to_date('$start_date', 'yyyy-mm-dd') and to_date('$end_date', 'yyyy-mm-dd') AND SERIALNUMBER=16508212 AND METERMITDATA2ID = 0 AND METERMITDATA1 > 0 ORDER BY METERMITREADDT ASC";
$rs = odbc_exec($connection, $query);

if (!$rs){
    exit("Error in SQL");
}

$table = array();
$table['cols'] = array(
    array('label' => 'date', 'type' => 'datetime'),
    array('label' => 'payoff', 'type' => 'number'),
);
$rows = array();

odbc_fetch_row($rs);
$pulses = odbc_result($rs,"METERMITDATA1");
$prev_kwh = $pulses * 2.5 / 1000000;
$day_count = 1;
while(odbc_fetch_row($rs)){
    $date = odbc_result($rs,"METERMITREADDT");
    $timestamp = strtotime($date) * 1000;
    $pulses = odbc_result($rs,"METERMITDATA1");
    $current_kwh = $pulses * 2.5 / 1000000;
    $daily_kwh = ($current_kwh - $prev_kwh) / $day_count;
    $daily_payoff = $daily_kwh * .055;
    if ($prev_kwh > 0 and $current_kwh > 0){
        $temp = array();
        $temp[] = array('v' => "Date($timestamp)");
        $temp[] = array('v' => (float) $daily_payoff);
        $rows[] = array('c' => $temp);
    }
    $prev_kwh = $current_kwh;
}

odbc_close($connection);

$table['rows'] = $rows;
$json_table = json_encode($table);

echo($json_table);
?>