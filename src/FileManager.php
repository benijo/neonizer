<?php declare(strict_types = 1);

namespace Contributte\Neonizer;

use Contributte\Neonizer\Decoder\IDecoderFactory;
use Contributte\Neonizer\Encoder\IEncoderFactory;

class FileManager
{

	/** @var IEncoderFactory */
	private $encoderFactory;

	/** @var IDecoderFactory */
	private $decoderFactory;

	public function __construct(
		IEncoderFactory $encoderFactory,
		IDecoderFactory $decoderFactory
	)
	{
		$this->encoderFactory = $encoderFactory;
		$this->decoderFactory = $decoderFactory;
	}

	/**
	 * @return mixed[]
	 */
	public function load(string $file, ?string $type = NULL): array
	{
		if ($type === NULL) {
			$type = Utils::detectFileType($file);
		}
		$decoder = $this->decoderFactory->create($type);
		return $decoder->decode(file_get_contents($file));
	}

	/**
	 * @param mixed[] $content
	 */
	public function save(array $content, string $file, ?string $type = NULL): void
	{
		if ($type === NULL) {
			$type = Utils::detectFileType($file);
		}
		$encoder = $this->encoderFactory->create($type);
		$content = $encoder->encode($content);
		$this->saveFile((string) $content, $file);
	}

	protected function saveFile(string $content, string $filename): void
	{
		$dir = dirname($filename);
		if (!is_dir($dir)) {
			mkdir($dir, 0755, TRUE);
		}
		file_put_contents($filename, $content);
	}

}
