<p align="right">
<?php printf(TS::AccountingOperationCategory_Count, count($operationcategories)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::AccountingOperationCategory_Label; ?></th>
  <th><?php echo TS::AccountingOperationCategory_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($operationcategories as $operationcategory)
    {
		$account_id = $operationcategory['id'];
?> 
<tr>
  <td>
    <?php
      echo $operationcategory['label'];
	?>
  </td>
  <td>
    <a href="<?php echo url_for('/accounting/operationcategories/', $operationcategory['id'])?>"><?php echo TS::AccountingOperationCategory_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
