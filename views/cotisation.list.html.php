<p align="right">
<?php printf(TS::Cotisation_CotisationCount, count($listCotisation)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::Cotisation_Label; ?></th>
  <th><?php echo TS::Cotisation_Type; ?></th>
  <th><?php echo TS::Cotisation_StartDate; ?></th>
  <th><?php echo TS::Cotisation_EndDate; ?></th>
  <th><?php echo TS::Cotisation_BasicPrice; ?></th>
  <th><?php echo TS::Cotisation_Members; ?></th>
  <th><?php echo TS::Cotisation_AmountCollected; ?></th>
  <th><?php echo TS::Cotisation_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($listCotisation as $cotisation)
    {
        $membershipSummary = findItemInListById($listMembershipSummaryPerCotisation, "cotisation_id", $cotisation['id']);

?> 
<tr>
  <td align="left"><?php echo $cotisation['label'] ?></td>
  <td align="center"><?php echo TSHelper::getCotisationType($cotisation['type']) ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($cotisation['start_date']) ?></td>
  <td align="center"><?php echo TSHelper::getShortDateTextFromDBDate($cotisation['end_date']) ?></td>
  <td align="center"><?php echo TSHelper::getCurrencyText($cotisation['amount']) ?></td>
  <td align="center">
    <a href="<?php echo url_for('/cotisations', $cotisation['id'], 'membership')?>"><?php printf(TS::Cotisation_MembersCount, ($membershipSummary != null ? $membershipSummary['membership_count'] : "0")) ?></a>
  </td>
  <td align="center"><?php echo TSHelper::getCurrencyText(($membershipSummary != null ? $membershipSummary['totalamount'] : 0.0)) ?></td>
  <td align="center">
    <a href="<?php echo url_for('/cotisations', $cotisation['id'])?>"><?php echo TS::Cotisation_View; ?></a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
