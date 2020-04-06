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
        }else{
		    $amount = $operation['amount_debit'];
            $color = "red";
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
