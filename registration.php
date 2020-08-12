<?php
session_start();

if (isset($_POST['username'])) {

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

  //Remember data
  $_SESSION['fr_username'] = $username;
  $_SESSION['fr_email'] = $email;
  // $_SESSION['fr_password1'] = $password1;
  // $_SESSION['fr_password2'] = $password2;


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
        //echo "Udana walidacja";
      }
    }


  } catch(Exception $e) {
    echo '<span class="text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
    echo '<br />Informacja developerska: '.$e;
  }

}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8" />
  <title>Mój Budżet - Rejestracja</title>
  <meta name="description" content="Zarejestruj się. Strona pomagająca prowadzić budżet osobisty." />
  <meta name="keywords" content="budżet, finanse, oszczędzanie, pieniądze" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="img/dollar.png" />

  <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="libraries/bootstrap-4.0.0/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="fontello-47dae6a1/css/fontello.css" type="text/css" />
  <link rel="stylesheet" href="style.css" type="text/css" />

  <!-- <script src="personalbudget.js"></script>
  <link rel="stylesheet" href="css/fontello.css"> -->

</head>

<body>

  <main id="cover">

    <div class="container">

      <div class="row">

        <section class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-5 offset-xl-1 bg-light">
          <h1 class="display-4 text-primary font-weight-bold mb-3">Mój Budżet</h1>
          <h3 class="mb-4">Rejestracja</h3>

          <form class="text-center mx-3" method="post">

            <div class="row">
              <div class="form-group form-inline col offset-1">

                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3"><i class="icon-user"></i></span>
                </div>

                <label class="sr-only">User Name</label>
                <input type="text" class="form-control col-9" name="username" placeholder="Wprowadź swoje imię" aria-label="Imię" aria-describedby="basic-addon3" required value="<?php if (isset($_SESSION['fr_username'])) {
                   echo $_SESSION['fr_username'];
                   unset($_SESSION['fr_username']);
                }?>">

                <?php
                if (isset($_SESSION['e_username'])) {
                  echo '<div class="row col-11 text-danger">' . $_SESSION['e_username'] . '</div>';
                  unset($_SESSION['e_username']);
                }
                ?>

              </div>
            </div>



            <div class="row">
              <div class="form-group form-inline col offset-1">

                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="icon-mail"></i></span>
                </div>
                <label class="sr-only">Email</label>
                <input type="email" class="form-control col-9" name="email" placeholder="Wprowadź adres email" aria-label="Email" aria-describedby="basic-addon1" required value="<?php if (isset($_SESSION['fr_email'])) {
                  echo $_SESSION['fr_email'];
                  unset($_SESSION['fr_email']);
                }?>">
                <?php
                if (isset($_SESSION['e_email'])) {
                  echo '<div class="row col-11 text-danger">' . $_SESSION['e_email'] . '</div>';
                  unset($_SESSION['e_email']);
                } 
                ?>
              </div>
            </div>

            <div class="row">
              <div class="form-group form-inline col offset-1">

                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon2"><i class="icon-lock"></i></span>
                </div>
                <label class="sr-only">Hasło</label>
                <!-- <input type="password" class="form-control col-9" placeholder="Wprowadź hasło" aria-label="Hasło" aria-describedby="basic-addon2" required> -->

              </div>
            </div>

            <div class="row">
              <div class="form-group form-inline col offset-1">

                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon4"><i class="icon-lock"></i></span>
                </div>
                <label class="sr-only">Hasło</label>
                <!-- <input type="password" class="form-control col-9" placeholder="Powtórz hasło" aria-label="Hasło2" aria-describedby="basic-addon4" required> -->

              </div>
            </div>

            <div class="row">

              <button type="submit" class="btn btn-success btn-md col-10 offset-1 mt-2">Zarejestruj</button>
            </div>

          </form>

          <a href="index.html" class="btn btn-secondary-outline btn-sm mt-1" role="button">&larr; Powrót do strony logowania</a>
        </section>

        <section class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-5 bg-description">

          <h4 class="mb-4">Napięty, nerwowy, Mój Budżet?</h4>
          <p>Mój Budżet to program dla wszystkich zainteresowanych równoważeniem budżetu i finansów rodziny. Jeżeli masz wrażenie, że Twoje pieniądze przeciekają Tobie przez palce, teraz możesz odzyskać kontrolę nad finansami.</p>

          <p>Żeby zmniejszyć i zorganizacować wydatki musisz najpierw poznać wydatki w domowym budżecie. Program pozwala na pokazanie i zredukowanie ukrytych kosztów w domowych wydatkach. Ukryte koszty domowego budżetu to potencjalne oszczędności.</p>


          <footer class="text-muted pt-lg-5">&copy; Copyright by Mateusz Broniszewski 2020</footer>


        </section>

      </div>

    </div>
  </main>







  <script src="libraries/jquery-3.5.1.min.js"></script>
  <!-- <script src="libraries/poper.min.js"></script> -->
  <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>