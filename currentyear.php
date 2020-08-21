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

      //incomes
      $instructionRetrieveIncomes = 'SELECT c.name as category, SUM(i.amount) as total FROM incomes i INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id=c.id WHERE c.user_id='.$_SESSION['id'].' AND i.date_of_income >= STR_TO_DATE("'.$date->format('Y-01-01').'","%Y-%m-%d") AND i.date_of_income <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") AND i.user_id = '.$_SESSION['id'].' GROUP BY category ORDER BY total DESC;';
      
      if($result = $connection->query($instructionRetrieveIncomes))
      {
        $incomes = $result->fetch_all();
        $_SESSION['incomes'] = $incomes;
      }else{
        throw new Exception($connection->error);
      }

      //expenses
      $instructionRetrieveExpenses = 'SELECT c.name as category, SUM(i.amount) as total FROM expenses i INNER JOIN expenses_category_assigned_to_users c WHERE c.user_id='.$_SESSION['id'].' AND i.expense_category_assigned_to_user_id=c.id  AND i.date_of_expense >= STR_TO_DATE("'.$date->format('Y-01-01').'","%Y-%m-%d") AND i.date_of_expense <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") AND i.user_id = '.$_SESSION['id'].' GROUP BY category ORDER BY total DESC;';
      
      if($result = $connection->query($instructionRetrieveExpenses))
      {
        $expenses = $result->fetch_all();
        $_SESSION['expenses'] = $expenses;
      }else{
        throw new Exception($connection->error);
      }

      //incomes detail
      $instructionRetrieveIncomesDetail = 'SELECT i.id, i.date_of_income, i.amount, c.name, i.income_comment FROM incomes i INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id=c.id  WHERE c.user_id='.$_SESSION['id'].' AND i.date_of_income >= STR_TO_DATE("'.$date->format('Y-01-01').'","%Y-%m-%d") AND i.date_of_income <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") AND i.user_id = '.$_SESSION['id'].' ORDER BY i.date_of_income DESC;';
      
      if($result = $connection->query($instructionRetrieveIncomesDetail))
      {
        $incomesDetail = $result->fetch_all();
        $_SESSION['incomesDetail'] = $incomesDetail;
      }else{
        throw new Exception($connection->error);
      }

      //expenses detail
      $instructionRetrieveExpensesDetail = 'SELECT i.id, i.date_of_expense, i.amount, c.name, p.name, i.expense_comment FROM expenses i INNER JOIN expenses_category_assigned_to_users c ON i.expense_category_assigned_to_user_id=c.id  INNER JOIN payment_methods_assigned_to_users p ON i.payment_method_assigned_to_user_id = p.id WHERE c.user_id='.$_SESSION['id'].' AND p.user_id='.$_SESSION['id'].' AND i.date_of_expense >= STR_TO_DATE("'.$date->format('Y-01-01').'","%Y-%m-%d") AND i.date_of_expense <= STR_TO_DATE("'.$date->format('Y-m-t').'","%Y-%m-%d") AND i.user_id = '.$_SESSION['id'].' ORDER BY i.date_of_expense DESC;';
      
      if($result = $connection->query($instructionRetrieveExpensesDetail))
      {
        $expensesDetail = $result->fetch_all();
        $_SESSION['expensesDetail'] = $expensesDetail;
      }else{
        throw new Exception($connection->error);
      }

      $result->free_result();

      $_SESSION['caption'] = 'Bilans za bieżący rok ('.$date->format('Y').')';
      $_SESSION['newPeriod'] = true;
      header('Location: balance.php');
      $connection -> close();
    }
    

  } catch (Exception $e) {
    $_SESSION['error'] = '<span class="row  col-10 offset-1 text-danger">Błąd serwera! Przepraszamy za niedogodności i prosimy spróbować w innym terminie!<span>';
    // $_SESSION['error'] .= '<br/> Informacja developerska: '.$e;
  }