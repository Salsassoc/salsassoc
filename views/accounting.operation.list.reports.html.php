<?php
    $tabOperationByCategoryIncomings = array();
    $tabOperationByCategoryOutcomings = array();

    $tabOperationByCategoryIncomingsSummary = array();
    $tabOperationByCategoryOutcomingsSummary = array();
    
    foreach  ($listAccountingOperation as $operation)
    {
        $category_id = $operation['category'];
		$operation_id = $operation['id'];

		$amount = $operation['amount_credit'];
        if($amount != ''){
            $bIsIncomings = true;
        }else{
		    $amount = $operation['amount_debit'];
            $bIsIncomings = false;
        }

        if($bIsIncomings){
            if(!array_key_exists($category_id, $tabOperationByCategoryIncomings)){
                $tabOperationByCategoryIncomings[$category_id] = array();
                $tabOperationByCategoryIncomingsSummary[$category_id] = 0.0;
            }
            $tabOperationByCategoryIncomings[$category_id][] = $operation_id;
            $tabOperationByCategoryIncomingsSummary[$category_id] += $amount;
        }else{
            if(!array_key_exists($category_id, $tabOperationByCategoryOutcomings)){
                $tabOperationByCategoryOutcomings[$category_id] = array();
                $tabOperationByCategoryOutcomingsSummary[$category_id] = 0.0;
            }
            $tabOperationByCategoryOutcomings[$category_id][] = $operation_id;
            $tabOperationByCategoryOutcomingsSummary[$category_id] += $amount;
        }
    }
?>

<div style="display:table;">
  <div style="display:table-row;">
    <div style="display:table-cell; padding:5px;">
    <?php
      set('tabTitle', "Recettes");
      set('tabOperationByCategory', $tabOperationByCategoryIncomings);
      set('tabOperationByCategorySummary', $tabOperationByCategoryIncomingsSummary);
      echo partial('accounting.operation.list.reports.table.html.php');
    ?>
    </div>

    <div style="display:table-cell;">
    <?php
      set('tabTitle', "Dépenses");
      set('tabOperationByCategory', $tabOperationByCategoryOutcomings);
      set('tabOperationByCategorySummary', $tabOperationByCategoryOutcomingsSummary);
      echo partial('accounting.operation.list.reports.table.html.php');
    ?>
    </div>
  </div>
</div>

