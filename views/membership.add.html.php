<?php
$formAction=url_for('/memberships/0/edit');
?>
<div>
  <form method="POST" action="<?php echo $formAction; ?>" class="form">

  <?php include("membership.form.person.html.php"); ?>
  <?php include("membership.form.membership.html.php"); ?>
  <?php include("membership.form.cotisations.html.php"); ?>

<br/>

<input type="submit" value="Save" />

<br/>
<br/>

</form>
</div>
