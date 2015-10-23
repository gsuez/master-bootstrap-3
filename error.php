<?php 
	/*------------------------------------------------------------------------
# author    Gonzalo Suez
# copyright © 2012 gsuez.cl. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.gsuez.cl
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die;
// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;
?><!doctype html>
<html lang="<?php echo $this->language; ?>">
<head>
  <title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> <!-- mobile viewport optimized -->
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/masterbootstrap/css/font-awesome.min.css" type="text/css" />  
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/masterbootstrap/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/masterbootstrap/css/template.css" type="text/css" />  
</head>
<body>
      <div class="error">
      <div class="container">
       <h3><?php echo htmlspecialchars($app->getCfg('sitename')); ?></h3>
       <p><i class="fa fa-github-alt fa-5x"></i></p>
       <h1> <?php echo $this->error->getCode(); ?></h1>
        <h3><?php echo $this->error->getMessage(); ?></h3>
        <p><a class="btn btn-warning btn-lg" href="<?php echo $this->baseurl; ?>/" title="<?php echo JText::_('HOME'); ?>"><?php echo JText::_('Go Back'); ?></a></p>
      <?php // render module mod_search
        $module = new stdClass();
        $module->module = 'mod_search';
        echo JModuleHelper::renderModule($module);
      ?>
    </div>
  </div>
</body>
</html>