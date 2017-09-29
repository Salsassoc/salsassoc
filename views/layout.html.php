<!DOCTYPE HTML>
<html lang="fr-FR">
<head>
	<meta charset="UTF-8">
	<title>Salsassoc: <?php echo h($page_title) ?></title>
</head>
<body>
  <?php if(isset($_SESSION['username'])){ ?>
  <a href="<?php echo url_for('/people')?>">People</a> |
  <a href="<?php echo url_for('/members')?>">Members</a> |
  <?php   echo $_SESSION['username']; ?>
  <a href="<?php echo url_for('/logout')?>">(Logout)</a>
  <hr/>
  <?php } ?>
  <div id="main">
    <!-- main content -->
  	<h1><?php echo h($page_title) ?></h1><br/>
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
