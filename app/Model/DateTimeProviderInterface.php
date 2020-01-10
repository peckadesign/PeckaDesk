<?php declare(strict_types = 1);

namespace PeckaDesk\Model;

interface DateTimeProviderInterface
{

	public function createDateTime(): \DateTimeImmutable;

}
