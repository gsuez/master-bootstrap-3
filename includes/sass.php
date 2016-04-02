<?php
/**
 * @package     Template.Master_Bootstrap_3
 * @subpackage  Include.Sass
 *
 * @copyright   Copyright (C) 2013 - 2015 gsuez.cl. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

$composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';

if (!file_exists($composerAutoload))
{
	return;
}

require_once $composerAutoload;

use Phproberto\Sass\FileCompiler;

$scssFolder  = dirname(__DIR__) . '/scss';
$cssFolder   = dirname(__DIR__) . '/css';
$cacheFolder = JPATH_ROOT . '/cache';

$compiler = new FileCompiler($scssFolder, $cssFolder, $cacheFolder);
$compiler->addFile('_template.scss');

try
{
	$compiler->compile();
}
catch (Exception $e)
{
	JFactory::getApplication()->enqueueMessage('Error compiling Sass: ' . $e->getMessage(), 'error');
}

$message = 'Sass successfully compiled.';

if ($compiler->isCachedCompilation())
{
	$message = 'No Sass files were modified.';
}

$message .= ' Time elapsed ' . $compiler->getTimeElapsed() . ' seconds';

JFactory::getApplication()->enqueueMessage($message, 'Success');
