<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Issues;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="issue")
 */
class Issue
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

	/**
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Projects\Project")
	 * @\Doctrine\ORM\Mapping\JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private \PeckaDesk\Model\Projects\Project $project;


	public function __construct(
		\PeckaDesk\Model\Projects\Project $project,
		string $name
	)
	{
		$this->project = $project;
		$this->name = $name;
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getProject(): \PeckaDesk\Model\Projects\Project
	{
		return $this->project;
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
