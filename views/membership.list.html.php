<?php
$formAction=url_for('/memberships');
?>

<form method="POST" action="<?php echo $formAction; ?>">

  <select name="FiscalYearId">
     <option value="">-- <?php echo TS::AccountingOperation_FiscalYear; ?> --</option>
    <?php
        $fiscal_year_id = $filters['fiscal_year_id'];
        foreach($listFiscalYear as $fiscal_year){
    ?>
          <option value="<?php echo $fiscal_year['id']; ?>" <?php echo ($fiscal_year_id == $fiscal_year['id'] ? 'selected' : '')?> ><?php echo $fiscal_year['title']; ?></option>
    <?php
        }
    ?>
  </select>

  <input type="submit" />
</form>

<div class="list-top-infos">
<?php printf(TS::Membership_MembershipCount, count($listMembership)); ?>
</div>

<?php include("membership.list.table.html.php"); ?>
