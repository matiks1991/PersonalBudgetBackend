<?php
  session_start();

  if(!isset($_SESSION['logged']))
  {
      header('Location: index.php');
      exit();
  }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
   <meta charset="utf-8" />
   <title>Twój Budżet - Strona Startowa</title>
   <meta name="description" content="Zarejestruj się. Strona pomagająca prowadzić budżet osobisty." />
   <meta name="keywords" content="budżet, finanse, oszczędzanie, pieniądze" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="shortcut icon" href="img/dollar.png" />

   <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Lato:wght@400;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="libraries/bootstrap-4.0.0/dist/css/bootstrap.min.css" type="text/css" />
   <link rel="stylesheet" href="fontello-47dae6a1/css/fontello.css" type="text/css" />
   <link rel="stylesheet" href="style.css" type="text/css" />

   <script src="personalbudget.js"></script>
  

</head>

<body>

  <header>
    <nav class="navbar sticky navbar-expand-xl navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="menu.php"><i class="icon-dollar"> Mój budżet</i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="menu.php"><i class="icon-home"> Menu</i><span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="expense.php"><i class="icon-upload-cloud"> Dodaj wydatek</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="income.php"><i class="icon-download-cloud"> Dodaj przychód</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="balance.php"><i class="icon-chart"> Przeglądaj bilans</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="settings.php"><i class="icon-sliders"> Ustawienia</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="icon-link-ext"> Wyloguj</i></a>
          </li>
        </ul>

        <div class="navbar-user ml-auto border my-0 p-2">
          <span><?= $_SESSION['username'];?></span>
        </div>

      </div>
    </nav>

  </header>

  <article>
    <div class="bg"></div>

    <div class="card col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-3">
      <small class="text-center"><?php 
      if(isset($_SESSION['successfulRegistration']) && $_SESSION['successfulRegistration']=true){
        echo 'Rejestracja zakończona sukcesem!';
        unset($_SESSION['successfulRegistration']);
      } else {
        echo 'Logowanie zakończone sukcesem!';
      }
      ?></small>
      <img class="card-img-top" src="img/doors.jpg" alt="Drzwi">
      <div class="card-body p-0">
        <h6 class="card-title text-center font-weight-bold">Witaj <span><?= $_SESSION['username'];?></span>! </h6>
        <p class="card-text text-center">Wybierz opcję z górnego menu.</p>
      </div>
    </div>
    <footer class="mt-4">
      <blockquote class="col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-0 bg-blockquote">
        <p>Nawyk zarządzania pieniędzmi jest ważniejszy niż ilość posiadanych pieniędzy.</p>
        <small>T. Harv Eker</small>
      </blockquote>
    </footer>
  </article>

   <script src="libraries/jquery-3.5.1.min.js"></script>
   <!-- <script src="libraries/poper.min.js"></script> -->
   <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>