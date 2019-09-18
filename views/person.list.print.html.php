<p align="center">
    ....................................................................................................
</p>

<table width="100%" class="table" border="1">
<thead>
<tr>
  <th><?php echo TS::Person_Lastname; ?></th>
  <th><?php echo TS::Person_Firstname; ?></th>
  <th><?php echo TS::Person_Check; ?></th>
  <th class="hsep">&nbsp;</th>
  <th><?php echo TS::Person_Lastname; ?></th>
  <th><?php echo TS::Person_Firstname; ?></th>
  <th><?php echo TS::Person_Check; ?></th>
</tr>
</thead>
<tbody>
<?php
    $i=0;
    foreach  ($personlist as $person)
    {
        // Start new line
        if($i % 2  == 0){
            echo "  <tr>";
        }
?>

  <td><?php echo $person['lastname'] ?></td>
  <td><?php echo $person['firstname'] ?></td>
  <td></td>

<?php
        $i++;
        if($i % 2  == 0){
            echo "  </tr>";
        }else{
            echo "  <td class=\"hsep\"></td>";
        }
?>


<?php
    }
?>
</tbody>
</table>
