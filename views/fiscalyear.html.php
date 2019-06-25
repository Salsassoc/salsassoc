<?php
$formAction=url_for('/fiscalyears/0/edit');
$bAdd=true;
if(isset($fiscalyear['id'])){
	$bAdd = false;
	$formAction=url_for('/fiscalyears', $fiscalyear['id'], 'edit');
}
?>

<div>
  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::FiscalYear_Form_GlobalInfo; ?></legend>

    <div class='form-row'>
      <label><?php echo TS::FiscalYear_Title; ?></label>
      <input type="text" name="Title" value="<?php echo $fiscalyear['title'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::FiscalYear_StartDate; ?></label>
      <input type="text" name="StartDate" value="<?php echo $fiscalyear['start_date'] ?>" placeholder="YYYY-MM-DD" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::FiscalYear_EndDate; ?></label>
      <input type="text" name="EndDate" value="<?php echo $fiscalyear['end_date'] ?>" placeholder="YYYY-MM-DD" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::FiscalYear_IsCurrent; ?></label>
      <select name="IsCurrent">
        <option value="true" <?php echo ($fiscalyear['is_current'] == 'true' ? 'selected' : '') ?>><?php echo TS::Yes; ?></option>
        <option value="false" <?php echo ($fiscalyear['is_current'] == 'false' ? 'selected' : '') ?>><?php echo TS::No; ?></option>
      </select>
    </div>
</fieldset>

<br/>

<input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

</form>
</div>
