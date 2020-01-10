<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Issues;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="revision")
 */
class Revision
{

	use \PeckaDesk\Model\CreatedTrait;

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 * @\Doctrine\ORM\Mapping\GeneratedValue
	 */
	private ?int $id = NULL;

	/**
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Issues\Comment")
	 * @\Doctrine\ORM\Mapping\JoinColumn(name="comment_id", referencedColumnName="id")
	 */
	private Comment $comment;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="text", nullable=true)
	 */
	private ?string $text;


	public function __construct(
		Comment $comment,
		?string $text,
		\PeckaDesk\Model\Users\User $createdBy,
		\DateTimeImmutable $created
	)
	{
		$this->comment = $comment;
		$comment->addRevision($this);
		$this->text = \PeckaDesk\Model\Filters::stringVal($text);
		$this->createdBy = $createdBy;
		$this->created = $created;
	}


	public function getCreated(): \DateTimeImmutable
	{
		return $this->created;
	}


	public function getCreatedBy(): \PeckaDesk\Model\Users\User
	{
		return $this->createdBy;
	}


	public function getId(): ?int
	{
		return $this->id;
	}


	public function getComment(): Comment
	{
		return $this->comment;
	}


	public function getText(): ?string
	{
		return $this->text;
	}

}
