<?php
/**
 * @version		$Id: panel.php 714 2014-03-03 18:27:34Z waseem $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport( 'joomla.filesystem.file' );
// Set up Joomla API references
$document 			= JFactory::getDocument();
$templateparams		= JFactory::getApplication()->getTemplate(true)->params;
$moduleId 			= $module->id;
$moduleTitle 		= ($module->showtitle) ? $module->title : '';
$mmenuCSS 			= JURI::base().'templates/'.basename(dirname(dirname(dirname(__FILE__)))).'/html/mod_menu/core/css/jquery.mmenu.all.css';
$jsPath				= 'templates/'.basename(dirname(dirname(dirname(__FILE__)))).'/html/mod_menu/core/js/';

// Jquery Hammer
$bpf_JqueryHammer 	= $jsPath . 'hammer.min.js';
// MMenu
$bpf_mmenuJs 		= $jsPath . 'jquery.mmenu.min.all.js';

// Load flexslider css
JHTML::stylesheet($mmenuCSS);

// Load Jquery Cookie
$document->addScript(JURI::base() . $bpf_JqueryHammer);
// Load Mmenu
$document->addScript(JURI::base() . $bpf_mmenuJs);

$mmenuLoader =
<<<EOL
(function($) {
	$(document).ready(function(){
		// Hide the bootstrap menu toggle button
		$('.navbar .navbar-header > button').css('display','none');
		// Add the link
		$('.navbar .navbar-header').append('<a id="panel-$moduleId-link" class="navbar-toggle panelnav-toggle hidden-sm hidden-md hidden-lg" href="#panel-$moduleId"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="title hidden-xs">Menu</span></a>');
		// position the link - uncomment if you want to position with JS instead of CSS
		// $('.navbar .navbar-inner > .navbar-toggle').css('position','absolute').css('top','1em').css('right','0');

		// panel Menu
		$(function() {
			$('nav#panel-$moduleId').mmenu({
				
				// options object
				content		: ['prev', 'title', 'close'],
				extensions	: ['pageshadow', 'theme-light', 'effect-slide-menu', 'effect-slide-listitems', 'pagedim-black'], //theme-dark, right, effect-zoom-menu, fullscreen
				dragOpen	: true,
				counters	: true,
				searchfield	: false,
				labels		: {
					fixed		: !$.mmenu.support.touch
				}
EOL;
if($moduleTitle):
$mmenuLoader .=
<<<EOL
				// object object
				,header		: {
					add			: true,
					update		: true,
					title		: '$moduleTitle'
				}
EOL;
endif;
$mmenuLoader .=
<<<EOL
			},
			{
				// configuration object
				selectedClass: "current"
			});
		});
	});
})(jQuery);
EOL;

$document->addScriptDeclaration($mmenuLoader);

?>
<nav id="panel-<?php echo $moduleId; ?>">
	<ul class="level_1 menu<?php echo $class_sfx;?>"<?php
		$tag = '';
		if ($params->get('tag_id')!=NULL) 
		{
			$tag = $params->get('tag_id').'';
			echo ' id="'.$tag.'"';
		}
	?>>
	<?php
		$currentitemcount = 0;
		$lastdeeper = false;
		foreach ($list as $i => &$item) :
			$class = 'item-'.$item->id;
			if ($item->id == $active_id)
			{
				$class .= ' current';
			}

			if (in_array($item->id, $path))
			{
				$class .= ' active';
			}
			elseif ($item->type == 'alias')
			{
				$aliasToId = $item->params->get('aliasoptions');
				if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
				{
					$class .= ' active';
				}
				elseif (in_array($aliasToId, $path))
				{
					$class .= ' alias-parent-active';
				}
			}

			$currentitemcount ++;

			if ($item->type == 'separator')
			{
				$class .= ' divider';
			}

			if ($item->deeper)
			{
				$class .= ' deeper';
				$lastdeeper = true;
			} else {
				$lastdeeper = false;   
			}
			
			if ($item->shallower or $currentitemcount == count($list)) {
				$class .= ' last';
			}
			
			if ($lastdeeper or $currentitemcount == "1") {
				$class .= ' first';
			}

			if ($item->parent)
			{
				$class .= ' parent';
			}

		if (!empty($class))
		{
			$class = ' class="'.trim($class) . ' level' .$item->level .'"';
		}

			echo '<li'.$class.'>';

			// Render the menu item.
			switch ($item->type) :
				case 'separator':
				case 'url':
				case 'component':
				case 'heading':
					require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
					break;

				default:
					require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
					break;
			endswitch;

			// The next item is deeper.
			if ($item->deeper)
			{
				$ul_level = $item->level +1;
				echo '<ul class="sub-menu level_'.$ul_level.'">';
			}
			// The next item is shallower.
			elseif ($item->shallower)
			{
				echo '</li>';
				echo str_repeat('</ul></li>', $item->level_diff);
			}
			// The next item is on the same level.
			else {
				echo '</li>';
			}
		endforeach
	?>
	</ul>
</nav>