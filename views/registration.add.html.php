<?php
$formAction=url_for('/regisrations/add');
?>
    <?php
        if(isset($person['id'])){
    ?>
    <div class='form-row'>
      <span><?php echo sprintf(TS::Person_MemberId, $person['id']); ?></span>
    </div>
    <?php
        }
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

<fieldset>
    <legend><?php echo TS::Cotisation_CotisationList; ?></legend>

    <input type="hidden" name="CotisationCount" value="<?php echo count($cotisations); ?>" />

	<table>
<?php
	$count = 0;
	foreach($listCotisations as $cotisation){
?>
      <tr>
        <td><?php echo $cotisation["label"]; ?></td>
        <td><input type="hidden" name="CotisationMember_<?php echo $count; ?>_CotisationId" value="<?php echo $cotisation["id"] ?>" /></td>
        <td>
            <input type="checkbox" name="CotisationMember_<?php echo $count; ?>_Enabled" checked="checked" />
            <input type="text" name="CotisationMember_<?php echo $count; ?>_Amount" value="<?php echo $cotisation["amount"] ?>" /> <?php echo TS::Currency; ?></td>
      </tr>
<?php

        $count++;
	}	
?>
      <tr>
        <td><?php echo  TS::Payment_Payment; ?></td>
        <td colspan="2">
            <select name="CotisationMember_PaymentMethod">
                <option value="">-- <?php echo TS::Unknown ?> --</option>
                <option value="0"><?php echo TS::PaymentMethod_None ?></option>
                <option value="1"><?php echo TS::PaymentMethod_Check ?></option>
                <option value="2"><?php echo TS::PaymentMethod_Cash ?></option>
            </select>
        </td>
      </tr>
      <tr>
        <td><?php echo TS::Date; ?></td>
        <td colspan="2">
            <input type="Text" name="CotisationMember_Date" value="<?php echo date("Y-m-d") ?>" />
        </td>
      </tr>

	</table>

</fieldset>

<br/>

<input type="submit" value="Save" />

</form>
</div>
