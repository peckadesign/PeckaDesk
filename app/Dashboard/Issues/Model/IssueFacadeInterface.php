<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Model;

interface IssueFacadeInterface
{

	/**
	 * @throws \PeckaDesk\Dashboard\Model\EntityNotFoundException
	 */
	public function getById(int $id): \PeckaDesk\Model\Issues\Issue;


	public function saveFromAddForm(\PeckaDesk\Model\Projects\Project $project, \PeckaDesk\Dashboard\Issues\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Issues\Issue;


	public function saveFromEditForm(\PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\EditFormValues $editFormValues): void;

}
