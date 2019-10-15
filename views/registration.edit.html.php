<?php
$registration_id = 0;
if($registration['id'] != null){
  $registration_id = $registration['id'];
}


$formAction=url_for('/registrations', $registration_id, 'edit');
?>
    <?php
        if(isset($registration['id'])){
    ?>
    <div class='form-row'>
      <span><?php echo sprintf(TS::Registration_Num, $registration['id']); ?></span>
    </div>
    <?php
        }
    ?>

<div>
  <form method="POST" action="<?php echo $formAction; ?>" class="form">

    <?php include("registration.form.person.html.php"); ?>
    <?php include("registration.form.registration.html.php"); ?>
    <?php include("registration.form.cotisations.html.php"); ?>

    <br/>

    <input type="submit" value="Save" />

  </form>
</div>
