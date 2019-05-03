<p align="right">
<?php printf(TS::Cotisation_CotisationCount, count($cotisationlist)); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th><?php echo TS::Cotisation_Label; ?></th>
  <th><?php echo TS::Cotisation_StartDate; ?></th>
  <th><?php echo TS::Cotisation_EndDate; ?></th>
  <th><?php echo TS::Cotisation_Amount; ?></th>
  <th><?php echo TS::Cotisation_Members; ?></th>
  <th><?php echo TS::Cotisation_TotalAmount; ?></th>
  <th><?php echo TS::Cotisation_View; ?></th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($cotisationlist as $cotisation)
    {
?> 
<tr>
  <td><?php echo $cotisation['label'] ?></td>
  <td><?php echo $cotisation['start_date'] ?></td>
  <td><?php echo $cotisation['end_date'] ?></td>
  <td><?php echo $cotisation['amount'] ?></td>
  <td>
    <a href="<?php echo url_for('/cotisation', $cotisation['id'], 'members')?>"><?php printf(TS::Cotisation_MembersCount, $cotisation['cotisation_count']) ?></a>
  </td>
  <td><?php echo $cotisation['cotisation_totalamount'] ?></td>
  <td>
    <a href="<?php echo url_for('/cotisation', $cotisation['id'])?>">View</a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
