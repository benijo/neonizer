<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Command;

use Contributte\Neonizer\Exception\InvalidArgumentException;
use Contributte\Neonizer\Utils;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ProcessCommand extends Command
{

	public const NAME = 'process';

	protected function configure()
	{
		$this
			->setName(self::NAME)
			->addArgument('dist-file', InputArgument::REQUIRED)
			->addArgument('file', InputArgument::OPTIONAL);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$helper = $this->getNeonizerHelper();
		$fileManager = $helper->getFileManager();

		$distFile = $input->getArgument('dist-file');
		$file = $input->getArgument('file');

		// Dist file
		if (empty($distFile)) {
			throw new InvalidArgumentException(
				'The dist-file name is required'
			);
		}

		if (!is_file($distFile)) {
			throw new InvalidArgumentException(
				sprintf(
					'The dist file "%s" does not exist. Check your dist-file config or create it.',
					$distFile
				)
			);
		}

		if (!$file) {
			$file = Utils::removeDistExtensions($distFile);
		}

		$output->writeLn(sprintf('<info>%s the "%s" file</info>', is_file($file) ? 'Updating' : 'Creating', $file));

		$expected = $fileManager->load($distFile);
		$actual = [];

		if (is_file($file)) {
			$existingValues = $fileManager->load($file);
			$actual = array_merge($actual, $existingValues);
		}

		$content = $this->processParams($input, $output, $expected, $actual);
		$fileManager->save($content, $file);

		return 0;
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @param mixed[] $expected
	 * @param mixed[] $actual
	 * @param string|NULL $parentSection
	 * @return mixed[]
	 */
	protected function processParams(InputInterface $input, OutputInterface $output, array $expected, array $actual,
		?string $parentSection = NULL): array
	{
		foreach ($expected as $key => $param) {
			$section = $parentSection ? $parentSection . '.' . $key : $key;
			if (is_array($param)) {
				$actualSection = isset($actual[$key]) ? $actual[$key] : [];
				$actual[$key] = $this->processParams($input, $output, $param, $actualSection, $section);
				continue;
			}
			if (array_key_exists($key, $actual)) {
				continue;
			}
			$actual[$key] = $this->getParam($input, $output, $section, $param);
		}

		return $actual;
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @param string $param
	 * @param string|NULL $default
	 * @return string|NULL
	 */
	protected function getParam(
		InputInterface $input,
		OutputInterface $output,
		string $param,
		?string $default
	): ?string
	{
		if (!$input->isInteractive()) {
			return $default;
		}

		/** @var QuestionHelper $helper */
		$helper = $this->getHelper('question');

		$question = new Question(
			sprintf('<question>%s</question> (<comment>%s</comment>): ', $param, $default),
			$default
		);

		return $helper->ask($input, $output, $question);
	}

}
