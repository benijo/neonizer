<?php declare(strict_types = 1);

namespace Contributte\Neonizer\DI;

use Contributte\Neonizer\Command\GetCommand;
use Contributte\Neonizer\Command\ProcessCommand;
use Contributte\Neonizer\Command\SetCommand;
use Contributte\Neonizer\Command\ValidateCommand;
use Contributte\Neonizer\Decoder\DecoderFactory;
use Contributte\Neonizer\Encoder\EncoderFactory;
use Contributte\Neonizer\FileManager;
use Contributte\Neonizer\NeonizerHelper;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Symfony\Component\Console\Application;

class NeonizerExtension extends CompilerExtension
{

	public const COMMAND_NAME_PREFIX = 'neonizer:';

	/**
	 * @return void
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('encoderFactory'))
			->setClass(EncoderFactory::class);
		$builder->addDefinition($this->prefix('decoderFactory'))
			->setClass(DecoderFactory::class);
		$builder->addDefinition($this->prefix('fileManager'))
			->setClass(FileManager::class);

		// Skip if it's not CLI mode
		if (PHP_SAPI !== 'cli') {
			return;
		}

		// Helpers
		$builder->addDefinition($this->prefix('neonizerHelper'))
			->setClass(NeonizerHelper::class, [$this->prefix('fileManager')])
			->setAutowired(FALSE);

		// Commands
		$builder->addDefinition($this->prefix('getCommand'))
			->setClass(GetCommand::class)
			->addSetup('setName', [self::COMMAND_NAME_PREFIX . GetCommand::NAME])
			->setAutowired(FALSE);
		$builder->addDefinition($this->prefix('setCommand'))
			->setClass(SetCommand::class)
			->addSetup('setName', [self::COMMAND_NAME_PREFIX . SetCommand::NAME])
			->setAutowired(FALSE);
		$builder->addDefinition($this->prefix('processCommand'))
			->setClass(ProcessCommand::class)
			->addSetup('setName', [self::COMMAND_NAME_PREFIX . ProcessCommand::NAME])
			->setAutowired(FALSE);
		$builder->addDefinition($this->prefix('validateCommand'))
			->setClass(ValidateCommand::class)
			->addSetup('setName', [self::COMMAND_NAME_PREFIX . ValidateCommand::NAME])
			->setAutowired(FALSE);
	}

	public function beforeCompile(): void
	{
		// Skip if it's not CLI mode
		if (PHP_SAPI !== 'cli') {
			return;
		}

		$builder = $this->getContainerBuilder();

		// Lookup for Symfony Console Application
		$application = $builder->getDefinitionByType(Application::class);

		// Register helper
		$neonizerHelper = $this->prefix('@neonizerHelper');
		$application->addSetup(new Statement('$service->getHelperSet()->set(?)', [$neonizerHelper]));
	}

}
