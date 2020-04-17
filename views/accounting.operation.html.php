<?php
$formAction=url_for('/accounting/operations/0/edit');
$bAdd=true;
if(isset($operation['id'])){
	$bAdd = false;
	$formAction=url_for('/accounting/operations/', $operation['id'], 'edit');
}
?>

<table class="table-column">
<tr>

<!-- left side -->
<td class="table-column-left">

  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::AccountingOperation_Form_GlobalInfo; ?></legend>

    <input type="hidden" name="Id" value="<?php echo $operation['id'] ?>" />

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_Label; ?></label>
      <input type="text" name="Label" value="<?php echo $operation['label'] ?>" />
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_DateValue; ?></label>
      <input type="text" name="DateValue" value="<?php echo $operation['date_value'] ?>" placeholder="YYYY-MM-DD" />
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_Category; ?></label>
      <select name="CategoryId">
        <?php
            foreach($listAccountingOperationCategory as $category){
        ?>
              <option value="<?php echo $category['id']; ?>" <?php echo ($operation['category'] == $category['id'] ? 'selected' : '')?> ><?php echo $category['label']; ?></option>
        <?php
            }
        ?>
      </select>
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_FiscalYear; ?></label>
      <select name="FiscalYearId">
        <?php
            foreach($listFiscalYear as $fiscalYear){
        ?>
              <option value="<?php echo $fiscalYear['id']; ?>" <?php echo ($operation['fiscalyear_id'] == $fiscalYear['id'] ? 'selected' : '')?> ><?php echo $fiscalYear['title']; ?></option>
        <?php
            }
        ?>
      </select>
    </div>
  </fieldset>

  <fieldset>
    <legend><?php echo TS::AccountingOperation_Form_Transaction; ?></legend>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_Type; ?></label>
      <select name="OpMethod">
        <?php
            $listOpMethod = OperationMethod::getOperationMethodList();
            foreach($listOpMethod as $opMethod){
        ?>
              <option value="<?php echo $opMethod; ?>" <?php echo ($operation['op_method'] == $opMethod ? 'selected' : '')?> ><?php echo TsHelper::getAccountingOperationMethod($opMethod); ?></option>
        <?php
            }
        ?>
      </select>
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_Number; ?></label>
      <input type="text" name="OpMethodNumber" value="<?php echo $operation['op_method_number'] ?>" />
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_AmountDebit; ?></label>
      <input type="text" name="AmountDebit" value="<?php echo $operation['amount_debit'] ?>" />
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_AmountCredit; ?></label>
      <input type="text" name="AmountCredit" value="<?php echo $operation['amount_credit'] ?>" />
    </div>

  </fieldset>

  <fieldset>
    <legend><?php echo TS::AccountingOperation_Form_Account; ?></legend>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_Account; ?></label>
      <select name="AccountId">
        <?php
            foreach($listAccountingAccount as $account){
        ?>
              <option value="<?php echo $account['id']; ?>" <?php echo ($operation['account_id'] == $account['id'] ? 'selected' : '')?> ><?php echo $account['label']; ?></option>
        <?php
            }
        ?>
      </select>
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_DateEffective; ?></label>
      <input type="text" name="DateEffective" value="<?php echo $operation['date_effective'] ?>" placeholder="YYYY-MM-DD" />
    </div>

    <div class='form-row'>
      <label><?php echo TS::AccountingOperation_LabelBank; ?></label>
      <textarea name="LabelBank" rows="5"><?php echo $operation['label_bank'] ?></textarea>
    </div>

  </fieldset>

  <br/>

  <input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

  </form>

</td>
</tr>
</table>
