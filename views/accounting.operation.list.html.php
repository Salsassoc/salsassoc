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


<p align="right">
<?php printf(TS::AccountingOperation_OperationCount, count($listAccountingOperation)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::AccountingOperation_DateValue; ?></th>
  <th><?php echo TS::AccountingOperation_DateEffective; ?></th>
  <th><?php echo TS::AccountingOperation_Label; ?></th>
  <th><?php echo TS::AccountingOperation_Number; ?></th>
  <th><?php echo TS::AccountingOperation_Category; ?></th>
  <th><?php echo TS::AccountingOperation_Type; ?></th>
  <th><?php echo TS::AccountingOperation_Amount; ?></th>
  <th><?php echo TS::AccountingOperation_FiscalYear; ?></th>
  <th><?php echo TS::AccountingOperation_View; ?></th>
</tr>
</thead>
<tbody>
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
		$tabAccountingOperationCategory[$category['id']] = $category['label'];
	}

    $totalIncomings = 0.0;
    $totalOutcomings = 0.0;

    foreach  ($listAccountingOperation as $operation)
    {
		$operation_id = $operation['id'];
?> 
<tr>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($operation['date_value']) ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($operation['date_effective']) ?></td>
  <td align="left"><?php echo $operation['label']; ?></td>
  <td align="center">
     <?php
       $number = $operation['op_method_number'];
       echo $number;
     ?>
  <td align="center">
     <?php
       $category = $operation['category'];
       echo $tabAccountingOperationCategory[$category];
     ?>
  </td>
  <td align="center"><?php echo TSHelper::getAccountingOperationMethod($operation['op_method']) ?></td>
  <td align="center">
	<?php
		$amount = $operation['amount_credit'];
        if($amount != ''){
            $color = "green";
            $totalIncomings += $amount;
        }else{
		    $amount = $operation['amount_debit'];
            $color = "red";
            $totalOutcomings += $amount;
        }
    ?>
    <span style="color:<?php echo $color; ?>">
    <?php
		echo TSHelper::getCurrencyText($amount);
	?>
    </span>
  </td>
  <td align="center">
	<?php
		$fiscalyear = $operation['fiscalyear_id'];
		echo $tabFiscalYear[$fiscalyear];
	?>
  </td>
  <td align="center">
    <a href="<?php echo url_for('/accounting/operations/', $operation['id'])?>"><?php echo TS::Cotisation_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>

<br/>

<table class="list" align="right" style="min-width:400px">
<thead>
<tr>
  <th><?php echo TS::AccountingAccount_AmountIncomings; ?></th>
  <th><?php echo TS::AccountingAccount_AmountOutcomings; ?></th>
  <th><?php echo TS::AccountingAccount_AmountBalance; ?></th>
</tr>
</thead>
<tbody>
<tr>
  <td><?php echo TSHelper::getCurrencyText($totalIncomings); ?></td>
  <td><?php echo TSHelper::getCurrencyText($totalOutcomings); ?></td>
  <td>
	<?php
		$amount = $totalIncomings+$totalOutcomings;
        if($amount >= 0){
            $color = "green";
        }else{
            $color = "red";
        }
    ?>
    <span style="color:<?php echo $color; ?>">
    <?php
		echo TSHelper::getCurrencyText($amount);
	?>
    </span>
  </td>
</tr>
</tbody>
</table>

<br/>
<br/>
