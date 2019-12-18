<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class EditFormValues
{

	public string $name;


	public static function createFromIssue(\PeckaDesk\Model\Issues\Issue $issue): self
	{
		$return = new self();

		$return->name = $issue->getName();

		return $return;
	}

}
