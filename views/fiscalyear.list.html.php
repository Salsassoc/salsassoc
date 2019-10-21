<p align="right">
<?php printf(TS::FiscalYear_FiscalYearCount, count($fiscalyears)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::FiscalYear_Label; ?></th>
  <th><?php echo TS::FiscalYear_StartDate; ?></th>
  <th><?php echo TS::FiscalYear_EndDate; ?></th>
  <th><?php echo TS::FiscalYear_Members; ?></th>
  <th><?php echo TS::FiscalYear_MembershipAmount; ?></th>
  <th><?php echo TS::FiscalYear_View; ?></th>
</tr>
</thead>
<tbody>
<?php
	// Compute associative array for fiscal year person count
	$tabFiscalYearsMembersCount = array();
    foreach  ($fiscalyearsmemberscount as $fiscalyearmemberscount)
    {
		$tabFiscalYearsMembersCount[$fiscalyearmemberscount['fiscal_year_id']] = $fiscalyearmemberscount['membership_count'];
	}

	// Compute associative array for fiscal year amount
	$tabFiscalYearsAmount = array();
    foreach  ($fiscalyearsamount as $fiscalyearamount)
    {
		$tabFiscalYearsAmount[$fiscalyearamount['fiscal_year_id']] = $fiscalyearamount['total_amount'];
	}

    foreach  ($fiscalyears as $fiscalyear)
    {
		$fiscalyear_id = $fiscalyear['id'];
?> 
<tr>
  <td align="left">
    <?php
	  $title = $fiscalyear['title'];
      if($title == ""){
		$title = sprintf(TS::FiscalYear_YearTitle, $fiscalyear_id);
	  }
      echo $title;
	?>
  </td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($fiscalyear['start_date']) ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($fiscalyear['end_date']) ?></td>
  <td align="center">
    <a href="<?php echo url_for('/fiscalyears', $fiscalyear['id'], 'memberships')?>">
		<?php
			$memberscount=0;
			if(isset($tabFiscalYearsMembersCount[$fiscalyear_id])){
				$memberscount=$tabFiscalYearsMembersCount[$fiscalyear_id];
			}
			printf(TS::Cotisation_MembersCount, $memberscount);
		?>
	</a>
  </td>
  <td align="center">
	<?php
		$totalamount=0.0;
		if(isset($tabFiscalYearsAmount[$fiscalyear_id])){
			$totalamount=$tabFiscalYearsAmount[$fiscalyear_id];
		}
		echo TSHelper::getCurrencyText($totalamount);
	?>
  </td>
  <td align="center">
    <a href="<?php echo url_for('/fiscalyears', $fiscalyear['id'])?>"><?php echo TS::Cotisation_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
