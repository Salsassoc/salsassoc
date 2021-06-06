<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::Person_Lastname; ?></th>
  <th><?php echo TS::Person_Firstname; ?></th>
  <th><?php echo TS::Person_Birthdate; ?></th>
  <th><?php echo TS::Person_City; ?></th>
  <th><?php echo TS::Person_Email; ?></th>
  <th colspan="2"><?php echo TS::Person_Phonenumber; ?></th>
  <th><?php echo TS::Person_ImageRights; ?></th>
  <th><?php echo TS::Membership_Date; ?></th>
  <th><?php echo TS::Membership_Type; ?></th>
  <th><?php echo TS::Cotisation_AmountCollected; ?></th>
  <th><?php echo TS::Payment_Payment; ?></th>
  <th><?php echo TS::Membership_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($listMembership as $membership)
    {
?> 
<tr>
  <td align="left"><?php echo $membership['lastname'] ?></td>
  <td align="left"><?php echo $membership['firstname'] ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($membership['birthdate']) ?></td>
  <td align="center"><?php echo ($membership['city'] ? $membership['city']." (".$membership['zipcode'].")" : "") ?></td>
  <td align="center"><?php echo $membership['email'] ?></td>
  <td align="center"><?php echo $membership['phonenumber'] ?></td>
  <td align="center"><?php echo $membership['phonenumber2'] ?></td>
  <td align="center"><?php echo TSHelper::getYesNoUnknownText($membership['image_rights']); ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($membership['membership_date']) ?></td>
  <td align="center"><?php echo TSHelper::getMembershipType($membership['membership_type']) ?></td>
  <td align="center"><?php echo ($membership['total_amount'] ? $membership['total_amount'] : 0) ?> EUR</td>
  <td align="center"><?php echo TSHelper::getPaymentMethod($membership['payment_method']); ?></td>
  <td align="center">
    <a href="<?php echo url_for('/memberships', $membership['id'], 'edit')?>"><?php echo TS::Membership_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
