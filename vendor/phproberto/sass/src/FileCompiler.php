<?php
/**
 * @package     Phproberto.Sass
 * @subpackage  Compiler
 *
 * @copyright   Copyright (C) 2016 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Phproberto\Sass;

use Leafo\ScssPhp\Compiler;

/**
 * Sass file compiler.
 *
 * @since  1.0.0
 */
class FileCompiler
{
	/**
	 * @const  string
	 */
	const FORMATTER_COMPACT = 'Leafo\ScssPhp\Formatter\Compact';

	/**
	 * @const  string
	 */
	const FORMATTER_COMPRESSED = 'Leafo\ScssPhp\Formatter\Compressed';

	/**
	 * @const  string
	 */
	const FORMATTER_CRUNCHED = 'Leafo\ScssPhp\Formatter\Crunched';

	/**
	 * @const  string
	 */
	const FORMATTER_DEBUG = 'Leafo\ScssPhp\Formatter\Debug';

	/**
	 * @const  string
	 */
	const FORMATTER_EXPANDED = 'Leafo\ScssPhp\Formatter\Expanded';

	/**
	 * @const  string
	 */
	const FORMATTER_NESTED = 'Leafo\ScssPhp\Formatter\Nested';

	/**
	 * @const  string
	 */
	const FORMATTER_OUTPUT_BLOCK = 'Leafo\ScssPhp\Formatter\OutputBlock';

	/**
	 * Cached compiled files.
	 *
	 * @var  array
	 */
	protected $cachedFiles = array();

	/**
	 * Folder where cache files will be stored.
	 *
	 * @var  string
	 */
	protected $cacheFolder;

	/**
	 * Compiled files.
	 *
	 * @var  array
	 */
	protected $compiledFiles = array();

	/**
	 * Sass compiler.
	 *
	 * @var  \Leafo\ScssPhp\Compiler
	 */
	protected $compiler;

	/**
	 * Time elapsed compiling.
	 *
	 * @var  float
	 */
	protected $timeElapsed = array();

	/**
	 * Constructor
	 *
	 * @param   string  $cacheFolder  Folder where cache files will be stored.
	 */
	public function __construct($cacheFolder)
	{
		if (!is_dir($cacheFolder))
		{
			throw new \InvalidArgumentException("Folder cannot be accessed: " . $cacheFolder);
		}

		$this->cacheFolder = $cacheFolder;
	}

	/**
	 * Compile a Sass file.
	 *
	 * @param   string  $sourceFile  Source file.
	 * @param   string  $destFile    Destination file
	 * @param   string  $formatter   Formatter to use to compile the file
	 *
	 * @return  boolean
	 *
	 * @throws  \InvalidArgumentException  Source file cannot be accessed
	 * @throws  \RuntimeException          If there are issues compiling file
	 */
	public function compileFile($sourceFile, $destFile, $formatter = null)
	{
		$this->timeElapsed[$destFile] = 0;
		unset($this->cachedFiles[$destFile]);
		$startTime = microtime(true);

		if (!$this->fileRequiresUpdate($destFile))
		{
			$this->cachedFiles[$destFile] = 1;
			$this->timeElapsed[$destFile] = round((microtime(true) - $startTime), 4);

			return true;
		}

		if (!is_readable($sourceFile))
		{
			throw new \InvalidArgumentException('Unable to read file: ' . $sourceFile);
		}

		$sourceFileInfo = pathinfo($sourceFile);

		$compiler = $this->getCompiler();

		$compiler->addImportPath($sourceFileInfo['dirname'] . '/');

		try
		{
			if ($formatter)
			{
				$compiler->setFormatter($formatter);
			}

			$compiled = $compiler->compile(file_get_contents($sourceFile), $sourceFile);
		}
		catch (Exception $e)
		{
			throw new \RuntimeException("Error compiling file: " . $sourceFile);
		}

		if (!file_put_contents($destFile, $compiled))
		{
			throw new \RuntimeException("Error compiling file: " . $sourceFile);
		}

		$cacheFile = $this->getCacheFileName($destFile);
		$parsedFiles = $compiler->getParsedFiles();

		if (!file_put_contents($cacheFile, json_encode($parsedFiles)))
		{
			throw new \RuntimeException("Error saving cache file: " . $cacheFile);
		}

		$this->compiledFiles[$destFile] = $sourceFile;
		$this->timeElapsed[$destFile] = round((microtime(true) - $startTime), 4);

		return true;
	}

	/**
	 * Check if a file needs to be re-compiled.
	 *
	 * @param   string  $destFile  File to check for updates
	 *
	 * @return  boolean
	 */
	private function fileRequiresUpdate($destFile)
	{
		$cacheFile = $this->getCacheFileName($destFile);

		if (!file_exists($cacheFile))
		{
			return true;
		}

		$destFileTime = filemtime($destFile);

		$dependencies = json_decode(file_get_contents($cacheFile));

		foreach ($dependencies as $file => $fileUpdateTime)
		{
			if (!file_exists($file))
			{
				return true;
			}

			$overridenFile = $this->getOverridenFile($file);

			if ($overridenFile)
			{
				$file = $overridenFile;
			}

			$currentFileTime = filemtime($file);

			if ($currentFileTime !== $fileUpdateTime || $currentFileTime > $destFileTime)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the cache file name associated to its destination file.
	 *
	 * @param   string  $file  File that has associated the cache file.
	 *
	 * @return  string
	 */
	protected function getCacheFileName($file)
	{
		return $this->cacheFolder . '/' . basename($file) . '.json';
	}

	/**
	 * Get the Sass compiler instance.
	 *
	 * @return  \Leafo\ScssPhp\Compiler
	 */
	public function getCompiler()
	{
		if (null === $this->compiler)
		{
			$this->compiler = new Compiler;
			$this->compiler->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
		}

		return $this->compiler;
	}

	/**
	 * Check if a Sass file has an override.
	 *
	 * @param   string  $file  Path to the source file to search for overrides
	 *
	 * @return  string
	 */
	private function getOverridenFile($file)
	{
		if (!file_exists($file))
		{
			return null;
		}

		$overridenFileName = ltrim(basename($file), '_');
		$overridenFile = dirname($file) . '/' . $overridenFileName;

		if ($overridenFileName === basename($file) || !file_exists($overridenFile))
		{
			return null;
		}

		return $overridenFile;
	}

	/**
	 * Get time elapsed.
	 *
	 * @param   string  $file  Source file.
	 *
	 * @return  float
	 */
	public function getTimeElapsed($file = null)
	{
		if ($file && isset($this->timeElapsed[$file]))
		{
			return $this->timeElapsed[$file];
		}

		return array_sum($this->timeElapsed);
	}

	/**
	 * Check if the latest compilation was cached.
	 *
	 * @param   string  $file  Optional file name to check for specific cached.
	 *
	 * @return  boolean
	 */
	public function isCachedCompilation($file = null)
	{
		if ($file)
		{
			return isset($this->cachedFiles[$file]);
		}

		return count($this->compiledFiles) === 0;
	}

	/**
	 * Set the Sass compiler.
	 *
	 * @param   Compiler  $compiler  Compiler instance
	 *
	 * @return  self
	 */
	public function setCompiler(Compiler $compiler)
	{
		$this->compiler = $compiler;

		return $this;
	}
}
