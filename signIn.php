<?php

session_start();

if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";

try{

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0)
    {
        throw new Exception($connection->error);
        //echo "Error: ".$connection->connect_errno." Opis: ".$connection->connect_error;
    }
    else{
        $connection->query("SET NAMES 'utf8'");

        //Logged In
        $email = $_POST['email'];
        $password = $_POST['password'];

        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_password'] = $password;

        $email = htmlentities($email, ENT_QUOTES, "UTF-8");
        
        $instructionRetrieveUserFromDatabase = sprintf("SELECT * FROM users WHERE email='%s'", mysqli_real_escape_string($connection, $email));
        
        if($result = $connection->query($instructionRetrieveUserFromDatabase))
        {
            $howManyUsers = $result->num_rows;
            echo $howManyUsers;
            if($howManyUsers>0)
            {
                $dataUser = $result->fetch_assoc();

                if(password_verify($password, $dataUser['password'])){
                    $_SESSION['logged'] = true;

                    $_SESSION['id'] = $dataUser['id'];
                    $_SESSION['username'] = $dataUser['username'];
                    $_SESSION['email'] = $dataUser['email'];

                    unset($_SESSION['error']);
                    $result->free_result();
                    header('Location:menu.php');
                }
                else {
                    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Niepoprawny login lub hasło!<span>';
                    header('Location:index.php');
                }
            }
            else {
                $_SESSION['error'] = '<span class="row col-10 offset-1 text-danger">Niepoprawny login lub hasło!<span>';
                header('Location:index.php');
            }

        }
        $connection->close();
    }

} catch(Exception $e) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy o logowanie w innym terminie!<span>';
    // $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
    header('Location:index.php');
}

