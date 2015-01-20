<?php
$conn = odbc_connect('TWACS','DCSI','DCSI');
if (!$conn)
{
    exit("Connection Failed: " . $conn);
}

//GET AVG PAYOFF & EST DAYS TIL PROFIT
$query = "SELECT max(METERTCTOTALCONSUMPT) FROM DCSI.METERACCTSTC WHERE SERIALNUMBER=11889004 AND METERTCTOTALCONSUMPT > 0";
$rs =  odbc_exec($conn, $query);

/* Conversion Constants For Pulses -> KWH */
$kr = 1;
$kh = 2.5;
$mpn = 8;
$divisor = 1000;
$mpd = 10;
$date = getdate();
$end_date = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
$start_date = "2014-05-29";
$time_difference_seconds = strtotime($end_date) - strtotime($start_date);
$time_difference_days = ceil($time_difference_seconds/86400);

$current_pulses = odbc_result($rs, "max(METERTCTOTALCONSUMPT)");
$current_kwh = ($current_pulses * $kr * $kh * $mpn) / ($divisor * $mpd);
$average_kwh = $current_kwh / $time_difference_days;
$current_payoff = $current_kwh * .055;
$average_payoff = $current_payoff / $time_difference_days;
$days_remaining = (13500 - $current_payoff) / $average_payoff;
$years_remaining = $days_remaining / 365.242;

//CLOSE CONNECTION
odbc_close($conn);

?>
