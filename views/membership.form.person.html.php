<fieldset>
  <legend><?php echo TS::Membership_MemberInfos; ?></legend>

  <input type="hidden" name="PersonId" value="<?php echo (isset($membership['person_id']) ? $membership['person_id'] : "") ?>" />

  <div class='form-row'>
    <label><?php echo TS::Person_Lastname; ?></label>
    <input type="text" name="Lastname" value="<?php echo $membership['lastname'] ?>" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Firstname; ?></label>
    <input type="text" name="Firstname" value="<?php echo $membership['firstname'] ?>" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Birthdate; ?></label>
    <input type="text" name="Birthdate" value="<?php echo $membership['birthdate'] ?>" placeholder="YYYY-MM-DD" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Address; ?></label>
    <input type="text" name="Address" value="<?php echo $membership['address'] ?>"  />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Zipcode; ?></label>
    <input type="text" name="Zipcode" value="<?php echo $membership['zipcode'] ?>"  />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_City; ?></label>
    <input type="text" name="City" value="<?php echo $membership['city'] ?>"  />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Email; ?></label>
    <input type="text" name="Email" value="<?php echo $membership['email'] ?>" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Phonenumber; ?></label>
    <input type="text" name="Phonenumber" value="<?php echo $membership['phonenumber'] ?>" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Phonenumber; ?></label>
    <input type="text" name="Phonenumber2" value="<?php echo $membership['phonenumber2'] ?>" />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_ImageRights; ?></label>
    <select name="Imagerights">
      <option value=""><?php echo TS::Unknown; ?></option>
      <option value="true" <?php echo ($membership['image_rights'] == 'true' ? 'selected' : '') ?>><?php echo TS::Yes; ?></option>
      <option value="false" <?php echo ($membership['image_rights'] == 'false' ? 'selected' : '') ?>><?php echo TS::No; ?></option>
    </select>
  </div>
</fieldset>
