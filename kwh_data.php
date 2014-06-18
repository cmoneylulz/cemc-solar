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

$query = "SELECT * FROM DCSI.METERACCTSTC WHERE METERTCREADDT between to_date('$start_date', 'yyyy-mm-dd') and to_date('$end_date', 'yyyy-mm-dd') AND SERIALNUMBER=11889004 AND METERTCTOTALCONSUMPT > 0 ORDER BY METERTCREADDT ASC"; /*AND METERMITDATA2ID = 0 AND METERMITDATA1 > 0 ORDER BY METERMITREADDT ASC";*/
$rs = odbc_exec($connection, $query);

if (!$rs){
    exit("Error in SQL");
}

$table = array();
$table['cols'] = array(
    array('label' => 'date', 'type' => 'datetime'),
    array('label' => 'kWh', 'type' => 'number'),
);
$rows = array();

/* Conversion Constants For Pulses -> KWH */
$kr = 1;
$kh = 2.5;
$mpn = 8;
$divisor = 1000;
$mpd = 10;

while(odbc_fetch_row($rs)){
    $date = odbc_result($rs,"METERTCREADDT");
    $timestamp = strtotime($date) * 1000;
    $pulses = odbc_result($rs,"METERTCTOTALCONSUMPT");
    $kwh = ($pulses * $kr * $kh * $mpn) / ($divisor * $mpd);
    $temp = array();
    $temp[] = array('v' => "Date($timestamp)");
    $temp[] = array('v' => (float) $kwh);
    $rows[] = array('c' => $temp);
}

odbc_close($connection);

$table['rows'] = $rows;
$json_table = json_encode($table);

echo($json_table);
?>