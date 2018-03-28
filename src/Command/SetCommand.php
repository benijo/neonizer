<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetCommand extends Command
{

	public const NAME = 'set';

	protected function configure()
	{
		$this
			->setName(self::NAME)
			->addArgument('file', InputArgument::REQUIRED)
			->addArgument('section', InputArgument::REQUIRED)
			->addArgument('value', InputArgument::REQUIRED);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$helper = $this->getNeonizerHelper();




	}

}
