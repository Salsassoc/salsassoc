<?php
$membership_id = 0;
if($membership['id'] != null){
  $membership_id = $membership['id'];
}

$formAction=url_for('/memberships', $membership_id, 'edit');
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


