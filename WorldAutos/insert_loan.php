<?php
// insert_loan.php

function insertLoan($make, $model, $price, $repayment_duration, $interest_rate, $total_payment, $total_interest, $monthly_payment) {
    // Підключення до бази даних
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "hello_world_autos"; 

    // Створення з'єднання
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Перевірка з'єднання
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL запит для вставки даних
    $sql = "INSERT INTO loans (make, model, price, repayment_duration, interest_rate, total_payment, total_interest, monthly_payment)
    VALUES ('$make', '$model', $price, $repayment_duration, $interest_rate, $total_payment, $total_interest, $monthly_payment)";

    if ($conn->query($sql) === TRUE) {
        return true; // Успішно вставлено
    } else {
        return false; // Помилка вставки
    }

    // Закриття з'єднання
    $conn->close();
}
?>