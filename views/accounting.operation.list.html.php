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

  <select name="CalendarYear">
     <option value="">-- <?php echo TS::AccountingOperation_CalendarYear; ?> --</option>
    <?php
        $current_year = intval(date('Y'));
        $selected_year = $filters['calendar_year'];
        for($i=$current_year; $i>=1999; $i--)
        {
    ?>
          <option value="<?php echo $i; ?>" <?php echo ($i == $selected_year ? 'selected' : '')?> ><?php echo $i; ?></option>
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

<?php
    // Compute associative array for fiscal year
	$tabFiscalYear = array();
    foreach  ($listFiscalYear as $fiscalyear)
    {
		$tabFiscalYear[$fiscalyear['id']] = $fiscalyear['title'];
	}

    // Compute associative array for account
	$tabAccount = array();
    foreach  ($listAccountingAccount as $account)
    {
		$tabAccount[$account['id']] = $account['label'];
	}

    // Compute associative array for category
	$tabAccountingOperationCategory = array();
    foreach  ($listAccountingOperationCategory as $category)
    {
		$tabAccountingOperationCategory[$category['id']] = $category;
	}

    $totalIncomings = 0.0;
    $totalOutcomings = 0.0;

    set('tabAccountingOperationCategory', $tabAccountingOperationCategory);

?>

<br/>

<?php include("accounting.operation.list.table.html.php"); ?>

<br/>

<?php include("accounting.operation.list.summary.html.php"); ?>

<br/>

<?php include("accounting.operation.list.reports.html.php"); ?>

<br/>

<br/>
<br/>
