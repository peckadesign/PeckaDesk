<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Model;

final class IssueFacade implements IssueFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		$this->entityManager = $entityManager;
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
		$this->entityManager->persist($issue);
		$this->entityManager->flush();

		return $issue;
	}


	public function saveFromEditForm(\PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\EditFormValues $addFormValues): void
	{
		$issue->setName($addFormValues->name);
		$this->entityManager->flush();
	}

}