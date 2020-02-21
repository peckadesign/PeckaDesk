<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Issues;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="issue")
 */
class Issue implements \PeckaDesk\Model\CreatedInterface
{

	use \PeckaDesk\Model\CreatedTrait;

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

	/**
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Projects\Project")
	 * @\Doctrine\ORM\Mapping\JoinColumn(name="project_id", referencedColumnName="id")
	 */
	private \PeckaDesk\Model\Projects\Project $project;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Model\Issues\Comment", mappedBy="issue")
	 * @\Doctrine\ORM\Mapping\OrderBy({"created" = "ASC"})
	 */
	private \Doctrine\Common\Collections\Collection $comments;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Model\Issues\Status", mappedBy="issue", indexBy="created")
	 * @\Doctrine\ORM\Mapping\OrderBy({"created" = "ASC"})
	 */
	private \Doctrine\Common\Collections\Collection $statuses;


	public function __construct(
		\PeckaDesk\Model\Projects\Project $project,
		string $name,
		\PeckaDesk\Model\Users\User $createdBy,
		\DateTimeImmutable $created
	)
	{
		$this->project = $project;
		$this->name = $name;
		$this->comments = new \Doctrine\Common\Collections\ArrayCollection();
		$this->createdBy = $createdBy;
		$this->created = $created;
		$this->statuses = new \Doctrine\Common\Collections\ArrayCollection();
	}


	public function addComment(Comment $comment): void
	{
		$this->comments->add($comment);
	}


	public function getComment(): Comment
	{
		return $this->comments->first();
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


	public function getDescription(): ?string
	{
		return $this->getCurrentRevision()->getText();
	}


	public function getComments(): \Doctrine\Common\Collections\Collection
	{
		return $this->comments;
	}


	private function getCurrentRevision(): Revision
	{
		return $this->getComment()->getCurrentRevision();
	}


	public function changeStatus(string $status, \PeckaDesk\Model\Users\User $createdBy, \DateTimeImmutable $created): Status
	{
		$status = new Status($this, $status, $createdBy, $created);
		$this->statuses->add($status);

		return $status;
	}


	public function getStatus(): Status
	{
		return $this->statuses->last();
	}


	public function getStatuses(): \Doctrine\Common\Collections\Collection
	{
		return $this->statuses;
	}

}
