<!DOCTYPE HTML>
<html lang="fr-FR">
<head>
	<meta charset="UTF-8">
	<title>Salsassoc: <?php echo h($page_title) ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo url_for('/style.css')?>">
</head>
<body>
  <?php if(isset($_SESSION['username'])){ ?>
  <a href="<?php echo url_for('/members')?>"><?php echo TS::Main_Menu_Members; ?></a> |
  <a href="<?php echo url_for('/people')?>"><?php echo TS::Main_Menu_People; ?></a> |
  <a href="<?php echo url_for('/cotisations')?>"><?php echo TS::Main_Menu_Cotisations; ?></a> |
  <?php   echo $_SESSION['username']; ?>
  <a href="<?php echo url_for('/logout')?>"><?php echo TS::Main_Menu_Logout; ?></a>
  <hr/>
  <?php } ?>
  <div id="main">
    <!-- main content -->
  	<h1><?php echo h($page_title) ?></h1>
    <?php echo $content; ?>
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
