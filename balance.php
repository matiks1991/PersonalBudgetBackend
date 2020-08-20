<?php
  session_start();

  if(!isset($_SESSION['logged']))
  {
    header('Location: index.php');
    exit();
  }

  if(!isset($_SESSION['newPeriod']))
  {
    require_once "currentmonth.php";
  }
  unset($_SESSION['newPeriod']);

  //download values
  $incomes = $_SESSION['incomes'];
  $expenses = $_SESSION['expenses'];
  $incomesDetail = $_SESSION['incomesDetail'];
  $expensesDetail = $_SESSION['expensesDetail'];
  $caption = $_SESSION['caption'];

  //pie chart
  $pieData = array(array('Category', "Total"));
  foreach($expenses as $expense){
    $pieData[] = array($expense[0], (double)$expense[1]);
  }

  $jsonTable = json_encode($pieData);

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

   <script src="libraries/jquery-3.5.1.min.js"></script>
   <script src="libraries/jquery.scrollTo.min.js"></script>
   <!-- <script src="libraries/poper.min.js"></script> -->
   <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
   <script src="libraries/loader.js"></script>

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
                  <a class="dropdown-item" href="balance.php">Bierzący miesiąc</a>
                  <a class="dropdown-item" href="previousmonth.php">Poprzedni miesiąc</a>
                  <a class="dropdown-item" href="currentyear.php">Bieżący rok</a>
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

               <h2 id="title" class="text-center font-weight-bold"><?=$caption;?></h2>
               <a href="#" class="scrollup"></a>
               <hr>
               <?php
                  if(isset($_SESSION['error'])) echo $_SESSION['error'];
               ?>
               <div class="container">
                  
                  <div class="row mt-4">
                     <div id="incomes" class="col-8 offset-2 col-lg-6 offset-lg-0">
                        <table class="table table-sm  table-striped table-success text-center">
                           <thead>
                              <tr><th scope="col" colspan="3">Przychody</th></tr>
                              <tr><th scope="col">Lp.</th><th scope="col">Kategoria</th><th scope="col">Kwota</th></tr>
                           </thead>
                           <tbody>
                              <?php
                                 $totalIncomes = 0;
                                 $ordinalNumber = 0;
                                 foreach ($incomes as $income) {
                                    echo '<tr><th scope="row">'.(++$ordinalNumber).'</th><td>'.$income[0].'</td><td>'.$income[1].'</td></tr>' ;
                                    $totalIncomes += $income[1];
                                 }
                                 echo '</tbody><tbody class="font-weight-bold"><tr><td></td><td class="sum">Suma:</td><td class="sum">'.number_format($totalIncomes, 2).' zł</td></tr>';
                              ?>
                           </tbody>
                        </table>
                     </div>

                     <div id="expenses" class="col-8 offset-2 col-lg-6 offset-lg-0">
                        <table class="table table-sm  table-striped table-secondary text-center">
                           <thead>
                              <tr><th scope="col" colspan="3">Wydatki</th></tr>
                              <tr><th scope="col">Lp.</th><th scope="col">Kategoria</th><th scope="col">Kwota</th></tr>
                           </thead>
                           <tbody>
                              <?php
                                 $totalExpenses = 0;
                                 $ordinalNumber = 0;
                                 foreach ($expenses as $expense) {
                                    echo '<tr><th scope="row">'.(++$ordinalNumber).'</th><td>'.$expense[0].'</td><td>'.$expense[1].'</td></tr>' ;
                                    $totalExpenses += $expense[1];
                                 }
                                 echo '</tbody><tbody class="font-weight-bold"><tr><td></td><td class="sum">Suma:</td><td class="sum">'.number_format($totalExpenses, 2).' zł</td></tr>';
                              ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  
                  <div class="row mt-2">
                    <div id="balance" class="col-8 offset-2">
                    <?php
                        $balance = number_format($totalIncomes - $totalExpenses, 2);
                        $warning = 'Uff.. Żyjesz na krawędzi ;)';

                        if ($balance > 0) {
                           $warning = "Gratulacje. Świetnie zarządzasz finansami!";
                           echo '<table class="table table-sm table-striped table-warning  text-center font-weight-bold"><tr><td class="sum">Bilans:</td><td class="sum">'.$balance.' zł</td></tr><tr><td colspan="2">'.$warning.'</td></tr></table>';
                        }
                        elseif ($balance < 0) {
                           $warning = "Uważaj, wpadasz w długi!";
                           echo '<table class="table table-sm table-striped table-danger  text-center font-weight-bold text-dark"><tr><td class="sum">Bilans:</td><td class="sum">'.$balance.' zł</td></tr><tr><td colspan="2">'.$warning.'</td></tr></table>';

                        }
                        else {
                           echo '<table class="table table-sm table-striped table-warning  text-center font-weight-bold text-dark"><tr><td class="sum">Bilans:</td><td class="sum">'.$balance.' zł</td></tr><tr><td colspan="2">'.$warning.'</td></tr></table>';
                        }
                        
                    ?>
                    </div>
                  </div>

                  <div class="row">
                     <div id="piechart" class="col-8 mx-auto"></div>
                  </div>

                  <div class="row mt-4">
                     <div id="incomesDetailed" class="col">
                        <form>
                           <table class="table table-responsive-sm table-sm table-striped table-success text-center">
                              <thead>
                                 <tr>
                                    <th scope="col" colspan="6">Szczegółowe zestawienie przychodów</th></tr><tr><th scope="col">Lp.</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Kwota</th>
                                    <th scope="col">Kategoria</th>
                                    <th scope="col">Komentarz</th>
                                    <th scope="col">Usuń</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    $ordinalNumber = 0;
                                    foreach ($incomesDetail as $incomeDetail) {
                                       echo '<tr><th scope="row">'.(++$ordinalNumber).'</th><td>'
                                       .$incomeDetail[1].'</td><td>'.$incomeDetail[2].'</td><td>'
                                       .$incomeDetail[3].'</td><td>'.$incomeDetail[4].'</td><td>
                                       <button class="btn btn-sm btn-delete" type="submit" name="deleteIncome" value='.$incomeDetail[0].'>
                                       <i class="icon-cancel"></i></button></td></tr>';
                                    }
                                 ?>
                              </tbody>
                           </table>
                        </form>
                     </div>
                  </div>

                  <div class="row my-4">
                     <div id="expensesDetailed" class="col">
                        <form>
                           <table class="table table-responsive-sm table-sm table-striped table-secondary text-center">
                              <thead>
                                 <tr>
                                    <th scope="col" colspan="7">Szczegółowe zestawienie przychodów</th></tr><tr><th scope="col">Lp.</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Kwota</th>
                                    <th scope="col">Kategoria</th>
                                    <th scope="col">Sposób płatności</th>
                                    <th scope="col">Komentarz</th>
                                    <th scope="col">Usuń</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    $ordinalNumber = 0;
                                    foreach ($expensesDetail as $expenseDetail) {
                                       echo '<tr><th scope="row">'.(++$ordinalNumber).'</th><td>'
                                       .$expenseDetail[1].'</td><td>'.$expenseDetail[2].'</td><td>'
                                       .$expenseDetail[3].'</td><td>'.$expenseDetail[4].'</td><td>'
                                       .$expenseDetail[5].'</td><td>
                                       <button class="btn btn-sm btn-delete" type="submit" name="deleteExpense" value='.$expenseDetail[0].'>
                                       <i class="icon-cancel"></i></button></td></tr>';
                                    }
                                 ?>
                              </tbody>
                           </table>
                        </form>
                     </div>
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
               <form class="text-center form-control" action="customperiod.php" method="post">
                  <div class="modal-body">

                     <div class="row">
                        <div class="form-group form-inline col form-control-sm">
                           <span class="text-primary mr-3 font-weight-bold">Od:</span>
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="icon-calendar"></i></span>
                           </div>
                           <label for="date1" class="sr-only">Data</label>
                           <input type="date" id="date1" class="form-control col-9" name="dateStart"
                              aria-label="Data" aria-describedby="basic-addon1" required value=<?php require_once "connect.php";

                              try{
                              $connection = @new mysqli($host, $db_user, $db_password, $db_name);

                              if ($connection->connect_errno != 0)
                              {
                                 throw new Exception($connection->error);
                                 //echo "Error: ".$connection->connect_errno." Opis: ".$connection->connect_error;
                              } else {

                                 //oldest date
                                 $instructionRetrieveOldestDate = 'SELECT LEAST((SELECT MIN(date_of_income) FROM incomes WHERE user_id = '.$_SESSION['id'].'),(SELECT MIN(date_of_expense) FROM expenses WHERE user_id = '.$_SESSION['id'].')) as total;';
                                 
                                 if($result = $connection->query($instructionRetrieveOldestDate))
                                 {
                                    $oldestDate = $result->fetch_assoc();
                                    echo $oldestDate['total'];
                                 }else{
                                    throw new Exception($connection->error);
                                 }

                                 $result->free_result();

                              }
                              

                              } catch (Exception $e) {
                              $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy spróbować w innym terminie!<span>';
                              // $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
                              }
                            ?>>
                        </div>
                     </div>

                     <div class="row">
                        <div class="form-group form-inline col form-control-sm">
                           <span class="text-primary mr-3 font-weight-bold">Do:</span>
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon2"><i class="icon-calendar"></i></span>
                           </div>
                           <label for="date2" class="sr-only">Data</label>
                           <input type="date" id="date2" class="form-control col-9" name="dateEnd"
                              aria-label="Data" aria-describedby="basic-addon2" required value=<?php require_once "connect.php";

                              try{
                              $connection = @new mysqli($host, $db_user, $db_password, $db_name);

                              if ($connection->connect_errno != 0)
                              {
                                 throw new Exception($connection->error);
                                 //echo "Error: ".$connection->connect_errno." Opis: ".$connection->connect_error;
                              } else {

                                 //youngest date
                                 $instructionRetrieveYoungestDate = 'SELECT GREATEST((SELECT MAX(date_of_income) FROM incomes WHERE user_id = '.$_SESSION['id'].'),(SELECT MAX(date_of_expense) FROM expenses WHERE user_id = '.$_SESSION['id'].')) as total;';
                                 
                                 if($result = $connection->query($instructionRetrieveYoungestDate))
                                 {
                                    $youngestDate = $result->fetch_assoc();
                                    echo $youngestDate['total'];
                                 }else{
                                    throw new Exception($connection->error);
                                 }

                                 $result->free_result();

                                 $connection -> close();
                              }


                              } catch (Exception $e) {
                              $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy spróbować w innym terminie!<span>';
                              // $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
                              }
                              ?>>
                        </div>
                     </div>

                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-reset btn-md" data-dismiss="modal">Zamknij</button>
                     <button type="submit" class="btn btn-success btn-md">Zapisz zmiany</button>
                  </div>
               </form>
               <?php
                  if(isset($_SESSION['error'])) echo $_SESSION['error'];
                  unset($_SESSION['error']);
               ?>
            </div>
         </div>
      </div>
   </section>

   <script>

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart(){
	
        var data = new google.visualization.arrayToDataTable(<?php echo $jsonTable; ?>);
        
        var options = {
          title:'Wydatki - graficznie',
          titleTextStyle:{color:'#52361b', fontSize:20, bold:1},
          legend: 'none',
          width:'100%',
          height:330,
          backgroundColor:'lightgray',
          sliceVisibilityThreshold:.005,
          margin:'0px',
          paddings:'0px',
          pieHole:0.4,
          borderradius:'20px'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }

      jQuery(function($)
		{
			//reset scroll
			$.scrollTo(0);
			$('.scrollup').click(function() { $.scrollTo($('body'), 1000); })
		}
      );
      
      //show during scrolling
      $(window).scroll(function()
		{
         if($(this).scrollTop()>300)
            $('.scrollup').fadeIn();
         else
            $('.scrollup').fadeOut();
		}
      );
      
      $(window).resize(function(){
         drawChart();
      });
      
      //listeningForElements();

   </script>

</body>

</html>