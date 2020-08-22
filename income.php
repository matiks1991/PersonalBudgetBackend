<?php
  session_start();

  if(!isset($_SESSION['logged']))
  {
      header('Location: index.php');
      exit();
  }

  require_once "connect.php";

  try{
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    $connection->query("SET NAMES 'utf8'");

    if ($connection->connect_errno != 0)
    {
        throw new Exception($connection->error);
        //echo "Error: ".$connection->connect_errno." Opis: ".$connection->connect_error;
    } else {

      $instructionRetrieveIncomesCategoryFromDatabase = 'SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id='.$_SESSION['id'];
      if($result = $connection->query($instructionRetrieveIncomesCategoryFromDatabase))
      {
        $dataIncomesCategory = $result->fetch_all();
      }
      $result->free_result();
    }

  } catch (Exception $e) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy spróbować w innym terminie!<span>';
    // $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
  }


?>

<!DOCTYPE html>
<html lang="pl">

<head>
   <meta charset="utf-8" />
   <title>Mój Budżet - Dodaj przychód</title>
   <meta name="description" content="Strona pomagająca prowadzić budżet osobisty." />
   <meta name="keywords" content="budżet, finanse, oszczędzanie, pieniądze" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="shortcut icon" href="img/dollar.png" />

   <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Lato:wght@400;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="libraries/bootstrap-4.0.0/dist/css/bootstrap.min.css" type="text/css" />
   <link rel="stylesheet" href="fontello-47dae6a1/css/fontello.css" type="text/css" />
   <link rel="stylesheet" href="style.css" type="text/css" />
  

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
          <li class="nav-item">
            <a class="nav-link" href="menu.php"><i class="icon-home"> Menu</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="expense.php"><i class="icon-upload-cloud"> Dodaj wydatek</i></a>
          </li>
          <li class="nav-item active">
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
  
    <div class="container">

      <div class="row">

        <div class="col-md-6 offset-md-3 mt-3 bg-form p-0">

          <h2 class="text-center font-weight-bold">Dodaj przychód</h2>

          <hr>
          <?php
              if(isset($_SESSION['error'])) echo $_SESSION['error'];

              if(isset($_SESSION['successfulAddition'])){
                echo $_SESSION['successfulAddition'];
                unset($_SESSION['successfulAddition']);
              }
          ?>
          <form class="text-center m-4 form-control-sm" action="saveincome.php" method="post">

            <div class="row">

              <div class="form-group form-inline col offset-1 form-control-sm">

                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="icon-money"></i></span>
                  </div>
                  <label class="sr-only">Kwota</label>
                  <input type="number" class="form-control col-8" name="amount" min="0" step="0.01" placeholder="Wprowadź kwotę" aria-label="Kwota" aria-describedby="basic-addon1" required>
                  
                  <span class="input-group-text col-1 px-0">PLN</span>
                  
              </div>
            </div>

            <div class="row">
              <div class="form-group form-inline col offset-1 form-control-sm">

                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar"></i></span>
                  </div>
                  <label class="sr-only">Data</label>
                  <input type="date" id="date" class="form-control col-9" name="date" aria-label="Data" aria-describedby="basic-addon2" required value=<?php 
                  $date = new DateTime();
                  echo $date->format('Y-m-d'); ?>>
                
              </div>
            </div>

            <fieldset class="text-left offset-1 mb-3">

              <legend>Kategoria:</legend>

              <?php
                if (!isset($dataIncomesCategory))
                {
                  $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy spróbować w innym terminie!<span>';
                } else {
                  foreach ($dataIncomesCategory as $incomeCategory) {
                    echo '<div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="category" id="category'.$incomeCategory[0].'" value="'.$incomeCategory[0].'" required>
                    <label class="custom-control-label" for="category'.$incomeCategory[0].'">
                    '.$incomeCategory[1].'
                    </label>
                  </div>';
                  }
                }
                unset($_SESSION['error']);
              ?>
            </fieldset>

            <div class="row">
              <div class="form-group col-10 offset-1">
                <label class="titleComment" for="comment">Komentarz (opcjonalnie)</label>
                <textarea class="form-control" id="comment" name="comment" rows="2" cols="100"></textarea>
              </div>
            </div>

            <div class="row">

              <button type="reset" class="btn btn-reset btn-md col-5 mt-4 offset-1">Reset</button>
              <button type="submit" class="btn btn-success btn-md col-5 mt-4">Dodaj</button>
              
            </div>

         </form>

        </div>
      </div>
      <div class="row">
        <footer class="col-md-6 offset-md-3 bg-blockquote">
          <blockquote>
            <p>Zasada nr 1 – nigdy nie trać pieniędzy. Zasada nr 2. – nigdy nie zapominaj o zasadzie nr 1.</p>
            <small>Warren Buffett</small>
          </blockquote>
        </footer>
      </div>
    </div>
    
    
  </article>
  



   <script src="libraries/jquery-3.5.1.min.js"></script>
   <!-- <script src="libraries/poper.min.js"></script> -->
   <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
  
</body>
</html>