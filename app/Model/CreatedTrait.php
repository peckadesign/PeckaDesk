<?php declare(strict_types = 1);

namespace PeckaDesk\Model;

trait CreatedTrait
{

	/**
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Users\User")
	 * @\Doctrine\ORM\Mapping\JoinColumn(referencedColumnName="id")
	 */
	private \PeckaDesk\Model\Users\User $createdBy;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="datetime_immutable")
	 */
	private \DateTimeImmutable $created;


	public function getCreatedBy(): Users\User
	{
		return $this->createdBy;
	}


	public function getCreated(): \DateTimeImmutable
	{
		return $this->created;
	}

}
