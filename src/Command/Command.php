<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Command;

use Contributte\Neonizer\NeonizerHelper;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand
{

	protected function getNeonizerHelper(): NeonizerHelper
	{
		return $this->getHelper(NeonizerHelper::NAME);
	}

}
