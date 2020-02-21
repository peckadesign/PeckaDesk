<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Issues;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="status")
 */
class Status implements \PeckaDesk\Model\CreatedInterface
{

	use \PeckaDesk\Model\CreatedTrait;

	public const STATUS_NEW = 'statusNew';
	public const STATUS_REJECTED = 'statusRejected';
	public const STATUS_ACCEPTED = 'statusAccepted';
	public const STATUS_WORKING = 'statusWorking';
	public const STATUS_FINISHED = 'statusFinished';

	public static $statuses = [
		self::STATUS_NEW,
		self::STATUS_ACCEPTED,
		self::STATUS_WORKING,
		self::STATUS_FINISHED,
	];

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Issues\Issue")
	 */
	private Issue $issue;

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $status;


	public function __construct(
		Issue $issue,
		string $status,
		\PeckaDesk\Model\Users\User $createdBy,
		\DateTimeImmutable $created
	)
	{
		$this->issue = $issue;
		$this->status = $status;
		$this->createdBy = $createdBy;
		$this->created = $created;
	}


	public function getStatus(): string
	{
		return $this->status;
	}

}
