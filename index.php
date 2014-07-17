<?php
/**
 * Created by PhpStorm.
 * User: cwilson
 * Date: 1/2/14
 * Time: 11:23 AM
 */
    session_start();
    include_once('payoff_data.php');
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/chart_style.css">
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="js/thermometer.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="js/chart.js"></script>

</head>
<body>
<div id="wrapper">
    <div id="banner_div"></div>
    <div id="form_wrapper">
        <form method="post" action="index.php" name="date-form">
                <?php
                    include("start_date_select_form.php");
                    include("end_date_select_form.php");
                ?>
                <input class="button" type="button" name="total_kwh" value="Total kWh" onclick="drawKwhChart()" />
                <input class="button" type="button" name="daily_kwh" value="Daily kWh" onclick="drawKwhDailyChart()" />
                <input class="button" type="button" name="daily_payoff" value="Daily Payoff" onclick="drawPayoffDailyChart()" />
        </form>
    </div>
    <div id="kwh_div"></div>
    <div id="content">
        <div id="chart_wrapper">
            <div id="chart_div"></div>
            <h3 class="center-text">Payoff Generated:</h3>
            <div id="thermo2" class="thermometer horizontal">
                <div class="track">
                    <div class="goal">
                        <div class="amount">13500 </div>
                    </div>
                    <div class="progress">
                        <div class="amount"><?php echo($current_payoff); ?> </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="statistics"><h3 class="center-text">Statistics:</h3><?php
            //ECHO RESULTS
            echo("<div class='category'>Current kWh:</div><div class='number'>".number_format($current_kwh, 2)."</div>");
            echo("<div class='category'>Average kWh:</div><div class='number'>".number_format($average_kwh, 2)."</div>");
            echo("<div class='category'>Total Payoff:</div><div class='number'>$".number_format($current_payoff, 2)."</div>");
            echo("<div class='category'>Average Daily Payoff:</div><div class='number'>$".number_format($average_payoff, 2)."</div>");
            echo("<div class='category'>Estimated Years Until Payoff:</div><div class='number'>".number_format($years_remaining)."</div>");
            ?>
        </div>
    </div>
</div>

</body>
</html>