<?php declare(strict_types = 1);

namespace Contributte\Neonizer;

use Symfony\Component\Console\Helper\Helper;

class NeonizerHelper extends Helper
{

	public const NAME = 'neonizer';

	/** @var FileManager */
	private $fileManager;

	public function __construct(FileManager $fileManager)
	{
		$this->fileManager = $fileManager;
	}

	public function getName()
	{
		return self::NAME;
	}

	public function getFileManager(): FileManager
	{
		return $this->fileManager;
	}

}
