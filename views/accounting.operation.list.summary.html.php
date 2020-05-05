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
