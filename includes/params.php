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
	$estilos = $this->params->get('estilos');
	// Column widths
	$leftcolgrid = $this->params->get('leftColumnWidth', 3);
	$rightcolgrid= $this->params->get('rightColumnWidth', 3);
	// add javascript files
	// JavaScript plugins (requires jQuery) 
	//$doc->addScript('templates/'.$this->template.'/js/bootstrap.min.js');
	//$doc->addScript('templates/'.$this->template.'/js/jquery-2.1.1.min.js');
	//$doc->addScript('templates/'.$this->template.'/js/jquery-noconflict.js');
	// Include all compiled plugins (below), or include individual files as needed 
	$doc->addScript('templates/'.$this->template.'/js/holder.js');
	//$doc->addScript('templates/'.$this->template.'/js/dropdown.js');
	//$doc->addScript('templates/'.$this->template.'/js/bootswatch.js');
	//$doc->addScript('templates/'.$this->template.'/js/tooltip.js');
	//$doc->addScript('templates/'.$this->template.'/js/popover.js');
	//$doc->addScript('templates/'.$this->template.'/js/modal.js');
	// Add Stylesheets
	$doc->addStyleSheet('templates/'.$this->template.'/css/navbar.css');
	$doc->addStyleSheet('templates/'.$this->template.'/css/bootstrap.min.css');
	$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
	// Remove
	unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/system/js/core.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/system/js/modal.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/system/js/caption.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/jui/js/jquery.min.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/jui/js/jquery-noconflict.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/jui/js/bootstrap.min.js']);
	unset($doc->_scripts[JURI::root(true) . '/media/jui/js/jquery-migrate.min.js']);
	// Variables
	$headdata = $doc->getHeadData();
	$menu = $app->getMenu();
	$active = $app->getMenu()->getActive();
	$pageclass = $params->get('pageclass_sfx');
	$tpath = $this->baseurl.'/templates/'.$this->template;
	// Parameter
	$frontpageshow = $this->params->get('frontpageshow', 0);
	$modernizr = $this->params->get('modernizr');
	$fontawesome = $this->params->get('fontawesome');
	$pie = $this->params->get('pie');
	// Generator tag
	$this->setGenerator(null);
	// force latest IE & chrome frame
	$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
	// Add javascripts
	if ($modernizr==1) $doc->addScript($tpath.'/js/modernizr-2.8.3.js');
	// add stylesheets
	if ($fontawesome==1) $doc->addStyleSheet($tpath.'/css/font-awesome.min.css');
	// Load Bootstrap
	$loadBootstrap = $this->params->get('loadBootstrap', 1);
	// Load JQuery
	$loadJquery = $this->params->get('loadJquery', 1);
	
	if ($loadJquery){
		$removeJs = array('/jquery.min.js','/jquery.js','/jquery-noconflict.js','/jquery-migrate.min.js','/jquery-migrate.js','/tabs-state.js','/bootstrap.min.js','/bootstrap.js',);
		$scripts = $doc->_scripts;
		foreach ($removeJs as $removeScript){
			foreach ($scripts as $script => $scriptdata){
				
				if (stristr($script, $removeScript)){
					unset($scripts[$script]);
				}

			}

		}

		$doc->_scripts = $scripts;
	}
	if ($loadJquery==1) $doc->addScript($tpath.'/js/jquery-2.1.1.min.js');
    if ($loadJquery==1) $doc->addScript($tpath.'/js/jquery-noconflict.js');
    if ($loadJquery==1) $doc->addScript($tpath.'/js/jquery-migrate.min.js');
    if ($loadBootstrap == 1) $doc->addScript($tpath.'/js/bootstrap.min.js');
	?>
<?php
 if ($this->countModules('left') == 0): ?>
<?php  $leftcolgrid  = "0"; ?>
<?php  endif; ?>
<?php
 if ($this->countModules('right') == 0): ?>
<?php  $rightcolgrid  = "0"; ?>
<?php  endif; ?>
