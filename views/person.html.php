<?php
$formAction=url_for('/members/0/edit');
$bAdd=true;
if(isset($person['id'])){
	$bAdd = false;
	$formAction=url_for('/members', $person['id'], 'edit');
}
?>


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
    <label><?php echo TS::Person_Address; ?></label>
    <input type="text" name="Address" value="<?php echo $person['address'] ?>"  />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_Zipcode; ?></label>
    <input type="text" name="Zipcode" value="<?php echo $person['zipcode'] ?>"  />
  </div>
  <div class='form-row'>
    <label><?php echo TS::Person_City; ?></label>
    <input type="text" name="City" value="<?php echo $person['city'] ?>"  />
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
    <label><?php echo TS::Person_Phonenumber; ?></label>
    <input type="text" name="Phonenumber2" value="<?php echo $person['phonenumber2'] ?>" />
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

<br/>

<input type="submit" value="<?php echo ($bAdd ? 'Add' : 'Save'); ?>">

<br/>

</form>

</td>

<!-- right side -->
<td class="table-column-right">

<?php
if(!$bAdd){
?>
  <h2><?php echo TS::Membership_Memberships; ?></h2>
<?php
  include("membership.list.table.html.php");
}
?>

</td>
</tr>
</table>

<br/>

