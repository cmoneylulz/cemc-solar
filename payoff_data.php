<?php
$conn = odbc_connect('TWACS','DCSI','DCSI');
if (!$conn)
{
    exit("Connection Failed: " . $conn);
}

//GET TOTAL # OF READINGS
$query = "SELECT COUNT(DISTINCT METERTCREADDT) AS RC FROM DCSI.METERACCTSTC WHERE SERIALNUMBER=11889004 AND METERTCTOTALCONSUMPT > 0";
$rs =  odbc_exec($conn, $query);
$reading_count = odbc_result($rs, "RC");

//GET AVG PAYOFF & EST DAYS TIL PROFIT
$query = "SELECT max(METERTCTOTALCONSUMPT) FROM DCSI.METERACCTSTC WHERE SERIALNUMBER=11889004 AND METERTCTOTALCONSUMPT > 0";
$rs =  odbc_exec($conn, $query);

/* Conversion Constants For Pulses -> KWH */
$kr = 1;
$kh = 2.5;
$mpn = 8;
$divisor = 1000;
$mpd = 10;

$current_pulses = odbc_result($rs, "max(METERTCTOTALCONSUMPT)");
$current_kwh = ($current_pulses * $kr * $kh * $mpn) / ($divisor * $mpd);
$average_kwh = $current_kwh / $reading_count;
$current_payoff = $current_kwh * .055;
$average_payoff = $current_payoff / $reading_count;
$days_remaining = (13500 - $current_payoff) / $average_payoff;
$years_remaining = $days_remaining / 365.242;

//CLOSE CONNECTION
odbc_close($conn);

?>
