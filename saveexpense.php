<?php
session_start();

if(!isset($_SESSION['logged']))
{
    header('Location: index.php');
    exit();
}

if ((!isset($_POST['amount'])) || (!isset($_POST['date'])) || (!isset($_POST['paymentMethod'])) || (!isset($_POST['category']))) {
    header('Location: expense.php');
    exit();
}




