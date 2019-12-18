<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Projects;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="project")
 */
class Project
{

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 * @\Doctrine\ORM\Mapping\GeneratedValue
	 */
	private ?int $id;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $name;


	public function __construct(
		string $name
	)
	{
		$this->name = $name;
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function setName(string $name): void
	{
		$this->name = $name;
	}

}
