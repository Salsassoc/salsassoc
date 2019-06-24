<p align="right">
<?php
  $iTotalMembers = count($personlist);
  $iTotalOldMembers = 0;
  foreach ($personlist as $person)
  {
	if($person['cotisation_count'] > 0){
		$iTotalOldMembers++;
    }
  }
?>
Number of members : <?php echo $iTotalMembers; ?>, 
Number of old members : <?php echo $iTotalOldMembers; ?> (<?php echo round(($iTotalOldMembers/$iTotalMembers)*100); ?> %)
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::Person_Lastname; ?></th>
  <th><?php echo TS::Person_Firstname; ?></th>
  <th><?php echo TS::Person_Birthdate; ?></th>
  <th><?php echo TS::Person_Email; ?></th>
  <th><?php echo TS::Person_Phonenumber; ?></th>
  <th><?php echo TS::Person_ImageRights; ?></th>
  <th><?php echo TS::Person_OldMember; ?></th>
  <th><?php echo TS::Person_DateCreated; ?></th>
  <th><?php echo TS::Cotisation_Cotisation; ?></th>
  <th><?php echo TS::Payment_Payment; ?></th>
  <th><?php echo TS::Person_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($personlist as $person)
    {
?> 
<tr>
  <td><?php echo $person['lastname'] ?></td>
  <td><?php echo $person['firstname'] ?></td>
  <td><?php echo TSHelper::getShortDateTextFromDBDate($person['birthdate']) ?></td>
  <td><?php echo $person['email'] ?></td>
  <td><?php echo $person['phonenumber'] ?></td>
  <td><?php echo TSHelper::getYesNoUnknownText($person['image_rights']); ?></td>
  <td><?php echo TSHelper::getYesNoUnknownText(($person['cotisation_count'] == null || $person['cotisation_count'] == 0) ? 'true' : 'false'); ?></td>
  <td><?php echo TSHelper::getShortDateTextFromDBDate($person['creation_date']) ?></td>
  <td><?php echo TSHelper::getCurrencyText($person['amount']); ?></td>
  <td><?php echo TSHelper::getPaymentMethod($person['payment_method']); ?></td>
  <td>
    <a href="<?php echo url_for('/members', $person['id'])?>"><?php echo TS::Person_View; ?></a> - 
    <a href="<?php echo url_for('/cotisations/register/member', $person['id'])?>"><?php echo TS::Cotisation_NewRegister; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
