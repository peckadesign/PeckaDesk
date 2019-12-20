<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Model;

interface ProjectFacadeInterface
{

	/**
	 * @throws \PeckaDesk\Dashboard\Model\EntityNotFoundException
	 */
	public function getById(int $id): \PeckaDesk\Model\Projects\Project;


	public function saveFromEditForm(\PeckaDesk\Model\Projects\Project $project, \PeckaDesk\Dashboard\Projects\Forms\EditFormValues $editFormValues): void;


	public function saveFromAddForm(\PeckaDesk\Dashboard\Projects\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Projects\Project;


	public function queryFactory(): \Doctrine\ORM\QueryBuilder;


	/**
	 * @return array<\PeckaDesk\Model\Projects\Project>
	 */
	public function fetchAll(): array;

}
