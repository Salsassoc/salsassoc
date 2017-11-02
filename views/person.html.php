<form method="POST" action="<?php echo url_for('/members', $person['id'], 'edit'); ?>">

<fieldset>
<legend>Global information</legend>

<label>Lastname :</label>&nbsp;<input type="text" name="Lastname" value="<?php echo $person['lastname'] ?>" /><br/>
<label>Firstname :</label>&nbsp;<input type="text" name="Firstname" value="<?php echo $person['firstname'] ?>" /><br/>
<label>Birthdate :</label>&nbsp;<input type="text" name="Birthdate" value="<?php echo $person['birthdate'] ?>" /><br/>
<label>E-mail :</label>&nbsp;<input type="text" name="Email" value="<?php echo $person['email'] ?>" /><br/>
<label>Phonenumber :</label>&nbsp;<input type="text" name="Phonenumber" value="<?php echo $person['phonenumber'] ?>" /><br/>

<label>Image rights :</label>&nbsp;
<select name="Imagerights">
<option value="">Unknown</option>
<option value="true" <?php echo ($person['image_rights'] == 'true' ? 'selected' : '') ?>>Yes</option>
<option value="false" <?php echo ($person['image_rights'] == 'false' ? 'selected' : '') ?>>No</option>
</select>
<br/>

<label>Comments :</label>&nbsp;
<textarea name="Comments" cols="50" rows="10">
<?php echo $person['comments']; ?>
</textarea>

</fieldset>

<br/>
<input type="submit" value="Save">

</form>

<h2>Cotisations</h2>

<table class="list">
<thead>
<tr>
  <th>Cotisation</th>
  <th>Date</th>
  <th>Amount</th>
</tr>
</thead>
<tbody>
<?php
    foreach  ($cotisations as $cotisation)
    {
?> 
<tr>
  <td><?php echo $cotisation['label'] ?></td>
  <td><?php echo $cotisation['date'] ?></td>
  <td><?php echo $cotisation['amount'] ?></td>
</tr>
<?php
    }
?> 
</tr>
</tbody>
</table>
