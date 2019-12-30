<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\PeckaNotesLogin;

final class StateStorage
{

	/**
	 * @var \Nette\Http\SessionSection<string, string>
	 */
	private \Nette\Http\SessionSection $sessionSection;


	/**
	 * @param \Nette\Http\SessionSection<string, string> $sessionSection
	 */
	public function __construct(\Nette\Http\SessionSection $sessionSection)
	{
		$this->sessionSection = $sessionSection;
	}


	public function saveState(string $state): void
	{
		$this->sessionSection['state'] = $state;
	}


	public function validateState(string $state): bool
	{
		return $this->sessionSection['state'] === $state;
	}

}
