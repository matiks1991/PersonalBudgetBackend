<?php
session_start();

if(!isset($_SESSION['logged']))
{
    header('Location: index.php');
    exit();
}

if ((!isset($_POST['amount'])) || (!isset($_POST['date'])) || (!isset($_POST['category']))) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Wypełnij wszystkie obowiązkowe pola!</span>';
    header('Location: expense.php');
    exit();
}

if(!is_numeric($_POST['amount'])) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Wprowadzona kwota musi być liczbą!</span>';
    header('Location: expense.php');
    exit();
}

if (!preg_match('/^[0-9]{4}\-[0-1][0-9]\-[0-3][0-9]$/', $_POST['date']))
{
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Wprowadź prawidłowy format daty!</span>';
    header('Location: expense.php');
    exit(); 
}

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try{
    $connection = new mysqli($host, $db_user, $db_password, $db_name);
  
    if($connection->connect_errno != 0){
      throw new Exception(mysqli_connect_errno());
    }
    else {
        $connection->query("SET NAMES 'utf8'");

        //Save income to database
        $instructionSavingIncomeInDatabase = "INSERT INTO incomes VALUES ( 'NULL', ".$_POST['amount'].", '".$_POST['date']."', ".$_POST['category'].", '".$_POST['comment']."', ".$_SESSION['id'].")";
        echo $instructionSavingIncomeInDatabase;
        if($connection->query($instructionSavingIncomeInDatabase))
        {
            $_SESSION['successfulAddition'] = '<div class="row"><div class="col text-center font-weight-bold text-success mt-2" >Przychód dodano pomyślnie!</div></div>
            ';
            header('Location: income.php');
            unset($_SESSION['error']);
        } else {
            throw new Exception($connection->error);
        }
    }
    $connection->close();
} catch(Exception $e) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy o skorzystanie w innym terminie!</span>';
    header('Location: expense.php');
    //echo '<br />Informacja developerska: '.$e;
}

