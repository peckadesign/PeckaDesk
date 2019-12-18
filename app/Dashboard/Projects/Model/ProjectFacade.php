<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Model;

final class ProjectFacade implements ProjectFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		$this->entityManager = $entityManager;
	}


	/**
	 * @throws \PeckaDesk\Dashboard\Model\EntityNotFoundException
	 */
	public function getById(int $id): \PeckaDesk\Model\Projects\Project
	{
		/** @var \PeckaDesk\Model\Projects\Project|null $project */
		$project = $this->entityManager->getRepository(\PeckaDesk\Model\Projects\Project::class)->find($id);

		if ($project === NULL) {
			throw new \PeckaDesk\Dashboard\Model\EntityNotFoundException();
		}

		return $project;
	}


	public function saveFromEditForm(\PeckaDesk\Model\Projects\Project $project, \PeckaDesk\Dashboard\Projects\Forms\EditFormValues $editFormValues): void
	{
		$project->setName($editFormValues->name);
		$this->entityManager->flush();
	}


	public function saveFromAddForm(\PeckaDesk\Dashboard\Projects\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Projects\Project
	{
		$project = new \PeckaDesk\Model\Projects\Project($addFormValues->name);
		$this->entityManager->flush();

		return $project;
	}

}
