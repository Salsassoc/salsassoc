<div class="list-top-infos">
<?php printf(TS::Membership_MembershipCount, count($memberships)); ?>
 - 
<a href="<?php echo url_for('/members/print')?>">Print</a>
</div>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::Person_Lastname; ?></th>
  <th><?php echo TS::Person_Firstname; ?></th>
  <th><?php echo TS::Person_Birthdate; ?></th>
  <th><?php echo TS::Person_Zipcode; ?></th>
  <th><?php echo TS::Person_City; ?></th>
  <th><?php echo TS::Person_Email; ?></th>
  <th><?php echo TS::Person_Phonenumber; ?></th>
  <th><?php echo TS::Person_ImageRights; ?></th>
  <th><?php echo TS::Person_DateCreated; ?></th>
  <th><?php echo TS::FiscalYear_Members_CotisationsAmount; ?></th>
  <th><?php echo TS::FiscalYear_Members_CotisationsPaymentMethod; ?></th>
  <th><?php echo TS::Person_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($memberships as $membership)
    {
        $membership_cotisation = getCotisationSumForMembership($membership["id"], $listCotisationMember);
?> 
<tr>
  <td align="left"><?php echo $membership['lastname'] ?></td>
  <td align="left"><?php echo $membership['firstname'] ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($membership['birthdate']) ?></td>
  <td align="center"><?php echo $membership['zipcode'] ?></td>
  <td align="center"><?php echo $membership['city'] ?></td>
  <td align="center"><?php echo $membership['email'] ?></td>
  <td align="center"><?php echo $membership['phonenumber'] ?></td>
  <td align="center"><?php echo TSHelper::getYesNoUnknownText($membership['image_rights']); ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($membership['membership_date']); ?></td>
  <td align="center"><?php echo TSHelper::getCurrencyText($membership_cotisation['amount']); ?></td>
  <td align="center"><?php echo TSHelper::getPaymentMethod($membership_cotisation['payment_method']); ?></td>
  <td align="center">
    <a href="<?php echo url_for('/membership', $membership['id'])?>"><?php echo TS::Person_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
