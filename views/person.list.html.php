<div class="list-top-infos">
<?php printf(TS::Person_PersonCount, count($personlist)); ?>
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
  <th><?php echo TS::Person_YearCount; ?></th>
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
  <td><?php echo ($person['city'] ? $person['city']." (".$person['zipcode'].")" : "") ?></td>
  <td><?php echo $person['email'] ?></td>
  <td><?php echo $person['phonenumber'] ?></td>
  <td><?php echo TSHelper::getYesNoUnknownText($person['image_rights']); ?></td>
  <td><?php echo $person['creation_date'] ?></td>
  <td>
	<?php echo sprintf(TS::Person_YearCountText, $person['year_count']);?>
	<!--(<?php echo $person['cotisation_count'] ?> cotis.)-->
  </td>
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
