<?php declare(strict_types = 1);

namespace PeckaDesk\Model;

final class Filters
{

	public static function stringVal(?string $value): ?string
	{
		if ($value === '') {
			return NULL;
		}

		return $value;
	}

}
