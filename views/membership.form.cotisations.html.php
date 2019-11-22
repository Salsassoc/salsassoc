<fieldset>
  <legend><?php echo TS::Cotisation_CotisationList; ?></legend>

  <input type="hidden" name="CotisationCount" value="<?php echo count($cotisations); ?>" />

    <table>
<?php
    $count = 0;
    foreach($cotisations as $cotisation)
    {
        $membership_cotisation = memberships_get_cotisation_from_id($membership, $cotisation['id']);

        if($membership_cotisation){
            $enabled = true;
            $amount = $membership_cotisation['amount'];
            $payment_method = $membership_cotisation['payment_method'];
            $date = $membership_cotisation['date'];
        }else{
            // If add
            $enabled = memberships_is_new($membership);
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
          <select name="CotisationMember_<?php echo $count; ?>_PaymentMethod">
            <option value="">-- <?php echo TS::Unknown ?> --</option>
            <option value="0" <?php echo (($payment_method == 0) ? 'selected' : '');?>><?php echo TS::PaymentMethod_None ?></option>
            <option value="1" <?php echo (($payment_method == 1) ? 'selected' : '');?>><?php echo TS::PaymentMethod_Check ?></option>
            <option value="2" <?php echo (($payment_method == 2) ? 'selected' : '');?>><?php echo TS::PaymentMethod_Cash ?></option>
            <option value="3" <?php echo (($payment_method == 3) ? 'selected' : '');?>><?php echo TS::PaymentMethod_CreditCard ?></option>
          </select>
          <input type="Text" name="CotisationMember_<?php echo $count; ?>_Date" value="<?php echo $date ?>" placeholder="YYYY-MM-DD" />
        </td>
      </tr>
<?php
      $count++;
	}	
?>
  </table>

</fieldset>
