<?php

session_start();

// if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
//     header('Location: index.php');
//     exit();
// }

require_once "connect.php";

try{

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0)
    {
        throw new Exception($connection->error);
        //echo "Error: ".$connection->connect_errno." Opis: ".$connection->connect_error;
    }
    else{

        unset($_SESSION['error']);
        $connection->close();
    }

} catch(Exception $e) {
    $_SESSION['error'] = '<span class="row col-11 text-danger">Błąd serwera! Pezpraszamy za niedogodności i prosimy o logowanie w innym terminie!<span>';
    // $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
    header('Location:index.php');
}

