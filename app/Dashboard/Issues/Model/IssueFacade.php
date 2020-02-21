<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Model;

final class IssueFacade implements IssueFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;

	private \PeckaDesk\Model\Files\FileStorageInterface $fileStorage;

	private \PeckaDesk\Model\DateTimeProviderInterface $dateTimeProvider;

	/**
	 * @var \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface
	 */
	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager,
		\PeckaDesk\Model\Files\FileStorageInterface $fileStorage,
		\PeckaDesk\Model\DateTimeProviderInterface $dateTimeProvider,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		$this->entityManager = $entityManager;
		$this->fileStorage = $fileStorage;
		$this->dateTimeProvider = $dateTimeProvider;
		$this->userFacade = $userFacade;
	}


	public function getById(int $id): \PeckaDesk\Model\Issues\Issue
	{
		/** @var \PeckaDesk\Model\Issues\Issue|null $issue */
		$issue = $this->entityManager->getRepository(\PeckaDesk\Model\Issues\Issue::class)->find($id);

		if ($issue === NULL) {
			throw new \PeckaDesk\Dashboard\Model\EntityNotFoundException();
		}

		return $issue;
	}


	public function saveFromAddForm(\PeckaDesk\Model\Users\User $createdBy, \PeckaDesk\Model\Projects\Project $project, \PeckaDesk\Dashboard\Issues\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Issues\Issue
	{
		$now = $this->dateTimeProvider->createDateTime();

		$createdBy = $this->userFacade->getByEmail($createdBy->getEmail());

		$issue = new \PeckaDesk\Model\Issues\Issue($project, $addFormValues->name, $createdBy, $now);
		$comment = new \PeckaDesk\Model\Issues\Comment($issue, $createdBy, $now);
		$revision = new \PeckaDesk\Model\Issues\Revision($comment, $addFormValues->description, $createdBy, $now);

		$this->entityManager->persist($issue);
		$this->entityManager->persist($comment);
		$this->entityManager->persist($revision);
		$this->entityManager->flush();

		foreach ($addFormValues->files as $uploadedFile) {
			$image = \Nette\Utils\Image::fromFile($uploadedFile->getTemporaryFile());
			$file = new \PeckaDesk\Model\Files\Image($uploadedFile->name, $image->getWidth(), $image->getHeight());
			$comment->addFile($file);
			$this->entityManager->persist($file);
			$this->entityManager->flush();
			$this->fileStorage->save($file, $uploadedFile);
		}

		return $issue;
	}


	public function saveFromEditForm(\PeckaDesk\Model\Users\User $createdBy, \PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\EditFormValues $addFormValues): void
	{
		$now = $this->dateTimeProvider->createDateTime();

		$createdBy = $this->userFacade->getByEmail($createdBy->getEmail());

		$revision = new \PeckaDesk\Model\Issues\Revision($issue->getComment(), $addFormValues->description, $createdBy, $now);
		$issue->getComment()->addRevision($revision);

		$this->entityManager->persist($revision);
		$this->entityManager->flush();
	}


	public function saveReplyForm(\PeckaDesk\Model\Users\User $createdBy, \PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\ReplyFormValues $replyFormValues): \PeckaDesk\Model\Issues\Comment
	{
		$now = $this->dateTimeProvider->createDateTime();

		$createdBy = $this->userFacade->getByEmail($createdBy->getEmail());

		$comment = new \PeckaDesk\Model\Issues\Comment($issue, $createdBy, $now);
		$revision = new \PeckaDesk\Model\Issues\Revision($comment, $replyFormValues->description, $createdBy, $now);

		$this->entityManager->persist($comment);
		$this->entityManager->persist($revision);
		$this->entityManager->flush();

		foreach ($replyFormValues->files as $uploadedFile) {
			$image = \Nette\Utils\Image::fromFile($uploadedFile->getTemporaryFile());
			$file = new \PeckaDesk\Model\Files\Image($uploadedFile->name, $image->getWidth(), $image->getHeight());
			$comment->addFile($file);
			$this->entityManager->persist($file);
			$this->entityManager->flush();
			$this->fileStorage->save($file, $uploadedFile);
		}

		return $comment;
	}


	public function queryFactory(\PeckaDesk\Model\Projects\Project $project): \Doctrine\ORM\QueryBuilder
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('i')->from(\PeckaDesk\Model\Issues\Issue::class, 'i');

		$qb->where('i.project = ?1');
		$qb->setParameter(1, $project);

		return $qb;
	}


	public function fetchAll(\PeckaDesk\Model\Projects\Project $project): array
	{
		$qb = $this->queryFactory($project);

		return $qb->getQuery()->getResult();
	}


	public function changeStatus(\PeckaDesk\Model\Issues\Issue $issue, string $status, \PeckaDesk\Model\Users\User $createdBy): \PeckaDesk\Model\Issues\Status
	{
		$status = $issue->changeStatus($status, $createdBy, $this->dateTimeProvider->createDateTime());
		$this->entityManager->persist($status);
		$this->entityManager->flush();

		return $status;
	}


	public function loadIssuePosts(\PeckaDesk\Model\Issues\Issue $issue): array
	{
		$comments = $issue->getComments();
		$statuses = $issue->getStatuses();

		$posts = [];
		foreach ($comments as $comment) {
			$posts[] = $comment;
		}

		foreach ($statuses as $status) {
			$posts[] = $status;
		}

		$cb = function (\PeckaDesk\Model\CreatedInterface $a, \PeckaDesk\Model\CreatedInterface $b) {
			return ((int) $a->getCreated()->format('U')) <=> ((int) $b->getCreated()->format('U'));
		};
		\usort($posts, $cb);

		return $posts;
	}

}
