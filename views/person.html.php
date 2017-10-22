<table width="100%" class="list">
<thead>
<tr>
  <th>Lastname</th>
  <th>Firstname</th>
  <th>Birthdate</th>
  <th>E-mail</th>
  <th>Phonenumber</th>
  <th>Image rights</th>
  <th>Created</th>
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
  <td><?php echo $person['creation_date'] ?></td>
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
