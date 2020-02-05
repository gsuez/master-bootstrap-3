<?php
 /*------------------------------------------------------------------------
# author    Gonzalo Suez
# Copyright © 2013 gsuez.cl. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.gsuez.cl
-------------------------------------------------------------------------*/// no direct access
defined('_JEXEC') or die;
JHtml::_('bootstrap.framework');
// Set HTML5 Document Output - thank you FabrizioG
$doc = JFactory::getDocument();
$doc->setHtml5(true);
?>
<?php
if(is_readable(JPATH_THEMES.'/'.$this->template.'/css/custom.css'))
{
	JFactory::getDocument()->addStylesheet(JURI::base().'templates/'.$this->template.'/css/custom.css');
}
?>
<head>
	<jdoc:include type="head" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
	<!--[if lte IE 8]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<?php  if ($pie == 1) : ?>
			<style>
				{behavior:url(<?php  echo $tpath; ?>/js/PIE.htc);}
			</style>
		<?php  endif; ?>
	<![endif]-->
<?php
 if($layout=='boxed'){ ?>
<?php  $path= JURI::base().'templates/'.$this->template."/images/elements/pattern".$pattern.".png"; ?>
<style type="text/css">
 body {
    background: url("<?php  echo $path ; ?>") repeat fixed center top rgba(0, 0, 0, 0);
 }
</style>
  <?php  } ?>
</head>
