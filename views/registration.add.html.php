<?php
$formAction=url_for('/registrations/0/edit');
?>
<div>
  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <?php include("registration.form.person.html.php"); ?>
  <?php include("registration.form.registration.html.php"); ?>
  <?php include("registration.form.cotisations.html.php"); ?>

<br/>

<input type="submit" value="Save" />

<br/>
<br/>

</form>
</div>
