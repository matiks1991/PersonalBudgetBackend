<?php
    session_start();

    if((isset($_SESSION['logged']))&&($_SESSION['logged']==true))
    {
        header('Location: menu.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">

<head>
   <meta charset="utf-8" />
   <title>Mój Budżet - Strona Startowa</title>
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
           <h3 class="mb-5">Logowanie</h3>

              
           <form class="text-center m-3" action="signIn.php" method="post">

              <div class="row">
                <div class="form-group form-inline col offset-1">

                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="icon-mail"></i></span>
                    </div>
                    <label class="sr-only">Email</label>
                    <input type="email" class="form-control col-9" placeholder="Wprowadź adres email" aria-label="Email" aria-describedby="basic-addon1" required name="email" value=<?php
                      if(isset($_SESSION['fr_email'])){
                        echo $_SESSION['fr_email'];
                        unset($_SESSION['fr_email']);
                      }
                    ?>>
                </div>
              </div>

              <div class="row">
                <div class="form-group form-inline col offset-1">

                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon2"><i class="icon-lock"></i></span>
                    </div>
                    <label class="sr-only">Hasło</label>
                    <input type="password" class="form-control col-9" placeholder="Wprowadź hasło" aria-label="Hasło" aria-describedby="basic-addon2" required name="password" value=<?php
                      if(isset($_SESSION['fr_password'])){
                        echo $_SESSION['fr_password'];
                        unset($_SESSION['fr_password']);
                      }
                    ?>>
                </div>
                <?php
                  if(isset($_SESSION['error'])) echo $_SESSION['error'];
                ?>
              </div>

              <div class="row">

                <button type="submit" class="btn btn-success btn-md col-10 offset-1 mt-4">Zaloguj</button>
              </div>

           </form>

           <a href="registration.php" class="btn btn-secondary-outline btn-sm" role="button">Nie masz jeszcze konta? Zarejestruj się &rarr;</a>
          </section>

        <section class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-5 bg-description">
          
            <h4 class="mb-4">Napięty, nerwowy, Mój Budżet?</h4>
            <p>Mój Budżet to program dla wszystkich zainteresowanych równoważeniem budżetu i finansów rodziny. Jeżeli masz wrażenie, że Twoje pieniądze przeciekają Tobie przez palce, teraz możesz odzyskać kontrolę nad finansami.</p>
            
            <p>Żeby zmniejszyć i zorganizować wydatki musisz najpierw poznać wydatki w domowym budżecie. Program pozwala na pokazanie i zredukowanie ukrytych kosztów w domowych wydatkach. Ukryte koszty domowego budżetu to potencjalne oszczędności.</p>


            <footer class="text-muted pt-lg-4">&copy; Copyright by Mateusz Broniszewski 2020</footer>

        </section>
        
      </div>
   
  </div>
</main>


   <script src="libraries/jquery-3.5.1.min.js"></script>
   <!-- <script src="libraries/poper.min.js"></script> -->
   <script src="libraries/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>