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
	 * Cached file compilations.
	 *
	 * @var  array
	 */
	protected $cachedCompilations = array();

	/**
	 * Folder where cache files will be stored.
	 *
	 * @var  string
	 */
	protected $cacheFolder;

	/**
	 * Sass compiler.
	 *
	 * @var  \Leafo\ScssPhp\Compiler
	 */
	protected $compiler;

	/**
	 * Folder for css files.
	 *
	 * @var  string
	 */
	protected $cssFolder;

	/**
	 * Files to compile.
	 *
	 * @var  array
	 */
	protected $files = array();

	/**
	 * Folder for scss files.
	 *
	 * @var  string
	 */
	protected $scssFolder;

	/**
	 * Time elapsed compiling.
	 *
	 * @var  float
	 */
	protected $timeElapsed = array();

	/**
	 * Constructor
	 *
	 * @param   string  $scssFolder   Folder containing source scss files.
	 * @param   string  $cssFolder    Folder where compiled files will be saved.
	 * @param   string  $cacheFolder  Folder where cache files will be stored.
	 */
	public function __construct($scssFolder, $cssFolder, $cacheFolder)
	{
		if (!is_dir($cssFolder))
		{
			throw new \InvalidArgumentException("Folder cannot be accessed: " . $cssFolder);
		}

		$this->cssFolder = $cssFolder;

		if (!is_dir($scssFolder))
		{
			throw new \InvalidArgumentException("Folder cannot be accessed: " . $scssFolder);
		}

		$this->scssFolder = $scssFolder;

		if (!is_dir($cacheFolder))
		{
			throw new \InvalidArgumentException("Folder cannot be accessed: " . $cacheFolder);
		}

		$this->cacheFolder = $cacheFolder;
	}

	/**
	 * Add file to compile.
	 *
	 * @param   string  $sourceFile  Source Sass file
	 * @param   string  $outputFile  File where compiled Sass will be stored.
	 *
	 * @return  self
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function addFile($sourceFile, $outputFile = null)
	{
		$sourceFile = $this->scssFolder . '/' . $sourceFile;

		if (!file_exists($sourceFile))
		{
			throw new \InvalidArgumentException("File does not exist: " . $sourceFile);
		}

		if (null === $outputFile)
		{
			$sourceFileInfo = pathinfo($sourceFile);
			$outputFile = ltrim($sourceFileInfo['filename'], '_') . '.css';
		}

		$outputFile = $this->cssFolder . '/' . $outputFile;

		$this->files[$sourceFile] = $outputFile;

		return $this;
	}

	/**
	 * Add files to compile.
	 *
	 * @param   array  $files  Files to compile
	 *
	 * @return  self
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function addFiles(array $files)
	{
		foreach ($files as $key => $file)
		{
			if (is_numeric($key))
			{
				$this->addFile($file);

				continue;
			}

			$this->addFile($key, $file);
		}

		return $this;
	}

	/**
	 * Compile all the files.
	 *
	 * @return  boolean
	 *
	 * @throws  \InvalidArgumentException  Source files cannot be accessed
	 * @throws  \RuntimeException          If there are issues compiling files
	 */
	public function compile()
	{
		$this->cachedCompilations = array();

		foreach ($this->files as $sourceFile => $destFile)
		{
			if (!$this->compileFile($sourceFile, $destFile))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Compile a Sass file.
	 *
	 * @param   string  $sourceFile  Source file.
	 * @param   string  $destFile    Destination file
	 *
	 * @return  boolean
	 *
	 * @throws  \InvalidArgumentException  Source file cannot be accessed
	 * @throws  \RuntimeException          If there are issues compiling file
	 */
	public function compileFile($sourceFile, $destFile)
	{
		$this->timeElapsed[$sourceFile] = 0;
		$startTime = microtime(true);
		unset($this->cachedCompilations[$sourceFile]);

		if (!$this->fileRequiresUpdate($sourceFile))
		{
			$this->cachedCompilations[$sourceFile] = 1;
			$this->timeElapsed[$sourceFile] = round((microtime(true) - $startTime), 4);

			return true;
		}

		if (!is_readable($sourceFile))
		{
			throw new \InvalidArgumentException('Unable to read file: ' . $sourceFile);
		}

		$sourceFileInfo = pathinfo($sourceFile);

		$this->getCompiler()->addImportPath($sourceFileInfo['dirname'] . '/');

		try
		{
			$compiled = $this->getCompiler()->compile(file_get_contents($sourceFile), $sourceFile);
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
		$parsedFiles = $this->getCompiler()->getParsedFiles();

		if (!file_put_contents($cacheFile, json_encode($parsedFiles)))
		{
			throw new \RuntimeException("Error saving cache file: " . $cacheFile);
		}

		$this->timeElapsed[$sourceFile] = round((microtime(true) - $startTime), 4);

		return true;
	}

	/**
	 * Check if a file needs to be re-compiled.
	 *
	 * @param   string  $file  File to check for updates
	 *
	 * @return  boolean
	 */
	private function fileRequiresUpdate($file)
	{
		if (!isset($this->files[$file]))
		{
			throw new \InvalidArgumentException("File is not set to compile: " . $file);
		}

		$destFile = $this->files[$file];

		$cacheFile = $this->getCacheFileName($destFile);

		if (!file_exists($cacheFile))
		{
			return true;
		}

		$destFileTime = filemtime($destFile);

		$dependencies = json_decode(file_get_contents($cacheFile));

		foreach ($dependencies as $file => $fileUpdateTime)
		{
			$currentFileTime = filemtime($file);

			if ($currentFileTime !== $fileUpdateTime || $currentFileTime > $destFileTime)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the cache file name associated to its source file.
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
	 * Get the Sass compiler instance
	 *
	 * @return  \Leafo\ScssPhp\Compiler
	 */
	private function getCompiler()
	{
		if (null === $this->compiler)
		{
			$this->compiler = new Compiler;
			$this->compiler->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
			$this->compiler->setImportPaths($this->scssFolder);
		}

		return $this->compiler;
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
		if ($file && !isset($this->cachedCompilations[$file]))
		{
			return false;
		}

		return count($this->files) === count($this->cachedCompilations);
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
