<p align="right">
Number of cotisation : <?php echo count($cotisationlist); ?>
</p>

<table width="100%" class="list">
<thead>
<tr>
  <th>Label</th>
  <th>Start date</th>
  <th>End date</th>
  <th>Amount</th>
  <th>Members</th>
  <th>Total amount</th>
  <th>View</th>
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
    <a href="<?php echo url_for('/cotisation', $cotisation['id'], 'members')?>"><?php echo $cotisation['cotisation_count'] ?> members</a>
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
