<!DOCTYPE HTML>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <title>Salsassoc: <?php echo h($page_title) ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo url_for('/style.css')?>">
</head>
<body>
  <div class="menu">
    <div class="menu-left">
      <span class="title"><?php echo TS::Main_Welcome; ?></span>
    </div>
    <div class="menu-right">
      <?php if(isset($_SESSION['username'])){ ?>
      <a href="<?php echo url_for('/members')?>"><?php echo TS::Main_Menu_Members; ?></a> |
     <!-- <a href="<?php echo url_for('/people')?>"><?php echo TS::Main_Menu_People; ?></a> |-->
      <a href="<?php echo url_for('/registrations')?>"><?php echo TS::Main_Menu_Registrations; ?></a> |
      <a href="<?php echo url_for('/cotisations')?>"><?php echo TS::Main_Menu_Cotisations; ?></a> |
      <a href="<?php echo url_for('/accounting')?>"><?php echo TS::Main_Menu_Accounting; ?></a> |
      <a href="<?php echo url_for('/fiscalyears')?>"><?php echo TS::Main_Menu_FiscalYears; ?></a> |
      <?php   echo $_SESSION['username']; ?>
      <a href="<?php echo url_for('/logout')?>"><?php echo TS::Main_Menu_Logout; ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="submenu">
	<div class="submenu-left">
    	<span class="page-title"><?php echo h($page_title) ?></span>
	</div>
    <div class="submenu-right">
      <?php if(isset($page_submenus)){
			 $iCount = 0;
			 foreach($page_submenus as $link => $label){
				if($iCount != 0){
					echo " | ";
				}
	  ?>
      <a href="<?php echo url_for($link)?>"><?php echo $label; ?></a>
      <?php  
               $iCount++;
             }
      } ?>
	</div>
  </div>
  <!-- main content -->
  <div id="main" class="content">
	<?php
        if(isset($errors) && count($errors) > 0){
    ?>
	<div class="content-errors">
       <ul>
    <?php foreach($errors as $error){ ?>
         <li><?php echo $error; ?></li>
    <?php } ?>
       </ul>
	</div><br/>
    <?php
        }
    ?>
	<div class="content-body">
    	<?php echo $content; ?>
	</div>
  </div>
  <!--
    $sidebar contains the content_for('sidebar') captured content.
  -->
  <?php if(!empty($sidebar)): ?>
  <div id="sidebar">
    <h2>Sidebar</h2>
    <?php echo $sidebar; ?>
  </div>
  <?php endif; ?>
</body>
</html>
