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
	 * @\Doctrine\ORM\Mapping\ManyToMany(targetEntity="\PeckaDesk\Model\Files\File")
	 * @\Doctrine\ORM\Mapping\JoinTable(name="issue_x_file",
	 *     joinColumns={@\Doctrine\ORM\Mapping\JoinColumn(name="issue_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@\Doctrine\ORM\Mapping\JoinColumn(name="file_id", referencedColumnName="id")}
	 * )
	 */
	private \Doctrine\Common\Collections\Collection $files;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Model\Issues\Comment", mappedBy="issue")
	 * @\Doctrine\ORM\Mapping\OrderBy({"created" = "DESC"})
	 */
	private \Doctrine\Common\Collections\Collection $comments;


	public function __construct(
		\PeckaDesk\Model\Projects\Project $project,
		string $name
	)
	{
		$this->project = $project;
		$this->name = $name;
		$this->comments = new \Doctrine\Common\Collections\ArrayCollection();
		$this->files = new \Doctrine\Common\Collections\ArrayCollection();
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


	public function addFile(\PeckaDesk\Model\Files\File $file): void
	{
		$this->files->add($file);
	}


	public function getFiles(): \Doctrine\Common\Collections\Collection
	{
		return $this->files;
	}


	private function getCurrentRevision(): Revision
	{
		return $this->getComment()->getCurrentRevision();
	}

}
