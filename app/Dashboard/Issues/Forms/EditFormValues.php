<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class EditFormValues
{

	public string $name;

	public ?string $description;

	/**
	 * @var array<\Nette\Http\FileUpload>
	 */
	public array $files;


	public static function createFromIssue(\PeckaDesk\Model\Issues\Issue $issue): self
	{
		$return = new self();

		$return->name = $issue->getName();
		$return->description = $issue->getDescription();

		return $return;
	}

}
