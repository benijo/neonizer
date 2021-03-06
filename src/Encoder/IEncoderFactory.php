<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Encoder;

interface IEncoderFactory
{

	/**
	 * @param string|NULL $type
	 * @return IEncoder
	 */
	public function create(?string $type): IEncoder;

}
