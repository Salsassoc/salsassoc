<?php
$formAction=url_for('/accounting/accounts/0/edit');
$bAdd=true;
if(isset($account['id'])){
	$bAdd = false;
	$formAction=url_for('/accounting/accounts/', $account['id'], 'edit');
}
?>

<table class="table-column">
<tr>

<!-- left side -->
<td class="table-column-left">

  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::AccountingAccount_Form_GlobalInfo; ?></legend>

    <div class='form-row'>
      <label><?php echo TS::AccountingAccount_Label; ?></label>
      <input type="text" name="Label" value="<?php echo $account['label'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::AccountingAccount_Type; ?></label>
      <select name="Type">
        <option value="1" <?php echo ($account['type'] == '1' ? 'selected' : '') ?>><?php echo TS::AccountType_CashBox; ?></option>
        <option value="2" <?php echo ($account['type'] == '2' ? 'selected' : '') ?>><?php echo TS::AccountType_BankAccount; ?></option>
        <option value=""><?php echo TS::AccountType_Other; ?></option>
      </select>
    </div>
  </fieldset>

  <br/>

  <input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

  </form>

</td>
</tr>
</table>
