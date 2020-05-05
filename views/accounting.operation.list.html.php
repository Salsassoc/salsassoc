<?php
$formAction=url_for('/accounting/operations');
?>

<form method="POST" action="<?php echo $formAction; ?>">

  <select name="FiscalYearId">
     <option value="">-- <?php echo TS::AccountingOperation_FiscalYear; ?> --</option>
    <?php
        $fiscal_year_id = $filters['fiscal_year_id'];
        foreach($listFiscalYear as $fiscal_year){
    ?>
          <option value="<?php echo $fiscal_year['id']; ?>" <?php echo ($fiscal_year_id == $fiscal_year['id'] ? 'selected' : '')?> ><?php echo $fiscal_year['title']; ?></option>
    <?php
        }
    ?>
  </select>

  <select name="AccountId">
     <option value="">-- <?php echo TS::AccountingOperation_Account; ?> --</option>
    <?php
        $account_id = $filters['account_id'];
        foreach($listAccountingAccount as $account){
    ?>
          <option value="<?php echo $account['id']; ?>" <?php echo ($account_id == $account['id'] ? 'selected' : '')?> ><?php echo $account['label']; ?></option>
    <?php
        }
    ?>
  </select>

  <select name="CategoryId">
     <option value="">-- <?php echo TS::AccountingOperation_Category; ?> --</option>
    <?php
        $category_id = $filters['category_id'];
        foreach($listAccountingOperationCategory as $category){
    ?>
          <option value="<?php echo $category['id']; ?>" <?php echo ($category_id == $category['id'] ? 'selected' : '')?> ><?php echo $category['label']; ?></option>
    <?php
        }
    ?>
  </select>

  <input type="submit" />
</form>


<?php include("accounting.operation.list.table.html.php"); ?>

<br/>

<?php include("accounting.operation.list.summary.php"); ?>

<br/>
<br/>
