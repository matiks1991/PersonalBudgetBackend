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
   <title>Mój Budżet - Dodaj wydatek</title>
   <meta name="description" content="Zarejestruj się. Strona pomagająca prowadzić budżet osobisty." />
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
          <li class="nav-item active">
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
  
    <div class="container">

      <div class="row">

        <div class="col-md-6 offset-md-3 mt-3 bg-form p-0">

          <h2 class="text-center font-weight-bold">Dodaj wydatek</h2>

          <hr>
          
          <form class="text-center m-4 form-control-sm">

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
                  <input type="date" id="date" class="form-control col-9" name="date" aria-label="Data" aria-describedby="basic-addon2" required>
                
              </div>
            </div>

            <fieldset class="text-left offset-1 mb-3">

              <legend>Sposób płatności:</legend>

              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="paymentMethod" id="paymentMethod1" value="1" checked>
                <label class="custom-control-label" for="paymentMethod1">
                  Gotówka
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="paymentMethod" id="paymentMethod2" value="2">
                <label class="custom-control-label" for="paymentMethod2">
                  Karta debetowa
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="paymentMethod" id="paymentMethod3" value="3">
                <label class="custom-control-label" for="paymentMethod3">
                  Karta kredytowa
                </label>
              </div>
            </fieldset>

            <fieldset class="text-left offset-1 mb-3">

              <legend>Kategoria:</legend>

              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category1" value="1" checked>
                <label class="custom-control-label" for="category1">
                  Jedzenie
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category2" value="2">
                <label class="custom-control-label" for="category2">
                  Mieszkanie
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category3" value="3">
                <label class="custom-control-label" for="category3">
                  Transport
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category4" value="4">
                <label class="custom-control-label" for="category4">
                  Telekomunikacja
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category5" value="5">
                <label class="custom-control-label" for="category5">
                  Opieka zdrowotna
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category6" value="6">
                <label class="custom-control-label" for="category6">
                  Ubranie
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category7" value="7">
                <label class="custom-control-label" for="category7">
                  Higiena
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category8" value="8">
                <label class="custom-control-label" for="category8">
                  Dzieci
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category9" value="9">
                <label class="custom-control-label" for="category9">
                  Rozrywka
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category10" value="10">
                <label class="custom-control-label" for="category10">
                  Wycieczka
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category11" value="11">
                <label class="custom-control-label" for="category11">
                  Szkolenia
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category12" value="12">
                <label class="custom-control-label" for="category12">
                  Książki
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category13" value="13">
                <label class="custom-control-label" for="category13">
                  Oszczędności
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category14" value="14">
                <label class="custom-control-label" for="category14">
                  Na złotą jesień, czyli emeryturę
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category15" value="15">
                <label class="custom-control-label" for="category15">
                  Spłata długów
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category16" value="16">
                <label class="custom-control-label" for="category16">
                  Darowizna
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="category" id="category17" value="17">
                <label class="custom-control-label" for="category17">
                  Inne wydatki
                </label>
              </div>
            </fieldset>

            <div class="row">
              <div class="form-group col-10 offset-1">
                <label class="titleComment" for="comment">Komentarz (opcjonalnie):</label>
                <textarea class="form-control" id="comment" name="comment" rows="2" cols="100"></textarea>
              </div>
            </div>

            <div class="row">

              <button type="submit" class="btn btn-success btn-md col-5 offset-1 mt-4">Dodaj</button>
              <button type="reset" class="btn btn-reset btn-md col-5 mt-4">Reset</button>
              
            </div>

         </form>
        </div>
      </div>
      <div class="row">
        <footer class="col-md-6 offset-md-3 bg-blockquote">
          <blockquote>
            <p>Mało, często powtarzane, stanowi wiele. Strzeżcie się drobnych wydatków – dosyć jest dla wody małego otworu, by wielki zatopiła okręt.</p>
            <small>Benjamin Franklin</small>
          </blockquote>
        </footer>
      </div>
    </div>
    
  </article>
  



   <script src="libraries/jquery-3.5.1.min.js"></script>
   <!-- <script src="libraries/poper.min.js"></script> -->
   <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

   
   <script src="personalbudget.js"></script>


   <script>
		
		setCurrentDate();
		
  </script>
  
</body>
</html>