<div class="list-top-infos">
<?php printf(TS::Registration_RegistrationCount, count($listRegistrations)); ?>
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
  <th><?php echo TS::Registration_Date; ?></th>
  <th><?php echo TS::Registration_Type; ?></th>
  <th><?php echo TS::Registration_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($listRegistrations as $registration)
    {
?> 
<tr>
  <td align="left"><?php echo $registration['lastname'] ?></td>
  <td align="left"><?php echo $registration['firstname'] ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($registration['birthdate']) ?></td>
  <td align="center"><?php echo ($registration['city'] ? $registration['city']." (".$registration['zipcode'].")" : "") ?></td>
  <td align="center"><?php echo $registration['email'] ?></td>
  <td align="center"><?php echo $registration['phonenumber'] ?></td>
  <td align="center"><?php echo TSHelper::getYesNoUnknownText($registration['image_rights']); ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($registration['registration_date']) ?></td>
  <td align="center"><?php echo TSHelper::getRegistrationType($registration['registration_type']) ?></td>
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
