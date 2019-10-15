<fieldset>
  <legend><?php echo TS::Cotisation_CotisationList; ?></legend>

  <input type="hidden" name="CotisationCount" value="<?php echo count($cotisations); ?>" />

    <table>
<?php
    $count = 0;
    foreach($cotisations as $cotisation){
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
