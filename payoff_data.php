<?php
$conn = odbc_connect('TWACS','DCSI','DCSI');
if (!$conn)
{
    exit("Connection Failed: " . $conn);
}

//GET TOTAL # OF READINGS
$query = "SELECT COUNT(DISTINCT METERMITREADDT) AS RC FROM DCSI.METERACCTSMIT WHERE SERIALNUMBER=16508212 AND METERMITDATA2ID=0 AND METERMITDATA1 > 0";
$rs =  odbc_exec($conn, $query);
$reading_count = odbc_result($rs, "RC");

//GET AVG PAYOFF & EST DAYS TIL PROFIT
$query = "SELECT max(METERMITDATA1) FROM DCSI.METERACCTSMIT WHERE SERIALNUMBER=16508212 AND METERMITDATA2ID=0 AND METERMITDATA1 > 0";
$rs =  odbc_exec($conn, $query);
$current_pulses = odbc_result($rs, "max(METERMITDATA1)");
$current_kwh = $current_pulses * 2.5 / 1000000;
$average_kwh = $current_kwh / $reading_count;
$current_payoff = $current_kwh * .055;
$average_payoff = $current_payoff / $reading_count;
$days_remaining = (10000 - $current_payoff) / $average_payoff;
$years_remaining = $days_remaining / 365.242;

//CLOSE CONNECTION
odbc_close($conn);

?>
