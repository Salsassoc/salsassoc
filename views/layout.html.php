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
      <a href="<?php echo url_for('/cotisations')?>"><?php echo TS::Main_Menu_Cotisations; ?></a> |
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
