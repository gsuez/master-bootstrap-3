<?php
	/*------------------------------------------------------------------------
# author    Gonzalo Suez
# copyright Copyright © 2013 gsuez.cl. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.gsuez.cl
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
// Column widths
$leftcolgrid = $this->params->get('leftColumnWidth', 3);
$rightcolgrid= $this->params->get('rightColumnWidth', 3);
// add javascript files
// JavaScript plugins (requires jQuery) 
$doc->addScript('templates/'.$this->template . '/js/jquery-1.10.2.min.js');
$doc->addScript('templates/'.$this->template . '/js/jquery-noconflict.js');
// Include all compiled plugins (below), or include individual files as needed 
$doc->addScript('templates/'.$this->template . '/js/bootstrap.min.js');
$doc->addScript('templates/' . $this->template . '/js/holder.js');
$doc->addScript('templates/' . $this->template . '/js/dropdown.js');
// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/css/bootstrap.min.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/navbar.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
// Variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$params = $app->getParams();
$headdata = $doc->getHeadData();
$menu = $app->getMenu();
$active = $app->getMenu()->getActive();
$pageclass = $params->get('pageclass_sfx');
$tpath = $this->baseurl.'/templates/'.$this->template;
// Parameter
$modernizr = $this->params->get('modernizr');
$fontawesome = $this->params->get('fontawesome');
$pie = $this->params->get('pie');
// Generator tag
$this->setGenerator(null);
// force latest IE & chrome frame
$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
// Add javascripts
if ($modernizr==1) $doc->addScript($tpath.'/js/modernizr-2.6.2.js');
// add stylesheets
if ($fontawesome==1) $doc->addStyleSheet($tpath.'/css/font-awesome.min.css');
// file ending
?>
<?php
 if ($this->countModules('left') == 0): ?>
<?php  $leftcolgrid  = "0"; ?>
<?php  endif; ?>
<?php
 if ($this->countModules('right') == 0): ?>
<?php  $rightcolgrid  = "0"; ?>
<?php  endif; ?>
