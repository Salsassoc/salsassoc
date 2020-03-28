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
  <th colspan="2"><?php echo TS::Person_Phonenumber; ?></th>
  <th><?php echo TS::Person_ImageRights; ?></th>
  <th><?php echo TS::Person_DateCreated; ?></th>
  <th><?php echo TS::Person_YearCount; ?></th>
  <th><?php echo TS::Person_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    // Compute associative array for fiscal year person count
	$tabPersonYearCount = array();
    foreach  ($listPersonYearCount as $personyearcount)
    {
        //echo "person:".$personyearcount['person_id']."=".$personyearcount['year_count']."<br/>";
		$tabPersonYearCount[$personyearcount['person_id']] = $personyearcount['year_count'];
	}

    foreach  ($personlist as $person)
    {
       $person_id = $person['id'];
?> 
<tr>
  <td align="left"><?php echo $person['lastname'] ?></td>
  <td align="left"><?php echo $person['firstname'] ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($person['birthdate']) ?></td>
  <td align="center"><?php echo ($person['city'] ? $person['city']." (".$person['zipcode'].")" : "") ?></td>
  <td align="center"><?php echo $person['email'] ?></td>
  <td align="center"><?php echo $person['phonenumber'] ?></td>
  <td align="center"><?php echo $person['phonenumber2'] ?></td>
  <td align="center"><?php echo TSHelper::getYesNoUnknownText($person['image_rights']); ?></td>
  <td align="center"><?php echo $person['creation_date'] ?></td>
  <td align="center">
	<?php echo sprintf(TS::Person_YearCountText, $tabPersonYearCount[$person_id]); ?>
	<!--(<?php echo $person['cotisation_count'] ?> cotis.)-->
  </td>
  <td align="center">
    <a href="<?php echo url_for('/members', $person['id'])?>"><?php echo TS::Person_View; ?></a> - 
    <a href="<?php echo url_for('/memberships/add/member', $person['id'])?>"><?php echo TS::Cotisation_NewRegister; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
