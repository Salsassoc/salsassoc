<fieldset>
  <legend><?php echo TS::Cotisation_CotisationList; ?></legend>

  <input type="hidden" name="CotisationCount" value="<?php echo count($cotisations); ?>" />

    <table>
<?php
    $count = 0;
    foreach($cotisations as $cotisation)
    {
        $registration_cotisation = registrations_get_cotisation_from_id($registration, $cotisation['id']);

        if($registration_cotisation){
            $enabled = true;
            $amount = $registration_cotisation['amount'];
            $payment_method = $registration_cotisation['payment_method'];
            $date = $registration_cotisation['date'];
        }else{
            // If add
            $enabled = registrations_is_new($registration);
            $amount = $cotisation["amount"];
            $payment_method = 1;
            $date = date("Y-m-d");
        }

?>
      <tr>
        <td><?php echo $cotisation["label"]; ?></td>
        <td><input type="hidden" name="CotisationMember_<?php echo $count; ?>_CotisationId" value="<?php echo $cotisation["id"] ?>" /></td>
        <td>
          <input type="checkbox" name="CotisationMember_<?php echo $count; ?>_Enabled" <?php echo ($enabled ? ' checked="checked"' : ''); ?> />
          <input type="text" name="CotisationMember_<?php echo $count; ?>_Amount" value="<?php echo $amount ?>" /> <?php echo TS::Currency; ?>
          <select name="CotisationMember_PaymentMethod">
            <option value="">-- <?php echo TS::Unknown ?> --</option>
            <option value="0" <?php echo (($payment_method == 0) ? 'selected' : '');?>><?php echo TS::PaymentMethod_None ?></option>
            <option value="1" <?php echo (($payment_method == 1) ? 'selected' : '');?>><?php echo TS::PaymentMethod_Check ?></option>
            <option value="2" <?php echo (($payment_method == 2) ? 'selected' : '');?>><?php echo TS::PaymentMethod_Cash ?></option>
          </select>
          <input type="Text" name="CotisationMember_Date" value="<?php echo $date ?>" placeholder="YYYY-MM-DD" />
        </td>
      </tr>
<?php
      $count++;
	}	
?>
  </table>

</fieldset>
