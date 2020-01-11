<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Templating;

final class Filters
{

	public static function dateTime(\DateTimeInterface $dateTime): string
	{
		return $dateTime->format('j. n. Y H:i:s');
	}
}
