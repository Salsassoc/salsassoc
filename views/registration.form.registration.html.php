<fieldset>
  <legend><?php echo TS::Registration_Registration; ?></legend>

  <input type="hidden" name="RegistrationId" value="<?php echo (isset($registration['id']) ? $registration['id'] : "") ?>" />
  <input type="hidden" name="RegistrationFiscalYearId" value="<?php echo $registration['fiscal_year_id'] ?>" />

  <div class='form-row'>
    <label><?php echo TS::Registration_Date; ?></label>
    <input type="text" name="RegistrationDate" value="<?php echo $registration['registration_date'] ?>" placeholder="YYYY-MM-DD" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Registration_Type; ?></label>
    <select name="RegistrationType">
      <option value=""><?php echo TS::Unknown; ?></option>
      <option value="1" <?php echo ($registration['registration_type'] == 1 ? 'selected' : '') ?>><?php echo TS::RegistrationType_MembershipStandard; ?></option>
      <option value="2" <?php echo ($registration['registration_type'] == 2 ? 'selected' : '') ?>><?php echo TS::RegistrationType_MembershipDiscounted; ?></option>
      <option value="3" <?php echo ($registration['registration_type'] == 3 ? 'selected' : '') ?>><?php echo TS::RegistrationType_ExecutiveBoard; ?></option>
      <option value="4" <?php echo ($registration['registration_type'] == 4 ? 'selected' : '') ?>><?php echo TS::RegistrationType_Professor; ?></option>
    </select>
  </div>
</fieldset>
