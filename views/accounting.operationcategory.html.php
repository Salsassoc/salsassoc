<?php
$formAction=url_for('/accounting/operationcategories/0/edit');
$bAdd=true;
if(isset($operationcategory['id'])){
	$bAdd = false;
	$formAction=url_for('/accounting/operationcategories/', $operationcategory['id'], 'edit');
}
?>

<table class="table-column">
<tr>

<!-- left side -->
<td class="table-column-left">

  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::AccountingOperationCategory_Form_GlobalInfo; ?></legend>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperationCategory_Label; ?></label>
      <input type="text" name="Label" value="<?php echo $operationcategory['label'] ?>" />
    </div>
  </fieldset>

  <br/>

  <input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

  </form>

</td>
</tr>
</table>
