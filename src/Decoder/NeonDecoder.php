<?php declare(strict_types = 1);

namespace Contributte\Neonizer\Decoder;

use Nette\Neon\Neon;

class NeonDecoder implements IDecoder
{

	/**
	 * @param string $value
	 * @return mixed[]
	 */
	public function decode(string $value): array
	{
		if (empty($value)) {
			return [];
		}
		return Neon::decode($value);
	}

}
