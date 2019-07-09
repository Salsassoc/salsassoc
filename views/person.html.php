<?php
$formAction=url_for('/members/0/edit');
$bAdd=true;
if(isset($person['id'])){
	$bAdd = false;
	$formAction=url_for('/members', $person['id'], 'edit');
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
      <input type="text" name="Lastname" value="<?php echo $person['lastname'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Firstname; ?></label>
      <input type="text" name="Firstname" value="<?php echo $person['firstname'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Birthdate; ?></label>
      <input type="text" name="Birthdate" value="<?php echo $person['birthdate'] ?>" placeholder="YYYY-MM-DD" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Email; ?></label>
      <input type="text" name="Email" value="<?php echo $person['email'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Phonenumber; ?></label>
      <input type="text" name="Phonenumber" value="<?php echo $person['phonenumber'] ?>" />
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_ImageRights; ?></label>
      <select name="Imagerights">
        <option value=""><?php echo TS::Unknown; ?></option>
        <option value="true" <?php echo ($person['image_rights'] == 'true' ? 'selected' : '') ?>><?php echo TS::Yes; ?></option>
        <option value="false" <?php echo ($person['image_rights'] == 'false' ? 'selected' : '') ?>><?php echo TS::No; ?></option>
      </select>
    </div>
    <div class='form-row'>
      <label><?php echo TS::Person_Comments; ?></label>
      <textarea name="Comments" cols="50" rows="10"><?php echo $person['comments']; ?></textarea>
    </div>
</fieldset>

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
    foreach  ($cotisations as $cotisation)
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
