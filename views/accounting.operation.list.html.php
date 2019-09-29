<p align="right">
<?php printf(TS::AccountingOperation_OperationCount, count($operations)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::AccountingOperation_Label; ?></th>
  <th><?php echo TS::AccountingOperation_Category; ?></th>
  <th><?php echo TS::AccountingOperation_DateValue; ?></th>
  <th><?php echo TS::AccountingOperation_Amount; ?></th>
  <th><?php echo TS::AccountingOperation_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($operations as $operation)
    {
		$operation_id = $operation['id'];
?> 
<tr>
  <td align="left">
    <?php
      echo $operation['label'];
	?>
  </td>
  <td align="center"><?php echo $operation['category'] ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($operation['date_value']) ?></td>
  <td align="center">
	<?php
		$amount = $operation['amount'];
		echo TSHelper::getCurrencyText($amount);
	?>
  </td>
  <td align="center">
    <a href="<?php echo url_for('/fiscalyears', $fiscalyear['id'])?>"><?php echo TS::Cotisation_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
