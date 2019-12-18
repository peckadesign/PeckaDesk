<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Forms;

final class EditFormValues
{

	public string $name;


	public static function createFromProject(\PeckaDesk\Model\Projects\Project $project): self
	{
		$return = new self();

		$return->name = $project->getName();

		return $return;
	}

}
