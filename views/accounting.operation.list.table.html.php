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
  <th colspan="2"><?php echo TS::AccountingOperation_Category; ?></th>
  <th><?php echo TS::AccountingOperation_Type; ?></th>
  <th><?php echo TS::AccountingOperation_Amount; ?></th>
  <th><?php echo TS::AccountingOperation_Amount; ?></th>
  <th><?php echo TS::AccountingOperation_FiscalYear; ?></th>
  <th><?php echo TS::AccountingOperation_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    $sum = 0.0;

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
       $category_id = $operation['category'];
       $category = $tabAccountingOperationCategory[$category_id];
       echo $category['label'];
     ?>
  </td>
  <td align="center">
     <?php
       echo $category['account_number'];
     ?>
  </td>
  <td align="center"><?php echo TSHelper::getAccountingOperationMethod($operation['op_method']) ?></td>
  <td align="center">
	<?php
		$amount = $operation['amount_credit'];
        if($amount != ''){
            $color = "green";
            if($category['id'] != 21){
                $totalIncomings += $amount;
            }
        }else{
		    $amount = $operation['amount_debit'];
            $color = "red";
            if($category['id'] != 21){
                $totalOutcomings += $amount;
            }
        }
        $sum += $amount;
    ?>
    <span style="color:<?php echo $color; ?>">
    <?php
		echo TSHelper::getCurrencyText($amount);
	?>
    </span>
  </td>
  <td align="center">
	<?php
        if($sum < 0){
            $color = "red";
        }else{
            $color = "black";
        }
    ?>
    <span style="color:<?php echo $color; ?>">
    <?php
		echo TSHelper::getCurrencyText($sum);
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
<br/>
