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

$scss = new FileCompiler($cacheFolder);

try
{
	$scss->compileFile($scssFolder . '/template.scss', $cssFolder . '/template.css', FileCompiler::FORMATTER_EXPANDED);
	$scss->compileFile($scssFolder . '/template.scss', $cssFolder . '/template.min.css', FileCompiler::FORMATTER_COMPRESSED);
}
catch (Exception $e)
{
	JFactory::getApplication()->enqueueMessage('Error compiling Sass: ' . $e->getMessage(), 'error');
}

$message = 'Sass successfully compiled.';

if ($scss->isCachedCompilation())
{
	$message = 'No Sass files were modified.';
}

$message .= ' Time elapsed ' . $scss->getTimeElapsed() . ' seconds';

JFactory::getApplication()->enqueueMessage($message, 'Success');
