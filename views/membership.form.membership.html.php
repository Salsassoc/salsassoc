<fieldset>
  <legend><?php echo TS::Membership_Membership; ?></legend>

  <input type="hidden" name="MembershipId" value="<?php echo (isset($membership['id']) ? $membership['id'] : "") ?>" />
  <input type="hidden" name="MembershipFiscalYearId" value="<?php echo $membership['fiscal_year_id'] ?>" />

  <div class='form-row'>
    <label><?php echo TS::Membership_Date; ?></label>
    <input type="text" name="MembershipDate" value="<?php echo $membership['membership_date'] ?>" placeholder="YYYY-MM-DD" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Membership_Type; ?></label>
    <select name="MembershipType">
      <option value=""><?php echo TS::Unknown; ?></option>
      <option value="1" <?php echo ($membership['membership_type'] == 1 ? 'selected' : '') ?>><?php echo TS::MembershipType_MembershipStandard; ?></option>
      <option value="2" <?php echo ($membership['membership_type'] == 2 ? 'selected' : '') ?>><?php echo TS::MembershipType_MembershipDiscounted; ?></option>
      <option value="3" <?php echo ($membership['membership_type'] == 3 ? 'selected' : '') ?>><?php echo TS::MembershipType_ExecutiveBoard; ?></option>
      <option value="4" <?php echo ($membership['membership_type'] == 4 ? 'selected' : '') ?>><?php echo TS::MembershipType_Professor; ?></option>
    </select>
  </div>
  <div class='form-row'>
    <label><?php echo TS::Membership_Comments; ?></label>
    <textarea name="Comments" cols="50" rows="10"><?php echo $membership['comments']; ?></textarea>
  </div>

</fieldset>
