<!doctype html>

<!-- Web page "World Autos" -->
<!-- Created by Harrison Kong -->
<!-- Copyright (C) Coursera 2021 -->

<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
<!-- CSS Stylesheets -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="css/payment-plan.css">

<?php include "utilities.php"; ?>
<?php include "insert_loan.php"; ?>
<title>World Autos</title>   

</head>

<body>

    <h1>Your Personalised Payment Plan</h1>

    <div class="content-area">
        <!-- Відображення зображення автомобіля -->
        <img class="hero" src="images/<?php echo isset($_POST['image']) ? $_POST['image'] : 'default-image.jpg'; ?>" alt="vehicle-image" />

        <!-- Відображення марки автомобіля -->
        <p class="vehicle-make">
            <?php echo isset($_POST['make']) ? $_POST['make'] : 'Unknown'; ?>
        </p>

        <!-- Відображення моделі автомобіля -->
        <p class="vehicle-model">
            <?php echo isset($_POST['model']) ? $_POST['model'] : 'Unknown'; ?>
        </p>

        <hr class="vehicle-hr">

        <!-- Відображення ціни автомобіля -->
        <p class="vehicle-price">
            $<?php echo isset($_POST['price']) ? number_format($_POST['price'], 2) : '0.00'; ?>
        </p>

        <!-- Відображення тривалості виплат -->
        <p>
            <span class="data-label">Repayment duration: </span>
            <span class="data-item">
                <?php echo isset($_POST['repayment-duration']) ? $_POST['repayment-duration'] : 'N/A'; ?> months
            </span>
        </p>

        <!-- Відображення відсоткової ставки -->
        <p>
            <span class="data-label">Interest rate: </span>
            <span class="data-item">
                <?php echo isset($_POST['interest-rate']) ? $_POST['interest-rate'] : 'N/A'; ?>% APR
            </span>
        </p>

        <!-- Відображення загальної суми виплат -->
        <p>
            <span class="data-label">Total payment: </span>
            <span class="data-item">$<?php 
                if (isset($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']) 
                    && $_POST['repayment-duration'] > 0) {
                    echo number_format(calculateTotalPayment($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']), 2);
                } else {
                    echo '0.00';
                }
            ?></span>
        </p>

        <!-- Відображення загальної суми відсотків -->
        <p>
            <span class="data-label">Total interest: </span>
            <span class="data-item">$<?php 
                if (isset($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']) 
                    && $_POST['repayment-duration'] > 0) {
                    echo number_format(calculateTotalInterest($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']), 2);
                } else {
                    echo '0.00';
                }
            ?></span>
        </p>

        <hr class="short-line">

        <!-- Відображення щомісячного платежу -->
        <p>
            <span class="data-label">Monthly payment: </span>
            <span class="focal-point">$<?php 
                if (isset($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']) 
                    && $_POST['repayment-duration'] > 0) {
                    echo number_format(calculateMonthlyPayment($_POST['price'], $_POST['repayment-duration'], $_POST['interest-rate']), 2);
                } else {
                    echo '0.00';
                }
            ?></span>
        </p>

        <br /><br />
    </div>



    <?php
    // Отримання даних з POST
    $make = $_POST['make'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $repayment_duration = $_POST['repayment-duration'];
    $interest_rate = $_POST['interest-rate'];

    // Обчислення платежів
    $total_payment = calculateTotalPayment($price, $repayment_duration, $interest_rate);
    $total_interest = calculateTotalInterest($price, $repayment_duration, $interest_rate);
    $monthly_payment = calculateMonthlyPayment($price, $repayment_duration, $interest_rate);

    // Вставка даних у базу даних
    if (insertLoan($make, $model, $price, $repayment_duration, $interest_rate, $total_payment, $total_interest, $monthly_payment))

    ?>
</body>

<footer>
    <?php include "footer.php" ?>
</footer>

</html>