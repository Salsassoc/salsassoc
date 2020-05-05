<?php
    $tabAccountingOperation = array();
    foreach  ($listAccountingOperation as $operation)
    {
		$tabAccountingOperation[$operation['id']] = $operation;
    }

    $totalAmount = 0.0;

?>

<table class="list">
<thead>
<tr>
  <th colspan="3"><?php echo $tabTitle; ?></th>
</tr>
<tr>
  <th>Date</th>
  <th>Libellé</th>
  <th>Montant</th>
</tr>
</thead>
<tbody>
  <?php 

    foreach  ($tabOperationByCategory as $category_id => $listOperations)
    {
  ?>
  <tr>
    <th align="left" colspan="2">
      <?php
        $category = $tabAccountingOperationCategory[$category_id];
        echo $category['label'];
      ?>
    </th>
    <th align="right" nowrap>
      <?php
        $sum = $tabOperationByCategorySummary[$category_id];
        $totalAmount += $sum;
        echo TSHelper::getCurrencyText($sum);
      ?>
    </th>
  </tr>
      
  <?php
    foreach  ($listOperations as $operation_id)
    {
      $operation = $tabAccountingOperation[$operation_id];
  ?>
     <tr>
       <td align="center" nowrap><?php echo TSHelper::getShortDateTextFromDBDate($operation['date_effective']) ?></td>
       <td align="left" nowrap><?php echo $operation['label']; ?></td>
       <td align="right" nowrap>
	    <?php
		    $amount = $operation['amount_credit'];
            if($amount != ''){
                if($category['id'] != 21){
                    //$totalIncomings += $amount;
                }
            }else{
		        $amount = $operation['amount_debit'];
                if($category['id'] != 21){
                    //$totalOutcomings += $amount;
                }
            }
        ?>
        <span style="color:<?php echo $color; ?>">
        <?php
		    echo TSHelper::getCurrencyText($amount);
	    ?>
        </span>
       </td>
     </tr>
  <?php
    }
  ?>
  <?php      
    }
  ?>
</tbody>

<tfoot>
<tr>
  <th align="left" colspan="2">Total</th>
  <th colspan="">
    <?php
	  echo TSHelper::getCurrencyText($totalAmount);
	?>
  </th>
</tr>
</tfoot>

</table>

