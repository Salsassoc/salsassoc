<?php
$formAction=url_for('/cotisation/register');
?>

<div>
  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <fieldset>
    <legend><?php echo TS::Cotisation_CotisationMemberInfos; ?></legend>

    <input type="hidden" name="PersonId" value="<?php echo (isset($person['id']) ? $person['id'] : "") ?>" />

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
      <input type="text" name="Birthdate" value="<?php echo $person['birthdate'] ?>" />
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
      <textarea name="Comments" cols="50" rows="10">
        <?php echo $person['comments']; ?>
      </textarea>
    </div>
</fieldset>

<fieldset>
    <legend><?php echo TS::Cotisation_CotisationList; ?></legend>

	<table>
<?php
	foreach($cotisations as $cotisation){
		$count = 0;
?>
      <tr>
        <td><?php echo $cotisation["label"]; ?></td>
        <td><input type="hidden" name="Cotisation['<?php $count; ?>'][Id]" value="<?php echo $cotisation["id"] ?>" /></td>
        <td>
           <select name="Cotisation['<?php $count; ?>'][PaymentMethod]">
             <option value="">-- <?php echo TS::Unknown ?> --</option>
             <option value="1"><?php echo TS::PaymentMethod_Check ?></option>
             <option value="2"><?php echo TS::PaymentMethod_Cash ?></option>
           </select>
        </td>
        <td><input type="Text" name="Cotisation['<?php $count; ?>'][Amount]" value="<?php echo $cotisation["amount"] ?>" /> <?php echo TS::Currency; ?></td>
      </tr>
<?php
	}	
?>
	</table>

</fieldset>

<input type="submit" value="Save" />

</form>
</div>
