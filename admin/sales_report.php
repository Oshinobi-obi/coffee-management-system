<?php

    include '../components/connect.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    };

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loris | Sales Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_header.php' ?>

<section class="sales">
<h1 class="heading">Sales Report</h1>
    <div class="box-container1">
        <div class="box1">
            <?php
                // Today's Sales //
                $total_today = 0;
                $select_today = $conn->prepare("SELECT SUM(total_price) AS total_today FROM `orders` WHERE payment_status = 'completed' AND DATE(placed_on) = CURDATE()");
                $select_today->execute();
                $row_today = $select_today->fetch(PDO::FETCH_ASSOC);
                $total_today = $row_today['total_today'];
                $formatted_today_sales = number_format($total_today);
            ?>
            <p>Today's Sales:</p>
            <p>(<span id="today-date"></span>)</p><br>
            <h3><span>₱ </span><?= $formatted_today_sales; ?></h3><br>  
        </div>
    </div>
</section>

<section class="sales1">
    <div class="box-container1">
        <div class="box1">
            <?php
                // Yesterday's Sales //
                $total_yesterday = 0;
                $select_yesterday = $conn->prepare("SELECT SUM(total_price) AS total_yesterday FROM `orders` WHERE payment_status = 'completed' AND DATE(placed_on) = CURDATE() - INTERVAL 1 DAY");
                $select_yesterday->execute();
                $row_yesterday = $select_yesterday->fetch(PDO::FETCH_ASSOC);
                $total_yesterday = $row_yesterday['total_yesterday'];
                $formatted_yesterday_sales = number_format($total_yesterday);
            ?>
            <p>Yesterday's Sales:</p>
            <p>(<span id="yesterday-date"></span>)</p><br>
            <h3><span>₱ </span><?= $formatted_yesterday_sales; ?></h3><br>
        </div>

        <div class="box1">
            <?php
                // This Month's Sales //
                $total_this_month = 0;
                $select_this_month = $conn->prepare("SELECT SUM(total_price) AS total_this_month FROM `orders` WHERE payment_status = 'completed' AND MONTH(placed_on) = MONTH(CURDATE())");
                $select_this_month->execute();
                $row_this_month = $select_this_month->fetch(PDO::FETCH_ASSOC);
                $total_this_month = $row_this_month['total_this_month'];
                $formatted_this_month_sales = number_format($total_this_month);
            ?>
            <p>This Month's Sales:</p>
            <p>(<span id="this-month-date"></span>)</p><br>
            <h3><span>₱ </span><?= $formatted_this_month_sales; ?></h3><br>
        </div>
        <div class="box1">
            <?php
                // This Year's Sales //
                $total_this_year = 0;
                $select_this_year = $conn->prepare("SELECT SUM(total_price) AS total_this_year FROM `orders` WHERE payment_status = 'completed' AND YEAR(placed_on) = YEAR(CURDATE())");
                $select_this_year->execute();
                $row_this_year = $select_this_year->fetch(PDO::FETCH_ASSOC);
                $total_this_year = $row_this_year['total_this_year'];
                $formatted_this_year_sales = number_format($total_this_year);
            ?>
            <p>This Year's Sales:</p>
            <p>(<span id="this-year-date"></span>)</p><br>
            <h3><span>₱ </span><?= $formatted_this_year_sales; ?></h3><br>
        </div>
    </div>
</section>

<script>
    function updateTodayDate() {
        var today = new Date();
        var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById('today-date').textContent = formattedDate;
    }

    function updateYesterdayDate() {
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        var formattedDate = yesterday.getFullYear() + '-' + ('0' + (yesterday.getMonth() + 1)).slice(-2) + '-' + ('0' + yesterday.getDate()).slice(-2);
        document.getElementById('yesterday-date').textContent = formattedDate;
    }

    function updateThisMonthDate() {
        var today = new Date();
        var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        var formattedStartDate = firstDayOfMonth.getFullYear() + '-' + ('0' + (firstDayOfMonth.getMonth() + 1)).slice(-2) + '-' + '01';
        var formattedEndDate = lastDayOfMonth.getFullYear() + '-' + ('0' + (lastDayOfMonth.getMonth() + 1)).slice(-2) + '-' + ('0' + lastDayOfMonth.getDate()).slice(-2);
        var formattedDateRange = formattedStartDate + ' - ' + formattedEndDate;
        document.getElementById('this-month-date').textContent = formattedDateRange;
    }

    function updateThisYearDate() {
        var thisYear = new Date().getFullYear();
        var formattedStartDate = thisYear + '-01-01';
        var formattedEndDate = thisYear + '-12-31';
        var formattedDateRange = formattedStartDate + ' - ' + formattedEndDate;
        document.getElementById('this-year-date').textContent = formattedDateRange;
    }

    updateTodayDate();
    updateYesterdayDate();
    updateThisMonthDate();
    updateThisYearDate();

    setInterval(updateTodayDate, 1000);
    setInterval(updateYesterdayDate, 1000);
    setInterval(updateThisMonthDate, 1000);
    setInterval(updateThisYearDate, 1000);
</script>
<script src="../js/admin_script.js"></script>
</body>
</html>