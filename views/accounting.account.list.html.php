<p align="right">
<?php printf(TS::AccountingAccount_AccountCount, count($listAccountingAccount)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::AccountingAccount_Label; ?></th>
  <th><?php echo TS::AccountingAccount_Type; ?></th>
  <th><?php echo TS::AccountingAccount_AmountIncomings; ?></th>
  <th><?php echo TS::AccountingAccount_AmountOutcomings; ?></th>
  <th><?php echo TS::AccountingAccount_AmountBalance; ?></th>
  <th><?php echo TS::AccountingAccount_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    // Compute associative array for category
	$tabAccountingAccountIncomings = array();
	$tabAccountingAccountOutcomings = array();
    foreach  ($listAccountingAccountResume as $resume)
    {
		$account_id = $resume['account_id'];
		$tabAccountingAccountIncomings[$account_id] = $resume['incomings'];
		$tabAccountingAccountOutcomings[$account_id] = $resume['outcommings'];
	}

    foreach  ($listAccountingAccount as $account)
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
        $amount_debit = 0;
        if(array_key_exists($account_id, $tabAccountingAccountIncomings)){
		  $amount_debit = $tabAccountingAccountIncomings[$account_id];
		  echo TSHelper::getCurrencyText($amount_debit);
        }
	?>
  </td>
  <td align="center">
	<?php
        $amount_credit = 0;
        if(array_key_exists($account_id, $tabAccountingAccountOutcomings)){
		  $amount_credit = $tabAccountingAccountOutcomings[$account_id];
		  echo TSHelper::getCurrencyText($amount_credit);
        }
	?>
  </td>
  <td align="center">
	<?php
        $amount = $amount_credit + $amount_debit;
        if($amount < 0){
            $color = "red";
        }else if($amount > 0){
            $color = "green";
        }else{
            $color = "black";
        }
    ?>
    <span style="color:<?php echo $color; ?>">
	<?php
		echo TSHelper::getCurrencyText($amount);
	?>
    </span>
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
