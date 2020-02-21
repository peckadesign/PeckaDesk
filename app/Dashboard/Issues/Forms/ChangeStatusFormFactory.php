<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class ChangeStatusFormFactory
{

	public const CONTROL_ACCEPT = 'accept';
	public const CONTROL_REJECT = 'reject';
	public const CONTROL_WORK = 'work';
	public const CONTROL_FINISH = 'finish';

	/**
	 * @var \PeckaDesk\Dashboard\Forms\BaseFactory
	 */
	private \PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory;


	public function __construct(
		\PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory
	)
	{
		$this->baseFactory = $baseFactory;
	}


	public function create(\PeckaDesk\Model\Issues\Issue $issue, callable $successCallback): \Nette\Application\UI\Form
	{
		$form = $this->baseFactory->create();

		if ($issue->getStatus()->getStatus() === \PeckaDesk\Model\Issues\Status::STATUS_NEW) {
			$form->addSubmit(self::CONTROL_ACCEPT)->onClick[] = static function () use ($successCallback): void {
				$successCallback(\PeckaDesk\Model\Issues\Status::STATUS_ACCEPTED);
			};
			$form->addSubmit(self::CONTROL_REJECT)->onClick[] = static function () use ($successCallback): void {
				$successCallback(\PeckaDesk\Model\Issues\Status::STATUS_REJECTED);
			};
		} elseif ($issue->getStatus()->getStatus() === \PeckaDesk\Model\Issues\Status::STATUS_ACCEPTED) {
			$form->addSubmit(self::CONTROL_WORK)->onClick[] = static function () use ($successCallback): void {
				$successCallback(\PeckaDesk\Model\Issues\Status::STATUS_WORKING);
			};
		} elseif ($issue->getStatus()->getStatus() === \PeckaDesk\Model\Issues\Status::STATUS_WORKING) {
			$form->addSubmit(self::CONTROL_FINISH)->onClick[] = static function () use ($successCallback): void {
				$successCallback(\PeckaDesk\Model\Issues\Status::STATUS_FINISHED);
			};
		}

		return $form;
	}

}
