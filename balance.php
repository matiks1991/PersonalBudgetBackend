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
   <title>Mój Budżet - Przeglądaj Bilans</title>
   <meta name="description" content="Strona pomagająca prowadzić budżet osobisty." />
   <meta name="keywords" content="budżet, finanse, oszczędzanie, pieniądze" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="shortcut icon" href="img/dollar.png" />

   <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Lato:wght@400;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="libraries/bootstrap-4.0.0/dist/css/bootstrap.min.css" type="text/css" />
   <link rel="stylesheet" href="fontello-47dae6a1/css/fontello.css" type="text/css" />
   <link rel="stylesheet" href="style.css" type="text/css" />

   <script src="libraries/jquery-3.2.1.slim.min.js"></script>
   <!-- <script src="libraries/poper.min.js"></script> -->
   <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
   <!-- <script src="libraries/jquery.tablesorter.min.js"></script> -->
   <script src="libraries/loader.js"></script>
   <!-- <script src="libraries/jquery.tablesorter.min.js"></script> -->


   <script src="personalbudget.js"></script>

</head>

<body>

   <header>
      <nav class="navbar sticky navbar-expand-xl navbar-dark bg-dark fixed-top py-0 text-center text-sm-left">

         <button class="navbar-toggler my-2" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>

         <a class="navbar-brand" href="menu.php"><i class="icon-dollar"> Mój budżet</i></a>

         <div class="collapse navbar-collapse py-1" id="navbarNav">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" href="menu.php"><i class="icon-home"> Menu</i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="expense.php"><i class="icon-upload-cloud"> Dodaj wydatek</i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="income.php"><i class="icon-download-cloud"> Dodaj przychód</i></a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="balance.php"><i class="icon-chart"> Bilans</i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="settings.php"><i class="icon-sliders"> Ustawienia</i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="logout.php"><i class="icon-link-ext"> Wyloguj</i></a>
               </li>
            </ul>

            <div class="navbar-user ml-auto border my-0 p-2 d-inline-block">
            <span><?= $_SESSION['username'];?></span>
            </div>

         </div>

         <ul class="navbar-nav mr-0 ml-auto ml-xl-3 d-inline-block navbar-dark visible-lg">
            <li class="nav-item dropdown">
               <button class="nav-link dropdown-toggle p-3" id="navbarDropdown" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  Wybierz okres
               </button>
               <div class="dropdown-menu navbar-dark" aria-labelledby="navbarDropdown">
                  <button class="dropdown-item" id="currentMonth">Bierzący miesiąc</button>
                  <button class="dropdown-item" id="previousMonth">Poprzedni miesiąc</button>
                  <button class="dropdown-item" id="currentYear">Bierzący rok</button>
                  <div class="dropdown-divider"></div>
                  <button class="dropdown-item" type="button" data-toggle="modal"
                     data-target="#choosePeriod">Niestandardowy</button>

               </div>
            </li>
         </ul>

      </nav>

   </header>

   <article>
      <div class="bg"></div>

      <div class="container">

         <div class="row">

            <div class="col-lg-8 offset-lg-2 mt-3 bg-balance p-0">

               <h2 id="title" class="text-center font-weight-bold">Bilans za miesiąc bieżący</h2>

               <hr>

               <div class="container">

                  <div class="row mt-4">
                     <div id="incomes" class="col-8 offset-2 col-lg-6 offset-lg-0"></div>
                     <div id="expenses" class="col-8 offset-2 col-lg-6 offset-lg-0"></div>
                  </div>
                  
                  <div class="row mt-2">
                     <div id="balance" class="col-8 offset-2"></div>
                  </div>

                  <div class="row">
                     <div id="piechart" class="col-8 mx-auto"></div>
                  </div>

                  <div class="row mt-4">
                     <div id="incomesDetailed" class="col"></div>
                     <div id="expensesDetailed" class="col"></div>
                  </div>

                  <div class="row">
                     <footer class="col bg-blockquote">
                       <blockquote>
                         <p>Kto wydaje więcej niż zarabia, wpada w pułapkę niepotrzebnych zachcianek, z której szybko dostaje się na dno kłopotów i upokorzenia.</p>
                         <small>Robert Kiyosaki</small>
                       </blockquote>
                     </footer>
                   </div>

               </div>

            </div>
         </div>
      </div>

   </article>

   <section>
      <div class="modal fade" id="choosePeriod" tabindex="-1" role="dialog" aria-labelledby="choosePeriodLabel"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="choosePeriodLabel">Wybierz zakres dat</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form class="text-center form-control">
                  <div class="modal-body">

                     <div class="row">
                        <div class="form-group form-inline col form-control-sm">
                           <span class="text-primary mr-3 font-weight-bold">Od:</span>
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                           </div>
                           <label for="date1" class="sr-only">Data</label>
                           <input type="date" id="date1" class="form-control col-9" name="date" 
                              aria-label="Data" aria-describedby="basic-addon1" required>
                        </div>
                     </div>

                     <div class="row">
                        <div class="form-group form-inline col form-control-sm">
                           <span class="text-primary mr-3 font-weight-bold">Do:</span>
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon2"><i class="icon-calendar"></i></span>
                           </div>
                           <label class="sr-only">Data</label>
                           <input type="date" id="date" class="form-control col-9" name="date"
                              aria-label="Data" aria-describedby="basic-addon2" required>
                        </div>
                     </div>

                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-reset btn-md" data-dismiss="modal">Zamknij</button>
                     <button type="submit" class="btn btn-success btn-md">Zapisz zmiany</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>


   
   

   <script>
      setCurrentDate();
      showCurrentMonth();

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      $(window).resize(function(){
         drawChart();
      });
      
      listeningForElements();

   </script>

</body>

</html>