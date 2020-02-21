<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Issues;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="comment")
 */
class Comment implements \PeckaDesk\Model\CreatedInterface
{

	use \PeckaDesk\Model\CreatedTrait;

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 * @\Doctrine\ORM\Mapping\GeneratedValue
	 */
	private ?int $id = NULL;

	/**
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Issues\Issue")
	 * @\Doctrine\ORM\Mapping\JoinColumn(name="issue_id", referencedColumnName="id")
	 */
	private Issue $issue;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Model\Issues\Revision", mappedBy="comment")
	 * @\Doctrine\ORM\Mapping\OrderBy({"created" = "DESC"})
	 */
	private \Doctrine\Common\Collections\Collection $revisions;

	/**
	 * @\Doctrine\ORM\Mapping\ManyToMany(targetEntity="\PeckaDesk\Model\Files\File")
	 * @\Doctrine\ORM\Mapping\JoinTable(name="comment_x_file",
	 *     joinColumns={@\Doctrine\ORM\Mapping\JoinColumn(name="comment_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@\Doctrine\ORM\Mapping\JoinColumn(name="file_id", referencedColumnName="id")}
	 * )
	 */
	private \Doctrine\Common\Collections\Collection $files;


	public function __construct(
		Issue $issue,
		\PeckaDesk\Model\Users\User $createdBy,
		\DateTimeImmutable $created
	)
	{
		$this->issue = $issue;
		$issue->addComment($this);
		$this->createdBy = $createdBy;
		$this->created = $created;
		$this->revisions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->files = new \Doctrine\Common\Collections\ArrayCollection();
	}


	public function addRevision(Revision $revision): void
	{
		$this->revisions->add($revision);
	}


	public function getCurrentRevision(): Revision
	{
		return $this->revisions->last();
	}


	public function addFile(\PeckaDesk\Model\Files\File $file): void
	{
		$this->files->add($file);
	}


	public function getFiles(): \Doctrine\Common\Collections\Collection
	{
		return $this->files;
	}

}
