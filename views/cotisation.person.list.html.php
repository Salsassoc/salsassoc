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
  <th>Lastname</th>
  <th>Firstname</th>
  <th>Birthdate</th>
  <th>E-mail</th>
  <th>Phonenumber</th>
  <th>Image rights</th>
  <th>Was members</th>
  <th>Created</th>
  <th>Cotisation</th>
  <th>Payment</th>
  <th>View</th>
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
  <td><?php echo $person['birthdate'] ?></td>
  <td><?php echo $person['email'] ?></td>
  <td><?php echo $person['phonenumber'] ?></td>
  <td>
    <?php if($person['image_rights'] == null){ ?>
     ?
    <?php }elseif($person['image_rights'] == 0){ ?>
     No
    <?php }else{ ?>
     Yes
    <?php } ?>
  </td>
  <td>
    <?php if($person['cotisation_count'] == null){ ?>
     No
    <?php }elseif($person['cotisation_count'] == 0){ ?>
     No
    <?php }else{ ?>
     Yes
    <?php } ?>
  </td>
  <td><?php echo $person['creation_date'] ?></td>
  <td><?php echo $person['amount']; ?></td>
  <td>
    <?php
        switch($person['payment_method']){
        case 1: echo "Check"; break;
        case 2: echo "Cash"; break;
        }
    ?>
  </td>
  <td>
    <a href="<?php echo url_for('/members', $person['id'])?>">View</a>
  </td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
