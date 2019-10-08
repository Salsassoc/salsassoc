<?php
$formAction=url_for('/registrations/0/edit');
$bAdd=true;
if(isset($registration['id'])){
	$bAdd = false;
	$formAction=url_for('/registrations', $registration['id'], 'edit');
}
?>

<table class="table-column">
<tr>

<!-- left side -->
<td class="table-column-left">

  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::Person_Form_GlobalInfo; ?></legend>

    <div class='form-row'>
      <label><?php echo TS::Person_Lastname; ?></label>
      <input type="text" name="Lastname" value="<?php echo $registration['lastname'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Firstname; ?></label>
      <input type="text" name="Firstname" value="<?php echo $registration['firstname'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Birthdate; ?></label>
      <input type="text" name="Birthdate" value="<?php echo $registration['birthdate'] ?>" placeholder="YYYY-MM-DD" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Address; ?></label>
      <input type="text" name="Address" value="<?php echo $registration['address'] ?>"  />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Zipcode; ?></label>
      <input type="text" name="Zipcode" value="<?php echo $registration['zipcode'] ?>"  />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_City; ?></label>
      <input type="text" name="City" value="<?php echo $registration['city'] ?>"  />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Email; ?></label>
      <input type="text" name="Email" value="<?php echo $registration['email'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Phonenumber; ?></label>
      <input type="text" name="Phonenumber" value="<?php echo $registration['phonenumber'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_ImageRights; ?></label>
      <select name="Imagerights">
        <option value=""><?php echo TS::Unknown; ?></option>
        <option value="true" <?php echo ($registration['image_rights'] == 'true' ? 'selected' : '') ?>><?php echo TS::Yes; ?></option>
        <option value="false" <?php echo ($registration['image_rights'] == 'false' ? 'selected' : '') ?>><?php echo TS::No; ?></option>
      </select>
    </div>
</fieldset>

<br />

<input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

</form>

</td>

<!-- right side -->
<td class="table-column-right">

<?php
if(!$bAdd){
?>

  <fieldset>
    <legend><?php echo TS::Cotisation_Cotisation; ?></legend>

<table class="list">
<thead>
<tr>
  <th>Cotisation</th>
  <th>Date</th>
  <th>Amount</th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($listCotisations as $cotisation)
    {
?> 
<tr>
  <td><?php echo $cotisation['label'] ?></td>
  <td><?php echo $cotisation['date'] ?></td>
  <td><?php echo $cotisation['amount'] ?></td>
</tr>
<?php
    }
?>
</tr>
</tbody>
</table>

  </fieldset>

<?php
}
?>

</td>
</tr>
</table>
