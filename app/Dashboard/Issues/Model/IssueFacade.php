<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Model;

final class IssueFacade implements IssueFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;

	/**
	 * @var \PeckaDesk\Model\Files\FileStorageInterface
	 */
	private \PeckaDesk\Model\Files\FileStorageInterface $fileStorage;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager,
		\PeckaDesk\Model\Files\FileStorageInterface $fileStorage
	)
	{
		$this->entityManager = $entityManager;
		$this->fileStorage = $fileStorage;
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


	public function saveFromAddForm(\PeckaDesk\Model\Projects\Project $project, \PeckaDesk\Dashboard\Issues\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Issues\Issue
	{
		$issue = new \PeckaDesk\Model\Issues\Issue($project, $addFormValues->name);
		$issue->setDescription($addFormValues->description);

		$this->entityManager->persist($issue);
		$this->entityManager->flush();

		foreach ($addFormValues->files as $uploadedFile) {
			$image = \Nette\Utils\Image::fromFile($uploadedFile->getTemporaryFile());
			$file = new \PeckaDesk\Model\Files\Image($uploadedFile->name, $image->getWidth(), $image->getHeight());
			$issue->addFile($file);
			$this->entityManager->persist($file);
			$this->entityManager->flush();
			$this->fileStorage->save($file, $uploadedFile);
		}


		return $issue;
	}


	public function saveFromEditForm(\PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\EditFormValues $addFormValues): void
	{
		$issue->setName($addFormValues->name);
		$this->entityManager->flush();
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

}
