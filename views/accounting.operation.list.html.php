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
  <td>
    <?php
      echo $operation['label'];
	?>
  </td>
  <td><?php echo $operation['category'] ?></td>
  <td><?php echo TSHelper::getShortDateTextFromDBDate($operation['date_value']) ?></td>
  <td>
	<?php
		$amount = $operation['amount'];
		echo TSHelper::getCurrencyText($amount);
	?>
  </td>
  <td>
    <a href="<?php echo url_for('/fiscalyears', $fiscalyear['id'])?>"><?php echo TS::Cotisation_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
