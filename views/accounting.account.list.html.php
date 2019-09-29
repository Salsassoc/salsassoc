<p align="right">
<?php printf(TS::AccountingAccount_AccountCount, count($accounts)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::AccountingAccount_Label; ?></th>
  <th><?php echo TS::AccountingAccount_Type; ?></th>
  <th><?php echo TS::AccountingAccount_Amount; ?></th>
  <th><?php echo TS::AccountingAccount_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($accounts as $account)
    {
		$account_id = $account['id'];
?> 
<tr>
  <td align="list">
    <?php
      echo $account['label'];
	?>
  </td>
  <td align="center"><?php echo TSHelper::getAccountType($account['type']) ?></td>
  <td align="center">
	<?php
		$amount = 0.0;
		echo TSHelper::getCurrencyText($amount);
	?>
  </td>
  <td align="center">
    <a href="<?php echo url_for('/accounting/accounts/', $account['id'])?>"><?php echo TS::AccountingAccount_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
