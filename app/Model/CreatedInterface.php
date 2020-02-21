<?php declare(strict_types = 1);

namespace PeckaDesk\Model;

interface CreatedInterface
{

	public function getCreatedBy(): Users\User;


	public function getCreated(): \DateTimeImmutable;

}
