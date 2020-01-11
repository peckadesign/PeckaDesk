<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class ReplyFormValues
{

	public ?string $description;

	/**
	 * @var array<\Nette\Http\FileUpload>
	 */
	public array $files;

}
