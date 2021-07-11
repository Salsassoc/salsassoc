<?php
$formAction=url_for('/cotisations/0/edit');
$bAdd=true;
if(isset($cotisation['id'])){
	$bAdd = false;
	$formAction=url_for('/cotisations', $cotisation['id'], 'edit');
}
?>

<div>
  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::Cotisation_Form_GlobalInfo; ?></legend>

    <input type="hidden" name="Id" value="<?php echo $cotisation['id'] ?>" />

    <div class='form-row'>
      <label><?php echo TS::Cotisation_Label; ?></label>
      <input type="text" name="Label" value="<?php echo $cotisation['label'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Cotisation_BasicPrice; ?></label>
      <input type="text" name="Amount" value="<?php echo $cotisation['amount'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Cotisation_StartDate; ?></label>
      <input type="text" name="StartDate" value="<?php echo $cotisation['start_date'] ?>" placeholder="YYYY-MM-DD" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Cotisation_EndDate; ?></label>
      <input type="text" name="EndDate" value="<?php echo $cotisation['end_date'] ?>" placeholder="YYYY-MM-DD" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Cotisation_FiscalYear; ?></label>
      <select name="FiscalYearId">
        <?php
            foreach($listFiscalYear as $fiscalYear){
        ?>
              <option value="<?php echo $fiscalYear['id']; ?>" <?php echo ($cotisation['fiscal_year_id'] == $fiscalYear['id'] ? 'selected' : '')?> ><?php echo $fiscalYear['title']; ?></option>
        <?php
            }
        ?>
      </select>
    </div>
    <div class='form-row'>
      <label><?php echo TS::Cotisation_Type; ?></label>
      <select name="Type">
        <?php
            for($i=1; $i<=4; $i++){
        ?>
              <option value="<?php echo $i; ?>" <?php echo ($cotisation['type'] == $i ? 'selected' : '')?> ><?php echo TSHelper::getCotisationType($i); ?></option>
        <?php
            }
        ?>
      </select>
    </div>
</fieldset>

<br/>

<input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

</form>
</div>
