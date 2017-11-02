<p align="right">
Number of members : <?php echo count($personlist); ?> 
-
<a href="<?php echo url_for('/members/add')?>">Add</a>
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
  <th>Created</th>
  <th>Cotisation count</th>
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
    <?php }elseif($person['image_rights'] == 'false'){ ?>
     No
    <?php }else{ ?>
     Yes
    <?php } ?>
  </td>
  <td><?php echo $person['creation_date'] ?></td>
  <td><?php echo $person['cotisation_count'] ?></td>
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
