<div class="list-top-infos">
<?php printf(TS::Person_PersonCount, count($personlist)); ?>
 - 
<a href="<?php echo url_for('/members/print')?>">Print</a>
</div>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::Person_Lastname; ?></th>
  <th><?php echo TS::Person_Firstname; ?></th>
  <th><?php echo TS::Person_Birthdate; ?></th>
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
    foreach  ($personlist as $person)
    {
        $cotisation_member = getCotisationSumForPerson($person["id"], $listCotisationMember);
?> 
<tr>
  <td align="left"><?php echo $person['lastname'] ?></td>
  <td align="left"><?php echo $person['firstname'] ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($person['birthdate']) ?></td>
  <td align="center"><?php echo ($person['city'] ? $person['city']." (".$person['zipcode'].")" : "") ?></td>
  <td align="center"><?php echo $person['email'] ?></td>
  <td align="center"><?php echo $person['phonenumber'] ?></td>
  <td align="center"><?php echo TSHelper::getYesNoUnknownText($person['image_rights']); ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($cotisation_member['date']); ?></td>
  <td align="center"><?php echo TSHelper::getCurrencyText($cotisation_member['amount']); ?></td>
  <td align="center"><?php echo TSHelper::getPaymentMethod($cotisation_member['payment_method']); ?></td>
  <td align="center">
    <a href="<?php echo url_for('/members', $person['id'])?>"><?php echo TS::Person_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
