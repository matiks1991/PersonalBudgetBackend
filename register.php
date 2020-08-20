<?php
session_start();

if ((!isset($_POST['username'])) || (!isset($_POST['email'])) || (!isset($_POST['password1'])) || (!isset($_POST['password2']))) {
  header('Location: registration.php');
  exit();
}

$allGood = true;

$username = $_POST['username'];

//First letter in uppercase, the rest in lowercase
$username = mb_convert_case($username, MB_CASE_TITLE, 'utf-8');

//Check length of username
if ((strlen($username) < 3) || (strlen($username) > 20)) {
  $allGood = false;
  $_SESSION['e_username'] = "Imię musi posiadać od 3 do 20 znaków!";
}

//Check letters of username
$polishAlphabet = '/^[A-ZĄĘÓŁŚŹŻĆŃa-ząęółśżźćń]+$/';

if (!preg_match($polishAlphabet, $username)) {
  $allGood = false;
  $_SESSION['e_username'] = "Imię może się składać tylko ze znaków z polskiego alfabetu!";
}

//Checking the correctness of the email
$email = $_POST['email'];
$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

if (((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false)) || ($emailB != $email)) {
    $allGood = false;
    $_SESSION['e_email'] = "Podaj poprawny adres email!";
}

//Check password
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

if ((strlen($password1) < 8) || (strlen($password1) > 20)) {
$allGood = false;
$_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków!";
}

if ($password1 != $password2) {
    $allGood = false;
    $_SESSION['e_password'] = "Podane hasła nie są identyczne!";
}

$passwordHash = password_hash($password1, PASSWORD_DEFAULT);

//Remember data
$_SESSION['fr_username'] = $username;
$_SESSION['fr_email'] = $email;
$_SESSION['fr_password1'] = $password1;
$_SESSION['fr_password2'] = $password2;


require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try{
  $connection = new mysqli($host, $db_user, $db_password, $db_name);

  if($connection->connect_errno != 0){
    throw new Exception(mysqli_connect_errno());
  }
  else {

    //Check if the email arledy exists in the database
    $theSameEmailsInTheDatabase = $connection->query("SELECT email FROM users WHERE email='$email'");

    if(!$theSameEmailsInTheDatabase)
      throw new Exception($connection->error);
    
    $howManyTheSameEmails = $theSameEmailsInTheDatabase->num_rows;

    if($howManyTheSameEmails > 0){
      $allGood = false;
      $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email!";
    }

    if ($allGood == true) {

      //Query to databese
      $instructionToSaveDataUserInDatabase = "INSERT INTO users VALUES (NULL, '$username', '$email','$passwordHash')";

      if ($connection->query($instructionToSaveDataUserInDatabase)) {

        //Add user tables 
        $instructionRetrievingUserIdFromDatabase = "SELECT * FROM users WHERE email='$email'";

        $result = $connection->query($instructionRetrievingUserIdFromDatabase);
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        
        $queryTableExpansesCategory = "CREATE TABLE expenses_category_assigned_to_ID_".$userId." AS SELECT * FROM expenses_category_default";
        $queryTableIncomesCategory = "CREATE TABLE incomes_category_assigned_to_ID_".$userId." AS SELECT * FROM incomes_category_default";
        $queryTablePaymentMethods = "CREATE TABLE payment_methods_assigned_to_ID_".$userId." AS SELECT * FROM payment_methods_default";


        if($connection->query($queryTableExpansesCategory) AND $connection->query($queryTableIncomesCategory) AND $connection->query($queryTablePaymentMethods)){
          $_SESSION['successfulRegistration'] = true;
          $_SESSION['logged'] = true;

          $_SESSION['id'] = $userId;
          $_SESSION['username'] = $username;
          $_SESSION['email'] = $email;

          

          header('Location: menu.php');
        }
        else {
          throw new Exception($connection->error);
        }
      }
      else {
          throw new Exception($connection->error);
      }
    } else {
      header('Location: registration.php');
    }
    $connection->close();
  }


} catch(Exception $e) {
  $_SESSION['e_connection'] = 'Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!';
  header('Location: registration.php');
  //echo '<br />Informacja developerska: '.$e;
}

