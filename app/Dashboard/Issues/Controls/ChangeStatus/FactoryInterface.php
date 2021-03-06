<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Controls\ChangeStatus;

interface FactoryInterface
{

	public function create(\PeckaDesk\Model\Issues\Issue $issue): Control;

}
