<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCommand extends Command
{

	public const NAME = 'get';

	protected function configure()
	{
		$this
			->setName(self::NAME)
			->addArgument('file', InputArgument::REQUIRED)
			->addArgument('section', InputArgument::REQUIRED);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$helper = $this->getNeonizerHelper();
		$fileManager = $helper->getFileManager();

		$file = $input->getArgument('file');
		$section = $input->getArgument('section');
		$content = $fileManager->load($file);

		$output->write(var_dump($content));
		return 0;
	}

}
