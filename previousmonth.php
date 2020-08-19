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

    if ($connection->connect_errno != 0)
    {
      throw new Exception($connection->error);
       //echo "Error: ".$connection->connect_errno." Opis: ".$connection->connect_error;
    } else {
      $date = new DateTime();
      $date->modify('-1 month');

      //incomes
      $instructionRetrieveIncomes = 'SELECT c.name as category, SUM(i.amount) as total FROM incomes i INNER JOIN incomes_category_assigned_to_id_'.$_SESSION['id'].' c WHERE i.income_category_assigned_to_user_id=c.id  AND i.date_of_income >= STR_TO_DATE("'.$date->format('Y-m-01').'","%Y-%m-%d") AND i.date_of_income <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") GROUP BY category ORDER BY total DESC;';
      
      if($result = $connection->query($instructionRetrieveIncomes))
      {
        $incomes = $result->fetch_all();
        $_SESSION['incomes'] = $incomes;
      }else{
        throw new Exception($connection->error);
      }

      //expenses
      $instructionRetrieveExpenses = 'SELECT c.name as category, SUM(i.amount) as total FROM expenses i INNER JOIN expenses_category_assigned_to_id_'.$_SESSION['id'].' c WHERE i.expense_category_assigned_to_user_id=c.id  AND i.date_of_expense >= STR_TO_DATE("'.$date->format('Y-m-01').'","%Y-%m-%d") AND i.date_of_expense <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") GROUP BY category ORDER BY total DESC;';
      
      if($result = $connection->query($instructionRetrieveExpenses))
      {
        $expenses = $result->fetch_all();
        $_SESSION['expenses'] = $expenses;
      }else{
        throw new Exception($connection->error);
      }

      //incomes detail
      $instructionRetrieveIncomesDetail = 'SELECT i.id, i.date_of_income, i.amount, c.name, i.income_comment FROM incomes i INNER JOIN incomes_category_assigned_to_id_'.$_SESSION['id'].' c ON i.income_category_assigned_to_user_id=c.id  WHERE i.date_of_income >= STR_TO_DATE("'.$date->format('Y-m-01').'","%Y-%m-%d") AND i.date_of_income <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") ORDER BY i.date_of_income DESC;';
      
      if($result = $connection->query($instructionRetrieveIncomesDetail))
      {
        $incomesDetail = $result->fetch_all();
        $_SESSION['incomesDetail'] = $incomesDetail;
      }else{
        throw new Exception($connection->error);
      }

      //expenses detail
      $instructionRetrieveExpensesDetail = 'SELECT i.id, i.date_of_expense, i.amount, c.name, p.name, i.expense_comment FROM expenses i INNER JOIN expenses_category_assigned_to_id_'.$_SESSION['id'].' c ON i.expense_category_assigned_to_user_id=c.id INNER JOIN payment_methods_assigned_to_id_'.$_SESSION['id'].' p ON i.payment_method_assigned_to_user_id = p.id WHERE i.date_of_expense >= STR_TO_DATE("'.$date->format('Y-m-01').'","%Y-%m-%d") AND i.date_of_expense <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") ORDER BY i.date_of_expense DESC;';
      
      if($result = $connection->query($instructionRetrieveExpensesDetail))
      {
        $expensesDetail = $result->fetch_all();
        $_SESSION['expensesDetail'] = $expensesDetail;
      }else{
        throw new Exception($connection->error);
      }

      $result->free_result();

      $_SESSION['caption'] = 'Bilans za miesiąc poprzedni';
      $_SESSION['newPeriod'] = true;
      header('Location: balance.php');
    }
    

  } catch (Exception $e) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy spróbować w innym terminie!<span>';
    $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
  }