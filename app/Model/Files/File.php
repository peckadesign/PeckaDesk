<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Files;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="file")
 * @\Doctrine\ORM\Mapping\InheritanceType("SINGLE_TABLE")
 * @\Doctrine\ORM\Mapping\DiscriminatorColumn(name="discr", type="string")
 * @\Doctrine\ORM\Mapping\DiscriminatorMap({"file" = "File", "image" = "Image"})
 */
class File
{

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 * @\Doctrine\ORM\Mapping\GeneratedValue
	 */
	private ?int $id = NULL;

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

}
