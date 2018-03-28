<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateCommand extends Command
{

	public const NAME = 'validate';

	protected function configure()
	{
		$this
			->setName(self::NAME)
			->addArgument('file', InputArgument::REQUIRED);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$helper = $this->getNeonizerHelper();
	}

}
