<?php declare(strict_types = 1);

namespace PeckaDesk\Model;

final class CurrentDateTimeProvider implements DateTimeProviderInterface
{

	public function createDateTime(): \DateTimeImmutable
	{
		return new \DateTimeImmutable();
	}

}
