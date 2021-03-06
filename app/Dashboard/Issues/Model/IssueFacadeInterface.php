<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Model;

interface IssueFacadeInterface
{

	/**
	 * @throws \PeckaDesk\Dashboard\Model\EntityNotFoundException
	 */
	public function getById(int $id): \PeckaDesk\Model\Issues\Issue;


	public function saveFromAddForm(\PeckaDesk\Model\Users\User $createdBy, \PeckaDesk\Model\Projects\Project $project, \PeckaDesk\Dashboard\Issues\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Issues\Issue;


	public function saveFromEditForm(\PeckaDesk\Model\Users\User $createdBy, \PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\EditFormValues $editFormValues): void;


	public function saveReplyForm(\PeckaDesk\Model\Users\User $createdBy, \PeckaDesk\Model\Issues\Issue $issue, \PeckaDesk\Dashboard\Issues\Forms\ReplyFormValues $replyFormValues): \PeckaDesk\Model\Issues\Comment;


	public function queryFactory(\PeckaDesk\Model\Projects\Project $project): \Doctrine\ORM\QueryBuilder;


	/**
	 * @return array<\PeckaDesk\Model\Issues\Issue>
	 */
	public function fetchAll(\PeckaDesk\Model\Projects\Project $project): array;


	public function changeStatus(\PeckaDesk\Model\Issues\Issue $issue, string $status, \PeckaDesk\Model\Users\User $createdBy): \PeckaDesk\Model\Issues\Status;


	/**
	 * @return array<\PeckaDesk\Model\CreatedInterface>
	 */
	public function loadIssuePosts(\PeckaDesk\Model\Issues\Issue $issue): array;

}
