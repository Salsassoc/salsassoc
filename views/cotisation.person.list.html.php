<p align="right">
<?php
  $iTotalMembers = count($listMembership);
  $iTotalOldMembers = 0;
  foreach ($listMembership as $membership)
  {
    /*
	if($membership['cotisation_count'] > 0){
		$iTotalOldMembers++;
    }*/
  }
?>
Number of members : <?php echo $iTotalMembers; ?>, 
Number of old members : <?php echo $iTotalOldMembers; ?> (<?php echo round(($iTotalOldMembers/$iTotalMembers)*100); ?> %)
</p>

<?php
    include('membership.list.table.html.php');
?>
